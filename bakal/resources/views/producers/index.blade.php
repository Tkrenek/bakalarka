@extends('layouts.navigation')
@section('content')
<h2 class="display-2 text-center">Seznam dodavatelů</h2>
<a class="btn-primary btn mb-3" href="{{ route('producers.create')}}" class="p-3">Přidat dodavatele</a>
<div class="d-flex justify-content-center">
   {{-- Zobrazemi vsech dodavaetelu v tabulce --}}
   <table class="table">
      <thead>
         <tr>
            <th scope="col">Název </th>
            <th scope="col">Email</th>
            <th scope="col">Telefon</th>
            <th scope="col">Adresa</th>
            <th scope="col">Upravit</th>
            <th scope="col">Smazat</th>
         </tr>
      </thead>
      <tbody>
         {{-- Pruchod pres vsechny dodavatele --}}
         @foreach ($producers as $producer)
         <tr>
            <td>{{ $producer->name }}</td>
            <td>{{ $producer->email }}</td>
            <td>{{ $producer->phone }}</td>
            <td>{{ $producer->address }}, {{ $producer->town }}</td>
            <td><a href="{{ route('producers.edit', $producer->id) }}" type="submit" class="btn btn-primary">Upravit profil</a>
            <td>
               <form action="{{ route('producers.destroy', $producer->id) }}" method="post">
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