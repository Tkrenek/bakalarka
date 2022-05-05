@extends('layouts.navigation')
@section('content')
<div class="text-center text-danger" style="font-size: larger;">
   @error('count')
   Musíte zadat množství!
   @enderror
</div>
<a href="{{ route('packageItem.show', $item->id) }}" class="btn btn-primary mb-3">Vrátit se zpět</a>
<table class="table mb-5">
   <thead>
      <tr>
         <th scope="col">Typ nádoby</th>
         <th scope="col">Objem(v litrech)</th>
         <th scope="col">Na skladě</th>
         <th scope="col">Cena</th>
         @auth('admin')
         <th scope="col">Vybrat</th>
         @endauth
         @auth('customer')
         <th scope="col">Vybrat</th>
         @endauth
      </tr>
   </thead>
   <tbody>
      @foreach ($containers as $container)
      <tr>
         <td>{{ $container->type }}</td>
         <td>{{ $container->bulk }}</td>
         <td>{{ $container->on_store }}</td>
         <td>{{ $container->prize }}</td>
         <td style="width: 200px">
            <form action="{{ route('packageItem.store', ['itemid' => $item->id, 'containerid' => $container->id]) }}" method="post">
               @csrf
               <div class="form-group ">
                  <input placeholder="množství" type="text"  id="count" name="count" class="mb-3 form-control " style="width: 170px">
                  <button type="submit" class="btn btn-primary mr-3">Přidat balení</button>
               </div>
            </form>
         </td>
      </tr>
      @endforeach
   </tbody>
</table>
@endsection