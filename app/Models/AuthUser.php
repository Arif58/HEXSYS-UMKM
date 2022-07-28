<?php

namespace App\Models;

use DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\MailResetPasswordNotification;
use App\Notifications\MailVerificationNewUserNotification;
use Tymon\JWTAuth\Contracts\JWTSubject;

class AuthUser extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use Notifiable;

    protected $table            = 'auth.users';
    private static $tableName   = 'auth.users as user';
    protected $primaryKey       = 'user_id'; 
    public $incrementing    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'user_nm',
        'email',
        'phone',
        'password',
        'comp_cd',
        'image',
        'rule_tp',
        'active',
        'email_verified_at',
        'token_register',
        'last_login',
		'unit_cd',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function mGetDetailUser($id){
        $data=DB::table(Self::$tableName)
            ->join('auth.role_users as ru','ru.user_id','user.user_id')
            ->join('auth.roles as role','role.role_cd','ru.role_cd')
            ->select("*")
            ->where('user.user_id',$id);
            
        return $data;
    }

    public static function getDataCd(){
        $numberLength = 4; 
        $lastNum      = AuthUser::select(DB::Raw("
                        concat('USER',lpad((MAX(RIGHT(user_id,$numberLength)::int) + 1)::varchar,$numberLength,'0')) as lastnum
                        "))
                        ->where(DB::Raw("LEFT(user_id,4) = 'USER'"))
                        ->first()
                        ->lastnum;

        // return 'USER'.str_pad($lastNum,$numberLength,"0",STR_PAD_LEFT)
        return $lastNum;
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    public function role(){
        return $this->hasOne('App\Models\AuthRoleUser','user_id');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    /* public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token,
$this->user_nm));
    } */

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    /* public function sendEmailVerificationNotification()
    {
        $this->notify(new MailVerificationNewUserNotification);
    } */
}
