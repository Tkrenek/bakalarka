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
                   
                    <input type="text" value="{{ $order->state }}" id="state" name="state" class="form-control @error('code') is-invalid @enderror" value="{{ $order->term }}">
                    <div class="invalid-feedback">
                        @error('state')

                            Musíte zadat stav objednávky.
            
                        @enderror
                    </div>
                </div>

                <div class="form-group ">
            
                    <label for="term">Termín objednávky</label>
                    <input type="date" id="term" value="{{ carbon::parse($order->term)->format('d.m.Y') }}" name="term" class="form-control @error('term') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('term')

                            {{  $message }}
            
                        @enderror
                    </div>  
                </div>
              

                <div class="form-group ">
                    
                    <label for="invoice">Faktura objednávky</label>
                       
                    <input type="text" value="{{ $order->invoice }}" id="invoice" name="invoice" class="form-control @error('invoice') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('invoice')

                            Musíte zadat fakturu.
            
                        @enderror
                    </div>
                </div>

                
           
                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary">Upravit objednávku</button>

                </div>
        </form>
       
            </div></div></div></div></div>
@endsection