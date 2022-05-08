@extends('layouts.navigation')
@section('content')
{{-- 
-- Nazev souboru: index.blade.php 
-- Pohled s navodem pro zprovozneni google kalendare pro zamestnance
-- autor: Tomas  Krenek(xkrene15)  
--}}

<div class="d-flex justify-content-center">
   <h2 class="display-2 mb-4">Aktivace google kalendáře</h2>
</div>
<div class="row mt-3">
   <div class="calendar">
      Pokud chcete mít přehled o všech objednávkách ve svém google kalendáři, přidejte si nový Google kalendář ve svém google účtu jako "Přidat nový kalendář pomocí URL":
      https://calendar.google.com/calendar/ical/lr8rolt3sp9kenip7vs97t6slo%40group.calendar.google.com/public/basic.ics
   </div>
</div>
@endsection