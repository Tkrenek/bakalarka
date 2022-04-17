@extends('layouts.navigation')

@section('content')
  

        
<a href="{{ route('product.index')}}" class="btn btn-secondary float-right">Zpět na seznam produktů</a>
   
   <h1>Kód produktu : {{ $mixedProduct->code }}</h1>
   
    <h3>Přidat novou přísadu: </h3>
    <form action="{{ route('mixingProduct.store', $mixedProduct->id) }}" method="post">

   
        @csrf
        <div class="form-group">
            <div class="col-lg-2">
                <label for="code">Kód produktu</label>
                <select name="code" id="code" class="form-control custom-select">
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
                            <strong>{{ $message }}  </strong>   
                        </div>    
                        
                        
                    @endif
                    
              </div>
          
          </div>
        <button type="submit" class="btn btn-secondary ml-3">Přidat</button>
    </form>
    <h3>Přísady:</h3>
  
    
        <table class="table">
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
   

  


@endsection