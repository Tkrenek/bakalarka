@extends('layouts.navigation')
@section('content')
{{-- 
-- Nazev souboru: index.blade.php 
-- Pohled pro zobrazeni statistik
-- autor: Tomas  Krenek(xkrene15)  
--}}
{{-- Inspirace pri vytvoreni grafu z: https://appdividend.com/2022/02/28/add-charts-laravel-using-chartjs/ --}}
<h1 class="display-1 text-center mb-5">Statistiky</h1>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
<script src="{{ asset('chart.js/chart.js') }}"></script>
{{-- Statistiky pro admina --}}
@auth('admin')
   <div class="row mt-4 mb-5">
      <div class="chart-container col-4">
         <div class="text-center mb-4">
            <span class="stats">Nejprodávaněší nádoby</span> 
         </div>
         <canvas id="myChart4"></canvas> {{-- Canvas do ktereho se graf vykresli --}}
      </div>
      <div class="chart-container col-4">
         <div class="text-center mb-4">
            <span class="stats">Nejprodávanější produkty</span>
         </div>
         <canvas id="myChart6"></canvas>
      </div>
      <div class="chart-container col-4">
         <div class="text-center mb-4">
            <span class="stats">Nejpilnější zaměstnanci</span>
         </div>
         <canvas id="myChart3"></canvas> {{-- Canvas do ktereho se graf vykresli --}}
      </div>
   </div>
   <div class="row mb-5 mt-5">
      <div class="chart-container col-4">
         <div class="text-center mb-4">
            <span class="stats">Podíl míchaných a originálních produktů (v %)</span>
         </div>
         <canvas id="myChart1"></canvas> {{-- Canvas do ktereho se graf vykresli --}}
      </div>
      <div class="chart-container mt-5 col-4">
         <div class="text-center mb-4">
            <span class="stats ">Největší zákazníci</span>
         </div>
         <canvas id="myChart2"></canvas> {{-- Canvas do ktereho se graf vykresli --}}
      </div>
      <div class="chart-container col-4">
         <div class="text-center mb-4">
            <span class="stats">Podíl kanystrů a plechovek (v %)</span>
         </div>
         <canvas id="myChart5"></canvas> {{-- Canvas do ktereho se graf vykresli --}}
      </div>
   </div>
@endauth
{{-- Statistiky pro zakaznika --}}
@auth('customer')
   <div class="row mt-4 mb-5">
      <div class="chart-container col-4 offset-2">
         <div class="text-center mb-4">
            <span class="stats">Nejprodávaněší nádoby</span>
         </div>
         <canvas id="myChart4"></canvas> {{-- Canvas do ktereho se graf vykresli --}}
      </div>
      <div class="chart-container col-4">
         <div class="text-center mb-4">
            <span class="stats">Nejprodávanější produkty</span>
         </div>
         <canvas id="myChart6"></canvas> {{-- Canvas do ktereho se graf vykresli --}}
      </div>
   </div>
   <div class="row mb-5 mt-5">
      <div class="chart-container col-4 offset-2">
         <div class="text-center mb-4">
            <span class="stats">Podíl míchaných a originálních produktů (v %)</span>
         </div>
         <canvas id="myChart1"></canvas> {{-- Canvas do ktereho se graf vykresli --}}
      </div>
      <div class="chart-container col-4">
         <div class="text-center mb-4">
            <span class="stats">Podíl kanystrů a plechovek (v %)</span>
         </div>
         <canvas id="myChart5"></canvas> {{-- Canvas do ktereho se graf vykresli --}}
      </div>
   </div>
@endauth
{{-- Statistiky pro zamestnance --}}
@auth('employee')
   <div class="row mt-4 mb-5">
      <div class="chart-container col-4">
         <div class="text-center mb-4">
            <span class="stats">Nejprodávaněší nádoby</span>
         </div>
         <canvas id="myChart4"></canvas> {{-- Canvas do ktereho se graf vykresli --}}
      </div>
      <div class="chart-container col-4">
         <div class="text-center mb-4">
            <span class="stats">Nejprodávanější produkty</span>
         </div>
         <canvas id="myChart6"></canvas> {{-- Canvas do ktereho se graf vykresli --}}
      </div>
      <div class="chart-container col-4">
         <div class="text-center mb-4">
            <span class="stats">Největší zákazníci</span>
         </div>
         <canvas id="myChart2"></canvas> {{-- Canvas do ktereho se graf vykresli --}}
      </div>
   </div>
   <div class="row mb-5 mt-5">
      <div class="chart-container col-4 offset-2">
         <div class="text-center mb-4">
            <span class="stats">Podíl míchaných a originálních produktů (v %)</span>
         </div>
         <canvas id="myChart1"></canvas> {{-- Canvas do ktereho se graf vykresli --}}
      </div>
      <div class="chart-container col-4">
         <div class="text-center mb-4">
            <span class="stats">Podíl kanystrů a plechovek (v %)</span>
         </div>
         <canvas id="myChart5"></canvas> {{-- Canvas do ktereho se graf vykresli --}}
      </div>
   </div>
@endauth
@php $label=array(); $data=array(); @endphp {{-- Pole pro data, ktera budou zobrazena --}}
{{-- Pruchod pres pole, ktere prislo z Controlleru --}}
@foreach($nejvic as $nej) 
   @php
      // ulozeni jmena a poctu do samostatnych poli
      array_push($label, $nej->name);
      array_push($data, $nej->count);
   @endphp
@endforeach
<script>
   // inspirace z: https://www.php.net/manual/en/function.json-encode.php
   var lbl = JSON.parse('{!! json_encode($label) !!}'); // prevedeni dat do promennych javascriptu, ktere se daji zobrazit v grafu
   var dt = JSON.parse('{!! json_encode($data) !!}'); 
   var ctx1 = document.getElementById('myChart1').getContext('2d');
   // Vymodelovani grafu
   var myChart = new Chart(ctx1, { 
     type: "pie", // kolacovy graf
     data:{
         labels:["Originální", "Míchané"],
         datasets:[{
             label: "Prodkty",
             data: [{!!$resultsOriginal!!}, {!!$resultsMixed!!}], // data, ktera chceme zobrazit
             backgroundColor: ["#AC3131", "#254AA1", '#669966', '#FFA500', '#FFFF00'],
         }]
     },
   })
   // graf pro zobrazeni zakazniku s nejvice objednavkami
   var ctx2 = document.getElementById('myChart2').getContext('2d');
   var myChart = new Chart(ctx2, { 
     
     type: "bar", // sloupcovy graf
     data:{
         labels: lbl,
         datasets:[{
             label: "Nejvíce objednávek",
             data: dt,
             backgroundColor: ["#AC3131", "#254AA1", "#669966", '#FFA500', '#FFFF00']
         }]
     },
   })
</script>
{{-- Graf pro zobrazeni nejpilnejsich zamestnancu --}}
@php $label1=array(); $data1=array(); @endphp {{-- Pole pro data, ktera budou zobrazena --}}
{{-- Pruchod pres pole, ktere prislo z controlleru --}}
@foreach ($zamestnanci as $zam)
   @php
      array_push($label1, $zam->name);
      array_push($data1, $zam->count);
   @endphp
@endforeach

<script>
   // inspirace z: https://www.php.net/manual/en/function.json-encode.php
     var lbl = JSON.parse('{!! json_encode($label1) !!}'); // prevedeni dat do promennych javascriptu, ktere se daji zobrazit v grafu
     var dt = JSON.parse('{!! json_encode($data1) !!}');
     var ctx3 = document.getElementById('myChart3').getContext('2d');
     var myChart = new Chart(ctx3, { 
       type: "bar", // sloupcovy graf
       data:{
           labels: lbl,
           datasets:[{
               label: "Zaměstnanci",
               data: dt,
               backgroundColor: ["#AC3131", "#254AA1", '#669966', '#FFA500', '#FFFF00'],
           }]
       },
     })
   
</script>
{{-- Graf pro zobrazeni nejprodavanejsich nadob --}}
@php $label=array(); $data=array(); @endphp 
@foreach($baleni as $bal) 
   @php
      array_push($label, $bal->code);
      array_push($data, $bal->count);
   @endphp
@endforeach
<script>
   // inspirace z: https://www.php.net/manual/en/function.json-encode.php
   var lbl = JSON.parse('{!! json_encode($label) !!}');
   var dt = JSON.parse('{!! json_encode($data) !!}');
   var ctx4 = document.getElementById('myChart4').getContext('2d');
   var myChart = new Chart(ctx4, { 
       
       type: "bar", // sloupcovy graf
       data:{
           labels: lbl,
           datasets:[{
               label: "Nádoby",
               data: dt,
               backgroundColor: ["#AC3131", "#254AA1", '#669966', '#FFA500', '#FFFF00'],
           }]
       },
     })
</script>
{{-- Graf pro zobrazeni pomeru kanystru a plechovek --}}
<script>
   // inspirace z: https://www.php.net/manual/en/function.json-encode.php
   var bal1 = JSON.parse('{!! json_encode($baleniPomer1) !!}');
   var bal2 = JSON.parse('{!! json_encode($baleniPomer2) !!}');
   var ctx5 = document.getElementById('myChart5').getContext('2d');
   var myChart = new Chart(ctx5, { 
       
       type: "pie", // kolacovy graf
       data:{
           labels: ["kanystry", "plechovky"],
           datasets:[{
               label: "poměr baleni",
               data: [bal1, bal2],
               backgroundColor: ["#AC3131", "#254AA1"],
           }]
       },
   })
</script>
{{-- Graf Pro zobrazeni nejprodavanejsich produktu --}}
@php $label=array(); $data=array(); @endphp
@foreach($maximaProdukty as $max) 
   @php
      array_push($label, $max->code);
      array_push($data, $max->count);
   @endphp
@endforeach
<script>
   // inspirace z: https://www.php.net/manual/en/function.json-encode.php
   var lbl = JSON.parse('{!! json_encode($label) !!}');
   var dat = JSON.parse('{!! json_encode($data) !!}');
   var ctx6 = document.getElementById('myChart6').getContext('2d');
   var myChart = new Chart(ctx6, { 
       
       type: "bar", // sloupcovy graf
       data:{
           labels: lbl,
           datasets:[{
               label: "Nejprodávanější produkty",
               data: dat,
               backgroundColor: ["#AC3131", "#254AA1", "#669966", '#FFA500', '#FFFF00'],
           }]
       },
   })
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js" charset="utf-8"></script>
@endsection