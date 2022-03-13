@extends('layouts.navigation')

@section('content')
  
<div class="container" style="width: 1000px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">Přidat míchaný produkt</div>

            <div class="card-body">
        
    <form  action="{{ route('productMixed.store') }}" method="POST">
        @csrf


                <div class="form-group row">
                                    
                    <label for="code">Kód</label>
                    
                    <input type="text" value="{{ old('code') }}" id="code" name="code" class="form-control @error('code') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('code')

                            Musíte zadat kód produktu.
            
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    
                    <label for="name">Název</label>
                   
                    <input type="text" value="{{ old('name') }}" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
                </div>

                <div class="form-group row">
                    
                    <label for="branch">Typ produktu</label>
                    <select name="branch" id="branch" class="form-control custom-select">
                        
                        <option class="form-control @error('branch') is-invalid @enderror" id="barva" name="barva">Barva</option>
                        <option class="form-control @error('branch') is-invalid @enderror" id="lak" name="lak">Lak</option>
                        <option class="form-control @error('branch') is-invalid @enderror" id="mořidlo" name="mořidlo">Mořidlo</option>
                        <option class="form-control @error('branch') is-invalid @enderror" id="tmel" name="tmel">Tmel</option>
                    </select>
                    <div class="invalid-feedback">
                        @error('branch')

                            Musíte vybrat typ produtku
            
                        @enderror
                    </div> 

                </div>

                <div class="form-group row">
                    
                    <label for="prize">Cena(v Kč)</label>
                    
                    <input type="number" value="{{ old('prize') }}" id="prize" name="prize" class="form-control @error('prize') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('prize')

                        

                            Musíte zadat cenu.
            
                        @enderror
            
                        
                    </div> 
                </div>

                
           
                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary">Přidat produkt</button>

                </div>
        </form>
       
            </div></div></div></div></div>

@endsection