<?php

namespace App\Presenters;

use NumberToWords\NumberToWords;
use Illuminate\Support\HtmlString;

class houseblPresenter extends Presenter
{
    public function statusBadge()
    {
        if ($this->model->canceled_at) {
            return new HtmlString('<span class="badge badge-danger-lighten">Cancelado</span>');
        } else {
            // if($this->model->invoices->isEmpty()){
            //     return new HtmlString('<span class="badge badge-warning-lighten">Pendiente facturar</span>');
            // }
            // elseif($this->model->invoices->pluck('fecha_pago')->contains(null)){
            //     return new HtmlString('<span class="badge badge-warning-lighten">Pendiente pago</span>');
            // }else{
                return new HtmlString('<span class="badge badge-success-lighten">Finalizado</span>');
            // }
        }

    }

    public function noPackagesOrUnits()
    {
        $contenedores = collect();
        foreach($this->model->containershousebl as $container){
            $contenedores->push($container->container->size);
        }
        $uniques = $contenedores->unique();
        $conten = "";
        for ($i=0; $i < count($uniques); $i++) {
            $count = 0;
            for ($j=0; $j < count($contenedores); $j++) {
                if($uniques[$i] == $contenedores[$j])
                {
                    $count++;
                }
            }
            $conten = $conten.", ".$uniques[$i]." x ".$count;
        }
        return substr($conten, 1);
    }

    public function grossWeight()
    {
		$weight = 0;
        foreach($this->model->containershousebl as $container){
            $weight = $weight + $container->container->weight;
        }
        return number_format($weight, 2, ".", ",")." KGS.";
    }

    public function measurement()
    {
		$measurement  = 0;
        foreach($this->model->containershousebl as $container){
            $measurement  = $measurement  + $container->container->measures;
        }

        return number_format($measurement, 2, ".", ",")." CBM.";
    }

    public function noPackagesOrUnitsInWords()
    {
        $contenedores = collect();
        foreach($this->model->containershousebl as $container){
            $contenedores->push($container->container->size);
        }
        $uniques = $contenedores->unique();
        $conten = "";
        for ($i=0; $i < count($uniques); $i++) {
            $count = 0;
            for ($j=0; $j < count($contenedores); $j++) {
                if($uniques[$i] == $contenedores[$j])
                {
                    $count++;
                }
            }
            $conten = $conten.", (".$uniques[$i]." x ".$count.")";
        }
        $conten = substr($conten, 1);
        $numberToWords = new NumberToWords();

        $numberTransformer = $numberToWords->getNumberTransformer('en');

        if(count($uniques) == 1){
            return strtoupper($numberTransformer->toWords(count($uniques)))." ".$conten. " CONTAINER ONLY.";

        }else{
            return strtoupper($numberTransformer->toWords(count($uniques)))." ".$conten. "CONTAINERS.";
        }
    }
}