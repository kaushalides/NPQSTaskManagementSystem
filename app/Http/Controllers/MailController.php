<?php

namespace App\Http\Controllers;
use \Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Tasks;
use Mail;
use App\mail\SendMail;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    public function basic_email(Request $req) {
        //dd("here");
$emailto =$req->emailto;
$title =$req->title;
$task_assign =$req->task_assign;
$all_date =$req->all_date;
$dl =$req->dl;
$emailfrom =$req->emailfrom;
$emailsub =$req->emailsub;
$serial_no =$req->serial_no;
$officer_id =$req->officer_id;$references =$req->references;



       $task = new Tasks;
      $task->serial_no = $serial_no;
      $task->allocated_date = $all_date;
       $task->task = $task_assign;
       $task->officer_id = $officer_id;
       $task->dead_line = $dl;
      $task->references = $references;
      $task->status = 1;

        $task->save();


        $data = array(
            'emailto'=>$emailto,
            'title'=>$title,            
           'task_assign'=>$task_assign,
            'all_date'=>$all_date,
            'dl'=>$dl,
            'emailfrom'=>$emailfrom,
            'emailsub'=>$emailsub
        );
     
        Mail::send(new SendMail( $data));
        return redirect()->back();
        
     }

     public function addReminders(Request $request){
        $task_id = $request->taskid;
        $reminder_note = $request->reminder_note;
        $date=  Carbon::now()->format('Y-m-d');
        
        $tasks_data = DB::table('tasks')->where('tasks.tasks_id','=',$task_id)
        ->join('employees', function ($join) {
            $join->on('tasks.officer_id', '=', 'employees.employee_id');
 
        })
        ->get();
        foreach($tasks_data as $tasks){
        $emailto=$tasks->email_address;
        $title = "Hello, ".$tasks->employee_name;
        $task_assign = "Your Task is ".$tasks->task
         ." This is a reminder for you. Reminder note: ".$reminder_note;
        $all_date = $tasks->allocated_date;
        $dl = $tasks->dead_line;
        $emailfrom = "newtask.npqs@gmail.com";
        $emailsub = "Reminder";
        
    }

    $data = array(
        'emailto'=>$emailto,
        'title'=>$title,            
       'task_assign'=>$task_assign,
        'all_date'=>$all_date,
        'dl'=>$dl,
        'emailfrom'=>$emailfrom,
        'emailsub'=>$emailsub
    );
    Mail::send(new SendMail( $data));
    $date=  Carbon::now()->format('Y-m-d');

          DB::table('reminder')->insert(
            ['task_id' => $task_id, 'reminder_note' => $reminder_note,
            'reminder_added_date' => $date]
          );
            return redirect()->back();

     }
}
