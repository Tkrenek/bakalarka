@extends('layouts.navigation')
@section('content')
{{-- 
-- Nazev souboru: index.blade.php 
-- Pohled pro zobrazeni receptu
-- autor: Tomas  Krenek(xkrene15)  
--}}
<h2 class="text-center display-2 mb-5">Recepty produktů</h2>
{{-- Zobrazeni tabulky s recepty --}}
<table class="table">
   <thead>
      <tr>
         <th scope="col">Kód produktu</th>
         <th scope="col">Recept</th>
      </tr>
   </thead>
   <tbody>
      @foreach ($mixeds as $mixed)
         @if ($mixed->id == 1)
         @else
            <tr>
               <td>    
                  {{ $mixed->code }}
               </td>
               <td>
                  @foreach ($mixed->mixingProduct as $mix)
                     ({{ $mix->productOriginal->code }})
                  @endforeach
               </td>
            </tr>
         @endif
      @endforeach
   </tbody>
</table>
@endsection