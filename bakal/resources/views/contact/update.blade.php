@extends('layouts.navigation')
@section('content')
{{-- 
-- Nazev souboru: update.blade.php 
-- Pohled pro upravu kontaktni osoby 
-- autor: Tomas  Krenek(xkrene15)  
--}}
@php
   use Carbon\Carbon;
@endphp
<div class="container">
   <div class="row justify-content-center" >
      <div class="col-lg-6">
         {{-- Formular pro zmenu udaju kontaktni osoby --}}
         <div class="card">
            <div class="card-header text-center">Upravit kontaktní osobu</div>
            <div class="card-body">
               <form action="{{ route('contact.update', $contact->id) }}" method="POST" >
                  @method('PUT')
                  @csrf
                  <div class="row">
                     <div class="col">
                        <div class="form-group">
                           <label for="name">Jméno</label>
                           <input type="text" value="{{ $contact->name }}" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
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
                           <input type="text" value="{{ $contact->surname }}" id="surname" name="surname" class="form-control @error('surname') is-invalid @enderror">
                           <div class="invalid-feedback">
                              @error('surname')
                              Musíte zadat příjmení.
                              @enderror
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="email">E-mail</label>
                     <input type="text" id="email" placeholder="jmeno@domena.cz" value="{{ $contact->email }}" name="email" class="form-control @error('email') is-invalid @enderror">
                     <div class="invalid-feedback">
                        @error('email')
                        Musíte zadat e-mail ve správném formátu.
                        @enderror
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="phone">Telefonní číslo</label>
                     <input type="text" id="phone" value="{{ $contact->phone }}"  name="phone" class="form-control @error('phone') is-invalid @enderror">
                     <div class="invalid-feedback">
                        @error('phone')
                        Musíte zadat telefonní číslo.
                        @enderror
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="birth_date">Datum narození</label>
                     <input type="date" id="birth_date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" value="{{ $contact->birth_date }}">
                     @php $date = Carbon::parse($contact->birth_date); @endphp
                     <script>
                        document.getElementById('birth_date').valueAsDate = new Date(<?php echo json_encode($date) ?>);
                     </script>
                     <div class="invalid-feedback">
                        @error('birth_date')
                        Musíte zadat datum narození. 
                        @enderror
                     </div>
                  </div>
                  <div class="d-flex justify-content-center p-3">
                     <button type="submit" class="btn btn-primary">Upravit kontaktní osobu</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection