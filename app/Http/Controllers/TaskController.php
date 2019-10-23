<?php

namespace App\Http\Controllers;
use \Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Tasks;

class TaskController extends Controller
{
    public function ongoingTask(){
  
$name = 'Ongoing';

       $tasks = DB::table('tasks')
       
       ->orderBy('tasks.allocated_date', 'asc')
       ->join('employees', function ($join) {
           $join->on('tasks.officer_id', '=', 'employees.employee_id')
                ->where('tasks.dead_line','>=',Carbon::now()->format('Y-m-d'))
                ->where('tasks.status','=',1);

       })
       ->get();
        return view('view_task',compact(['tasks', 'name'])
    )->with('name', $name);
    }

    public function pendingTask(){
        $name = 'Pending';
        $date=  Carbon::now()->format('Y-m-d');
         $tasks = DB::table('tasks')
         ->join('employees', function ($join) {
             $join->on('tasks.officer_id', '=', 'employees.employee_id')
         ->orderBy('tasks.allocated_date', 'desc')

                  ->where('tasks.dead_line','<=',Carbon::now()->format('Y-m-d'))
                  ->where('tasks.status','=',1);
         })                       


         ->get();
  
  
          return view('view_task',compact('tasks'))->with('name', $name);
      }
      public function completedTask(){
        $name = 'Completed';

        $tasks = DB::table('tasks')
        ->orderBy('tasks.allocated_date', 'asc')
        ->join('employees', function ($join) {
            $join->on('tasks.officer_id', '=', 'employees.employee_id')
                 ->where('tasks.status','=',0);
 
        })
        ->get();
  
          return view('view_task',compact('tasks'))->with('name', $name);
      }
    public function store(Request $request){
        $task = new Tasks;
            $task->serial_no = $request->serial_no;
            $task->allocated_date = $request->allocated_date;
            $task->task = $request->task;
            $task->officer_id = $request->officer_id;
            $task->dead_line = $request->deadline;
            $task->references = $request->references;
            $task->status = 1;

            $task->save();
            return redirect()->back();
    }
    public function getReminders(Request $req){
    $taskid= $req->taskid;
    $tasks['data'] =  DB::table('reminder')
    ->where('task_id','=',$taskid)
    ->get();
   return $tasks;
    }
    public function deleteTask(Request $req){
        $taskid= $req->taskid;

        DB::table('tasks')->where('tasks_id', $taskid)->update([
            'status' => 0
            ]);
        return true;
    }
    public function updateTask(Request $req){ 
        $taskid= $req->taskid;
        $serialnmbr= $req->serialnmbr;
        $allocated_date= $req->allocated_date;
        $task= $req->task;
        $officer_id= $req->officer_id;
        $deadline= $req->deadline;
        $ref= $req->ref;

        DB::table('tasks')->where('tasks_id', $taskid)->update([

            'serial_no' =>$serialnmbr,
            'allocated_date'=>$allocated_date,
            'task'=>$task,
            'officer_id' => $officer_id,
            'dead_line' =>$deadline,
            'references' => $ref,
            'status' => 1
            ]);
        return true;
    }
    public function addReminders(Request $request){
        $task = $request->taskid;
        $reminder_note = $request->reminder_note;
        $date=  Carbon::now()->format('Y-m-d');

           
            DB::insert('insert into reminder (task_id,reminder_note,reminder_added_date) values(?,?,?)',[$task,$reminder_note,$date]);
                  return redirect()->back();
    }
    public function taskCompleted(Request $req){ 
        $taskid= $req->taskid;
        $date=  Carbon::now()->format('Y-m-d');
        if($taskid == 1){
            DB::table('tasks')->where('tasks_id', $taskid)->update([

                'updated_at'=>$date,
                
                'status' => 0
                ]);
        }else{
        DB::table('tasks')->where('tasks_id', $taskid)->update([

            'updated_at'=>$date,
            
            'status' => 1
            ]);
    }
    return true;

}
}
