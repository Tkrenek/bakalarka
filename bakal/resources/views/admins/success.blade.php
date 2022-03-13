@extends('layouts.navigation')

@section('content')
  
@php
    use Illuminate\Support\Facades\Auth;
@endphp


yeeees

@auth('employee')
    {{ auth('employee')->user()->name }}
@endauth

@auth
    {{ auth()->user('employee')->name }}

    
@endauth

@guest
    Odhlášeno
@endguest




@endsection