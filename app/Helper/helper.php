<?php


use App\AppSetting;

function getColor(){
    $color = ['warning','danger','success','info','primary'];
    $index=array_rand($color);
    return $color[$index];
}

function setActive($path)
{
    if(!\Request::ajax()){
        return \Request::is($path . '*') ? 'active' :  '';
    }
}

function showDate($date = ''){
    if($date == '' || $date == null)
        return;

    $format = config('config.date_format') ? : 'd-m-Y';
    return date($format,strtotime($date));
}

function isSecure(){
    if(!getMode())
        return 1;

    $url = \Request::url();
    $result = strpos($url, 'wmlab');
    if($result === FALSE)
        return 0;
    else
        return 1;
}

function getRemoteIPAddress() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];

    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    return $_SERVER['REMOTE_ADDR'];
}

function getClientIp(){
    $ips = getRemoteIPAddress();
    $ips = explode(',', $ips);
    return !empty($ips[0]) ? $ips[0] : \Request::getClientIp();
}

function sendMail($id,$data,$to,$from){
    $maildata = \App\MailTemplate::where('mail_template_id',$id)->first();

    foreach($data as $key => $value){
        $maildata->mail_body      = str_replace('[['.$key.']]',$data[$key],$maildata->mail_body);
    }

    $data['mail_body'] = $maildata->mail_body;

     Mail::send('Admin.mail_template.mail_template',$data, function($message) use($to,$from,$maildata){
         $message->to($to)->subject($maildata->mail_subject);
         $message->from($from,'Granth');
     });
}

function uploadImage($file, $path, $id, $field_name)
{

    if ($file != null) {
        $paths = public_path().$path;
        if (!file_exists($paths)) {
            File::makeDirectory($paths, $mode = 0777, true, true);
        }
    } else {
        $filename = \DB::table('users')->where('id', $id)->value($field_name);
    }

    if ($file!='') {
        $filename =time().'-'.$file->getClientOriginalName();
        $file->move($paths, $filename);

        $images[$field_name]=$filename;
        return \App\User::updateOrCreate(['id' => $id], $images);
    }
}


function envChanges($type,$value){
    $path = base_path('.env');
    if (file_exists($path)) {
        file_put_contents($path, str_replace(
            $type.'='.env($type), $type.'='.$value, file_get_contents($path)
        ));
    }
}

function CheckRecordExist($table_list,$column_name,$id){
    $search_keyword = $column_name;
    if(count($table_list) > 0){
        foreach($table_list as $table){
            $check_data = \DB::table($table)->where('category_id',$id)->WhereNull('deleted_at')->count();
            if($check_data > 0)
            {
                return false ;
            }
        }
        return true;
    }
    else {
        return true;
    }
}

function sendOneSignalMessage($device_ids, $device_data) {
    $content = array(
        "en" => isset($device_data['message']) ? $device_data['message'] :  env('APP_NAME').' Message'
    );
    $heading = array(
        "en" =>isset($device_data['title']) ? $device_data['title'] :  env('APP_NAME').' Title'
    );
    $device_contents = array(
            "type"       => isset($device_data['type']) ? $device_data['type'] :  env('APP_NAME'),
            "user_id"    => isset($device_data['user_id']) ? $device_data['user_id'] : 0,
            "title"      =>  isset($device_data['title']) ? $device_data['title'] :  env('APP_NAME').' Title',
            "message"    => isset($device_data['message']) ? $device_data['message'] :  env('APP_NAME').' Message',
            "book_id"    => isset($device_data['book_id']) ? $device_data['book_id'] : 'book_id',
            "notification_type"    => isset($device_data['notification_type']) ? $device_data['notification_type'] : 'notification_type',
        );
        $device_ids = array_filter($device_ids);
    // Save notification in database Added by tejas 19-06-19
    $insert = [
        'title' => isset($device_data['title']) ? $device_data['title'] : "Title",
        'content' => json_encode($device_contents)
    ];
    foreach($device_ids as $data) {
        $repeat= [];
        $user_id = \App\User::where('registration_id',$data)->first();
        if(!in_array($user_id->id,$repeat))
        {
            $repeat[] = $user_id->id;
            $insert['user_id'] = $user_id->id;
            $insert['device_id'] = $data;
            $insert['status'] = 0 ; // for unread notification
            $notification_data = \App\Notification_history::create($insert);
            $device_contents['notification_id'] =  $notification_data->notification_id;
        }
    }

    $fields = array(
        'app_id' => env('ONESIGNAL_API_KEY'),
        'include_player_ids' => $device_ids,
        'data' => $device_contents,
        'contents' => $content,
        'headings' => $heading,
        // 'big_picture' => isset($device_data['image']) ? $device_data['image'] : 'Image',
    );

    $header=[
        "title" => isset($device_data['title']) ? $device_data['title'] :  env('APP_NAME').' Title',
        "message" => isset($device_data['message']) ? $device_data['message'] :  env('APP_NAME').' Message',
    ];



    $sendContent = json_encode($fields);
    // dd($sendContent);
    oneSignalAPI($sendContent);
}

