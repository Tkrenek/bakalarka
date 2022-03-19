@extends('layouts.navigation')

@section('content')
  
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
            <div class="card-header">Přidat položku</div>

            <div class="card-body">
        
            <form  action="{{ route('items.store', $order->id) }}" method="POST">
                @csrf
               
               
                <div class="form-group">
                    
                    <label for="amount">Množství(v litrech)</label>
                   
                    <input type="text" value="{{ old('amount') }}" id="amount" name="amount" class="form-control @error('amount') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('amount')

                        Musíte zadat množství.
            
                    @enderror

                    </div>
                </div>
                
                <div class="form-group">
                   
                    <label for="product" >Kód produktu</label>
                    <select name="product" id="product" class="form-control custom-select @error('product') is-invalid @enderror">
                        @foreach ($products as  $product)
                            <option id="{{ $product->code }}" name="{{ $product->code }}">{{ $product->code }}</option>
                        @endforeach
                        @foreach ($productsMixed as  $product)
                            <option id="{{ $product->code }}" name="{{ $product->code }}">{{ $product->code }}</option>
                        @endforeach


                        
                    </select>
                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <strong>{{ $message }}  </strong>   
                    </div>  
                    @endif   
                        
                    
                </div>

                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary">Přidat položku</button>

                </div>
            </form>
       
            </div></div></div></div></div>

@endsection