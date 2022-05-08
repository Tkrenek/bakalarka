@extends('layouts.navigation')
@section('content')
{{-- 
-- Nazev souboru: index.blade.php 
-- Pohled pro zobrazeni objednavek
-- autor: Tomas  Krenek(xkrene15)  
--}}
@php
   use Carbon\Carbon as carbon;
@endphp

{{-- Pohled pro zobazeni objednavek --}}
@if ($message = Session::get('errorInvoice'))
   <div class="text-center text-danger">
      <strong>{{ $message }}  </strong>
   </div>
@endif
<h1 class="display-2 text-center mb-5">Přehled objednávek</h1>
<div class="row">
   <div class="col">
      <form action="{{ route('orders.store') }}" method="post"  class="">
         @csrf
         @auth('customer')
            <button type="submit" class="btn btn-primary mb-5">Vytvořit novou objednávku</button>
         @endauth
      </form>
   </div>
   <div class="col text-center tip">
      Tip: Pro detail objednávky klikněte na číslo objednávky.
   </div>
   <div class="col">
      <form action="{{ route('orders.index.filter') }}" type="get" class="float-right mb-5">
         <div class="row">
            <div class="col">
               <input type="search" class="form-control mr-sm-2" name="query" placeholder="Zadejte ID">
            </div>
            <div class="col">
               <button class="btn btn-primary" type="submit" class="float-right">Vyhledat</button>
            </div>
         </div>
         @if ($message = Session::get('error'))
         <div class="mt-2 text-danger">
            <strong>{{ $message }}  </strong>  
         </div>
         @endif
      </form>
   </div>
