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
            <th scope="col">Vybrat</th>
        @endauth
        @auth('customer')
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
        
       
        
    </tr>
      @endforeach
      
    </tbody>
  </table>


   
  


@endsection