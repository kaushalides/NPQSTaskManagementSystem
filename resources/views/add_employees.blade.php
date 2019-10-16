@extends('layout.mainlayout')
@section('content')
<!-- Default form login -->
<div class="container" style="margin-left:20%; height:100%">
    <div class="text-center">

    <h1 class="text-uppercase" style="color:white;">Add New Employee</h1>
    </div>
    <br/>
    <br/>
<form class="text-center border border-light p-5"  style="margin-right:15%;margin-left:5%"  method="POST" action="/addemployee">
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="row"> 
<div class="col-md-6" style="text-align: left";>
<input type="text" id="empname"  name="empname" required class="form-control mb-4" placeholder="Employee Name">
</div>
<div class="col-md-6" style="text-align: left";>
<input type="text" required id="emp_des" name="emp_des" class="form-control mb-4" placeholder="Designation">
</div>
</div>
<br/>

<div class="row"> 
<div class="col-md-6" style="text-align: left";>
<select class="form-control dynamic" data-dependent="officer" id="section" name='section'>
            <option value="0" selected>Employee Section</option>
              @foreach($sections as $section)
            <option value="{{ $section['section_id'] }}">{{ $section['section'] }}</option>
              @endforeach

          </select>
</div>
<div class="col-md-6" style="text-align: left";>
<input type="email" required id="emp_email" name="emp_email" class="form-control mb-4" placeholder="Email">
</div>
</div>
<br/>

<div class="row"> 
<div class="col-md-6" style="text-align: left";>
<input type="number" id="empnmbr"  name="empnmbr" required class="form-control mb-4" placeholder="Employee Contact Number">
</div>
<div class="col-md-6" style="text-align: left";>
</div>
</div>
<br/>





    <button class="btn btn-success" type="submit">Add Employee</button>

    

    
</form>
<!-- Default form login -->
</div>
@endsection