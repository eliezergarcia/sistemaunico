<?php

namespace App;

use App\Container;
use App\ContainersHousebl;
use NumberToWords\NumberToWords;
use App\Presenters\HouseblPresenter;
use Illuminate\Database\Eloquent\Model;

class Housebl extends Model
{
    use GeneralFunctions;

	protected $fillable = [
        'operation_id', 'shipper', 'house_consignee', 'notify_party', 'no_pkgs', 'description', 'bl_type', 'cargo_type', 'service_term1', 'service_term2', 'description_header1', 'description_header2', 'freight_term'
    ];

	public function operation()
	{
		return $this->belongsTo(Operation::class);
	}

	public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'assigned_invoices');
    }

	public function containershousebl()
    {
      return $this->hasMany(ContainersHousebl::class, 'housebl_id');
    }

    public function present()
    {
        return new HouseblPresenter($this);
    }

    public function getShipAttribute()
    {
        $ship = Client::findOrFail($this->shipper);

        return $ship;
    }

    public function getHouseAttribute()
    {
        $house = Client::findOrFail($this->house_consignee);

        return $house;
    }

	public function getNumberFormatAttribute()
    {
        if ($this->number < 10) {
            $number = "0".$this->number;
        } else {
            $number = $this->number;
        }

        return "ULMX".substr($this->created_at->format('Ymd')."-".$number, 2);
    }

	public function getContainersGroupAttribute()
    {
        $groupBy = $this->containers->unique('size')->pluck('size');
        $pluck = $this->containers->pluck('size');
        $container = "";
        for ($i=0; $i < count($groupBy); $i++) {
            $count = 0;
            for ($j=0; $j < count($pluck); $j++) {
                if($groupBy[$i] == $pluck[$j])
                {
                    $count++;
                }
            }
            $container = $container.", ".$groupBy[$i]." x ".$count;
        }
        $container = substr($container, 1);

        return $container;
    }

 	public function getWeightHouseAttribute()
    {
        $numberToWords = new NumberToWords();

        $numberTransformer = $numberToWords->getNumberTransformer('en');

        return $numberTransformer->toWords(2);
    }
}
