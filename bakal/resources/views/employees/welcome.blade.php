@extends('layouts.navigation')
@section('content')
{{-- 
-- Nazev souboru: welcome.blade.php 
-- Pohled pro privitani zamestnancu
-- autor: Tomas  Krenek(xkrene15)  
--}}
@php
   use Illuminate\Support\Facades\Auth;
   use Carbon\Carbon as carbon;
@endphp
{{-- Privitaci obrazovka po prihlaseni zamestnance --}}

<h2 class="display-2 text-center mb-5">Úspěšně přihlášen do systému</h2>
<div class="text-center welcome-text">
   {{-- Vypis udaju o prihlasenem zamestnanci --}}
   Jméno a příjmení: {{ auth('employee')->user()->name }} {{ auth('employee')->user()->surname }} <br>
   Datum narození: {{ Carbon::parse(auth('employee')->user()->birth_date)->format('d.m. Y')}} <br>
   Email: {{ auth('employee')->user()->email }}  <br>
   Telefon: {{ auth('employee')->user()->phone }}  <br>
   Funkce: {{ auth('employee')->user()->function }}  <br>
</div>
<h5 class="display-5 text-center mt-3">Vyberte svoji další akci</h5>
<hr>
<div class="row">
   <div class="col-sm-4">
      <div class="card">
         <div class="card-body text-center">
            <h5 class="card-title">Seznam objenávek</h5>
            <p class="card-text">Zobrazte si všechny objednávky, které v systému jsou</p>
            <a href="{{ route('orders.index') }}" class="btn btn-primary">Přejít</a>
         </div>
      </div>
   </div>
   <div class="col-sm-4">
      <div class="card">
         <div class="card-body text-center">
            <h5 class="card-title">Seznam nádob</h5>
            <p class="card-text">Prohédněte si seznam nádob, které jsou nabízeny.</p>
            <a  href="{{ route('containers.index')}}" class="btn btn-primary">Přejít</a>
         </div>
      </div>
   </div>
   <div class="col-sm-4">
      <div class="card">
         <div class="card-body text-center">
            <h5 class="card-title">Seznam produktů</h5>
            <p class="card-text">Prohlédněte si seznam nabízených produktů.</p>
            <a  href="{{ route('product.index')}}" class="btn btn-primary">Přejít</a>
         </div>
      </div>
   </div>
</div>
<div class="row mt-2">
   
   <div class="col-sm-4 offset-2">
      <div class="card">
         <div class="card-body text-center">
            <h5 class="card-title">Odvedená práce</h5>
            <p class="card-text">Zobrazte si svoji práci na objednávkách.</p>
            <a href="{{ route('orderWork.index')}}" class="btn btn-primary">Přejít</a>
         </div>
      </div>
   </div>
   <div class="col-sm-4">
      <div class="card">
         <div class="card-body text-center">
            <h5 class="card-title">Google kalendář</h5>
            <p class="card-text">Temíny objednávek ve vašem google kalendáři.</p>
            <a href="{{ route('google.index') }}" class="btn btn-primary">Přejít</a>
         </div>
      </div>
   </div>
</div>
@endsection