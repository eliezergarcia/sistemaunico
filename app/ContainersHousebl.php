<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContainersHousebl extends Model
{
    protected $fillable = ['container_id'];

    public function housebl()
    {
    	return $this->belongsTo(Housebl::class);
    }

    public function operation()
    {
    	return $this->belongsTo(Operation::class);
    }

    public function container()
    {
    	return $this->belongsTo(Container::class);
    }

    public function getWeightAttribute()
    {
      foreach ($this->container as $key => $value) {
          # code...
      }
    }
}
