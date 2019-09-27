<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sections;
use App\Employee;
use DB;

class EmployeeController extends Controller
{
    public function index(){
        $sections= Sections::all()->toArray();
            //dd($sections);
        return view('add_task',compact('sections'));
        }
   
   
     // Fetch records
     public function getEmployees($sectionid=0){
        // Fetch Employees by Departmentid
        $userData['data'] = Employee::getSectionEmployee($sectionid);

             return  $userData;                                                                                                                                                                                                                                                                                                                                                                                                                                                
      }
      public function getAllEmployees(){
        $employee= Employee::select('employee_id','employee_name','employee_position','section_id')->get();
        return $employee;
      }
       // Fetch records
     public function getSections(){
      $sections= Sections::select('section_id','section')->get();
      return $sections;
    }
}
