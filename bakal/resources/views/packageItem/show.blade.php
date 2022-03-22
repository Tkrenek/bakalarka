@extends('layouts.navigation')

@section('content')
  

        
   
   
   <h1>ID položky: {{ $item->id }}</h1>
   
 
   <a href="{{ route('orders.show', $item->order->id) }}">Zpět na objednávku</a>
  
   <table class="table">
      <th scope="col">Kód nádoby</th>
      <th scope="col">Typ</th>
      <th scope="col">Objem</th>
      <th scope="col">Počet</th>
      <th scope="col">Změnit počet</th>
      <th scope="col">Odstranit</th>
      
         @foreach ($item->packageItem as $pckg)
         <tr>
            <td>
               {{ $pckg->container->code }}
            </td>
            <td>
               {{ $pckg->container->type }}
            </td>
            <td>
               {{ $pckg->container->bulk }} l
            </td>
            <td>
               {{ $pckg->count }} ks
            </td>
            
               <td><form action="{{ route('packageItem.changeCount', $pckg->id) }}" method="post">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    @error('count')
      
                        {{  $message }}
            
                    @enderror
                    <label for="count" class="sr-only">Množství</label>
                    <input type="number"  id="count" name="count" class="form-control">
                    </div>
                  <button type="submit" class="btn btn-secondary">Změnit počet</button>
              </form>
                </td>
            </td>
            <td>
               <form action="{{ route('packageItem.destroy', $pckg->id) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Smazat</button>
              </form>
            </td>
         </tr>
         @endforeach
      
      
   </table>
   <a class="btn btn-outline-secondary" href="{{  route('packageItem.create', $item->id ) }}" role="button">Přidat balení</a>
  


@endsection