@extends('layouts.navigation')

@section('content')
  
@php
    use Illuminate\Support\Facades\Auth;
    use Carbon\Carbon as carbon;
@endphp


<h2 class="display-2 text-center mb-5">Úspěšně přihlášen do systému</h2>

<div class="text-center welcome-text">
    Jméno a příjmení: {{ auth('admin')->user()->name }} {{ auth('admin')->user()->surname }} <br>
    Datum narození: {{ Carbon::parse(auth('admin')->user()->birth_date)->format('d.m. Y')}} <br>
    Email: {{ auth('admin')->user()->email }}  <br>
    Telefon: {{ auth('admin')->user()->phone }}  <br>
</div>

<h5 class="display-5 text-center mt-3">Vyberte svoji další akci</h5>
<hr>
<div class="row">
    <div class="col-sm-4">
        <div class="card ">
          <div class="card-body text-center">
            <h5 class="card-title">Seznam objenávek</h5>
            <p class="card-text">Zobrazte si svoje objednávky</p>
            <a  class="btn btn-primary"  href="{{ route('orders.index') }}">Přejít</a>
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
      <div class="card ">
        <div class="card-body text-center">
          <h5 class="card-title">Seznam produktů</h5>
          <p class="card-text">Prohlédněte si seznam nabízených produktů.</p>
          <a  href="{{ route('product.index')}}" class="btn btn-primary">Přejít</a>
        </div>
      </div>
    </div>
    
</div>
  
  <div class="row mt-3">
    
    <div class="col-sm-4">
      <div class="card ">
        <div class="card-body text-center">
          <h5 class="card-title">Zobrazit zaměstnance</h5>
          <p class="card-text">Přidejte do systému další kontaktní osoby.</p>
          <a href="{{ route('contact.create')}}" class="btn btn-primary">Přejít</a>
        </div>
      </div>
    </div>
  
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body text-center">
        <h5 class="card-title">Zobrazit zákazníky</h5>
        <p class="card-text">Zobrazte si svoje objednávky</p>
        <a  class="btn btn-primary"  href="{{ route('orders.index') }}">Přejít</a>
      </div>
    </div>
  </div>
<div class="col-sm-4">
  <div class="card ">
    <div class="card-body text-center">
      <h5 class="card-title">Registrace dodavatele</h5>
      <p class="card-text">Prohédněte si seznam nádob, které jsou nabízeny.</p>
      <a  href="{{ route('containers.index')}}" class="btn btn-primary">Přejít</a>
    </div>
  </div>
</div>

</div>
    



        
      


@endsection