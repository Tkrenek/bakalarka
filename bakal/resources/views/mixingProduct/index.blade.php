@extends('layouts.navigation')

@section('content')
  

        
  <h1>Recepty produktů</h1>
   <table class="table">
      <thead>
        <tr>
       
          <th scope="col">Kód produktu</th>
          <th scope="col">Recept</th>
          
   
        </tr>
      </thead>
      <tbody>
           
                @foreach ($mixeds as $mixed)
                @if ($mixed->id == 1)
                  
                @else
                  <tr>
                    <td>    

                    {{ $mixed->code }}
                  

                    </td>      
                    
                    <td>
                        @foreach ($mixed->mixingProduct as $mix)
                            ({{ $mix->productOriginal->code }})
                        @endforeach
                    </td>
                </tr>    
                @endif
                
                @endforeach

        
      </tbody>
    </table>
  

@endsection