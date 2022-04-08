@extends('layouts.navigation')

@section('content')
  
@php
    use Illuminate\Support\Facades\Auth;
@endphp


Jste přihlášen jako zákazník.

@auth('customer')
    {{ auth('customer')->user()->login }}
@endauth

@auth('admin')
    sfasf
@endauth




@endsection