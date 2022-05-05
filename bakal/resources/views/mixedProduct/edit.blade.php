@extends('layouts.navigation')
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-lg-6">
         {{-- Formular pro zmenu vlastnosti michaneho produktu --}}
         <div class="card">
            <div class="card-header text-center">Upravit míchaný produkt</div>
            <div class="card-body">
               <form action="{{ route('productMixed.update', $productMixed->id) }}" method="POST" style="width: 450px; margin: auto;">
                  @method('PUT')
                  @csrf
                  <div class="form-group ">
                     <label for="code">Kód</label>
                     <input type="text" value="{{ $productMixed->code }}" id="code" name="code" class="form-control @error('code') is-invalid @enderror">
                     <div class="invalid-feedback">
                        @error('code')
                        Musíte zadat kód produktu.
                        @enderror
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="name">Název</label>
                     <input type="text" value="{{ $productMixed->name }}" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
                  </div>
                  <div class="form-group ">
                     <label for="branch">Typ produktu</label>
                     <select name="branch" id="branch" class="form-control custom-select">
                        <option class="form-control @error('department') is-invalid @enderror" id="barva" name="barva">Barva</option>
                        <option class="form-control @error('department') is-invalid @enderror" id="lak" name="lak">Lak</option>
                        <option class="form-control @error('department') is-invalid @enderror" id="mořidlo" name="mořidlo">Mořidlo</option>
                        <option class="form-control @error('department') is-invalid @enderror" id="tmel" name="tmel">Tmel</option>
                     </select>
                     <div class="invalid-feedback">
                        @error('branch')
                        Musíte vybrat typ produtku
                        @enderror
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="prize">Cena(v Kč)</label>
                     <input type="number" value="{{ $productMixed->prize }}" id="prize" name="prize" class="form-control @error('prize') is-invalid @enderror">
                     <div class="invalid-feedback">
                        @error('prize')
                        Musíte zadat cenu.
                        @enderror
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="on_store">Na skladě</label>
                     <input type="number" value="{{ $productMixed->on_store }}" id="on_store" name="on_store" class="form-control @error('on_store') is-invalid @enderror">
                     <div class="invalid-feedback">
                        @error('on_store')
                        Musíte zadat množství.
                        @enderror
                     </div>
                  </div>
                  <div class="d-flex justify-content-center p-3">
                     <button type="submit" class="btn btn-primary">Upravit produkt</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection