<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens,Notifiable, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','name', 'email', 'password','contact_number','user_type','image',
        'college_id','role_id','admin_assistant_roles'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

   
    public function ratings(){
        return $this->hasMany(BookRating::class, 'user_id','id');
    }

    public function getUserDetail(){
        return $this->belongsTo(UserDetail::class, 'id' , 'user_id');
    }

    public function getCategoryData($id) {
        $category_data = \App\Category::where('category_id',$id)->first();
        return $category_data;
    }

    public function user_role()
    {
        return $this->hasOneThrough('App\Role', 'App\RoleUser','user_id','id','id','role_id')->withDefault([
            'name' => ''
        ]);
    }

    public function is($roleName) {
        // $auth_user=authSession();
        $role=$this->user_role;
        if(isset($role))
        {
            if ($role->name == $roleName)
            {
                return true;
            }
        }

        return false;
    }

    public function allowedAccess($section = null)
    {//USED TO VERIFY IF AN ADMIN ASSISTANT HAVE ACCESS TO A FEATURE

        if($this->role_id === 1)
        {//IF THE PERSON IS A SUPER ADMIN
            return true;
        }

        if($section == null)
        {
            return false;
        }

        if($this->role_id === 5)
        {
            $roles = array_map("trim", explode(";;", $this->admin_assistant_roles));
            return in_array($section, $roles, true);
        }

        return false;
    }
}
