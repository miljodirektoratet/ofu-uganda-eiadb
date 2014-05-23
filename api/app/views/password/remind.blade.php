<!doctype html>
<html lang="en">
<head>
</head>
<body>

@if (Session::has('error'))
  {{ Lang::get(Session::get('error')) }}
@elseif (Session::has('status'))
  {{ Lang::get(Session::get('status')) }}  
@endif

 
{{ Form::open(array('route' => 'password.request')) }}
 
  <p>{{ Form::label('email', 'Email') }}
  {{ Form::text('email') }}</p>
 
  <p>{{ Form::submit('Send reset url') }}</p>
 
{{ Form::close() }}

</body>
</html>