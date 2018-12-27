<?php

namespace App\Presenters;

use App\User;
use Illuminate\Support\HtmlString;

class UserPresenter extends Presenter
{
    public function roles()
    {
      return $this->model->roles->pluck('display_name')->implode(', ');
    }

	  public function hasRoles(array $roles)
    {
        return $this->model->roles->pluck('name')->intersect($roles)->count();
    }

    public function isAdmin()
    {
      return $this->hasRoles(['administrador']);
    }

    public function isOper()
    {
      return $this->hasRoles(['operador']);
    }

    public function isFac()
    {
      return $this->hasRoles(['facturador']);
    }

    public function isFin()
    {
      return $this->hasRoles(['finanzas']);
    }

    public function isAdminGeneral()
    {
      return $this->hasRoles(['administradorgeneral']);
    }

    public function createdUserNotification($notification)
    {
      $this->model = User::findOrFail($notification->data['created_user']);

      return $this->model;
    }

    public function statusBadge()
    {
      if($this->model->inactive_at){
            return new HtmlString('<span class="badge badge-danger-lighten"><i class="mdi mdi-close-circle-outline"></i> Inactivo</span>');
        }else{
            if($this->model->roles->isEmpty()){
                return new HtmlString('<span class="badge badge-warning-lighten"><i class="mdi mdi-alert-outline"></i> Rol no asignado</span>');
            }else{
                return new HtmlString('<span class="badge badge-success-lighten"><i class="mdi mdi-check-circle-outline"></i> Activo</span>');
            }
        }
    }
}
