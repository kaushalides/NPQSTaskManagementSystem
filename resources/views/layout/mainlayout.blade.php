<!DOCTYPE html>
<html lang="en">
 <head>
 @include('layout.partials.head')

 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

 </head>
 <body class="main">
 <div id="particles-js" style="height:100%">

@include('layout.partials.nav')
@include('layout.partials.header')
@yield('content')
@include('layout.partials.footer')

</div>
</body>
</html>
