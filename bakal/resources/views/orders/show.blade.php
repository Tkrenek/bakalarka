@extends('layouts.navigation')

@section('content')
  

        
   
   
   <h1>ID objednávky: {{ $order->id }}</h1>
   
  
   <table>
      <th>Kód produktu</th>
      <th>Název produktu</th>
      <th>Množství(v litrech)</th>
    
      <th>Stav</th>
      <th>Temín</th>
      <th>Cena</th>
      <th>Cena za balení</th>

      <th>Vybrat balení</th>
      <th>Balení</th>
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
 
         <td>{{ $order->state }} 
            
         </td> 

         <td> {{ $order->term }}</td> 
         <td><a href="{{ route('packageItem.create', $item->id) }}">Vybrat balení</a></td>
         <td>@foreach ($item->packageItem as $cont)
            {{ $cont->container->type }} - {{ $cont->container->bulk }}l({{ $cont->count }})
         @endforeach
         </td>
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
      </tr>
      
      @endforeach

      
   </table>

   <a href="{{ route('items.create', $order->id) }}">Přidat položku</a>
  
  


@endsection