<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
    public static function getSection(){

        $value=DB::table('sections')->orderBy('section_id', 'asc')->get(); 
        return $value;
      }
      public static function getSectionEmployee($sectionid=0){

        $value=DB::table('employees')->where('section_id', $sectionid)->get();

        return $value;
      }
   
}
