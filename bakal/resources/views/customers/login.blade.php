@extends('layouts.navigation')
@section('content')
{{-- 
-- Nazev souboru: login.blade.php 
-- Pohled pro prihlaseni zakazniku
-- autor: Tomas  Krenek(xkrene15)  
--}}
<div class="justify-content-center d-flex p-5">
   <h1 class="display-1">Informační systém Coloral</h1>
</div>
<div class="justify-content-center d-flex p-1 login-option">Jste zaměstnanec? Klikněte: <a href="{{ route('employees.login') }}"> zde </a>.</div>
<div class="container">
   <div class="row justify-content-center">
      <div class="col-lg-6">
         {{-- Formular pro prihlaseni zakaznika --}}
         <div class="card">
            <div class="card-header text-center">Přihlášení zákazníka</div>
            <div class="card-body">
               <form  action="{{ route('customers.login.post') }}" method="POST">
                  @csrf
                  <div class="row">
                     <div class="col">
                        @if ($message = Session::get('error'))
                           <div class="alert alert-danger alert-block">
                              <strong>{{ $message }}  </strong>   
                           </div>
                        @endif
                        <div class="form-group">
                           <label for="login">Login</label>
                           <input type="text" id="login" class="form-control @error('login') is-invalid @enderror" value="{{ old('login') }}" name="login">
                           <div class="invalid-feedback">
                              @error('login')
                                 Musíte zadat Login. 
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
                           <div class="d-flex justify-content-center p-3">
                              <button type="submit" class="btn btn-primary">Přihlásit se</button>
                           </div>
               </form>
               <span class="login-option">Pokud nemáte účet zaregistrujte se <a href="{{ route('customers.create') }}">tady</a></span>
               </div>
               </div>
               </div>
            </div>
         </div>
         <div class="login-option mb-5"> Přístup pro admina: <a href="{{ route('admins.login') }}">zde</a>.</div>
      </div>
   </div>
</div>
@endsection