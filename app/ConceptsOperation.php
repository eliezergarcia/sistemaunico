<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConceptsOperation extends Model
{
    protected $fillable = ['concept_id', 'operation_id', 'debit_note_id', 'prefacture_id', 'rate', 'iva', 'qty', 'foreign'];

    public function debitnote()
    {
    	return $this->belongsTo(Operation::class);
    }

	public function prefacture()
    {
    	return $this->belongsTo(Operation::class);
    }

    public function concept()
    {
    	return $this->belongsTo(Concepts::class);
    }
}
