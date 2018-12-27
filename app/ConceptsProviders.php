<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\ConceptProviderPresenter;

class ConceptsProviders extends Model
{
    use GeneralFunctions;

	protected $fillable = ['concept_id', 'description', 'curr', 'rate', 'inactive_at'];

    public function invoices()
    {
    	return $this->belongsToMany(Invoice::class);
    }

	public function concept()
    {
    	return $this->belongsTo(Concepts::class);
    }

    public function present()
    {
      return new ConceptProviderPresenter($this);
    }
}
