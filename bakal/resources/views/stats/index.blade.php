@extends('layouts.navigation')

@section('content')

<h1 class="display-2 text-center mb-5">Statistiky</h1>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
        <script src="{{ asset('chart.js/chart.js') }}"></script>


        <div class="row mt-4 mb-5">
            

         
            
            <div class="chart-container col-4">
                <div class="text-center mb-4">
                    Podíl míchaných a originálních produktů
                </div>
                <canvas id="myChart1"></canvas>
            </div>
            <div class="chart-container col-4">
                <div class="text-center mb-4">
                    Největší zákazníci
                </div>
                <canvas id="myChart2"></canvas>
            </div>
            <div class="chart-container col-4">
                <div class="text-center mb-4">
                    Nejpilnější zaměstnanci
                </div>
                <canvas id="myChart3"></canvas>
            </div>
        </div>
  
        <div class="row mb-5 mt-5">
            <div class="chart-container col-4">
                <div class="text-center mb-4">
                    Nejprodávaněší nádoby
                </div>
                <canvas id="myChart4"></canvas>
            </div>
            <div class="chart-container col-4">
                <div class="text-center mb-4">
                    Podíl kanistrů a plechovek
                </div>
                <canvas id="myChart5"></canvas>
            </div>
            <div class="chart-container col-4">
                <div class="text-center mb-4">
                    Nejprodávanější produkty
                </div>
                <canvas id="myChart6"></canvas>
            </div>
        </div>
        


        @php $label=array(); $data=array(); @endphp

        @foreach($nejvic as $nej) 
            @php
                array_push($label, $nej->name);
                
                array_push($data, $nej->count);
             @endphp
        @endforeach

       

<script>

  var lbl = JSON.parse('{!! json_encode($label) !!}');
  var dt = JSON.parse('{!! json_encode($data) !!}');
  var ctx1 = document.getElementById('myChart1').getContext('2d');
  var myChart = new Chart(ctx1, { 
    
    type: "pie",
    data:{
        labels:["Originální", "Míchané"],
        datasets:[{
            label: "Prodkty",
            data: [{!!$resultsOriginal!!}, {!!$resultsMixed!!}],
            backgroundColor: ["#AC3131", "#254AA1", '#AC3131'],
        }]
    },
  })

  var ctx2 = document.getElementById('myChart2').getContext('2d');
  var myChart = new Chart(ctx2, { 
    
    type: "bar",
    data:{
        labels: lbl,
        datasets:[{
            label: "Nejvíce objednávek",
            data: dt,
            backgroundColor: ["#AC3131", "#254AA1", "#669966"]
        }]
    },
  })
</script>
@php $label1=array(); $data1=array(); @endphp
  @foreach ($zamestnanci as $zam)
            @php
                array_push($label1, $zam->name);
                
                array_push($data1, $zam->count);
            @endphp
        @endforeach

        
<script>

var lbl = JSON.parse('{!! json_encode($label1) !!}');
  var dt = JSON.parse('{!! json_encode($data1) !!}');
  var ctx3 = document.getElementById('myChart3').getContext('2d');
  var myChart = new Chart(ctx3, { 
    
    type: "pie",
    data:{
        labels: lbl,
        datasets:[{
            label: "Zaměstnanci",
            data: dt,
            backgroundColor: ["#AC3131", "#254AA1", '#AC3131'],
        }]
    },
  })

</script>

@php $label=array(); $data=array(); @endphp

        @foreach($baleni as $bal) 
            @php
                array_push($label, $bal->code);
                
                array_push($data, $bal->count);
             @endphp
        @endforeach
<script>

var lbl = JSON.parse('{!! json_encode($label) !!}');
  var dt = JSON.parse('{!! json_encode($data) !!}');
  var ctx4 = document.getElementById('myChart4').getContext('2d');
  var myChart = new Chart(ctx4, { 
    
    type: "pie",
    data:{
        labels: lbl,
        datasets:[{
            label: "Zaměstnanci",
            data: dt,
            backgroundColor: ["#AC3131", "#254AA1", '#AC3131'],
        }]
    },
  })
</script>


        <script>
            var bal1 = JSON.parse('{!! json_encode($baleniPomer1) !!}');
            var bal2 = JSON.parse('{!! json_encode($baleniPomer2) !!}');
            var ctx5 = document.getElementById('myChart5').getContext('2d');
            var myChart = new Chart(ctx5, { 
                
                type: "pie",
                data:{
                    labels: ["kanistry", "plechovky"],
                    datasets:[{
                        label: "poměr baleni",
                        data: [bal1, bal2],
                        backgroundColor: ["#AC3131", "#254AA1"],
                    }]
                },
            })
        </script>


@php $label=array(); $data=array(); @endphp

@foreach($maximaProdukty as $max) 
    @php
        array_push($label, $max->code);
        
        array_push($data, $max->count);
     @endphp
@endforeach




<script>

            var lbl = JSON.parse('{!! json_encode($label) !!}');
            var dat = JSON.parse('{!! json_encode($data) !!}');
            var ctx6 = document.getElementById('myChart6').getContext('2d');
            var myChart = new Chart(ctx6, { 
                
                type: "bar",
                data:{
                    labels: lbl,
                    datasets:[{
                        label: "Nejprodávanější produkty",
                        data: dat,
                        backgroundColor: ["#AC3131", "#254AA1", "#669966"],
                    }]
                },
            })
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js" charset="utf-8"></script>
@endsection