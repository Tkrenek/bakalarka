@extends('layouts.navigation')

@section('content')
  
<div class="d-flex justify-content-center">
        
   <table class="table table-bordered">
      <thead>
        <tr>
       
          <th scope="col">Jméno</th>
          <th scope="col">Příjmení</th>
          <th scope="col">Email</th>
          <th scope="col">Telefon</th>
          <th scope="col">Datum narození</th>
          <th scope="col">Společnost</th>
          <th scope="col">Upravit</th>
          <th scope="col">Smazat</th>
          
        </tr>
      </thead>
      <tbody>
         @foreach ($contacts as $contact)
          
       
        <tr>
          
          <td>{{ $contact->name }}</td>
          <td>{{ $contact->surname }}</td>
          <td>{{ $contact->email }}</td>
          <td>{{ $contact->phone }}</td>
          <td>{{ \Carbon\Carbon::parse($contact->birth_date)->format('d.m.Y') }}</td>
          <td>{{ $contact->customer->name }}</td>
          <td><a href="{{ route('contact.edit', $contact->id) }}" type="submit" class="btn btn-secondary">Upravit profil</a></td>
          <td>
             <form action="{{ route('contact.destroy', $contact->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Smazat</button>
            </form>
          
          
      </tr>
        @endforeach
        
      </tbody>
    </table>
  
</div>

@endsection