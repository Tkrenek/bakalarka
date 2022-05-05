@extends('layouts.navigation')
@section('content')
@php
$orderSum = 0;
@endphp
<h1 class="text-center mb-5 display-2">ID objednávky: {{ $order->id }}</h1>
@auth('customer')
<a href="{{ route('orders.myindex', auth('customer')->user()->id )}}" role="button" class="btn btn-primary">Zpět na moje objednávky</a>
@endauth
@auth('admin')
<a href="{{ route('orders.index')}}" class="btn btn-primary mb-3">Zpět na  objednávky</a>
@endauth
@auth('employee')
<a href="{{ route('orders.index')}}" class="btn btn-primary mb-3">Zpět na  objednávky</a>
@endauth
@auth('customer')
<a class="btn btn-primary float-right mb-3" href="{{ route('items.create', $order->id) }}" role="button">Přidat položku</a>
@endauth
@auth('admin')
<a class="btn btn-primary float-right mb-3" href="{{ route('items.create', $order->id) }}" role="button">Přidat položku</a>
@endauth
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
   @foreach ($items as $item)
   <tr>
      @if ($item->is_mixed == "ano")
      <td>{{ $item->productMixed->code }}</td>
      <td>{{ $item->productMixed->name }}</td>
      @else
      <td>{{ $item->productOriginal->code }}</td>
      <td>{{ $item->productOriginal->name }}</td>
      @endif
      <td>{{ $item->amount }}</td>
      @php
      $sumProduct = 0;
      @endphp
      <td>
         @if ($item->is_mixed == "ano")
         @php
         $sumProduct = $item->amount * $item->productMixed->prize
         @endphp
         @else
         @php
         $sumProduct = $item->amount * $item->productOriginal->prize
         @endphp
         @endif
         {{ $sumProduct }} 
         Kč
      </td>
      @php
      $sumPckg = 0;
      @endphp
      <td>
         @foreach ($item->packageItem as $pckg)
         @php
         $sumPckg += $pckg->count * $pckg->container->prize;
         @endphp
         @endforeach
         {{ $sumPckg }} Kč
      </td>
      <td>
         {{ $sumPckg + $sumProduct }} Kč
         @php
         $orderSum += $sumPckg + $sumProduct
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
<h5  class="float-right">Celková cena: {{ $orderSum }} Kč</h5>
@auth('customer')
@php
$pole = array()
@endphp
@if (empty($recommended))
@else
<h3>Často nakupované položky s vaším zbožím:</h3>
@foreach ($recommended as $one)
@if (in_array($one[0], $pole))
@else 
<span class="recommended">
{{ $one[0] }}  &nbsp 
</span>
@endif
@php
array_push($pole, $one[0])
@endphp
@endforeach
@endif
@endauth
@auth('admin')
@php
$pole = array();
$konec = 0;   
@endphp
@if (empty($recommended))
@else
<h3>Doporučené položky:</h3>
@foreach ($recommended as $one)
@if (in_array($one[0], $pole))
@else 
<span class="recommended">
{{ $one[0] }}  &nbsp
</span>
@endif
@php
array_push($pole, $one[0])
@endphp
@endforeach
@endif
@endauth
@endsection