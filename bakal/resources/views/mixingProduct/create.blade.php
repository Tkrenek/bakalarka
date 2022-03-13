@extends('layouts.navigation')

@section('content')
  

<div class="container" style="width: 1000px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">Přidat recept</div>

            <div class="card-body">  
    <form action="{{ route('mixingProduct.store') }}" method="POST">
        @csrf


                <div class="form-group row">
                                    
                    <label for="mixed">Míchaný produkt</label>
                    @error('mixed')

                        {{  $message }}
            
                    @enderror
                    <select name="mixed" id="mixed" class="form-control custom-select">
                        @foreach ($mixeds as  $mixed)
                            <option id="{{ $mixed->code }}" name="{{ $mixed->code }}">{{ $mixed->code }}</option>
                        @endforeach
                    </select>    

                    <div class="invalid-feedback">
                        @error('mixed')
                            Musíte vybrat kód produktu.
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    
                    <label for="original">Originální produkt(přísada)</label>
                    
                    <select name="original" id="original" class="form-control custom-select">
                        @foreach ($originals as  $original)
                        <option id="{{ $original->code }}" name="{{ $original->code }}">{{ $original->code }}</option>
                        @endforeach
                    </select>  
                    <div class="invalid-feedback">
                        @error('mixed')
                            Musíte vybrat kód produktu.
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary">Přidat recept</button>

                </div>
        </form>
       
            </div></div></div></div></div>

@endsection