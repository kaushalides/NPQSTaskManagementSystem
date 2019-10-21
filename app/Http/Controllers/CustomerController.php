<?php

namespace App\Http\Controllers;
use \Carbon\Carbon;

use Illuminate\Http\Request;
use PDF;
use DB;

class CustomerController extends Controller
{
    public function printPDF($id)
    {
       // This  $data array will be passed to our PDF blade
       //dd($id);
    if($id =="Ongoing"){
       $tasks = DB::table('tasks')
       ->leftjoin('reminder', 'reminder.task_id', '=', 'tasks.tasks_id')

       ->join('employees', function ($join) {
           $join->on('tasks.officer_id', '=', 'employees.employee_id')
                ->where('tasks.dead_line','>=',Carbon::now()->format('Y-m-d'))
                ->where('tasks.status','=',1);

       })
       ->get();

    }
    else if($id =="pending"){
        $tasks = DB::table('tasks')
        ->join('employees', function ($join) {
            $join->on('tasks.officer_id', '=', 'employees.employee_id')
                 ->where('tasks.dead_line','<=',Carbon::now()->format('Y-m-d'))
                 ->where('tasks.status','=',1);
        })
        ->get();
    }
    else if($id =="Completed"){
    $tasks = DB::table('tasks')
    ->join('employees', function ($join) {
        $join->on('tasks.officer_id', '=', 'employees.employee_id')
             ->where('tasks.status','=',0);

    })
    ->get();

}
       $data = [
          'title' => $id.' Tasks',
          'content' => $tasks
          ];
        
        $pdf = PDF::loadView('pdf_view', $data);  
        return $pdf->stream('/medium.pdf');
    }
}
