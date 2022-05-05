@extends('layouts.navigation')
@section('content')
<div class="container">
   <div class="row justify-content-center" >
      <div class="col-lg-6">
         {{-- Formular pro pridani oddeleni --}}
         <div class="card">
            <div class="card-header text-center">Přidat oddělení</div>
            <div class="card-body">
               <form action="{{ route('departments.store') }}" method="POST" >
                  @csrf
                  <div class="form-group">
                     <label for="name">Název oddělení</label>
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
            </div>
         </div>
      </div>
   </div>
</div>
@endsection