@extends('layout.mainlayout')
@section('content')
  
  <div class="container" style="margin-left:20%; height:100%">
    <div class="text-center">
    <h1 class="text-uppercase" style="color:white;">Add Tasks</h1>
    </div>
    <br/>
    <br/>
    <!-- The Modal -->
<div id="EmailModal" class="modal1">

<!-- Modal content -->
<div class="modal-content1">



<div class="d-flex justify-content-center" >
  <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;" id="spin" name="spin">
    <span class="sr-only">Loading...</span>
  </div>
</div>


<form class="form-horizontal" name="popup" id="popup" action="">
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="text-center">
<h1 class="text-uppercase" style="color:black;">Send Tasks</h1>

</div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="emailfrom">From:</label>
      <div class="col-sm-10">
        <input type="email" value="newtask.npqs@gmail.com" readonly class="form-control" id="emailfrom"  name="emailfrom">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="emailto">To:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" id="emailto"  name="emailto">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="emailsub">Subject:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="emailsub"  name="emailsub">
      </div>
    </div> <div class="form-group">
      <label class="control-label col-sm-2" for="emailtask">Task:</label>
      <div class="col-sm-10">
       <textarea class="form-control" id="emailtask"  name="emailtask"></textarea>
      </div>
   
      <input type="hidden" name="title" id="title" >
      <input type="hidden" name="task_assign" id="task_assign" >
      <input type="hidden" name="all_date" id="all_date" >
      <input type="hidden" name="dl" id="dl" >

    </div>
    
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10"> 
        <button type="button" onclick= "sendMail()" class="btn btn-success">Send</button>
        <button type="button" onclick="closeModel()" data-dismiss="modal1" class="btn btn-danger">Close</button>

      </div>
    </div>
  </form>

</div>

</div>
<script type="text/javascript">
function sendMail(){
  var emailto = document.getElementById("emailto").value;
var title = document.getElementById("title").value;
var task_assign = document.getElementById("task_assign").value;
var all_date = document.getElementById("all_date").value;
var emailfrom = document.getElementById("emailfrom").value;
var dl = document.getElementById("dl").value;
var emailsub = document.getElementById("emailsub").value;
var serial_no =document.getElementById("serial_no").value;
var officer_id =document.getElementById("officer_id").value;
var references =document.getElementById("references").value;
alert("here");
$.ajax({
        type: "POST",
        url: '{{url("/sendemail")}}',
        data: {
        "_token": "{{ csrf_token() }}",
        "emailto": emailto,
        "title": title,
        "task_assign": task_assign,
        "all_date": all_date,
        "emailfrom": emailfrom,
        "dl": dl,
        "emailsub": emailsub,
        "serial_no" : serial_no,
        "officer_id" :officer_id,
        "references":references

        },
        beforeSend: function() {
       $('.spin').show();
        document.getElementById("popup").style.display = "none";

    },
        success: function(msg) {
          location.reload(true);

        //closeModel();

        },
        complete: function (jqXHR, textStatus) {
         document.getElementById("popup").style.display = "block";
          $('#spin').hide();

        },
        error:function(){

        }
    });

}
var modal = document.getElementById("EmailModal");