function oneSignalAPI($sendContent)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER,
                        array('Content-Type: application/json;
                                charset=utf-8',
                                 'Authorization: Basic '.env('ONESIGNAL_REST_API_KEY')
                        ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $sendContent);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);
    // dd($response);
    return $response;
}

function getSingleMedia($model, $collection = 'image_icon',$image_type='',$file_type='image',$skip=true)
{
    switch($file_type){
        case 'video':
                    // if (!\Auth::check() && $skip) {
                    //     return asset('assets/sample_file/sample.mp4');
                    // }
                    if ($model !== null) {
                        $media = $model->getFirstMedia($collection);
                    }
                    $imgurl= isset($media)?$media->getPath():'';

                    if (file_exists($imgurl)) {
                        return $media->getFullUrl();
                    }else{
                        return asset('assets/sample_file/sample.mp4');
                    }
        case 'epub':
                    // if (!\Auth::check() && $skip) {
                    //     return asset('assets/sample_file/sample.epub');
                    // }
                    if ($model !== null) {
                        $media = $model->getFirstMedia($collection);
                    }
                    $imgurl= isset($media)?$media->getPath():'';

                    if (file_exists($imgurl)) {
                        return $media->getFullUrl();
                    }else{
                        return asset('assets/sample_file/sample.epub');
                    }
        case 'pdf':
                    // if (!\Auth::check() && $skip) {
                    //     return asset('assets/sample_file/sample.pdf');
                    // }
                    if ($model !== null) {
                        $media = $model->getFirstMedia($collection);
                    }
                    $imgurl= isset($media)?$media->getPath():'';

                    if (file_exists($imgurl)) {
                        return $media->getFullUrl();
                    }else{
                        return asset('assets/sample_file/sample.pdf');
                    }
        case 'image':
        default:
                // if (!\Auth::check() && $skip) {
                //     return asset('assets/img/icons/user/user.png');
                // }
                if ($model !== null) {
                    $media = $model->getFirstMedia($collection);
                }
                if(isset($image_type)){
                    $imgurl= isset($media)?$media->getPath('thumb'):'';
                }else{
                    $imgurl= isset($media)?$media->getPath():'';
                }
                if (file_exists($imgurl)) {
                    if(isset($image_type)){
                        return $media->getFullUrl('thumb');
                    }else{
                        return $media->getFullUrl();
                    }
                }else{

                switch ($collection) {
                    case 'image_icon':
                    case 'image':
                        $media = asset('assets/img/icons/user/user.png');
                        break;
                    default:
                        $media = asset('assets/img/icons/common/add.png');
                        break;
                }

                return $media;

                }
    }
}

function getBookImage($img_media,$collection){
    $image = "";
    $img = $img_media->where('collection_name',$collection)->last();
    if($img){
        $image=$img->getFullUrl();
    }
    return $image;
}

function authSession($force=false){
    $session=new \App\User;
    if($force){
        $user=\Auth::user();//->with('user_role');
        \Session::put('auth_user',$user);
        $session =\Session::get('auth_user');
        return $session;
    }
    if(\Session::has('auth_user')){
        $session =\Session::get('auth_user');
    }else{
        $user=\Auth::user();
        \Session::put('auth_user',$user);
        $session =\Session::get('auth_user');
    }
    return $session;
}

function settingSession($type='get'){
    if(\Session::get('setting_data')==''){
        $type='set';
    }
    switch ($type){
        case "set" : $settings = AppSetting::first();\Session::put('setting_data',$settings); break;
        default : break;
    }
    return \Session::get('setting_data');
}

function money($price,$symbol='$'){
    if($price==''){
        $price=0;
    }
    return $symbol.' '.$price;
}

function fileExitsCheck($defaultimg, $path, $filename)
{
    $image= $defaultimg;
    $imgurl= public_path($path.'/'.$filename);
    if ($filename != null && file_exists($imgurl)) {
        $isimgurl=URL::asset($path.'/'.$filename);
        $image=$isimgurl;
    }
    return $image;
}

?>
