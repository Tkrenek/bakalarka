@extends('layouts.navigation')

@section('content')
  
@php
    use Illuminate\Support\Facades\Auth;
@endphp


<h3 class="display-3 text-center mb-5">Jste přihlášen jako správce</h3>

<div class="text-center">
    Jméno a příjmení: {{ auth('admin')->user()->name }} {{ auth('admin')->user()->surname }} <br />
        Telefon: {{ auth('admin')->user()->phone }}<br />
        Email: {{ auth('admin')->user()->email }}
</div>

        
      


@endsection