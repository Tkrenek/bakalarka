@extends('layouts.navigation')
@section('content')
{{-- 
-- Nazev souboru: create.blade.php 
-- Pohled pro registraci admina 
-- autor: Tomas  Krenek(xkrene15)  
--}}
<div class="container">
   <div class="row justify-content-center">
      <div class="col-lg-6">
         {{-- Formulář pro registraci admina --}}
         <div class="card">
            <div class="card-header text-center">Registrace admina</div>
            <div class="card-body">
               <form  action="{{ route('admins.store') }}" method="POST">
                  @csrf
                  <div class="row">
                     <div class="col">
                        <div class="form-group">
                           <label for="name">Jméno</label>
                           <input class="form-control @error('name') is-invalid @enderror"  type="text" value="{{ old('name') }}" id="name" name="name">
                           <div class="invalid-feedback">
                              @error('name')
                              Musíte zadat jméno. 
                              @enderror
                           </div>
                        </div>
                     </div>
                     <div class="col">
                        <div class="form-group">
                           <label for="surname">Příjmení</label>
                           <input type="text" class="form-control  @error('surname') is-invalid @enderror"  value="{{ old('surname') }}" id="surname" name="surname" >
                           <div class="invalid-feedback">
                              @error('surname')
                              Musíte zadat příjmení. 
                              @enderror
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="email">Email</label>
                     <input type="text" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email">
                     <div class="invalid-feedback">
                        @error('email')
                        Musíte zadat e-mail. 
                        @enderror
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="phone">Telefonní číslo</label>
                     <input class="form-control @error('email') is-invalid @enderror" type="text" id="phone"  name="phone">
                     <div class="invalid-feedback">
                        @error('phone')
                        Musíte zadat telefonní číslo.  
                        @enderror
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="birth_date">Datum narození</label>
                     <input type="date" id="birth_date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" value="{{ old('birth_date') }}">
                     <div class="invalid-feedback">
                        @error('birth_date')
                        Musíte zadat datum narození. 
                        @enderror
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="password" class=>Heslo</label>
                     <input class="form-control @error('password') is-invalid @enderror"  type="password" id="password" name="password">
                     <div class="invalid-feedback">
                        @error('password')
                        @if($message == "The password confirmation does not match.") 
                        Hesla se neshodují.
                        @else
                        Musíte zadat heslo.
                        @endif
                        @enderror
                     </div>
                     <div class="form-group">
                        <label for="password_confirmation">Ověření hesla</label>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password_confirmation" id="password_confirmation" >
                        <div class="invalid-feedback">
                           @error('password')
                              @if($message == "The password confirmation does not match.") 
                                 Hesla se neshodují.
                              @else
                                 Musíte zadat heslo.
                              @endif
                           @enderror
                        </div>
                     </div>
                     <div class="d-flex justify-content-center p-3 m-2">
                        <button type="submit" class="btn btn-primary ">Registrovat admina</button>
                     </div>
               </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection