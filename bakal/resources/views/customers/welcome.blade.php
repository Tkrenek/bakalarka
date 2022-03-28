@extends('layouts.navigation')

@section('content')
  
@php
    use Illuminate\Support\Facades\Auth;
@endphp


Jste přihlášen jako zákazník.

@auth('customer')
    {{ auth('customer')->user()->login }}
@endauth

@auth
    sfasf
@endauth




@endsection