<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    public static function getVehicle($id){
        $vehicle = Vehicle::find($id);
		return $vehicle;
	}
}
