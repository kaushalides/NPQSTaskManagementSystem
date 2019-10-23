@extends('layout.mainlayout')
@section('content')
<script type="text/javascript">
  $(document).ready(function() {
   
   var enddate=$('input[name="enddate"]'); //our date input has the name "date"
   var startdate=$('input[name="startdate"]'); 
 
       var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
       var options={
         format: 'yyyy/mm/dd',
         container: container,
         todayHighlight: true,
         orientation: 'auto',
         changeMonth: true,
         changeYear: true,
         autoclose: true,
         startdate: new Date()
 
       };
       enddate.datepicker(options);
       startdate.datepicker(options);
       
      var modal = document.getElementById("popup");
      modal.style.display = "none";
      $('#tbl_task').DataTable({
    "pagingType": "simple", // "simple" option for 'Previous' and 'Next' buttons only
    "pageLength": 5,
    searching: false,
    bLengthChange: false
  });
  $('.dataTables_length').addClass('bs-select');
  function changedIt(){
}

$('#secpopup').change(function(){
  document.getElementById('employeepopup').options.length = 0;

  var id = this.value;
  $.ajax({
     url: 'getEmployees/'+id,
     type: 'get',
     dataType: 'json',
     success: function(response){
       var len = 0;
       if(response['data'] != null){
         len = response['data'].length;
      }
       if(len > 0){
         for(var i=0; i<len; i++){
          var name = response['data'][i].employee_name;
          var id = response['data'][i].employee_id;
           var option = "<option value='"+id+"'>"+name+"</option>"; 
          $("#employeepopup").append(option); 
         }
         $('#employeepopup').val(officerid);
       }
     } ,
     error:function(){
     }
  });
});
var x = document.getElementById("reminderlbl");
var addrem = document.getElementById("addrem");

var y = document.getElementById("reminder");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
  if (y.style.display === "none") {
    y.style.display = "block";
  } else {
    y.style.display = "none";
  }
  //addrem.style.display = "none";
  //$("addrem").hide();
  addrem.style.visibility = 'hidden'; 

} );
function searchSection($nmbr,$search){
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById($search);
  filter = input.value.toUpperCase();
  table = document.getElementById("tbl_task");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[$nmbr];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }}