</div>
{{-- Tabulka pro zobrazeni objednavek --}}
<table class="table text-center align-middle mb-5 order-table">
   <thead>
      <tr>
         <th scope="col">ID objednávky</th>
         <th scope="col">Zákazník</th>
         <th scope="col">Stav objednávky</th>
         <th scope="col">Termín objednávky</th>
         <th scope="col">Celková cena</th>
         <th scope="col">Faktura</th>
         {{-- Zobrzeni pouze pro admina --}}
         @auth('admin')
            <th scope="col">Nahrát fakturu</th>
            <th scope="col">Odstranit objednávku</th>
            <th scope="col">Upravit objednávku</th>
         @endauth
         {{-- Zobrzeni pouze pro zamestnance --}}
         @auth('employee')
            <th scope="col">Nahrát fakturu</th>
            <th scope="col">Označit práci</th>
            <th scope="col">Změnit stav objednávky</th>
         @endauth
         {{-- Zobrzeni pouze pro zakaznika --}}
         @auth('customer')
            <th scope="col">Změnit termín</th>
         @endauth
      </tr>
   </thead>
   <tbody>
      {{-- Prucho pres vsechny objednavky --}}
      @foreach ($orders as $order)
         <tr>
            <td><a class="link" href="{{  route('orders.show', $order->id) }}">{{ $order->id }}</a></td>
            <td>{{ $order->customer->name }}</td>
            <td>{{ $order->state }}</td>
            <td>{{ Carbon::parse($order->term)->format('d.m. Y')}} </td>
            <td>
               {{-- promenne pro sumy cen --}}
               @php
                  $sum = 0;
                  $sumPckg = 0;
               @endphp
               {{-- Prucho pres polozky objednavky --}}
               @foreach ($order->item as $item)
                  {{-- Pruchod pres baleni polozek --}}
                  @foreach($item->packageItem as $pc)
                     @php
                        $sumPckg += $pc->container->prize * $pc->count // soucet cen za baleni
                     @endphp
                  @endforeach
                  {{-- Soucet ceny produktu --}}
                  @php
                     if($item->is_mixed == "ano") {
                        $sum += $item->amount * $item->productMixed->prize;
                     } else {
                        $sum += $item->amount * $item->productOriginal->prize;
                     }
                  @endphp
               @endforeach
               {{-- Celkovy soucet za celou objednavku --}}
               {{ $sum + $sumPckg}} Kč 
            </td>
            {{-- Zobrazeni pouze pro admina --}}
            @auth('admin')
               <td>
                  {{-- Pokud je nahrana faktura, zobrazi se --}}
                  @if($order->invoice != "bude doplněno")
                     <a class="invoice" href="{{ route('orders.downloadInvoice', $order->invoice) }}">{{ $order->invoice }}</a>
                  @endif
               </td>
               <td>
                  {{-- Nahrani faktury do systemu --}}
                  <form method="post" action="{{ route('orders.uploadFile', $order->id) }}" enctype="multipart/form-data">
                     @csrf
                     <div class="form-group">
                        <label for="invoice">Vyberte fakturu</label>
                        <input type="file" class="form-control-file" id="invoice" name="invoice">
                     </div>
                     <button class="btn btn-primary">Nahrát</button>
                  </form>
               </td>
               @endauth
               {{-- Zobrazeni pro zamestnance --}}
               @auth('employee')
                  <td>
                     @if($order->invoice != "bude doplněno")
                     <a class="invoice" href="{{ route('orders.downloadInvoice', $order->invoice) }}">{{ $order->invoice }}</a>
                     @endif
                  </td>
                  <td>
                     <form method="post" action="{{ route('orders.uploadFile', $order->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                           <label for="invoice">Vyberte fakturu</label>
                           <input type="file" class="form-control-file" id="invoice" name="invoice">
                        </div>
                        <button class="btn btn-primary">Nahrát</button>
                     </form>
                  </td>
               @endauth
               {{-- Zobrazeni pro zakaznika --}}
            @auth('customer')
               <td>
                  @if($order->invoice == "bude doplněno")
                     Bude doplněno
                  @else   
                     <a class="invoice" href="{{ route('orders.downloadInvoice', $order->invoice) }}">{{ $order->invoice }}</a>
                  @endif
               </td>
            @endauth
            {{-- Zobrazeni pro admina --}}
            @auth('admin')
               <td>
                  <form action="{{ route('orders.destroy', $order->id) }}" method="post">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="btn btn-danger">Smazat</button>
                  </form>
               </td>
            @endauth
            {{-- Zobrazeni pro zamestnance --}}
            @auth('employee')
               <td>
                  <a href="{{ route('orderWork.create', $order->id) }}" type="btn" class="btn btn-primary">Označit</a>
               </td>
               <td>
                  <form action="{{ route('orders.changeState', $order->id) }}" method="post">
                     @csrf
                     @method('PUT')
                     <div class="form-group">
                        <label for="state" >Stav</label>
                        <select name="state" id="state" class="form-control custom-select">
                           <option id="založeno" name="založeno">založeno</option class="form-control @error('state') is-invalid @enderror">
                           <option id="namícháno" name="namícháno">namícháno</option class="form-control @error('state') is-invalid @enderror">
                           <option id="zabaleno" name="zabaleno">zabaleno</option class="form-control @error('state') is-invalid @enderror">
                        </select>
                        <div class="invalid-feedback">
                           @error('state')
                              Je nutné vybrat stav.
                           @enderror
                        </div>
                     </div>
                     <button type="submit" class="btn btn-primary">Změnit stav objednávky</button>
                  </form>
               </td>
            @endauth
            {{-- Zobrazeni pro admina --}}
            @auth('admin')
               <td>
                  <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary">Upravit</a>
               </td>
               
            @endauth
            {{-- Zobrazeni pro zakaznika --}}
            @auth('customer')
               <td>
                  <form action="{{ route('orders.changeTerm', $order->id) }}" method="post">
                     @csrf
                     @method('PUT')
                     <div class="form-group">
                        <label for="term">Změnit termín</label>
                        <input type="date" id="term" name="term" class="@error('term') is-invalid @enderror form-control">
                        <div class="invalid-feedback">
                           @error('term')
                           Je nutné zadat datum.
                           @enderror
                        </div>
                     </div>
                     <button type="submit" class="btn btn-primary">Změnit termín</button>
                  </form>
               </td>
            @endauth
         </tr>
      @endforeach
   </tbody>
</table>
@endsection