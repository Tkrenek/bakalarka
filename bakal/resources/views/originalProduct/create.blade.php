@extends('layouts.navigation')

@section('content')

        
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
            <div class="card-header">Přidat originální produkt</div>

            <div class="card-body">
    <form action="{{ route('productOriginal.store') }}" method="POST" style="width: 400px; margin: auto;">
        @csrf

                <div class="form-group ">
                            
                    <label for="code">Kód produktu</label>
                    
                    <input type="text" value="{{ old('code') }}" id="code" name="code" class="form-control @error('code') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('code')

                            Musíte zadat kód produktu.
            
                        @enderror
                    </div>
                </div>

                <div class="form-group ">
                    
                    <label for="name">Název produktu</label>
                    
                    <input type="text" value="{{ old('name') }}" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('code')

                            Musíte zadat název produktu.
            
                        @enderror
                    </div>
                </div>

                <div class="form-group ">
                    
                    <label for="branch">Odvětví produktu</label>
                    
                    <select name="branch" id="branch" class="form-control custom-select">
                        
                        <option class="form-control @error('branch') is-invalid @enderror" id="barva" name="barva">Barva</option>
                        <option class="form-control @error('branch') is-invalid @enderror" id="lak" name="lak">Lak</option>
                        <option class="form-control @error('branch') is-invalid @enderror" id="mořidlo" name="mořidlo">Mořidlo</option>
                        <option class="form-control @error('branch') is-invalid @enderror" id="tmel" name="tmel">Tmel</option>
                    </select>
                    <div class="invalid-feedback">
                        @error('branch')

                            Musíte vybrat typ produtku.
            
                        @enderror
                    </div> 
                </div>

                <div class="form-group ">
                    
                    <label for="prize">Cena produktu(Kč/l)</label>
                    
                    <input type="number" value="{{ old('prize') }}" id="prize" name="prize" class="form-control @error('prize') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('prize')

                            Musíte vybrat cenu produtku.
            
                        @enderror
                    </div> 
                </div>

                <div class="form-group ">
                    
                    <label for="on_store">Na skladě(l)</label>
                    
                    <input type="number" value="{{ old('on_store') }}" id="on_store" name="on_store" class="form-control @error('on_store') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('on_store')

                            Musíte zadat množství na skladě.
            
                        @enderror
                    </div> 
                </div>

                <div class="form-group ">
                    
                    <label for="producer" class="sr-only">Dodavatel</label>
                    <select name="producer" id="producer" class="form-control custom-select @error('producer') is-invalid @enderror">
                        @foreach ($producers as  $producer)
                            <option id="{{ $producer->name }}" name="{{ $producer->name }}">{{ $producer->name }}</option>
                        @endforeach
                    </select>

                    <div class="invalid-feedback">
                        @error('producer')

                            Musíte vybrat dodavatele.
            
                        @enderror
                    </div> 
                        
                </div>
           
                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary">Přidat produkt</button>

                </div>
        </form>
            </div></div></div></div></div>

@endsection