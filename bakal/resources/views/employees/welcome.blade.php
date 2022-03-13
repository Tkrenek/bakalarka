@extends('layouts.navigation')

@section('content')
  
@php
    use Illuminate\Support\Facades\Auth;
@endphp


Jste přihlášen jako zaměstnanec.

@auth('employee')
    {{ auth('employee')->user()->name }}
@endauth

@auth
    sfasf
@endauth




@endsection