@extends('layouts.navigation')

@section('content')
  
<div class="container" style="width: 1000px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">Přidat položku</div>

            <div class="card-body">
        
            <form  action="{{ route('items.store', $order->id) }}" method="POST">
                @csrf
               
               
                <div class="form-group row">
                    
                    <label for="amount">Množství(v litrech)</label>
                   
                    <input type="text" value="{{ old('amount') }}" id="amount" name="amount" class="form-control @error('amount') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('amount')

                        Musíte zadat množství.
            
                    @enderror

                    </div>
                </div>
                
                <div class="form-group row">
                   
                    <label for="product" class="sr-only">Kód produktu</label>
                    <select name="product" id="product" class="form-control custom-select @error('product') is-invalid @enderror">
                        @foreach ($products as  $product)
                            <option id="{{ $product->code }}" name="{{ $product->code }}">{{ $product->code }}</option>
                        @endforeach
                        @foreach ($productsMixed as  $product)
                            <option id="{{ $product->code }}" name="{{ $product->code }}">{{ $product->code }}</option>
                        @endforeach


                        
                    </select>
                        <div class="invalid-feedback">
                        @error('product')

                            Musíte zadat kód produktu.
            
                        @enderror

                        </div>  
                        
                    
                </div>

                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary">Přidat položku</button>

                </div>
            </form>
       
            </div></div></div></div></div>

@endsection