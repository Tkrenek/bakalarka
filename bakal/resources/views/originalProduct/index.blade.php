@extends('layouts.navigation')
@section('content')
{{-- 
-- Nazev souboru: index.blade.php 
-- Pohled pro zobrazeni vsech produktu
-- autor: Tomas  Krenek(xkrene15)  
--}}
@auth('admin')
   <a class="btn btn-primary" href="{{ route('productOriginal.create')}}" class="p-3">Přidat originální produkt</a>
   <a class="btn btn-primary float-right" href="{{ route('productMixed.create')}}" class="p-3">Přidat míchaný produkt</a>
@endauth
<div class="row mt-3 nav-products">
   <div class="col-2">
      <a class="btn btn-primary float-left" href="{{ route('product.indexOriginal')}}" class="p-3">Pouze originální produkty</a>
   </div>
   <div class="col-4 offset-2">
      <form action="{{ route('product.index.filter') }}" type="get" class="float-right mb-5">
         <div class="row">
            <div class="col">
               <input type="search" class="form-control mr-sm-2" name="query" placeholder="Kód produktu">
            </div>
            <div class="col">
               <button class="btn btn-primary" type="submit" class="float-right">Vyhledat</button>
            </div>
         </div>
         @if ($message = Session::get('errorFilter'))
            <div class="mt-2 text-danger">
               <strong>{{ $message }}  </strong>  
            </div>
         @endif
         @error('query')
            <div class="mt-2 text-danger">
               <strong>Musíte zadat kód produktu</strong>  
            </div>
         @enderror
      </form>
   </div>
   <div class="col-2 offset-2">
      <a class="btn btn-primary float-right" href="{{ route('product.indexMixed')}}" class="p-3">Pouze Míchané produkty</a>
   </div>
</div>
<div class="text-danger text-center" style="font-size: large">
   @if ($message = Session::get('error'))
      <div class="color-danger tex-center">
         <strong>{{ $message }}  </strong>   
      </div>
   @endif
</div>

   

<div class="text-center text-danger" style="font-size: larger;">
   @error('ammount')
      Musíte zadat množství!
   @enderror
</div>

@if (!$products->isEmpty())
<h1 class="display-3 text-center mb-5">Originální produkty</h1>
{{-- Tabulka se vsemi produkty --}}
<table class="table  mb-5">
   <thead>
      <tr>
         <th scope="col">Kód</th>
         <th scope="col">Název</th>
         <th scope="col">Na skladě</th>
         <th scope="col">Odvětví</th>
         <th scope="col">Cena(Kč)</th>
         <th scope="col">Dodavatel</th>
         @auth('admin')
            <th scope="col">Naskladnit</th>
            <th scope="col">Upravit</th>
            <th scope="col">Odstranit</th>
         @endauth
         @auth('employee')
            <th scope="col">Naskladnit</th>
         @endauth          
      </tr>
   </thead>
   <tbody>
      
      {{-- Pruchod pres vsechny originalni produkty --}}
      @foreach ($products as $product)
         @if($product->code != 'O-default')
            
            <tr>
               <td>{{ $product->code }}</td>
               <td>{{ $product->name }}</td>
               <td>{{ $product->on_store }}</td>
               <td>{{ $product->branch }}</td>
               <td>{{ $product->prize }}</td>
               <td>{{ $product->producer->name }}</td>
               @auth('admin')
               <td style="width: 150px">
                  <form action="{{ route('productOriginal.addStore', $product->id) }}" method="post">
                     @csrf
                     @method('PUT')
                     <div class="form-group ">
                        <label for="ammount" class="sr-only">Množsví</label>
                        <input type="text"  id="ammount" name="ammount" class="form-control " placeholder="množství">
                        <div class="invalid-feedback">
                        </div>
                     </div>
                     <button type="submit" class="btn btn-primary">Naskladnit</button>
                  </form>
               </td>
               <td><a href="{{ route('productOriginal.edit', $product->id) }}" type="submit" class="btn btn-primary">Upravit</a></td>
               <td>
                  <form action="{{ route('productOriginal.destroy', $product->id) }}" method="post">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="btn btn-danger">Odstranit</button>
                  </form>
               </td>
               @endauth
               @auth('employee')
               <td style="width: 150px">
                  <form action="{{ route('productOriginal.addStore', $product->id) }}" method="post">
                     @csrf
                     @method('PUT')
                     <div class="form-group">
                        <label for="ammount" class="sr-only">Množsví</label>
                        <input type="number"  id="ammount" name="ammount" class="form-control" placeholder="množství">
                        <div class="invalid-feedback">
                        </div>
                     </div>
                     <button type="submit" class="btn btn-primary">Naskladnit</button>
                  </form>
               </td>
               @endauth
            </tr>
         @endif
      @endforeach
   </tbody>
</table>
@endif
@if (!$productsMixed->isEmpty() )
<h1 class="display-3 text-center mb-5">Míchané produkty</h1>
{{-- Tabulka s michanymi produkty --}}
<table class="table mb-5">
   <thead >
      <tr>
         <th scope="col">Kód</th>
         <th scope="col">Název</th>
         <th scope="col">Na skladě</th>
         <th scope="col">Odvětví</th>
         <th scope="col">Cena(Kč)</th>
         <th scope="col">Recept</th>
         @auth('admin')
            <th scope="col">Upravit recept</th>
            <th scope="col">Naskladnit</th>
            <th scope="col">Upravit</th>
            <th scope="col">Odstranit</th>
         @endauth
         @auth('employee')
            <th scope="col">Naskladnit</th>
         @endauth
      </tr>
   </thead>
   <tbody>
      
         {{-- Pruchod pres michane produkty --}}
         @foreach ($productsMixed as $product)
            @if($product->code != 'M-default')
      <tr>
         <td>{{ $product->code }}</td>
         <td>{{ $product->name }}</td>
         <td>{{ $product->on_store }}</td>
         <td>{{ $product->branch }}</td>
         <td>{{ $product->prize }}</td>
         <td>
            @foreach ($product->mixingProduct as $originals)
            {{ $originals->productOriginal->code}}
            @endforeach  
         </td>
         @auth('admin')
         <td><a href="{{ route('mixingProduct.show', $product->id) }}" type="submit" class="btn btn-primary">Změnit recept</a></td>
         <td style="width: 150px">
            <form action="{{ route('productMixed.addStore', $product->id) }}" method="post">
               @csrf
               @method('PUT')
               <div class="form-group">
                  <input type="number"  id="ammount" name="ammount" class="form-control" placeholder="množství">
                  <div class="invalid-feedback">
                  </div>
               </div>
               <button type="submit " class="btn btn-primary">Naskladnit</button>
            </form>
         </td>
         <td><a href="{{ route('productMixed.edit', $product->id) }}" type="submit" class="btn btn-primary">Upravit</a></td>
         <td>
            <form action="{{ route('productMixed.destroy', $product->id) }}" method="post">
               @csrf
               @method('DELETE')
               <button type="submit" class="btn btn-danger">Odstranit</button>
            </form>
         </td>
         @endauth
         @auth('employee')
         <td style="width: 150px">
            <form action="{{ route('productMixed.addStore', $product->id) }}" method="post">
               @csrf
               @method('PUT')
               <div class="form-group">
                  <input type="number"  id="ammount" name="ammount" class="form-control" placeholder="množství">
                  <div class="invalid-feedback">
                  </div>
               </div>
               <button type="submit" class="btn btn-primary">Naskladnit</button>
            </form>
         </td>
         @endauth
      </tr>
      @endif
      @endforeach
   </tbody>
</table>
@endif
@endsection