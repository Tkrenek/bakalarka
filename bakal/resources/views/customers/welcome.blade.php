@extends('layouts.navigation')

@section('content')
  
@php
    use Illuminate\Support\Facades\Auth;
@endphp

<h2 class="display-2 text-center mb-5">Jste přihlášen jako zákazník.</h2>




    {{ auth('customer')->user()->login }}
    {{ auth('customer')->user()->address }}





@endsection