@extends('layouts.navigation')

@section('content')
  
@php
    use Illuminate\Support\Facades\Auth;
@endphp


Jste přihlášen jako zákazník.

@auth('subscriber')
    {{ auth('subscriber')->user()->login }}
@endauth

@auth
    sfasf
@endauth




@endsection