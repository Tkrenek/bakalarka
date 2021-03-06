@extends('layouts.navigation')
@section('content')
{{-- 
-- Nazev souboru: subindex.blade.php 
-- Pohled pro zobrazeni zuakaznikovych kontaktnich osob
-- autor: Tomas  Krenek(xkrene15)  
--}}
<h1 class="text-center mb-5 display-2">Moje kontatní osoby </h1>
<div class="d-flex justify-content-center">
   {{-- Zobrazeni kontaktnich osob pro zakaznika --}}
   <table class="table">
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
         {{-- Pruchod pres vsechny zakaznikovi kontaktni osoby --}}
         @foreach ($contacts as $contact)
         <tr>
            <td>{{ $contact->name }}</td>
            <td>{{ $contact->surname }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->phone }}</td>
            <td>{{ \Carbon\Carbon::parse($contact->birth_date)->format('d.m.Y') }}</td>
            <td>{{ $contact->customer->name }}</td>
            <td><a href="{{ route('contact.edit', $contact->id) }}" type="submit" class="btn btn-primary">Upravit profil</a></td>
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