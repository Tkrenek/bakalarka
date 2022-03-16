@extends('layouts.navigation')

@section('content')
  

        
    <h1>Práce na zakázce</h1>

   <table class="table">
      <thead>
        <tr>
       
          <th scope="col">ID objednávky</th>
          <th scope="col">Zaměstnanec</th>
          <th scope="col">Typ práce</th>

        </tr>
      </thead>
      <tbody>
          
            
                @foreach ($orderworks as $orderwork)
                <tr>
                    <td>    

                    {{ $orderwork->order->id }}
                  

                    </td>      
                    
                    <td>
                      {{ $orderwork->employee->name }} {{ $orderwork->employee->surname }}
                    </td>

                    <td>
                      {{ $orderwork->work_type }} </td>
                </tr>    
                @endforeach
            

          

   

        
      </tbody>
    </table>


@endsection