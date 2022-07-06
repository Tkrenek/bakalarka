@extends('layouts.navigation')
@section('content')
{{-- 
-- Nazev souboru: show.blade.php 
-- Pohled pro zobrazeni detailu objednavky
-- autor: Tomas  Krenek(xkrene15)  
--}}
@php
   $orderSum = 0;
@endphp
<h1 class="text-center mb-5 display-2">ID objednávky: {{ $order->id }}</h1>
@if ($message = Session::get('error'))
   <div class="alert text-center" style="color: red; font-weight: bold;"  >
      <strong>{{ $message }}  </strong>   
   </div>
@endif
{{-- Zobrazeni detailu objednavky --}}
@auth('customer')
   <a href="{{ route('orders.myindex', auth('customer')->user()->id )}}" role="button" class="btn btn-primary">Zpět na moje objednávky</a>
@endauth
@auth('admin')
   <a href="{{ route('orders.index')}}" class="btn btn-primary mb-3">Zpět na  objednávky</a>
@endauth
@auth('employee')
   <a href="{{ route('orders.index')}}" class="btn btn-primary mb-3">Zpět na  objednávky</a>
@endauth
{{-- Admin a zakaznik mohou pridat polozku --}}
@auth('customer')
   <a class="btn btn-primary float-right mb-3" href="{{ route('items.create', $order->id) }}" role="button">Přidat položku</a>
@endauth
@auth('admin')
   <a class="btn btn-primary float-right mb-3" href="{{ route('items.create', $order->id) }}" role="button">Přidat položku</a>
@endauth
{{-- Tabulka pro zobrazeni polozek v objednavce --}}
<table class="table">
   <thead>
      <th scope="col">Kód produktu</th>
      <th scope="col">Název produktu</th>
      <th scope="col">Množství(v litrech)</th>
      <th scope="col">Cena</th>
      <th scope="col">Cena za balení</th>
      <th scope="col">Celková cena</th>
      <th scope="col">Balení</th>
      @auth('admin')
         <th scope="col">Vybrat balení</th>
         <th scope="col">Odstranit</th>
      @endauth
      @auth('customer')
         <th scope="col">Vybrat balení</th>
         <th scope="col">Odstranit</th>
      @endauth
   </thead>
   {{-- Pruchod pres vsechny polozky --}}
   @foreach ($items as $item)
      <tr>
         {{-- Pokud je produkt michany --}}
         @if ($item->is_mixed == "ano")
            <td>{{ $item->productMixed->code }}</td>
            <td>{{ $item->productMixed->name }}</td>
         @else
            {{-- Pokud je produkt originalni --}}
            <td>{{ $item->productOriginal->code }}</td>
            <td>{{ $item->productOriginal->name }}</td>
         @endif
         <td>
            <div class="change">

               <div class="mnozstvi">
                  {{ $item->amount }}
                     
               </div> <form action="{{ route('items.change', $item->id) }}" class="formik" method="POST">
                  @csrf
                  @method('PUT')
                  <input id="ammountSpecial" type="number" name="ammountSpecial" >
                  
                  <input type="submit" name="" id="" value="Změnit" class="btn btn-primary">
               </form>
            </div>
         
            
            
            
     
      </td>
         @php
            $sumProduct = 0; // suma za produkty
         @endphp
         <td>
            {{-- Pokud je produkt michany --}}
            @if ($item->is_mixed == "ano")
               @php
                  $sumProduct = $item->amount * $item->productMixed->prize // soucet ceny za produkt michany
               @endphp
               {{-- Pokud je produkt originalni --}}
            @else
               @php
                  $sumProduct = $item->amount * $item->productOriginal->prize // soucet ceny za produkt originalni
               @endphp
            @endif
            {{ $sumProduct }} Kč {{-- Vypis ceny produktu --}}
         </td>
         @php
            $sumPckg = 0; // cena za baleni
         @endphp
         <td>
            {{-- Pruchod pres vsechny baleni --}}
            @foreach ($item->packageItem as $pckg)
               @php
                  $sumPckg += $pckg->count * $pckg->container->prize; // pripocet ceny za baleni do celkove ceny za baleni
               @endphp
            @endforeach
            {{ $sumPckg }} Kč {{-- Vypis ceny za baleni --}}
         </td>
         <td>
            {{ $sumPckg + $sumProduct }} Kč {{-- Zobrazeni celkove ceny polozky i s balenim --}}
            @php
               $orderSum += $sumPckg + $sumProduct // Pripocteni k cene za celo objednavku
            @endphp
         </td>
         <td>
            @foreach ($item->packageItem as $cont)
               {{ $cont->container->type }} - {{ $cont->container->bulk }}l({{ $cont->count }}ks)
            @endforeach
         </td>
         @auth('admin')
            <td><a href="{{ route('packageItem.show', $item->id) }}" role="button" class="btn btn-primary">Upravit balení</a>
            <td>
               <form action="{{ route('items.destroy', $item->id) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Smazat</button>
               </form>
            </td>
         @endauth
         @auth('customer')
            <td><a href="{{ route('packageItem.show', $item->id) }}" role="button" class="btn btn-primary">Upravit balení</a>
            <td>
               <form action="{{ route('items.destroy', $item->id) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Smazat</button>
               </form>
            </td>
         @endauth
      </tr>
   @endforeach
</table>
<h5  class="float-right">Celková cena: {{ $orderSum }} Kč</h5> {{-- Vypis celkove ceny --}}
{{-- Zobrazeni doporucenych produktu pomoci metody Apriori --}}
@auth('customer')
   @php
      $pole = array()
   @endphp
   @if (empty($recommended)) {{-- Pokud neprisly zadne doporucene polozky --}}
   @else {{-- Jinak --}}
      <h3>Často nakupované položky s vaším zbožím:</h3>
      {{-- Pruchod pres doporucene polozky --}}
      @foreach ($recommended as $one)
         {{-- Pokud uz byla polozka vypsana, jdeme dal --}}
         @if (in_array($one[0], $pole))
         @else 
            {{-- Vypis polozky --}}
            <span class="recommended">
               <a href="{{ route('pridat', ['orderId'=>$order->id,'productCode'=>$one[0]]) }}"> {{ $one[0] }}</a>  &nbsp 
            </span>
         @endif
         @php
            array_push($pole, $one[0]) // pridani do pole, ze uz je vypsana, aby se nevypsala znovu
         @endphp
      @endforeach
   @endif
@endauth
@auth('admin')
   @php
      $pole = array();
      $konec = 0;   
   @endphp
   @if (empty($recommended)){{-- Pokud neprisly zadne doporucene polozky --}}
   @else {{-- Jinak --}}
      <h3>Doporučené položky:</h3>
      {{-- Pruchod pres doporucene polozky --}}
      @foreach ($recommended as $one)
         {{-- Pokud uz byla polozka vypsana, jdeme dal --}}
         @if (in_array($one[0], $pole))
         @else 
            {{-- Vypis polozky --}}
            <span class="recommended">
               <a href="{{ route('pridat', ['orderId'=>$order->id,'productCode'=>$one[0]]) }}"> {{ $one[0] }} </a>  &nbsp
            </span>
         @endif
         @php
            array_push($pole, $one[0]) // pridani do pole, ze uz je vypsana, aby se nevypsala znovu
         @endphp
      @endforeach
   @endif
@endauth
@endsection