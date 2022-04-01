@extends('layouts.navigation')

@section('content')
  



   
   <h1>ID objednávky: {{ $order->id }}</h1>
   @auth('customer')
      <a href="{{ route('orders.myindex', auth('customer')->user()->id )}}">Zpět na moje objednávky</a>
   @endauth
   @auth
      <a href="{{ route('orders.index')}}">Zpět na  objednávky</a>
   @endauth
   @auth('employee')
      <a href="{{ route('orders.index')}}">Zpět na  objednávky</a>
   @endauth

   @auth('customer')
      <a class="btn btn-outline-secondary" href="{{ route('items.create', $order->id) }}" role="button">Přidat položku</a>
   @endauth
   @auth()
      <a class="btn btn-outline-secondary" href="{{ route('items.create', $order->id) }}" role="button">Přidat položku</a>
   @endauth

   <table class="table">
      <th scope="col">Kód produktu</th>
      <th scope="col">Název produktu</th>
      <th scope="col">Množství(v litrech)</th>
    

      <th scope="col">Cena</th>
      <th scope="col">Cena za balení</th>
      <th scope="col">Balení</th>

      @auth
         <th scope="col">Vybrat balení</th>
         
         <th scope="col">Odstranit</th>
      @endauth
      @auth('customer')
         <th scope="col">Vybrat balení</th>
         
         <th scope="col">Odstranit</th>
      @endauth
     

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
         <td>
            
            @if ($item->is_mixed == "ano")
               {{ $item->amount * $item->productMixed->prize  }}
            @else
               {{ $item->amount * $item->productOriginal->prize }}   
            @endif
            Kč
            
         </td>
         <td>
            @foreach ($item->packageItem as $pckg)
               {{ $pckg->count * $pckg->container->prize }} Kč
            @endforeach

         </td>

         <td>
            @foreach ($item->packageItem as $cont)
               {{ $cont->container->type }} - {{ $cont->container->bulk }}l({{ $cont->count }}ks)
            @endforeach
            </td>
            @auth
               <td><a href="{{ route('packageItem.show', $item->id) }}">Upravit balení</a>
            
                  <td>
                     <form action="{{ route('items.destroy', $item->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Smazat</button>
                  </form>
                  </td>
            @endauth
            @auth('customer')
               <td><a href="{{ route('packageItem.show', $item->id) }}">Upravit balení</a>
               
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
@if (empty($recommended))
   
@else
<h3>Často nakupované položky s vaším zbožím:</h3>
   @foreach ($recommended as $one)
      {{ $one[0] }}
   
   @endforeach
@endif
   
  


@endsection