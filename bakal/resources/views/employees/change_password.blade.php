@extends('layouts.navigation')
@section('content')
{{-- 
-- Nazev souboru: change_password.blade.php 
-- Pohled pro zmenu hesla zamestnance
-- autor: Tomas  Krenek(xkrene15)  
--}}
<div class="container">
   <div class="row justify-content-center">
      <div class="col-lg-6">
         {{-- Formular pro zmenu hesla zamestnance --}}
         <div class="card">
            <div class="card-header text-center">Změna hesla</div>
            <div class="card-body">
               <form  action="{{ route('employees.update_password', auth('employee')->user()->id) }}" method="POST">
                  @csrf
                  @if ($message = Session::get('error'))
                     <div class="alert alert-danger alert-block">
                        <strong>{{ $message }}  </strong>   
                     </div>
                  @endif
                  @if ($message = Session::get('success'))
                     <div class="alert alert-success alert-block text-center">
                        <strong >{{ $message }}</strong>   
                     </div>
                  @endif
                  <div class="form-group">
                     <label for="password_old" class=>Staré heslo</label>
                     <input class="form-control @error('password_old') is-invalid @enderror"  type="password" id="password_old" name="password_old">
                     <div class="invalid-feedback">
                        @error('password_old')
                           Musíte zadat heslo.
                        @enderror
                     </div>
                     <div class="form-group">
                        <label for="password" class=>Nové heslo</label>
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
                        <div class="d-flex justify-content-center p-3">
                           <button type="submit" class="btn btn-primary ">Změnit heslo</button>
                        </div>
               </form>
               </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection