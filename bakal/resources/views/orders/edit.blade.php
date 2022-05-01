@extends('layouts.navigation')

@section('content')
  
@php
  use Carbon\Carbon as carbon;
@endphp

<div class="container" >
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
            <div class="card-header text-center">Upravit objednávku</div>

            <div class="card-body"> 
    <form action="{{ route('orders.update', $order->id) }}" method="POST" >
        @csrf
        @method('PUT')


                <div class="form-group ">
                    
                    <label for="state">Stav objednávky</label>
                   
                    <select name="state" id="state" class="form-control custom-select">
                       
                        <option id="založeno" name="založeno">Založeno</option class="form-control @error('state') is-invalid @enderror">
                        <option id="namícháno" name="namícháno">Namícháno</option class="form-control @error('state') is-invalid @enderror">
                        <option id="zabaleno" name="zabaleno">Zabaleno</option class="form-control @error('state') is-invalid @enderror">
                        <option id="vyřízeno" name="vyřízeno">Vyřízeno</option class="form-control @error('state') is-invalid @enderror">
                    </select> 
                    
                    <div class="invalid-feedback">
                        @error('state')

                            Musíte zadat stav objednávky.
            
                        @enderror
                    </div>
                </div>

                <div class="form-group ">
            
                    <label for="term">Termín objednávky</label>
                    <input type="date" id="term" value="{{  $order->term }}" name="term" class="form-control @error('term') is-invalid @enderror">
                    @php $date = Carbon::parse($order->term); @endphp
                    <script>

                        document.getElementById('term').valueAsDate = new Date(<?php echo json_encode($date) ?>);
                    </script>
                    <div class="invalid-feedback">
                        @error('term')

                            {{  $message }}
            
                        @enderror
                    </div>  
                </div>
              

            

                
           
                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary">Upravit objednávku</button>

                </div>
        </form>
       
            </div>
        </div>
    </div>
</div>
</div>
@endsection