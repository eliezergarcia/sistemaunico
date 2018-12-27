<?php

namespace App;

use Carbon\Carbon;

trait GeneralFunctions
{
    public function activate()
    {
        $this->inactive_at = null;
        $this->save();
    }

    public function deactivate()
    {
        $this->inactive_at = Carbon::now();
        $this->save();
    }

    public function uncanceled()
    {
        $this->canceled_at = null;
        $this->save();
    }

    public function canceled()
    {
        $this->canceled_at = Carbon::now();
        $this->save();
    }
}
