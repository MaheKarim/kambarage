<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\AppSetting;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Intervention\Image\Facades\Image;
use Input;
use Config;
use App\Setting;
use Auth;

class SettingController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function termAndCondition(Request $request){
        if(!Auth::user()->allowedAccess('terms_of_service'))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $term_condition_data=Setting::where('key','terms&condition')->first();
        $pageTitle = trans('messages.tnc');
        return view('Admin.term_condition.create',compact('term_condition_data','pageTitle'));
    }

    public function saveTermAndCondition(Request $request)
    {
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }

        if(!Auth::user()->allowedAccess('terms_of_service'))
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $terms_condition_data = array(
                        'key'=>'terms&condition',
                        'value' => $request->value );
        $result = Setting::updateOrCreate(['id' => $request->id],$terms_condition_data);
        if($result->wasRecentlyCreated)
        {
            $message = trans('messages.save_form',['form' => trans('messages.tnc')]);
        }else{
            $message = trans('messages.update_form',['form' => trans('messages.tnc')]);
        }
        return redirect()->route('term-condition')->withsuccess($message);
    }

    public function privacyPolicy(Request $request){
        if(!Auth::user()->allowedAccess('terms_of_service'))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $privacy_policy_data=Setting::where('key','privacy_policy')->first();
        $pageTitle = trans('messages.privacy_policy');
        return view('Admin.privacy_policy.create',compact('privacy_policy_data','pageTitle'));
    }

    public function savePrivacyPolicy(Request $request)
    {
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }

        if(!Auth::user()->allowedAccess('terms_of_service'))
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $privacy_policy_data = array(
                        'key'=>'privacy_policy',
                        'value' => $request->value );
        $result = Setting::updateOrCreate(['id' => $request->id],$privacy_policy_data);
        if($result->wasRecentlyCreated){
            $message = trans('messages.save_form',['form' => trans('messages.privacy_policy')]);
        }else{
            $message = trans('messages.update_form',['form' => trans('messages.privacy_policy')]);
        }
        return redirect()->route('privacy-policy')->withsuccess($message);
    }

    public function settings(Request $request)
    {
        $auth_user=authSession();
        $pageTitle = 'Setting';
        $page=$request->page;

        $assets = ['text_editor'];
        if($page == ''){
            if($auth_user->is('admin') || $auth_user->is('demo_admin')){
                $page = 'general-setting';
            }else{
                $page = 'profile_form';
            }
        }

        return view('Admin.setting.index',compact('page','assets' , 'pageTitle'));
    }

    public function settingsUpdates(Request $request)
    {
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        
        if(!Auth::user()->allowedAccess())
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        

        $settings =  $request->all();

        $page=$request->page;

        $res = AppSetting::updateOrCreate(['id' => $settings['id']], $settings);
        $ext_type = Config::get('constant.IMAGE_EXTENTIONS');
        $message = '';
        if($request->site_logo) {
            $res->clearMediaCollection('site_logo');
            $res->addMediaFromRequest('site_logo')
                ->toMediaCollection('site_logo');
        }
        if($request->site_favicon) {
            $res->clearMediaCollection('site_favicon');
            $res->addMediaFromRequest('site_favicon')
                ->toMediaCollection('site_favicon');
        }
        settingSession('set');

        return redirect()->route('admin.settings', ['page' => $page])->withSuccess(trans('Successfully updated.'.$message));
    }

    public function contactus_settings(Request $request)
    {
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        
        if(!Auth::user()->allowedAccess())
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        
        $settings =  $request->all();
        $page=$request->page;

        $res = AppSetting::updateOrCreate(['id' => $request->id], $settings);

        return redirect()->route('admin.settings', ['page' => $page])->withSuccess(trans('Contact information updated successfully.'));
    }

    /*ajax show layout data*/

    public function layoutPage(Request $request){
        $page = $request->page;
        $auth_user=authSession();
        $user_id = $auth_user->id;
        $settings = AppSetting::first();
        $user_data = User::find($user_id);
        $envSettting = $envSettting_value =[];
        if ($page == 'mail-setting'){
            $envSettting = Config::get('constant.MAIL_SETTING');
        }
        if(count($envSettting)>0){
            $envSettting_value=Setting::whereIn('key',array_keys($envSettting))->get();
        }
        if($settings==null){
            $settings =new AppSetting;
        }elseif($user_data == null){
            $user_data = new User;
        }
        switch ($page) {
            case 'password_form':
                $data  = view('Admin.users.profile.'.$page, compact('settings','user_data','page'))->render();
                break;
            case 'profile_form':
                $data  = view('Admin.users.profile.'.$page, compact('settings','user_data','page'))->render();
                break;
            case 'mail-setting':
                $data  = view('Admin.setting.'.$page, compact('settings','page','envSettting','envSettting_value'))->render();
                break;
            default:
                $data  = view('Admin.setting.'.$page, compact('settings','page','envSettting'))->render();
                break;
        }
        return response()->json($data);
    }

    public function envSetting(Request $request)
    {
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        
        if(!Auth::user()->allowedAccess())
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $page=$request->page;
        $envtype = $request->type;
        $setting = $social = null;
        if ($envtype == 'mail') {

            $setting = Config::get('constant.MAIL_SETTING');

        }elseif($envtype == 'configuration'){

            $setting = Config::get('constant.CONFIGURATION');

        }elseif($envtype == 'social'){
            $social = Config::get('constant.SOCIAL');
        } else{
            $setting = null;
        }
        if ( $setting != null ) {
            foreach($setting as $key => $value){
                if ($value != null){
                    $type = $key;
                    $value = str_replace(' ','_',$request->$key);
                    envChanges($type,$value);
                }
                $input=[
                    'key' => $key,
                    'value' => str_replace(' ','_',$request->$key),
                ];
                Setting::updateOrCreate(['key'=>$input['key']],$input);
            }
        }
        if ( $social != null){
            foreach ($social as $key => $value){
                foreach($value as $social => $social_value){
                    $type = $social;
                    $value = $request->$social;
                    envChanges($type,$value);
                }
                $input=[
                    'key' => $key,
                    'value' => str_replace(' ','_',$request->$key),
                ];
                Setting::updateOrCreate(['key'=>$input['key']],$input);
            }
        }
        return redirect()->route('admin.settings', ['page' => $page])->withSuccess(ucfirst($envtype).' Setting Changed Successfully.');
    }

    public function getMobileSetting(){
        
        if(!Auth::user()->allowedAccess())
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        
        $pageTitle = "Mobile Setting";
        $setting = Config::get('mobile-config');
        $getSetting=[];
        foreach($setting as $k=>$s){
            foreach ($s as $sk => $ss){
                $getSetting[]=$k.'_'.$sk;
            }
        }
        $setting_value=Setting::whereIn('key',$getSetting)->get();
        return view('Admin.setting.mobile_setting',compact('setting','pageTitle','setting_value'));
    }

    public function saveMobileSetting(Request $request){
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        
        if(!Auth::user()->allowedAccess())
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $data=$request->all();
        foreach($data['key'] as $key=>$val){
            $input=[
                'key' => $data['key'][$key],
                'value' => $data['value'][$key],
            ];
            Setting::updateOrCreate(['key'=>$input['key']],$input);
        }
        return redirect()->route('mobile_app.config')->withSucess('Mobile Setting Changed Successfully');
    }

}
