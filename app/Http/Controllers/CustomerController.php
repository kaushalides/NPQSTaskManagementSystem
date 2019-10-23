<?php

namespace App\Http\Controllers;
use \Carbon\Carbon;

use Illuminate\Http\Request;
use PDF;
use DB;

class CustomerController extends Controller
{
    public function printPDF(Request $req)
    {
        $id = $req->name;
     
       // This  $data array will be passed to our PDF blade
    if($id =="Ongoing"){
       $tasks = DB::table('tasks')
       ->leftjoin('reminder', 'reminder.task_id', '=', 'tasks.tasks_id')

       ->join('employees', function ($join) {
           $join->on('tasks.officer_id', '=', 'employees.employee_id')
           ->whereBetween('tasks.dead_line', [$req->startdate, $req->enddate])
                ->where('tasks.status','=',1);

       })
       ->get();

    }
    else if($id =="Pending"){
        $tasks = DB::table('tasks')
        ->leftjoin('reminder', 'reminder.task_id', '=', 'tasks.tasks_id')

        ->join('employees', function ($join) use ($req) {
            $join->on('tasks.officer_id', '=', 'employees.employee_id')
            ->whereBetween('tasks.dead_line', [$req->startdate,$req->enddate])
            ->where('tasks.status','=',1);
        })
        ->get();
    }
    else if($id =="Completed"){
    $tasks = DB::table('tasks')
    ->leftjoin('reminder', 'reminder.task_id', '=', 'tasks.tasks_id')

    ->join('employees', function ($join) {
        $join->on('tasks.officer_id', '=', 'employees.employee_id')
        ->whereBetween('tasks.dead_line', [$req->startdate,$req->enddate])

             ->where('tasks.status','=',0);

    })
    ->get();

}
       $data = [
          'title' => $id.' Tasks From '.$req->startdate.' To '.$req->enddate,
          'content' => $tasks
          ];
        
        $pdf = PDF::loadView('pdf_view', $data);  
        return $pdf->stream('/medium.pdf');
    }
}
