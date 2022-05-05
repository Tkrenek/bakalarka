@extends('layouts.navigation')
@section('content')
@php
   use Illuminate\Support\Facades\Auth;
@endphp

{{--  Privitaci obrazvka po prihlaseni zakaznika --}}
<h2 class="display-2 text-center mb-5">Úspěšně přihlášen do systému</h2>
<div class="text-center welcome-text">
   Název společnosti: {{ auth('customer')->user()->name }} <br>
   Adresa: {{ auth('customer')->user()->address }}, {{ auth('customer')->user()->town }} <br>
   Login: {{ auth('customer')->user()->login }} <br>
</div>
<h5 class="display-5 text-center mt-3">Vyberte svoji další akci</h5>
<hr>
<div class="row">
   <div class="col-sm-4">
      <div class="card">
         <div class="card-body text-center">
            <h5 class="card-title">Seznam objenávek</h5>
            <p class="card-text">Zobrazte si svoje objednávky</p>
            <a  class="btn btn-primary"  href="{{ route('orders.myindex',  auth('customer')->user()->id )}}">Přejít</a>
         </div>
      </div>
   </div>
   <div class="col-sm-4">
      <div class="card ">
         <div class="card-body text-center">
            <h5 class="card-title">Seznam nádob</h5>
            <p class="card-text">Prohédněte si seznam nádob, které jsou nabízeny.</p>
            <a  href="{{ route('containers.index')}}" class="btn btn-primary">Přejít</a>
         </div>
      </div>
   </div>
   <div class="col-sm-4">
      <div class="card ">
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
            <h5 class="card-title">Přidat kontaktní osobu</h5>
            <p class="card-text">Přidejte do systému další kontaktní osoby.</p>
            <a href="{{ route('contact.create')}}" class="btn btn-primary">Přejít</a>
         </div>
      </div>
   </div>
   <div class="col-sm-4">
      <div class="card">
         <div class="card-body text-center">
            <h5 class="card-title">Zobrazit osoby</h5>
            <p class="card-text">Zobrazte si své kontaktní osoby.</p>
            <a href="{{ route('contact.index.sub', auth('customer')->user()->id)}}" class="btn btn-primary">Přejít</a>
         </div>
      </div>
   </div>
</div>
@endsection