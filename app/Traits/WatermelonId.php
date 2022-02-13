<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait WatermelonId
{

    public function id() {
        return $this->watermelon_id;
    }
}