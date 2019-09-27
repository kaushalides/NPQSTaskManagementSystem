@extends('layout.login_layout')
@section('content')
<div id="login" class="modal1">

<div class="modal1-content">

<form class="form-horizontal" name="login" id="login" action="">
    <div class="text-center">
        <h1 class="text-uppercase" style="color:black;">Login</h1>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="user_name">User Name:</label>
        <div class="col-sm-10">
        <input type="text"   class="form-control" id="u_name"  name="u_name">
        </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Password:</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" id="pwd"  name="pwd">
      </div>
    </div>
    
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10"> 
        <button type="submit" class="btn btn-success">Login</button>
        <button type="button" onClick="closeModel();" data-dismiss="modal1" class="btn btn-info">Signup</button>
      </div>
    </div>
  </form>
  </div></div>
  @endsection
<b></b>

  <style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal1 {
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  padding-bottom: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal1-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

</style>