@extends('layouts.navigation')
@section('content')
{{-- 
-- Nazev souboru: index.blade.php 
-- Pohled pro zobrazeni zamestnancu
-- autor: Tomas  Krenek(xkrene15)  
--}}
<h2 class="display-2 text-center">Seznam zaměstnanců</h2>
<a class="btn-primary btn mb-3" href="{{ route('employees.create')}}" class="p-3">Přidat zaměstnance</a>
<div class="d-flex justify-content-center">
   {{-- Tabulka pro zobrazeni vsech zamestnancu --}}
   <table class="table mb-5">
      <thead>
         <tr>
            <th scope="col">Jméno
            </th>
            <th scope="col">Příjmení</th>
            <th scope="col">Email</th>
            <th scope="col">Telefon</th>
            <th scope="col">Datum narození</th>
            <th scope="col">Oddělení</th>
            <th scope="col">Označit práci</th>
            <th scope="col">Upravit</th>
            <th scope="col">Změnit heslo</th>
            <th scope="col">Smazat</th>
         </tr>
      </thead>
      <tbody>
         {{-- Pruchod pres vsechny zamestnance --}}
         @foreach ($employees as $employee)
         <tr>
            <td>{{ $employee->name }}</td>
            <td>{{ $employee->surname }}</td>
            <td>{{ $employee->email }}</td>
            <td>{{ $employee->phone }}</td>
            <td>{{ \Carbon\Carbon::parse($employee->birth_date)->format('d.m.Y') }}</td>
            <td>{{ $employee->department->name }}</td>
            <td><a href="{{ route('orderWork.admin.create', $employee->id) }}" type="submit" class="btn btn-primary">Označit práci</a></td>
            <td><a href="{{ route('employees.edit', $employee->id) }}" type="submit" class="btn btn-primary">Upravit profil</a>
            <td> <a href="{{ route('employees.change_password.admin', $employee->id) }}" type="submit" class="btn btn-primary">Změnit heslo</a></td>
            <td>
               <form action="{{ route('employees.destroy', $employee->id) }}" method="post">
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