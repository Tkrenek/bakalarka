@extends('layouts.navigation')

@section('content')
@auth('admin')




<a class="btn btn-primary float-right" href="{{ route('productMixed.create')}}" class="p-3 ">Přidat míchaný produkt</a>



@endauth

<a class="btn btn-primary float-right" href="{{ route('product.indexOriginal')}}" class="p-3">Pouze originální produkty</a>

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



    <h1 class="display-3 text-center mb-5">Míchané produkty</h1> 
  
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
        @endforeach
        
      </tbody>
    </table>


@endsection