var btn = document.getElementById("myBtn");

 $(document).ready(function(){
   
  var deadline=$('input[name="deadline"]'); //our date input has the name "date"
  var allocated_date=$('input[name="allocated_date"]'); 

      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'yyyy/mm/dd',
        container: container,
        todayHighlight: true,
        orientation: 'auto',
        changeMonth: true,
        changeYear: true,
        autoclose: true,
        startDate: new Date()

      };
      deadline.datepicker(options);
      allocated_date.datepicker(options);
  
  //$('#popup').on('submit', function(e) {
    //alert("here");
    //e.preventDefault(); 
  
//});
 
// Department Change
$('#section').change(function(){
   // Department id
   var id = $(this).val();
   // Empty the dropdown
   $('#officer').find('option').not(':first').remove();

   // AJAX request 
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
         // Read data and create <option >
         for(var i=0; i<len; i++){

           var email_id = response['data'][i].email_address;
           var name = response['data'][i].employee_name;
           //var email = response['data'][i].	email_address;
           var id = response['data'][i].employee_id;

           var option = "<option value='"+email_id+"'>"+name+"</option>"; 

           $("#officer").append(option); 
           var input = document.createElement("input");

input.setAttribute("type", "hidden");

input.setAttribute("name", email_id);
input.setAttribute("id", email_id);

input.setAttribute("value", id );

//append to form element that you want .
document.getElementById("addform").appendChild(input);



         }
       }

     } ,
     error:function(){
     }
  });
});
$('#officer').change(function(){
  var email_id = $(this).val();
  //alert( email_id.trim());

  var id = document.getElementById(email_id.trim()).value;
  //alert(id);
  document.getElementById('officer_id').value =id;

});

});

 function viewemail() {
  $('#spin').hide();

  var officer = document.getElementById("officer").value;
   var x = document.getElementById("officer").selectedIndex;
  var y = document.getElementById("officer").options;
  var officer_name= y[x].text;

if(officer != 0){
  var title= "Hello ";
  var task = document.getElementById("task").value;
  var allocated_date = document.getElementById("allocated_date").value;
  var deadline = document.getElementById("deadline").value;

  var message = title.concat(officer_name,"\n",task,"\n Allocated Date :",allocated_date,"\n Deadline :",deadline) ;
  document.getElementById("emailto").value =officer;
  document.getElementById("emailtask").value =message;
  
  document.getElementById("title").value =title.concat(officer_name);
  document.getElementById("task_assign").value =task;
  document.getElementById("all_date").value =allocated_date;
  document.getElementById("dl").value =deadline;
}
  modal.style.display = "block";

}
function closeModel(){
  

  modal.style.display = "none";

}

</script>

    <form class="text-center border border-light p-5" method="post" name="addform" id="addform" action="{{url('/saveTasks')}}" style="margin-right:8%">
    {{csrf_field()}}
    <div class="row"> 

        <div class="col-md-6" style="text-align: left";>
          <input type="text" required class="form-control" id="serial_no" name="serial_no" placeholder= "Serial Number Here">
        </div>

        <div class="col-md-6" style="text-align: left";>
          <select class="form-control dynamic" data-dependent="officer" id="section" name='section'>
            <option value="0" selected>Employee Section</option>
              @foreach($sections as $section)
            <option value="{{ $section['section_id'] }}">{{ $section['section'] }}</option>
              @endforeach

          </select>
        </div>
        
       
    </div>
<br/>
    <div class="row"> 
    <div class="col-md-6" id="date_picker" name="date_picker">

<input type="text" class="date form-control" id="allocated_date" name="allocated_date" placeholder= "Enter Allocated Date Here">

</div>
        
        <div class="col-md-6" style="text-align: left";>
        <select class="form-control dynamic" name="officer" id="officer">
          <option id="0" value="0" selected>Employee </option>"</select>
          <input type='hidden' id='officer_name' value='0'/>
          <input type='hidden' name= 'officer_id' id='officer_id' value='0'/>

      </div>
      </div>
<br/>
    <div class="row"> 

    <div class="col-md-6" style="text-align: left";>
          <textarea class="form-control" placeholder= "Task Here" required rows="4" cols="50" name="task" id="task" ></textarea>
        </div>
        <div class="col-md-6  ">

<input type="text" class="form-control" id="references" name="references" placeholder= "Enter References Here">
</div>
      
    </div>
<br/>
  <div class="row"> 
        
  <div class="col-md-6" id="date_picker" name="date_picker">

<input type="text" class="date form-control" id="deadline" name="deadline" placeholder= "Enter Deadline Date Here">

</div>


  </div>

        <br/>        <br/>

  <div class="row"> 
      
    <div class="col-md-6 ">


      <input type="submit" class="btn btn-success" value="Save" >
      <input type="button" id="myBtn" onclick="viewemail()" class="btn btn-info" value="Send Email" >

        <br/>
        <br/>
    </div>
    <div class="col-md-6 ">
    </div>
  </div>
</form>




@endsection
<b></b>
<style>
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