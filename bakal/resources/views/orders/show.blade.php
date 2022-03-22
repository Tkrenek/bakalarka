@extends('layouts.navigation')

@section('content')
  

        
   
   
   <h1>ID objednávky: {{ $order->id }}</h1>
   
   <a href="{{ route('orders.myindex', 1 )}}">Zpět na moje objednávky</a>
  
   <table class="table">
      <th scope="col">Kód produktu</th>
      <th scope="col">Název produktu</th>
      <th scope="col">Množství(v litrech)</th>
    

      <th scope="col">Cena</th>
      <th scope="col">Cena za balení</th>

      <th scope="col">Vybrat balení</th>
      <th scope="col">Balení</th>
      <th scope="col">Odstranit</th>

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
         <td><a href="{{ route('packageItem.show', $item->id) }}">Upravit balení</a>
            

         <td>
         @foreach ($item->packageItem as $cont)
            {{ $cont->container->type }} - {{ $cont->container->bulk }}l({{ $cont->count }}ks)
         @endforeach
         </td>
         
         <td>
            <form action="{{ route('items.destroy', $item->id) }}" method="post">
               @csrf
               @method('DELETE')
               <button type="submit" class="btn btn-danger">Smazat</button>
           </form>
         </td>
         </tr>
      
      @endforeach

      
   </table>
   <a class="btn btn-outline-secondary" href="{{ route('items.create', $order->id) }}" role="button">Přidat položku</a>
  


@endsection