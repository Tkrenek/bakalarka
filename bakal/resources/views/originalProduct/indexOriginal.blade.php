@extends('layouts.navigation')

@section('content')
@auth('admin')
<a class="btn btn-primary" href="{{ route('productOriginal.create')}}" class="p-3">Přidat originální produkt</a>



@endauth
<a class="btn btn-primary float-right" href="{{ route('product.indexMixed')}}" class="p-3">Pouze míchané produkty</a>

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


  <h1 class="display-3 text-center mb-5">Originální produkty</h1>    
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
        @endforeach
        
      </tbody>
    </table>

  

@endsection