function deleteRecord(){
  var taskid = document.getElementById("task_idpopup").value;
  $.ajax({
        type: 'post',
        url: '/delTask',  
        data: {
        "_token": "{{ csrf_token() }}",
        "taskid": taskid
        },    
        success: function(response) {
        var modal = document.getElementById("popup");
  modal.style.display = "none";
        },
        complete: function (jqXHR, textStatus) {
          location.reload(true);

        },
        error:function(){
        }
    });

    addrem.style.visibility = 'hidden'; 

}
function updateRecord(){
  var taskid = document.getElementById("task_idpopup").value;
  var serialnmbr   = document.getElementById("serialnmbr").value;
  var allocated_datepopup   = document.getElementById("allocated_datepopup").value;
  var taskpopup   = document.getElementById("taskpopup").value;
  var officer_idpopup   = document.getElementById("employeepopup").value;
  var deadlinepopup   = document.getElementById("deadlinepopup").value;
  var refpopup   = document.getElementById("refpopup").value;
$.ajax({
        type: 'post',
        url: '/updateTask',  
        data: {
        "_token": "{{ csrf_token() }}",
        "taskid": taskid,
        "serialnmbr" : serialnmbr,
        "allocated_date" : allocated_datepopup,
        "task" : taskpopup,
        "officer_id" :officer_idpopup,
        "deadline" : deadlinepopup,
        "ref" : refpopup
        },    
        success: function(response) {
          var modal = document.getElementById("popup");
  modal.style.display = "none";
        },
        complete: function (jqXHR, textStatus) {
          location.reload(true);

        },
        error:function(){
        }
    });
    addrem.style.visibility = 'hidden'; 

}
 
  
function popupModel(btnid){
  var modal = document.getElementById("popup");
  const splitString = btnid.split("_");
  var serial_no = document.getElementById("serialno_"+splitString[1]).value;
  var task = document.getElementById("task"+splitString[1]).value;
  var allocated_date = document.getElementById("allocated_date_"+splitString[1]).value;
  var dead_line = document.getElementById("dead_line_"+splitString[1]).value;
  var employee_name = document.getElementById("employee_name_"+splitString[1]).value;
  var references = document.getElementById("references_"+splitString[1]).value;
  var taskid = document.getElementById("taskid_"+splitString[1]).value;
  var officerid = document.getElementById("officerid_"+splitString[1]).value;
  var section_id = document.getElementById("section_id_"+splitString[1]).value;
  document.getElementById("serialnmbr").value =serial_no;
  document.getElementById("taskpopup").value =task;
  document.getElementById("allocated_datepopup").value =allocated_date;
  document.getElementById("deadlinepopup").value =dead_line;
  document.getElementById("employeepopup").value =employee_name;
  document.getElementById("refpopup").value =references;
  document.getElementById('secpopup').options.length = 0;
  document.getElementById('employeepopup').options.length = 0;
  document.getElementById('task_idpopup').value = taskid;
  document.getElementById('officer_idpopup').value = officerid;
  document.getElementById("reminder").value ="";
  var x = document.getElementById("reminderlbl");
  var y = document.getElementById("reminder");
  x.style.display = "none";
  y.style.display = "none";
  $('#secpopup').find('option').not(':first').remove();
  $('#employeepopup').find('option').not(':first').remove();

  $.ajax({
        type: 'get',
        url: '/getSections',      
        success: function(response) {
          var length =response.length;
          var option;
          for(var i=0; i<length; i++){ 
            option = "<option value='"+ response[i].section_id+"'>"+response[i].section+"</option>"; 
            $("#secpopup").append(option); 
          }
          $('#secpopup').val(section_id);
        },
        complete: function (jqXHR, textStatus) {
        },
        error:function(){
        }
    });
   



   
    $.ajax({
     url: 'getEmployees/'+section_id,
     type: 'get',
     dataType: 'json',
     success: function(response){
       var len = 0;
       if(response['data'] != null){
         len = response['data'].length;
      }
       if(len > 0){
         for(var i=0; i<len; i++){
          var name = response['data'][i].employee_name;
          var id = response['data'][i].employee_id;
           var option = "<option value='"+id+"'>"+name+"</option>"; 
          $("#employeepopup").append(option); 
         }
         $('#employeepopup').val(officerid);
       }
     },
     error:function(){
     }
  });
    $.ajax({
        type: 'POST',
        url: '/getReminders',
        data: {
        "_token": "{{ csrf_token() }}",
        "taskid": taskid
        },
        success: function(msg) {
          var len = 0;
       if(msg['data'] != null){
         len = msg['data'].length;
      }

        //closeModel();
        if(len>0){
          var fullnote = "";
          for(var i=0; i<len; i++){
            var name = msg['data'][i].reminder_note;
            var added_date = msg['data'][i].reminder_added_date;


            fullnote=name+' Added on '+added_date+'\n' +fullnote ;
            //document.getElementById("serialnmbr").value =serial_no;
          

          }
          document.getElementById("reminder").value =fullnote;

       

        document.getElementById("reminder_status").value = 1;
        //refpopup
        x.style.display = "block";
        y.style.display = "block";

        }
        },
        complete: function (jqXHR, textStatus) {
        },
        error:function(){
        }
    });
  modal.style.display = "block";
}
  function addReminder(){
    var reminder_status = document.getElementById("reminder_status").value;
    var addrem = document.getElementById("addrem");
addrem.style.visibility = 'visible'; 
    //document.getElementById("reminder_status").value = 0;


  }
function closeModel(){
  var modal = document.getElementById("popup");
  modal.style.display = "none";
  addrem.style.visibility = 'hidden'; 

}
function addNewReminder(){
  var spinner = $('#loader');

  var taskid = document.getElementById("task_idpopup").value;
  var reminder = document.getElementById("rempopup").value;
  $.ajax({
        type: 'POST',
        url: '/addReminders',
        data: {
        "_token": "{{ csrf_token() }}",
        "taskid": taskid,
        "reminder_note":reminder
        },
        success: function(msg) {
      var modal = document.getElementById("popup");
      modal.style.display = "none";
        },beforeSend: function() {
    spinner.show();


        },
        complete: function (jqXHR, textStatus) {
          spinner.hide();

        location.reload(true);

        },
        error:function(){
        }
    });
    }
function completed(btnid){
  const splitString = btnid.split("_");

  var taskid = document.getElementById("taskid_"+splitString[3]).value;
  $.ajax({
        type: 'POST',
        url: '/taskCompleted',
        data: {
        "_token": "{{ csrf_token() }}",
        "taskid": taskid
        },
        success: function(msg) {

    
        },
        complete: function (jqXHR, textStatus) {
          location.reload(true);

        },
        error:function(){
        }
    });
}
</script>
<div class="container"  style="margin-left:15%; margin-right:10%; height:100%">
    <div class="text-center">

