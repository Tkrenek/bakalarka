@extends('layouts.navigation')
@section('content')
{{-- 
-- Nazev souboru: index.blade.php 
-- Pohled pro zobrzeni prace na objednavce
-- autor: Tomas  Krenek(xkrene15)  
--}}
@php
use Carbon\Carbon;
@endphp
<h2 class="text-center display-2 mb-5">Odvedená práce</h2>
{{-- Tabulka pro vypsani odvedenych praci na objednavkach --}}
<table class="table mb-5">
   <thead>
      <tr>
         <th scope="col">ID objednávky</th>
         <th scope="col">Typ práce</th>
         <th scope="col">Datum</th>
         <th scope="col">Doba práce</th>
         @auth('admin')
            <th scope="col">Zaměstnanec</th>
            <th scope="col">Smazat</th>
         @endauth
         @auth('employee')
            <th scope="col">Smazat</th>
         @endauth
      </tr>
   </thead>
   <tbody>
      {{-- Pruchod pres vschny odvedene prace --}}
      @foreach ($orderworks as $orderwork)
         <tr>
            <td>    
               {{ $orderwork->order->id }}
            </td>
            <td>
               {{ $orderwork->work_type }} 
            </td>
            <td>    
               {{ \Carbon\Carbon::parse($orderwork->date)->format('d.m.Y') }}
            </td>
            <td>    
               {{ $orderwork->time }}
            </td>
            @auth('admin')
            <td>
               {{ $orderwork->employee->name }} {{ $orderwork->employee->surname }}
            </td>
            @endauth
            <td>
               <form action="{{ route('orderWork.destroy', $orderwork->id) }}" method="post">
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