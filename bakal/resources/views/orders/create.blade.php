@extends('layouts.navigation')

@section('content')
  
<div class="container" style="width: 1000px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">Přidat nádobu</div>

            <div class="card-body">
        
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf


                <div class="form-group row">
                    
                    <label for="name" class="col-md-4 col-form-label">Name</label>
                    @error('name')

                    {{  $message }}
            
                @enderror
                    <input type="text" value="{{ old('name') }}" id="name" name="name">
                </div>

                <div class="form-group row">
                    
                    <label for="branch" class="col-md-4 col-form-label">Branch</label>
                    @error('branch')

                    {{  $message }}
            
                @enderror
                    <input type="text" value="{{ old('branch') }}" id="branch" name="branch">
                </div>

                <div class="form-group row">
                    
                    <label for="prize" class="col-md-4 col-form-label">Prize</label>
                    @error('prize')

                    {{  $message }}
            
                @enderror
                    <input type="text" value="{{ old('prize') }}" id="prize" name="prize">
                </div>

                
           
                <button type="submit" class="btn btn-primary">Add product</button>
        </form>
       

</div>
@endsection