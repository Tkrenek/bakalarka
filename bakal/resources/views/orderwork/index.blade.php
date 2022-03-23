@extends('layouts.navigation')

@section('content')
  
@php
  use Carbon\Carbon;
@endphp
        
    <h1>Práce na zakázce</h1>

   <table class="table">
      <thead>
        <tr>
       
          <th scope="col">ID objednávky</th>
          <th scope="col">Zaměstnanec</th>
          <th scope="col">Typ práce</th>
          <th scope="col">Datum</th>
          <th scope="col">Doba práce</th>
          @auth
            <th scope="col">Smazat</th>
          @endauth
          

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
                  
                    <td>    

                      {{ \Carbon\Carbon::parse($orderwork->date)->format('d.m.Y') }}
                    
  
                      </td>     
                      <td>    

                        {{ $orderwork->time }}
                      
    
                        </td>    
                        <td>
                          <form action="{{ route('orderWork.destroy', $orderwork->id) }}" method="post">
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