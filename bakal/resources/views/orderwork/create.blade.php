@extends('layouts.navigation')

@section('content')
  
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
            <div class="card-header">Oznčit práci na objedávce</div>

            <div class="card-body"> 
    <form action="{{ route('orderWork.store') }}" method="POST" style="width: 450px; margin: auto;">
        @csrf


                <div class="form-group ">
                                    
                <label for="order">Objednávka</label>
                   
                <select name="order" id="order" class="form-control custom-select">
                    @foreach ($orders as  $order)
                        <option id="{{ $order->id }}" name="{{ $order->id }}">{{ $order->id }}</option>
                    @endforeach
                </select>    
                </div>

                <div class="form-group ">
                    
                    <label for="type">Typ práce na objednávce</label>
                    
                    <select name="type" id="type" class="form-control custom-select">
                        
                        <option id="míchání" name="míchání">Míchání</option>
                        <option id="balení" name="balení">Balení</option>
                        <option id="expedice" name="expedice">Expedice</option>
                    </select>
                </div>

                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary">Označit práci</button>

                </div>
        </form>
       

            </div></div></div></div></div>

@endsection