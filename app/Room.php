<?php

namespace App;

use App\Branch;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    public static function getBranch($id){
        $branch = Branch::find($id);
		return $branch->name;
	}
}
