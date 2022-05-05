@extends('layouts.navigation')
@section('content')
<div class="container">
   <div class="row justify-content-center" >
      <div class="col-lg-6">
         <div class="card">
            <div class="card-header text-center">Upravit zákazníka</div>
            <div class="card-body">
               <form action="{{ route('customers.update', $customer->id) }}" method="POST" >
                  @csrf
                  @method('PUT')
                  <div class="form-group ">
                     <label for="name" class="form-label">Název společnosti</label>
                     <input type="text" value="{{ $customer->name }}" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
                     <div class="invalid-feedback">
                        @error('name')
                        Musíte zadat název společnosti.
                        @enderror
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="town" class="form-label">Město</label>
                     <input type="text" value="{{ $customer->town }}" id="town" name="town" class="form-control @error('town') is-invalid @enderror">
                     <div class="invalid-feedback">
                        @error('town')
                        Musíte zadat město, ve kterém společnost sídlí.
                        @enderror
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="address" class="form-label">Adresa</label>
                     <input type="text" id="address" value="{{ $customer->address }}" name="address" class="form-control @error('address') is-invalid @enderror">
                     <div class="invalid-feedback">
                        @error('address')
                        Musíte zadat adresu, na které společnost sídlí.
                        @enderror
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="login" class="form-label">Login</label>
                     <input type="text" id="login" value="{{ $customer->login }}" name="login" class="form-control @error('login') is-invalid @enderror">
                     <div class="invalid-feedback">
                        @error('login')
                        Musíte zadat login.
                        @enderror
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="url" class="form-label">URL</label>
                     <input type="text" value="{{ $customer->url }}" id="url" name="url" class="form-control @error('url') is-invalid @enderror">
                     <div class="invalid-feedback">
                        @error('url')
                        Musíte zadat url adresu.
                        @enderror
                     </div>
                  </div>
                  <div class="d-flex justify-content-center p-3">
                     <button type="submit" class="btn btn-primary">Upravit zákazníka</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection