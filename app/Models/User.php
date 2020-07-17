<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($user){
            $user->activation_token = Str::random(30);
        });
    }

    public function statuses()
    {
        return $this->hasMany( Status::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function feed()
    {
        $userIds = $this->followings->pluck('id')->toArray();

        return Status::whereIn('user_id', $userIds)
            ->with('user')
            ->orderBy('created_at', 'desc');
    }

    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    public function follow($userIds)
    {
        if(! is_array($userIds)){
            $userIds = [ $userIds ];
        }

        $this->followings()->sync($userIds, false);
    }

    public function unfollow($userIds)
    {
        if(! is_array($userIds) ){
            $userIds = [ $userIds ];
        }

        $this->followings()->detach($userIds);
    }

    public function isFollowing($userId)
    {
        return $this->followings->contains($userId);
    }
}
