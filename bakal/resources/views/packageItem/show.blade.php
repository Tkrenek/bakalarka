@extends('layouts.navigation')
@section('content')
{{-- Pohled se zobrazenim zabaleni konkretni polozky --}}
@if ($item->is_mixed == "ano")
   <h2 class="display-2 text-center">Položka: {{ $item->productMixed->code }}</h2>
@else
<h2 class="display-2 text-center">Položka: {{ $item->productOriginal->code }}</h2>
   @endif
<div class="text-center text-danger" style="font-size: larger;">
   @error('count')
      Musíte zadat množství!
   @enderror
</div>
<a type="button" class="btn btn-primary mb-3" href="{{ route('orders.show', $item->order->id) }}">Zpět na objednávku</a>
<a class="btn btn-primary float-right" href="{{  route('packageItem.create', $item->id ) }}" role="button">Přidat balení</a>
{{-- Tabulka pro zobrazeni baleni polozky --}}
<table class="table">
   <thead>
      <th scope="col">Kód nádoby</th>
      <th scope="col">Typ</th>
      <th scope="col">Objem</th>
      <th scope="col">Počet</th>
      <th scope="col">Změnit počet</th>
      <th scope="col">Odstranit</th>
   </thead>
   <tbody>
      {{-- Pruchod pres vsechny baleni polozky --}}
      @foreach ($item->packageItem as $pckg)
      <tr>
         <td>
            {{ $pckg->container->code }}
         </td>
         <td>
            {{ $pckg->container->type }}
         </td>
         <td>
            {{ $pckg->container->bulk }} l
         </td>
         <td>
            {{ $pckg->count }} ks
         </td>
         <td style="width: 200px">
            <form action="{{ route('packageItem.changeCount', $pckg->id) }}" method="post">
               @csrf
               @method('PUT')
               <div class="form-group">
                  <input placeholder="počet" style="width: 175px;" type="number"   id="count" name="count" class="form-control">
               </div>
               <button type="submit" class="btn btn-primary" >Změnit</button>
            </form>
         </td>
         <td>
            <form action="{{ route('packageItem.destroy', $pckg->id) }}" method="post">
               @csrf
               @method('DELETE')
               <button type="submit" class="btn btn-danger">Smazat</button>
            </form>
         </td>
      </tr>
      @endforeach
   </tbody>
</table>
@endsection