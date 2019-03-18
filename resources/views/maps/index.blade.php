<script>
  var cliente=1;
  var dist=1000;
  var max_cams=16;
  var userid=2;
  </script>
  <script>
        function myFunction(url) {
          var myWindow = window.open(url, "", "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=400,height=400,titlebar=no,location=no,menubar=no");
        }
</script>
@extends('crudbooster::admin_template')
@section('content')
  <notification-map></notification-map>  
@endsection