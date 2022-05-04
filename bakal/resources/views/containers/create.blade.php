@extends('layouts.navigation')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
            <div class="card-header text-center">Přidat nádobu</div>

            <div class="card-body">
        
            <form action="{{ route('containers.store') }}" method="POST">
                @csrf
               
                <div class="form-group ">
                    
                    <label for="type">Kód nádoby</label>
                   
                    
                    <input type="text" value="{{ old('code') }}" id="code" name="code" class="form-control @error('code') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('code')

                        Musíte vybrat kód.
            
                    @enderror
                    </div>
                
                </div>
               

                <div class="form-group ">
                    
                    <label for="type">Typ nádoby</label>
                    
                    <select name="type" id="type" value="{{ old('type') }}" class="form-control custom-select @error('type') is-invalid @enderror" >
                        <option id="kanistr" name="kanystr">Kanystr</option>
                        <option id="plechovka" name="plechovka">Plechovka</option>
                    </select> 
                    <div class="invalid-feedback">
                        @error('type')

                        Musíte vybrat kód.
            
                    @enderror
                
                </div>

                <div class="form-group ">
                    
                    <label for="bulk">Objem(v litrech)</label>
                    
                    <input type="number" value="{{ old('bulk') }}" id="bulk" name="bulk" class="form-control @error('bulk') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('bulk')

                            Musíte vybrat objem.
            
                    @enderror
                </div>

                <div class="form-group ">
                    
                    <label for="on_store">Na skladě</label>
                    
                    <input type="number" value="{{ old('on_store') }}" id="on_store" name="on_store" class="form-control @error('on_store') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('bulk')

                            Musíte vybrat množství na skladě.
            
                        @enderror
                    </div>
                </div>


                <div class="form-group ">
                    
                    <label for="prize">Cena(v Kč)</label>
                    
                    <input type="number" value="{{ old('prize') }}" id="prize" name="prize" class="form-control @error('prize') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('prize')

                            Musíte vybrat cenu.
            
                        @enderror
                    </div>
                </div>
                
                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary">Přidat nádobu</button>

                </div>
            </form>
       
            </div>
        </div>
    </div>
</div>

</div>


@endsection