@extends('layout.mainlayout')
@section('content')
<!-- Default form login -->
<div class="container" style="margin-left:20%; height:100%">
    <div class="text-center">

    <h1 class="text-uppercase" style="color:white;">Add New Section</h1>
    </div>
    <br/>
    <br/>
<form class="text-center border border-light p-5"  style="margin-right:15%;margin-left:15%"  method="POST" action="{{url('/addsection')}}">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
      <div class="col-sm-10">
    <input type="text" id="sectionname"  name="sectionname" required class="form-control mb-4" placeholder="Section Name">
</div> 
</div>

<div class="form-group">
<div class="col-sm-10">
<input type="text" required id="sectionphone_ex" name="sectionphone_ex" class="form-control mb-4" placeholder="Section Phone Extension">
</div>


</div>
<div class="form-group">
<div class="col-sm-10">
<input type="email" required id="sectionemail" name="sectionemail" class="form-control mb-4" placeholder="Section Email">
</div>
</div>
    <button class="btn btn-success" type="submit">Add Section</button>

    

    
</form>
<!-- Default form login -->
</div>
@endsection