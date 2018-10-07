<?php

namespace App;

use App\Presenters\UserPresenter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_name', 'email', 'password', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // public function setPasswordAttribute($password)
    // {
    //   $this->attributes['password'] = bcrypt($password);
    // }

    public function getUrlAttribute()
    {
      // if (substr($this->avatar, 0, 4) === "http"){
      //   return $this->avatar;
      // }

      if (!$this->avatar) {
        return 'public/default-user.png';
      }

      return $this->avatar;
    }

    public function getPassAttribute()
    {
      return decrypt($this->password);
    }

    public function roles()
    {
      return $this->belongsToMany(Role::class, 'assigned_roles');
    }

    public function hasRoles(array $roles)
    {
        foreach($roles as $role)
        {
            if ($this->role->name === $role) 
            {
                return true;    
            }
        }

        return false;
    }

    public function present()
    {
      return new UserPresenter($this);
    }
}
