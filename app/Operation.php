<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operation extends Model
{

    protected $fillable = ['user_id', 'shipper', 'master_consigner', 'house_consigner', 'etd', 'eta', 'impo_expo', 'pol', 'pod', 'destino', 'incoterm', 'booking', 'custom_cutoff', 'vessel', 'o_f', 'c_invoice', 'm_bl', 'h_bl', 'cntr', 'type', 'size', 'qty', 'weight_measures', 'modalidad', 'aa'];

    use SoftDeletes;

    public function hasRoles(array $roles)
    {
        return $this->roles->pluck('name')->intersect($roles)->count();
    }

    public function isAdmin()
    {
      return $this->hasRoles(['admin']);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    // public function getEtdAttribute()
    // {        
    
    // }


    // public function getEtaAttribute()
    // {
      
    // }


    // public function getCustomCutoffAttribute()
    // {
      
    // }


    function setEtdAttribute($etd)
    {
        $this->attributes['etd'] = Carbon::parse($etd)->format('Y-m-d');
    }

    function setEtaAttribute($eta)
    {
        $this->attributes['eta'] = Carbon::parse($eta)->format('Y-m-d');
    }

    function setCustomCutoffAttribute($custom_cutoff)
    {
        $this->attributes['custom_cutoff'] = Carbon::parse($custom_cutoff)->format('Y-m-d');
    }
}
