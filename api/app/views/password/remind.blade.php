<!doctype html>
<html lang="en">
<head>
	<style>
		input { width:300px; }
	</style>
</head>
<body>

@if (Session::has('error'))
  {{ Lang::get(Session::get('error')) }}
@elseif (Session::has('status'))
  {{ Lang::get(Session::get('status')) }}  
@endif

 
{{ Form::open(array('route' => 'password.request')) }}
 
  <p>{{ Form::label('email', 'Email') }}
  {{ Form::text('email', Auth::check() ? Auth::user()->email : '')}}</p>
 
  <p>{{ Form::submit('Send reset url') }}</p>
 
{{ Form::close() }}

</body>
</html>