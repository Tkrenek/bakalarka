@extends('layouts.navigation')

@section('content')
  
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
            <div class="card-header">Oznčit práci na objedávce</div>

            <div class="card-body"> 
    <form action="{{ route('orderWork.store', $order->id) }}" method="POST">
        @csrf



                <div class="form-group ">
                    
                    <label for="type">Typ práce na objednávce</label>
                    
                    <select name="type" id="type" class="form-control custom-select">
                        
                        <option id="míchání" name="míchání">Míchání</option>
                        <option id="balení" name="balení">Balení</option>
                        <option id="expedice" name="expedice">Expedice</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date">Datum vykonání činnosti</label>
                    <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}">
                    <div class="invalid-feedback">
                        @error('date')

                            Musíte zadat datum. 
            
                        @enderror
                    </div>  
                </div>

                <div class="form-group">
                    <label for="time">Zadejte počet hodin</label>
                    <input type="number" id="time" name="time" class="form-control @error('time') is-invalid @enderror" value="{{ old('time') }}">
                    <div class="invalid-feedback">
                        @error('time')

                            Musíte zadat čas. 
            
                        @enderror
                    </div>  
                </div>


                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary">Označit práci</button>

                </div>
        </form>
       

            </div></div></div></div></div>

@endsection