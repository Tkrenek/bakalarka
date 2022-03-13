@extends('layouts.navigation')

@section('content')
  

  <h1>Originální produkty</h1>    
   <table class="table">
      <thead>
        <tr>
          <th scope="col">Kód</th>
          <th scope="col">Název</th>
          <th scope="col">Na skladě</th>
          <th scope="col">Odvětví</th>
          <th scope="col">Cena(Kč)</th>
          <th scope="col">Dodavatel</th>
          @auth
            <th scope="col">Upravit</th>
            <th scope="col">Naskladnit</th>
            <th scope="col">Odstranit</th>

          @endauth
          @auth('employee')
          <th scope="col">Upravit</th>
          <th scope="col">Naskladnit</th>
          <th scope="col">Odstranit</th>
          @endauth          
        </tr>
      </thead>
      <tbody>
         @foreach ($products as $product)
          
       
        <tr>
          <td>{{ $product->code }}</td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->on_store }}</td>
          <td>{{ $product->branch }}</td>
          <td>{{ $product->prize }}</td>
          <td>{{ $product->producer->name }}</td>
          
          @auth
            <td><a href="{{ route('productOriginal.edit', $product->id) }}">Upravit</a></td>
            <td>
              <form action="{{ route('productOriginal.addStore', $product->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group row">
                  @error('ammount')

                      {{  $message }}
          
                  @enderror
                  <label for="ammount" class="sr-only">Množsví</label>
                  <input type="text"  id="ammount" name="ammount" >
                  </div>
                <button type="submit">Naskladnit</button>
              </form>
            </td>
            <td>
              <form action="{{ route('productOriginal.destroy', $product->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit">Odstranit</button>
            </form>
            </td>
          @endauth

          @auth('employee')
          <td><a href="{{ route('productOriginal.edit', $product->id) }}">Upravit</a></td>
          <td>
            <form action="{{ route('productOriginal.addStore', $product->id) }}" method="post">
              @csrf
              @method('PUT')
              <div class="form-group row">
                @error('ammount')

                    {{  $message }}
        
                @enderror
                <label for="ammount" class="sr-only">Množsví</label>
                <input type="text"  id="ammount" name="ammount" >
                </div>
              <button type="submit">Naskladnit</button>
            </form>
          </td>
          <td>
            <form action="{{ route('productOriginal.destroy', $product->id) }}" method="post">
              @csrf
              @method('DELETE')
              <button type="submit">Odstranit</button>
          </form>
          </td>
          @endauth
          
      </tr>
        @endforeach
        
      </tbody>
    </table>

    <h1>Mixed Products</h1> 
  
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Kód</th>
          <th scope="col">Název</th>
          <th scope="col">Na skladě</th>
          <th scope="col">Odvětví</th>
          <th scope="col">Cena(Kč)</th>
          <th scope="col">Dodavatel</th>
          <th scope="col">Upravit</th>
          <th scope="col">Naskladnit</th>
          <th scope="col">Odstranit</th>
        </tr>
      </thead>
      <tbody>
         @foreach ($productsMixed as $product)
          
       
        <tr>
          <td>{{ $product->code }}</td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->branch }}</td>
          <td>{{ $product->prize }}</td>
          <td>{{ $product->on_store }}</td>
          @auth
            <td><a href="{{ route('productMixed.edit', $product->id) }}">Upravit produkt</a></td>
            <td>
              <form action="{{ route('productMixed.addStore', $product->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group row">
                  @error('ammount')

                      {{  $message }}
          
                  @enderror
                  <label for="ammount" class="sr-only">Množství</label>
                  <input type="text"  id="ammount" name="ammount" >
                  </div>
                <button type="submit">Naskladnit</button>
              </form>
            </td>
            
            <td>
              <form action="{{ route('productMixed.destroy', $product->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit">Odstranit</button>
            </form>
          </td>
          @endauth

          @auth('employee')
          <td><a href="{{ route('productMixed.edit', $product->id) }}">Upravit produkt</a></td>
          <td>
            <form action="{{ route('productMixed.addStore', $product->id) }}" method="post">
               @csrf
               @method('PUT')
               <div class="form-group row">
                @error('ammount')

                    {{  $message }}
        
                @enderror
                <label for="ammount" class="sr-only">Množství</label>
                <input type="text"  id="ammount" name="ammount" >
                </div>
               <button type="submit">Naskladnit</button>
            </form>
          </td>
          
          <td>
            <form action="{{ route('productMixed.destroy', $product->id) }}" method="post">
               @csrf
               @method('DELETE')
               <button type="submit">Odstranit</button>
           </form>
          </td>
          @endauth
          
      </tr>
        @endforeach
        
      </tbody>
    </table>


@endsection