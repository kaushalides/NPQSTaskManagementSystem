<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sections;
use App\Employee;
use DB;
use \Carbon\Carbon;

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
    public function addNewEmployee(){
      $sections= Sections::all()->toArray();
      return view('add_employees',compact('sections'));
    }
    public function addSection(Request $request)
    {
        $date=  Carbon::now()->format('Y-m-d');
DB::table('sections')->insert(
  ['section' => $request->sectionname, 'contact' => $request->sectionphone_ex,
  'contact_email' => $request->sectionemail, 'created_at' => $date]
);
return redirect()->back();
    }
    public function addemployee(Request $request)
    {
        $date=  Carbon::now()->format('Y-m-d');
DB::table('employees')->insert(
  ['employee_name' => $request->empname, 'employee_position' => $request->emp_des,
  'section_id' => $request->section, 'email_address' => $request->emp_email,'contact_no' => $request->empnmbr,'created_at' => $date]
);
return redirect()->back();

    }
   
}
