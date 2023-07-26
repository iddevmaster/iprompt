<?php

namespace App\CoreFunction;

use Illuminate\Database\Eloquent\Model;
use App\Models\agencie;
use App\Models\branche;
use App\Models\department;
use App\Models\user_role;


class Helper extends Model
{
    public static  function regData () {
        // return Branche Name and Brance Address จาก brance id

        $agencie = agencie::all();
        $department = department::all();
        $branche = branche::all();
        $role = user_role::all();

        return compact('agencie','department','branche','role');
    }

}