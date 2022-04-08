@extends('layouts.navigation')

@section('content')
  
<h1 class="display-3 text-center mb-5">Přehled nádob</h1>

  <table class="table table-bordered">
    <thead>
      <tr>
     
        <th scope="col">Typ nádoby</th>
        <th scope="col">Objem(v litrech)</th>
        <th scope="col">Na skladě</th>
        <th scope="col">Cena</th>
        @auth('admin')
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
       @foreach ($containers as $container)
        
     
      <tr>
        
        <td>{{ $container->type }}</td>
        <td>{{ $container->bulk }} (litr)</td>
        <td>{{ $container->on_store }} ks</td>
        <td>{{ $container->prize }} Kč</td>
 
        @auth('employee')
        <td><a href="{{ route('containers.edit', $container->id) }}" type="submit" class="btn btn-secondary">Upravit</a></td>
        
          <td>
            <form action="{{ route('containers.addStore', $container->id) }}" method="post">
              @csrf
              @method('PUT')
              <div class="form-group">
               
                <label for="ammount" class="sr-only">Množství</label>
                <input type="number"  id="ammount" name="ammount" class="form-control @error('ammount') is-invalid @enderror">
                <div class="invalid-feedback">
                  @error('ammount')
                      Musíte zadat množství.
         
                  @enderror
              </div>  
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
        @auth('admin')
        
          <td><a href="{{ route('containers.edit', $container->id) }}" type="submit" class="btn btn-secondary">Upravit</a></td>
          <td><form action="{{ route('containers.addStore', $container->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
             
              <label for="ammount" class="sr-only">Množství</label>
              <input type="number"  id="ammount" name="ammount" class="form-control  @error('ammount') is-invalid @enderror">
              <div class="invalid-feedback">
                @error('ammount')
                    Musíte zadat množství.
       
                @enderror
            </div>  
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