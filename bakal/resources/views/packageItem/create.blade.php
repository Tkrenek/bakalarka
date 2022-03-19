@extends('layouts.navigation')

@section('content')
  
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
            <div class="card-header">Výběr balení</div>

            <div class="card-body">
        
    <form action="{{ route('packageItem.store', $itemid) }}" method="POST" style="width: 450px; margin: auto;">
        @csrf

                <div class="form-group ">
                    @error('container')

                        {{  $message }}
            
                    @enderror
                    <label for="container">Nádoba</label>
                    <select name="container" id="container" class="form-control custom-select">
                        @foreach ($containers as  $container)
                        <option id="{{ $container->id }}" name="{{ $container->id }}">{{ $container->type }} - {{ $container->bulk }}</option>
                        @endforeach
                    </select>
                        
                </div>

                <div class="form-group ">
                    
                    <label for="count">Počet(ks)</label>
                    
                    <input type="number" value="{{ old('count') }}" id="count" name="count" class="form-control @error('code') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('count')

                            Musíte zadat počet.
            
                        @enderror
                         
                    </div>
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <strong>{{ $message }}  </strong>   
                        </div>  
                        @endif
                </div>
           
                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary">Přidat balení</button>

                </div>
        </form>
       
            </div></div></div></div></div>

@endsection