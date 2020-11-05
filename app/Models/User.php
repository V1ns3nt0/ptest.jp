<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;


/**
 * Class User
 * @package App\Models
 * @property string username
 * @property string email
 * @property string password
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relation with TaskList class.
     * @return mixed
     */
    public function taskList()
    {
        return $this->hasMany(TaskList::class);
    }


    /**
     * The method get a request data, create and return new user.
     * @param $request
     * @return mixed
     */
    public static function createNewUser($request)
    {
        return self::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    /**
     * The method accepts user data and attempts to match it with the data in the database.
     * If successful, the user logs in and the token is returned.
     * @param $request
     * @return array|false
     */
    public static function authentificate($request)
    {
        $userdata = $request->only('email', 'password');

        if (Auth::attempt($userdata)) {
            $user = Auth::user();
            return ["token" => $user->createToken('userToken')->accessToken];
        } else {
            return false;
        }
    }
}
