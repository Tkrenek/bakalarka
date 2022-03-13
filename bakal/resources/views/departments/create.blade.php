@extends('layouts.navigation')

@section('content')
  
<div class="container" style="width: 1000px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">Přidat nádobu</div>

            <div class="card-body">
        
            <form action="{{ route('departments.store') }}" method="POST" style="width: 450px; margin: auto;">
                @csrf
               
                
                <div class="form-group row">
                    
                    <label for="name" class="col-md-4 col-form-label">Název oddělení</label>
                    
                    <input type="text" value="{{ old('name') }}" id="name" name="name" class="form-control custom-select @error('name') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('name')
                            Musíte zadat název oddělení.
                        @enderror
                    </div>
                </div>
                
                <div class="d-flex justify-content-center p-3">
                    <button type="submit" class="btn btn-primary">Přidat oddělení</button>

                </div>
            </form>
       
            </div></div></div></div></div>

@endsection