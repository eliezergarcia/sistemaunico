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
        'name', 'user_name', 'email', 'password', 'phone', 'address', 'email_office', 'password_email_office'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($password)
    {
      $this->attributes['password'] = bcrypt($password);
    }

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
        return $this->roles->pluck('name')->intersect($roles)->count();
    }

    public function isAdmin()
    {
      return $this->hasRoles(['admin']);
    }

    public function isOper()
    {
      return $this->hasRoles(['oper']);
    }

    public function isFac()
    {
      return $this->hasRoles(['fac']);
    }

    public function isPag()
    {
      return $this->hasRoles(['pag']);
    }

    public function operations()
    {
      return $this->hasMany(Operation::class);
    }

    public function present()
    {
      return new UserPresenter($this);
    }
}
