<?php

namespace App;

use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
	use SoftDeletes;

    protected $fillable = ['read_at', 'deleted_at'];

    public function priorityBadge()
    {
		if($this->data['priority'] == 1){
            return new HtmlString('<span class="badge badge-danger">Alta</span>');
		}elseif($this->data['priority'] == 2){
            return new HtmlString('<span class="badge badge-warning">Media</span>');
		}elseif($this->data['priority'] == 3){
            return new HtmlString('<span class="badge badge-success">Baja</span>');
		}else{
            return new HtmlString('<span class="badge badge-secondary">Sin prioridad</span>');
		}
    }
}
