@extends('layouts.navigation')
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-lg-6">
         {{-- Formular pro vytvoreni kontaktni osoby --}}
         <div class="card">
            <div class="card-header text-center">Přidat kontaktní osobu</div>
            <div class="card-body">
               @auth('admin')
               <form  action="{{ route('contact.admin.store', $customer->id) }}" method="POST">
                  @endauth
                  @auth('customer')
               <form  action="{{ route('contact.store') }}" method="POST">
                  @endauth
                  @csrf
                  <div class="row">
                     <div class="col">
                        <div class="form-group ">
                           <label for="name"  >Jméno</label>
                           <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
                           <div class="invalid-feedback">
                              @error('name')
                              Musíte zadat jméno.
                              @enderror
                           </div>
                        </div>
                     </div>
                     <div class="col">
                        <div class="form-group ">
                           <label for="surname"  >Příjmení</label>
                           <input type="text" id="surname" name="surname" value="{{ old('surname') }}" class="form-control @error('surname') is-invalid @enderror">
                           <div class="invalid-feedback">
                              @error('surname')
                              Musíte zadat příjmení.
                              @enderror
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="email"  >E-mail</label>
                     <input type="text" id="email" name="email" value="{{ old('email') }}" class="form-control  @error('email') is-invalid @enderror" placeholder="jmeno@domena.cz">
                     <div class="invalid-feedback">
                        @error('email')
                        Musíte zadat e-mail ve správném formátu.
                        @enderror
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="phone"  >Telefonní číslo</label>
                     <input type="number" id="phone" name="phone" value="{{ old('phone') }}" class="form-control  @error('phone') is-invalid @enderror">
                     <div class="invalid-feedback">
                        @error('phone')
                        Musíte zadat telefonní číslo.
                        @enderror
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="birth_date"  >Datum narození</label>
                     <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" class="form-control @error('birth_date') is-invalid @enderror">
                     <div class="invalid-feedback">
                        @error('birth_date')
                        Musíte zadat datum narození.
                        @enderror
                     </div>
                  </div>
                  <div class="d-flex justify-content-center p-3">
                     <button type="submit" class="btn btn-primary">Přidat kontaktní osobu</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
@endsection