<?php

namespace App;

use App\Presenters\ConceptPresenter;
use Illuminate\Database\Eloquent\Model;

class Concepts extends Model
{
	protected $fillable = ['description', 'curr', 'rate', 'inactive_at'];

    public function operations()
    {
    	return $this->belongsToMany(Operation::class);
    }

    public function present()
    {
      return new ConceptPresenter($this);
    }
}
