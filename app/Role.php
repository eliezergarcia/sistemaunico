<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Role extends Model
{
	use Notifiable;

    protected $fillable = [
        'display_name', 'description',
    ];

    public function user()
    {
    	return $this->hasMany(User::class);
    }
}
