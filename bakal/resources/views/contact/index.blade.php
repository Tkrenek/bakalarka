@extends('layouts.navigation')
@section('content')
{{-- 
-- Nazev souboru: index.blade.php 
-- Pohled pro zobrazeni kontaktnich osob
-- autor: Tomas  Krenek(xkrene15)  
--}}
<h1 class="text-center mb-5 display-2">Kontatní osoby </h1>
<div class="d-flex justify-content-center">
   {{-- Tabulka pro zobrazeni kontaktnich osob --}}
   <table class="table mb-5">
      <thead>
         <tr>
            <th scope="col">Jméno</th>
            <th scope="col">Příjmení</th>
            <th scope="col">Email</th>
            <th scope="col">Telefon</th>
            <th scope="col">Datum narození</th>
            <th scope="col">Společnost</th>
            {{-- Zobhrazeni pouze pro admina --}}
            @auth('admin')
               <th scope="col">Upravit</th>
               <th scope="col">Smazat</th>
            @endauth
         </tr>
      </thead>
      <tbody>
         {{-- prochazime kontaktni osoby v promenne contacts --}}
         @foreach ($contacts as $contact)
         <tr>
            <td>{{ $contact->name }}</td>
            <td>{{ $contact->surname }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->phone }}</td>
            <td>{{ \Carbon\Carbon::parse($contact->birth_date)->format('d.m.Y') }}</td>
            <td>{{ $contact->customer->name }}</td>
            @auth('admin')
            <td><a href="{{ route('contact.edit', $contact->id) }}" type="submit" class="btn btn-primary">Upravit profil</a></td>
            <td>
               <form action="{{ route('contact.destroy', $contact->id) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Smazat</button>
               </form>
            </td>
            @endauth
         </tr>
         @endforeach
      </tbody>
   </table>
</div>
@endsection