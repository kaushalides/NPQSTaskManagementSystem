<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

 </head>
 <body class="main">

<h1 class=" text-uppercase">{{$title}}<h1>
<table class= "table  table-responsive" style="color: '#00004d';"id="tbl_task" name="tbl_task"  >
        <thead class="thead-light">

        <tr>
        <th>Task</th>
        <th>Allocated Date</th>
        <th>DeadLine</th>
        <th>Officer</th>
        <th>Reference</th>
        <th>Reminder</th>
        <th>Reminder Added on</th>

        </tr>
        </thead>
  
        <tbody class="tbody-dark">
        <?php
$x=0;
?>
@foreach($content as $task)

<tr>
<td>{{$task->task}}</td>
<td>{{$task->allocated_date}}</td>
<td>{{$task->dead_line}}</td>
<td>{{$task->employee_name}}</td>
<td>{{$task->references}}</td>
<td>{{$task->reminder_note}}</td>
<td>{{$task->reminder_added_date}}</td>




</tr>

@endforeach
</tbody>

</div></div>
        </table>
     </body> 
     <style>

     #tbl_task {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#tbl_task td, #tbl_task th {
  border: 1px solid #ddd;
  padding: 8px;
}

#tbl_task tr:nth-child(even){background-color: #f2f2f2;}

#tbl_task tr:hover {background-color: #ddd;}

#tbl_task th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>
       </html>