<h1 class="text-uppercase" style="color:white;"> <?= $name; ?> tasks</h1>
<br/>


<!-- The Modal -->
      <div id="popup" class="modal1">
                                                  
<!-- Modal content -->
        <div class="modal-content1">
          <form class="form-horizontal" name="popup" id="popup" action="">

          <div class="text-center">
          <h1 class="text-uppercase" style="color:black;"> Tasks</h1>
          </div>
          <br>
          <div class="row">
                <input type="hidden"   class="form-control" id="task_idpopup"  name="task_idpopup">

                <div class="form-group col-md-2" style="align:left">
                  <label class="control" for="serialnmbr">Serial Number:</label>
                  </div>
                <div class="form-group col-md-4">
                  <input type="text"   class="form-control" id="serialnmbr"  name="serialnmbr">
                  <input type="hidden"   class="form-control" id="officer_idpopup"  name="officer_idpopup">

                </div>
                <div class="form-group col-md-1">
                <label class="control" for="taskpopup">Task:</label>
                </div>
                <div class="form-group col-md-5 ">
                  <textarea class="form-control"  rows="2" name="taskpopup" id="taskpopup" >
                    </textarea>
                </div>
            </div>

              <div class="row">

                  <div class="form-group col-md-2">
                  <label class="control" for="allocated_datepopup">Allocated Date:</label>
                  </div>
                  <div class="form-group col-md-4">
                    <input type="text"   class="form-control" readonly id="allocated_datepopup"  name="allocated_datepopup">
                  </div>
                  <div class="form-group col-md-1">
                    <label class="control" for="deadlinepopup">DeadLine:</label>
                    </div>
                  <div class="form-group col-md-5 ">
                  <input type="text"   class="form-control" readonly id="deadlinepopup"  name="deadlinepopup">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-2">
                  <label class="control" for="secpopup">Section:</label>
                  </div>
                  <div class="form-group col-md-4">
                  <select class="form-control dynamic"  name="secpopup" id="secpopup">
                          </select>
                          <input type='hidden' name= 'secpopup_id' id='secpopup_id' value='0'/>
                  </div>
                  <div class="form-group col-md-1">
                  <label class="control" for="employeepopup">Employee:</label>
                  </div>
                  <div class="form-group col-md-5">
                  <select class="form-control dynamic" name="employeepopup" id="employeepopup">
                          </select>
                          <input type='hidden' name= 'officer_id' id='officer_id' value='0'/>
                  </div>

                  </div>
                  <div class="row">

                    <div class="form-group col-md-2" style="align:left">
                      <label class="control" for="refpopup_id">Reference:</label>
                      </div>
                    <div class="form-group col-md-4">
                      <input type="text"   class="form-control" id="refpopup"  name="refpopup">
                  </div>
                <div class="form-group col-md-1">
                  <label class="control" id="reminderlbl" name="reminderlbl" for="setReminder">Reminder Note:</label>
                  </div>
                  <div class="form-group col-md-5 ">
                    <textarea readonly class="form-control"  rows="2" name="reminder" id="reminder" ></textarea>
                </div>
              </div>
                    <div name ="addrem" id="addrem"class="row">

                    <div class="form-group col-md-2" style="align:left">
                      <label class="control" for="rempopup_id">Add Reminder:</label>
                      </div>
                    <div class="form-group col-md-4">
                      <input type="text"   class="form-control" id="rempopup"  name="rempopup">
                      </div>

                    <div class="form-group col-md-2">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div id="loader"></div>

                      <button type="button" onClick="addNewReminder();" class="btn btn-primary">Add New Reminder</button>

                    </div>

                  </div>



                        <input type="hidden" value="0" name="reminder_status" id="reminder_status" >
                        <input type="hidden" name="title" id="title" >
                          <input type="hidden" name="task_assign" id="task_assign" >
                          <input type="hidden" name="all_date" id="all_date" >
                          <input type="hidden" name="dl" id="dl" >
                        <br>
                  <div class="form-group">        
                    <div class="col-sm-offset-2 col-sm-10"> 
                    <button type="button" onClick="addReminder();" class="btn btn-info">Add Reminder</button>

                      <button type="button" onClick="updateRecord();" class="btn btn-success">Update</button>
                      <button type="button" onClick="deleteRecord();" class="btn btn-danger">Delete</button>

                      <button type="button" onClick="closeModel();" data-dismiss="modal1" class="btn btn-warning  ">Close</button>
                    </div>
                  </div>
  </form>
