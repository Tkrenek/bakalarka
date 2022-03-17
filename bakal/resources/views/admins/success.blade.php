@extends('layouts.navigation')

@section('content')
  
@php
    use Illuminate\Support\Facades\Auth;
@endphp


@auth
    {{ auth()->user('employee')->name }}

    
@endauth

@guest
    Odhlášeno
@endguest




@endsection