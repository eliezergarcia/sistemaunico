<?php

namespace App;

use Carbon\Carbon;
use App\Presenters\UserPresenter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Notifications\OperationDelay;
use App\Notifications\OperationStorage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use GeneralFunctions;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_name', 'email', 'password', 'phone', 'address', 'email_office', 'password_email_office', 'inactive_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
      return $this->belongsToMany(Role::class, 'assigned_roles')->orderBy('id', 'asc');
    }

    public function clients()
    {
      return $this->belongsToMany(Client::class, 'assigned_clients');
    }

    public function operations()
    {
      return $this->hasMany(Operation::class);
    }

    public function debitnotes()
    {
        return $this->hasManyThrough(DebitNote::class, Operation::class);
    }

    public function prefactures()
    {
        return $this->hasManyThrough(Prefacture::class, Operation::class);
    }

    public function housebls()
    {
        return $this->hasManyThrough(Housebl::class, Operation::class);
    }

    public function present()
    {
      return new UserPresenter($this);
    }

    public function setPasswordAttribute($password)
    {
      $this->attributes['password'] = bcrypt($password);
    }

    public function getUrlAttribute()
    {
      if (!$this->avatar) {
        return 'public/default-user.png';
      }

      return $this->avatar;
    }

    public function notificationsStorage()
    {
        if($this->roles->pluck('name')->contains('operador') || $this->roles->pluck('name')->contains('administrador')){
            $operations = Operation::where('impo_expo', 'impo')
                                   ->where('toca_piso', '!=', null)->get();

            foreach ($operations as $operation) {
                if ($operation->pod == "LZC") {
                    $diasalmacenaje = 10;
                }else{
                    $diasalmacenaje = 7;
                }

                $date = Carbon::now();
                $date = $date->format('Y-m-d');
                $fecha = Carbon::createFromFormat('Y-m-d', $date);
                foreach ($operation->containers as $container) {
                    $eta = Carbon::createFromFormat('Y-m-d', $operation->eta);
                    if ($eta->diffInDays($fecha) <= $diasalmacenaje && ($container->port_etd == null && $container->dlv_day == null)) {
                        self::createNotificationOperationStorage($operation, $container);
                    }
                }
            }
        }
    }

    public function notificationsDelay()
    {
        if($this->roles->pluck('name')->contains('operador') || $this->roles->pluck('name')->contains('administrador')){
            $operations = Operation::where('impo_expo', 'impo')
                                   ->where('toca_piso', '!=', null)->get();

            foreach ($operations as $operation) {
                $diasdemora = 2;

                $date = Carbon::now();
                $date = $date->format('Y-m-d');
                $fecha = Carbon::createFromFormat('Y-m-d', $date);
                foreach ($operation->containers as $container) {
                    $eta = Carbon::createFromFormat('Y-m-d', $operation->eta);
                    if ($eta->diffInDays($fecha) <= $diasdemora && ($container->port_etd != null && $container->dlv_day == null)) {
                        self::createNotificationOperationDelay($operation, $container);
                    }
                }
            }
        }
    }

    public function createNotificationOperationStorage($operation, $container)
    {
        $users = User::all();

        $existsNotification = DB::table('notifications')->where('data', 'like', '%'.'OA'.$container->id.'%')
                                                  ->where('read_at', null)->get();

        if (!$existsNotification || $existsNotification->isEmpty()) {
            foreach ($users as $user) {
                if(($user->roles->pluck('name')->contains('administrador') && $user->roles->pluck('name')->contains('operador')) || $user->roles->pluck('name')->contains('administradorgeneral') || ($user->id == $operation->user_id)){
                    $user->notify(new OperationStorage($operation, $container));
                }
            }
        }
    }

    public function createNotificationOperationDelay($operation, $container)
    {
        $users = User::all();

        $existsNotification = DB::table('notifications')->where('data', 'like', '%'.'OD'.$container->id.'%')
                                                  ->where('read_at', null)->get();

        if (!$existsNotification || $existsNotification->isEmpty()) {
            foreach ($users as $user) {
                if(($user->roles->pluck('name')->contains('administrador') && $user->roles->pluck('name')->contains('operador')) || $user->roles->pluck('name')->contains('administradorgeneral') || ($user->id == $operation->user_id)){
                    $user->notify(new OperationDelay($operation, $container));
                }
            }
        }
    }
}
