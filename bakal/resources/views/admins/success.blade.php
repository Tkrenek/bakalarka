@extends('layouts.navigation')

@section('content')
  
@php
    use Illuminate\Support\Facades\Auth;
@endphp


<h1 class="display-2 text-center">Jste přihlášen jako správce</h1>

<h3 class="display-4 text-center">{{ auth('admin')->user()->name }} {{ auth('admin')->user()->surname }}</h3>
<h3 class="display-4 text-center">{{ auth('admin')->user()->email }}</h3>
<h3 class="display-4 text-center">{{ auth('admin')->user()->phone }}</h3>

@endsection