@extends('layouts.navigation')

@section('content')
  
<a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary">Vrátit se zpět</a>


  


<h1 class="display-3 text-center mb-5">Originální produkty</h1>    
  <div class="row">
    @if ($message = Session::get('error'))
                        <div class="alert alert-block alert-danger color-danger text-center">
                            <strong>{{ $message }}  </strong>   
                        </div>    
                        
                        
                    @endif
  </div>
  
   <table class="table mb-5 table-bordered">
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
          <td>
             
            <form action="{{ route('items.store', ['orderid'=>$order->id,'productcode'=>$product->code]) }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="ammount" >Množsví</label>
                    <div class="row">
                        <div class="col">   
                            <input type="text"  id="ammount" name="ammount" class="form-control @error('ammount') is-invalid @enderror">
                            <div class="invalid-feedback">
                              @error('ammount')
                                  Musíte zadat množství.
                     
                              @enderror
                              
                              
                          
                        </div>
                        
                      </div>
                        <div class="col">
                            <button type="submit" class="btn btn-secondary">Přidat k objednávce</button>
                        </div>
                    </div>
              </form>

          </td>
          
  
          
      </tr>
        @endforeach
        
      </tbody>
    </table>

    <h1 class="display-3 text-center mb-5"> Míchané produkty</h1> 
  
    <table class="table mb-5 table-bordered">
      <thead >
        <tr>
          <th scope="col">Kód</th>
          <th scope="col">Název</th>
          <th scope="col">Na skladě</th>
          <th scope="col">Odvětví</th>
          <th scope="col">Cena(Kč)</th>
          
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
         @foreach ($productsMixed as $product)
           
         
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
          <td>
          <form action="{{ route('items.store', ['orderid'=>$order->id,'productcode'=>$product->code]) }}" method="post">
            @csrf
            <div class="form-group ">

                <label for="ammount" >Množsví</label>
                <div class="row">
                    <div class="col">   
                        <input type="text"  id="ammount" name="ammount" class="form-control @error('ammount') is-invalid @enderror" >
                        <div class="invalid-feedback">
                          @error('ammount')
                              Musíte zadat množství.
                          @enderror
                      </div>
                     
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-secondary">Přidat k objednávce</button>
                    </div>
                </div>
                
              </div>
            
          </form>
          </td>
          
          

         
          
      </tr>
        @endforeach
        
      </tbody>
    </table>


@endsection