@extends('layouts.navigation')
@section('content')
{{-- 
-- Nazev souboru: index.blade.php 
-- Pohled pro zobrazeni oddeleni
-- autor: Tomas  Krenek(xkrene15)  
--}}
@php
   use Carbon\Carbon as carbon;
@endphp
<h1 class="display-2 text-center mb-5">Seznam oddělení</h1>
<a class="btn btn-primary mb-3" href="{{ route('departments.create') }}">Přidat Oddělení</a>
{{-- Zobrazeni vsech oddeleni --}}
<table class="table text-center">
   <thead>
      <tr>
         <th scope="col">Název oddělení</th>
         <th scope="col">Počet pracovníků</th>
         <th scope="col">Odstranit</th>
      </tr>
   </thead>
   <tbody>
      {{-- Pruchod pres vsechny oddeleni --}}
      @foreach ($departments as $department)
      <tr>
         <td>
            {{ $department->name }}
         </td>
         {{-- Zobrazeni poctu zamestnancu na oddeleni --}}
         <td>
            {{ $count2 = \DB::table('employees')->where('department_id', '=', $department->id)->count() }}
         </td>
         <td>
            <form action="{{ route('departments.destroy', $department->id) }}" method="post">
               @csrf
               @method('DELETE')
               <button type="submit" class="btn btn-danger">Odstranit</button>
            </form>
         </td>
      </tr>
      @endforeach
   </tbody>
</table>
@endsection