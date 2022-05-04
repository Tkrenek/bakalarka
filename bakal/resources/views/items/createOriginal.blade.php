@extends('layouts.navigation')

@section('content')
  
<div class="text-center text-danger" style="font-size: larger;">

  @error('ammount')
    Musíte vybrat množství ve správném formátu.
  @enderror

</div>

<a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary">Vrátit se zpět</a>

<a href="{{ route('items.create', $order->id) }}" class="btn btn-primary float-right ml-2">Všechny produkty</a>
<a href="{{ route('items.createMixed', $order->id) }}" class="btn btn-primary float-right ">Pouze Míchané</a>
  


<h1 class="display-3 text-center mb-5">Originální produkty</h1>    
  <div class="row">
    @if ($message = Session::get('error'))
                        <div class="alert alert-block alert-danger color-danger text-center">
                            <strong>{{ $message }}  </strong>   
                        </div>    
                        
                        
                    @endif
  </div>
  
   <table class="table mb-5">
      <thead>
        <tr>
          <th scope="col">Kód</th>
          <th scope="col">Název</th>
          <th scope="col">Na skladě</th>
          <th scope="col">Odvětví</th>
          <th scope="col">Cena(Kč)</th>
          <th scope="col">Dodavatel</th>
          @auth('admin')
          <th scope="col">Vybrat</th>
        @endauth
          @auth('customer')
            <th scope="col">Vybrat</th>
          @endauth
        </tr>
      </thead>
      <tbody>
        @php
          $isFirst = true;
          @endphp

         @foreach ($products as $product)
         @php
         if($isFirst) {
        $isFirst = false;
        continue;
        } 
       @endphp
       
        <tr>
          <td>{{ $product->code }}</td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->on_store }}</td>
          <td>{{ $product->branch }}</td>
          <td>{{ $product->prize }}</td>
          <td>{{ $product->producer->name }}</td>
          <td style="width: 150px">
             
            <form action="{{ route('items.store', ['orderid'=>$order->id,'productcode'=>$product->code]) }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="ammount" >Množsví</label>
                    <div class="row">
                        <div class="col">   
                            <input placeholder="množství" style="width: 170px" type="text"  id="ammount" name="ammount" class="mb-3 form-control ">
                            
                        
                      </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">Přidat k objednávce</button>
                        </div>
                    </div>
              </form>

          </td>
         
          
  
          
      </tr>
        @endforeach
        
      </tbody>
    </table>



@endsection