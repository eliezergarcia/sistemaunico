<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $fillable = ['title', 'created_by', 'start_date', 'end_date', 'color', 'message', 'deleted_at'];

    public function deleteUserEvents()
    {
		DB::table('assigned_events_users')->where('calendar_id', $this->id)->delete();
    }

 	public function deleteDepartmentsEvents()
    {
		DB::table('assigned_events_departments')->where('calendar_id', $this->id)->delete();
    }
}
