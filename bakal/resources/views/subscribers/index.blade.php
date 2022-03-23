@extends('layouts.navigation')

@section('content')
  
<div class="d-flex justify-content-center">
        
   <table class="table">
      <thead>
        <tr>
       
          <th scope="col">Jméno</th>
          <th scope="col">Město</th>
          <th scope="col">Adresa</th>
          <th scope="col">URL</th>
          <th scope="col">Upravit</th>
          <th scope="col">Nová objednávka</th>
          <th scope="col">Nová kontaktní osoba</th>
          <th scope="col">Odstranit</th>
        </tr>
      </thead>
      <tbody>
         @foreach ($customers as $customer)
          
       
        <tr>
          
          <td>{{ $customer->name }}</td>
          <td>{{ $customer->town }}</td>
          <td>{{ $customer->address }}</td>
          <td>{{ $customer->url }}</td>
          <td><a href="{{ route('subscribers.edit', $customer->id) }}" type="submit" class="btn btn-secondary">Upravit účet</a></td>
          
          <td>
            <form action="{{ route('orders.admin.store', $customer->id) }}" method="post">
              @csrf
              <button type="submit" class="btn btn-secondary">Vytvořit objednávku</button>
            </form> 
         </td>
         <td>
          <form action="{{ route('orders.admin.store', $customer->id) }}" method="post">
            @csrf
            <button type="submit" class="btn btn-secondary">Přidat osobu</button>
          </form> 
       </td>
         
          <td>
             <form action="{{ route('subscribers.destroy', $customer->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Odstranit</button>
            </form>
          </td>
          
         
        </tr>
        @endforeach
        
      </tbody>
    </table>
  
</div>

@endsection