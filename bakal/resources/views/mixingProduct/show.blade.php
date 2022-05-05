@extends('layouts.navigation')
@section('content')
<a href="{{ route('product.index')}}" class="btn btn-primary float-right">Zpět na seznam produktů</a>
<h1 class="display-3 text-center mb-5">Kód produktu : {{ $mixedProduct->code }}</h1>
<div class="row">
   <div class="col-8">
      <h3>Přidat novou přísadu: </h3>
      <form action="{{ route('mixingProduct.store', $mixedProduct->id) }}" method="post">
         @csrf
         <div class="form-group">
            <div class="col-lg-2">
               <label for="code">Kód produktu</label>
               <select name="code" id="code" class="form-control custom-select" style="width: 200px">
                  @foreach ($originals as  $original)
                  @if($original->id != 1)
                  <option id="{{ $original->code }}" name="{{ $original->code }}">{{ $original->code }}</option class="form-control @error('department') is-invalid @enderror">
                     @endif    
                     @endforeach
               </select>
               @error('code')
               <strong>Musíte zadat kód produktu.</strong>
               @enderror
               @if ($message = Session::get('error'))
               <div>
                  <span class="text-danger">{{ $message }}</span>  
               </div>
               @endif
            </div>
         </div>
         <button type="submit" class="btn btn-primary ml-3">Přidat</button>
      </form>
   </div>
   <div class="col-4">
      <h3>Přísady:</h3>
      <table class="table" style="width: 400px">
         <thead>
            <th class="col">Kód přísady</th>
            <th class="col">Smazat</th>
         </thead>
         <tbody>
            @foreach ($mixedProduct->mixingProduct as $prod)
            <tr>
               <td>
                  {{ $prod->productOriginal->code}}
               </td>
               <td>
                  <form action="{{ route('mixingProduct.destroy', $prod->id)  }}" method="post">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="btn btn-danger">Odstranit</button>
                  </form>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>
@endsection