</div>
</div>


      <div class="row">
      
      <div class="active-cyan-3 active-cyan-3 col-md-3">
        <input class="form-control" type="text" name="myno_search" id="myno_search" onkeyup="searchSection(0 ,'myno_search')" placeholder="Search By My Number" aria-label="Search">
      </div>
      <div class="active-cyan-3 active-cyan-3 col-md-3">
        <input class="form-control" type="text" name="emp_search" id="emp_search" placeholder="Search By Employee" onkeyup="searchSection(4 ,'emp_search')" aria-label="Search">
      </div>
      <div class="input-group col-md-6">
      <form class=" form-inline" target="_blank" action="{{route('customer.printpdf', $name)}}">

      <input type="text" class=" form-control col-md-3  date" id="startdate" name="startdate" placeholder= "Start Date ">
      <input type="text" class=" form-control col-md-3 date" id="enddate" name="enddate" placeholder= "End Date ">
       
      <input type= "submit" class="btn btn-primary col-md-3 " href="" value="Print PDF">
      </form>
      </div>

    </div>
<br/><br/>

     <table class= "table  table-responsive" style="color: '#00004d';"id="tbl_task" name="tbl_task"  >
        <thead class="thead-light">

        <tr>
        <th>My NO</th>
        <th>Task</th>
        <th>Allocated Date</th>
        <th>DeadLine</th>
        <th>Officer</th>
        <th>Reference</th>
        <th>Action</th>
        <th>Status</th>

        </tr>
        </thead>
  
        <tbody class="tbody-dark">
        <?php
$x=0;
?>
@foreach($tasks as $task)

<tr>
<td >{{$task->serial_no}}</td>
<td>{{$task->task}}</td>
<td>{{$task->allocated_date}}</td>
<td>{{$task->dead_line}}</td>
<td>{{$task->employee_name}}</td>
<td>{{$task->references}}</td>

<td>
<input type="hidden" id="serialno_<?php echo $x; ?>" value="<?php echo $task->serial_no ?>">
<input type="hidden" id="task<?php echo $x; ?>" value="<?php echo $task->task ?>">
<input type="hidden" id="allocated_date_<?php echo $x; ?>" value="<?php echo $task->allocated_date ?>">
<input type="hidden" id="dead_line_<?php echo $x; ?>" value="<?php echo $task->dead_line ?>">
<input type="hidden" id="employee_name_<?php echo $x; ?>" value="<?php echo $task->employee_name ?>">
<input type="hidden" id="references_<?php echo $x; ?>" value="<?php echo $task->references ?>">
<input type="hidden" id="taskid_<?php echo $x; ?>" value="<?php echo $task->tasks_id ?>">
<input type="hidden" id="officerid_<?php echo $x; ?>" value="<?php echo $task->officer_id ?>">
<input type="hidden" id="section_id_<?php echo $x; ?>" value="<?php echo $task->section_id ?>">
<?php
if($task->status){}
?>
<button class="btn btn-primary btn-xs"  name="btnPopup_<?php echo $x; ?>" id="btnPopup_<?php echo $x; ?>" onClick="popupModel(this.id);"><i class="fa fa-pencil fa-xs"></i></button>
</td>

<td>
<?php
if($task->status){
?>
<button class="btn btn-success btn-xs" name="btn_sus_Popup_<?php echo $x; ?>" id="btn_sus_Popup_<?php echo $x; ?>" onClick="completed(this.id);"><i class="fa fa-check fa-xs">Done</i></button>
<?php
} else{?>
<button class="btn btn-danger btn-xs" name="btn_sus_Popup_<?php echo $x; ?>" id="btn_sus_Popup_<?php echo $x; ?>" onClick="completed(this.id);"><i class="fa fa-check fa-xs">UnDo</i></button>
<?php
}?>
    </td>
    
</tr>
<?php $x=$x+1;?>

@endforeach
</tbody>
<div id="pager">
      <ul id="pagination" class="pagination-sm"></ul>
</div>
</div></div>
        </table>
        

 
@endsection
<b></b>
<style>
#loader {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  width: 100%;
  background: rgba(0,0,0,0.75) url(images/loading2.gif) no-repeat center center;
  z-index: 10000;
}
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal1 {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content1 {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

</style>