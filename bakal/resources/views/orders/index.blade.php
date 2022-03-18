@extends('layouts.navigation')

@section('content')
  
@php
  use Carbon\Carbon as carbon;
@endphp
<form action="{{ route('orders.store') }}" method="post">
  @csrf
  <button type="submit" class="btn btn-outline-secondary">Vytvořit novou objednávku</button>
</form> 
   <table class="table">
      <thead>
        <tr>
       
          <th scope="col">ID objednávky</th>
          <th scope="col">Stav objednávky</th>
          <th scope="col">Termín objednávky</th>
          <th scope="col">Celková cena</th>
          <th scope="col">Faktura</th>
          @auth
          <th scope="col">Odstranit objednávku</th>
          <th scope="col">Změnit stav objednávky</th>
          <th scope="col">Změnit termín objednávky</th>
          <th scope="col">Upravit objednávku</th>
          @endauth
   
        </tr>
      </thead>
      <tbody>
         @foreach ($orders as $order)
          
       
        <tr>
           
          <td><a href="{{  route('orders.show', $order->id) }}">{{ $order->id }}</a></td> 
          <td>{{ $order->state }}</td>
          <td>{{ Carbon::parse($order->term)->format('d.m. Y')}} </td>
          <td>
            @php
              $sum = 0;
              $sumPckg = 0;
            @endphp
            @foreach ($order->item as $item)
              @foreach($item->packageItem as $pc)
                  @php
                  
                    $sumPckg += $pc->container->prize * $pc->count
                  
                  @endphp
              @endforeach
              @php
                  if($item->is_mixed == "ano") {
                    $sum += $item->amount * $item->productMixed->prize;
                  } else {
                    $sum += $item->amount * $item->productOriginal->prize;
                  }
              @endphp
                
              
            @endforeach
            {{ $sum + $sumPckg}} Kč
           </td>
          <td>{{ $order->invoice }}</td>
          @auth()
            <td>
              <form action="{{ route('orders.destroy', $order->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-secondary">Odstranit objednávku</button>
            </form>
            </td>
          @endauth
          

          
            @auth('employee')
            <td>
            <form action="{{ route('orders.changeState', $order->id) }}" method="post">
              @csrf
              @method('PUT')
              <div class="form-group">
               @error('state')
  
                   {{  $message }}
      
               @enderror
               <label for="state" class="sr-only">Stav</label>
               <input type="text"  id="state" name="state" >
               </div>
              <button type="submit" class="btn btn-secondary">Změnit stav objednávky</button>
              </form>
            </td>
          @endauth
          @auth
          <td>
          <form action="{{ route('orders.changeState', $order->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group ">
             @error('state')

                 {{  $message }}
    
             @enderror
             <label for="state" class="sr-only">Stav</label>
             <input type="text"  id="state" name="state" >
             </div> 
            <button type="submit" class="btn btn-secondary">Změnit stav objednávky</button>
        </form>
      </td>
          @endauth
            
          
@auth
<td>

  <form action="{{ route('orders.changeTerm', $order->id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="term">Změnit termín</label>
      <input type="date" id="term" name="term" class="@error('term') is-invalid @enderror form-control" >
      <div class="invalid-feedback">
          @error('term')

              {{  $message }}

          @enderror
      </div>  
  </div>
    <button type="submit" class="btn btn-secondary">Změnit termín objednávky</button>
</form>
<td>
    <a href="{{ route('orders.edit', $order->id) }}">Upravit objednávku(Admin)</a>
</td>
</td>
@endauth

@auth('employee')
<td>

  <form action="{{ route('orders.changeTerm', $order->id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="term">Změnit termín</label>
      <input type="date" id="term" name="term" class="form-control @error('term') is-invalid @enderror" >
      <div class="invalid-feedback">
          @error('term')

              {{  $message }}

          @enderror
      </div>  
  </div>
    <button type="submit" class="btn btn-secondary">Změnit termín objednávky</button>
</form>
<td>
    <a href="{{ route('orders.edit', $order->id) }}">Upravit objednávku(Admin)</a>
</td>
</td>
@endauth
           
      </tr>
        @endforeach
        
      </tbody>
    </table>
  

@endsection