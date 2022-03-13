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
        
      </tr>
    </thead>
    <tbody>
       @foreach ($containers as $container)
        
     
      <tr>
        
        <td>{{ $container->type }}</td>
        <td>{{ $container->bulk }}</td>
        <td>{{ $container->on_store }}</td>
        <td>{{ $container->prize }}</td>
 
        @auth('employee')
        <td><a href="{{ route('containers.edit', $container->id) }}">Upravit</a></td>
        
          <td>
            <form action="{{ route('containers.addStore', $container->id) }}" method="post">
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
            <form action="{{ route('containers.destroy', $container->id) }}" method="post">
              @csrf
              @method('DELETE')
              <button type="submit">Smazat</button>
          </form>
          </td>
        @endauth
        @auth
        <td>
          <td><a href="{{ route('containers.edit', $container->id) }}">Upravit</a></td>
          <form action="{{ route('containers.addStore', $container->id) }}" method="post">
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
          <form action="{{ route('containers.destroy', $container->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit">Smazat</button>
        </form>
        </td>
        @endauth
        
    </tr>
      @endforeach
      
    </tbody>
  </table>


   
  


@endsection