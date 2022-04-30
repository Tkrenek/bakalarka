@extends('layouts.navigation')

@section('content')
  
<h1 class="text-center display-2 mb-5">Seznam zákazníků</h1>
<a class="btn-secondary btn mb-3" href="{{ route('customers.create')}}" class="p-3">Přidat zákazníka</a>
<div class="d-flex justify-content-center">
        
   <table class="table">
      <thead>
        <tr>
       
          <th scope="col">Jméno</th>
          <th scope="col">Město</th>
          <th scope="col">Adresa</th>
          <th scope="col">URL</th>
          <th scope="col">Upravit</th>
          <th scope="col">Změnit heslo</th>
          <th scope="col">Nová objednávka</th>
          <th scope="col">Kontaktní osoby</th>
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
          <td><a href="{{ route('customers.edit', $customer->id) }}" type="submit" class="btn btn-secondary">Upravit účet</a></td>
          <td><a href="{{ route('customers.change_passwordAdmin', $customer->id) }}" type="submit" class="btn btn-secondary">Změnit heslo</a></td>
          <td>
            <form action="{{ route('orders.admin.store', $customer->id) }}" method="post">
              @csrf
              <button type="submit" class="btn btn-secondary">Vytvořit objednávku</button>
            </form> 
         </td>
         <td>
          <a href="{{ route('contact.indexAdmin', $customer->id) }}" type="btn" class="btn btn-secondary">Zobrazit kontakty</a> 
          </td>
         <td>
          <a href="{{ route('contact.admin.create', $customer->id) }}" type="btn" class="btn btn-secondary">Přidat osobu</a> 
       </td>
         
          <td>
             <form action="{{ route('customers.destroy', $customer->id) }}" method="post">
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