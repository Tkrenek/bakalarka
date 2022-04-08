@extends('layouts.navigation')

@section('content')

<h1 class="display-2 text-center mb-5">Statistiky</h1>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
        <script src="{{ asset('chart.js/chart.js') }}"></script>

        <h3 class="display-6 text-center">Nejprodávanější</h3>
        <div class="row mt-4 mb-4">
            <div class="chart-container col-4">
                <canvas id="myChart"></canvas>
            </div>
            <div class="chart-container col-4">
                <canvas id="myChart2"></canvas>
            </div>
            <div class="chart-container col-4">
                <canvas id="myChart3"></canvas>
            </div>
        </div>
        <h3 class="display-6 text-center mt-4 mb-4">Odvedená práce</h3>
        <div class="row">
            <div class="chart-container col-4">
                <canvas id="myChart4"></canvas>
            </div>
            <div class="chart-container col-4">
                <canvas id="myChart5"></canvas>
            </div>
            <div class="chart-container col-4">
                <canvas id="myChart6"></canvas>
            </div>
        </div>
        


        @php $label=array(); $data=array(); @endphp

        @foreach($zakaznici as $zak) 
            @php
                array_push($label, $zak->name);
                array_push($data, $zak->count);
             @endphp
        @endforeach

        @php
            $label = json_encode($label);
            $data = json_encode($data);
        @endphp
<script>
  var ctx = document.getElementById('myChart').getContext('2d');
  var myChart = new Chart(ctx, { 
    
    type: "pie",
    data:{
        labels:["Originální", "Míchané"],
        datasets:[{
            label: "Prodkty",
            data: [{!!$resultsOriginal!!}, {!!$resultsMixed!!}],
            backgroundColor: ["#AC3131", "#254AA1"]
        }]
    },
  })


  var ctx = document.getElementById('myChart2').getContext('2d');
  var myChart = new Chart(ctx, { 
    
    type: "pie",
    data:{
        labels: [<?php echo $label ?>],
        datasets:[{
            label: "Produkty",
            data = [<?php echo $data ?>];
            backgroundColor: ["#AC3131", "#254AA1"]
        }]
    },
  })
  
  var ctx = document.getElementById('myChart3').getContext('2d');
  var myChart = new Chart(ctx, { 
    
    type: "pie",
    data:{
        labels:["ss", "sss"],
        datasets:[{
            label: "Prodkty",
            data: [{!!$resultsOriginal!!}, {!!$resultsMixed!!}],
            backgroundColor: ["#AC3131", "#254AA1"]
        }]
    },
  })

  var ctx = document.getElementById('myChart4').getContext('2d');
  var myChart = new Chart(ctx, { 
    
    type: "pie",
    data:{
        labels:["ss", "sss"],
        datasets:[{
            label: "Prodkty",
            data: [{!!$resultsOriginal!!}, {!!$resultsMixed!!}],
            backgroundColor: ["#AC3131", "#254AA1"]
        }]
    },
  })

  var ctx = document.getElementById('myChart5').getContext('2d');
  var myChart = new Chart(ctx, { 
    
    type: "pie",
    data:{
        labels:["ss", "sss"],
        datasets:[{
            label: "Prodkty",
            data: [{!!$resultsOriginal!!}, {!!$resultsMixed!!}],
            backgroundColor: ["#AC3131", "#254AA1"]
        }]
    },
  })

  var ctx = document.getElementById('myChart6').getContext('2d');
  var myChart = new Chart(ctx, { 
    
    type: "pie",
    data:{
        labels:["ss", "sss"],
        datasets:[{
            label: "Prodkty",
            data: [{!!$resultsOriginal!!}, {!!$resultsMixed!!}],
            backgroundColor: ["#AC3131", "#254AA1"]
        }]
    },
  })
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js" charset="utf-8"></script>
@endsection