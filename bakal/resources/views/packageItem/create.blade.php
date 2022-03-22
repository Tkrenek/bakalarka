@extends('layouts.navigation')

@section('content')
  

  <table class="table">
    <thead>
      <tr>
     
        <th scope="col">Typ nádoby</th>
        <th scope="col">Objem(v litrech)</th>
        <th scope="col">Na skladě</th>
        <th scope="col">Cena</th>

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
        @auth('subscriber')
            <th scope="col">Vybrat</th>
        @endauth
        
      </tr>
    </thead>
    <tbody>
       @foreach ($containers as $container)
        
     
      <tr>
        
        <td>{{ $container->type }}</td>
        <td>{{ $container->bulk }}</td>
        <td>{{ $container->on_store }}</td>
        <td>{{ $container->prize }}</td>
        <td>
            
            <form action="{{ route('packageItem.store', ['itemid' => $itemid, 'containerid' => $container->id]) }}" method="post">
              @csrf
              <div class="form-group ">
  
                  <label for="count" >Množsví</label>
                  <div class="row">
                      <div class="col">   
                          <input type="text"  id="count" name="count" class="form-control">
                      </div>
                      <div class="col">
                          <button type="submit" class="btn btn-secondary">Přidat balení</button>
                      </div>
                  </div>
                @error('count')
  
                Musíte vybrat množství.
        
                @enderror
                </div>
              
            </form>
            </td>
        
        @auth('employee')
        <td><a href="{{ route('containers.edit', $container->id) }}" type="submit" class="btn btn-secondary">Upravit</a></td>
        
          <td>
            <form action="{{ route('containers.addStore', $container->id) }}" method="post">
              @csrf
              @method('PUT')
              <div class="form-group">
               
                <label for="ammount" class="sr-only">Množství</label>
                <input type="number"  id="ammount" name="ammount" class="form-control">
                @error('ammount')

                  Musíte zadat množství.
    
            @enderror
                </div>
              <button type="submit" class="btn btn-secondary">Naskladnit</button>
          </form>
          </td>
          <td>
            <form action="{{ route('containers.destroy', $container->id) }}" method="post">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-secondary">Smazat</button>
          </form>
          </td>
        @endauth
        @auth
        
          <td><a href="{{ route('containers.edit', $container->id) }}" type="submit" class="btn btn-secondary">Upravit</a></td>
          <td><form action="{{ route('containers.addStore', $container->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
              @error('ammount')

                  {{  $message }}
      
              @enderror
              <label for="ammount" class="sr-only">Množství</label>
              <input type="number"  id="ammount" name="ammount" class="form-control">
              </div>
            <button type="submit" class="btn btn-secondary">Naskladnit</button>
        </form>
          </td>
        <td>
          <form action="{{ route('containers.destroy', $container->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-secondary">Smazat</button>
        </form>
        </td>
        @endauth
        
    </tr>
      @endforeach
      
    </tbody>
  </table>


   
  


@endsection