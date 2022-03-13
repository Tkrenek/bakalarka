@extends('layouts.navigation')

@section('content')
  
@php
  use Carbon\Carbon as carbon;
@endphp

        
<div class="container" style="width: 1000px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">Upravit objednávku</div>

            <div class="card-body">
    <form action="{{ route('orders.update', $order->id) }}" method="POST" style="width: 450px; margin: auto;">
        @csrf
        @method('PUT')


                <div class="form-group row">
                    
                    <label for="state">Stav objednávky</label>
                   
                    <input type="text" value="{{ $order->state }}" id="state" name="state" class="form-control @error('code') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('state')

                            Musíte zadat stav objednávky.
            
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="term">Datum narození</label>
                    <input type="date" id="term" value="{{ carbon::parse($order->term)->format('d.m. Y')  }}" name="term" class="form-control @error('term') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('term')

                            {{  $message }}
            
                        @enderror
                    </div>  
                </div>
              

                <div class="form-group row">
                    
                    <label for="invoice">Faktura objednávky</label>
                       
                    <input type="text" value="{{ $order->invoice }}" id="invoice" name="invoice" class="form-control @error('invoice') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('invoice')

                            Musíte zadat fakturu.
            
                        @enderror
                    </div>
                </div>

                
           
                <button type="submit" class="btn btn-primary">Upravit objednávku</button>
        </form>
       
            </div></div></div></div></div>
@endsection