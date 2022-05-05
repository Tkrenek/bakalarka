@extends('layouts.navigation')
@section('content')
<div class="text-center text-danger" style="font-size: larger;">
   @error('ammount')
      Musíte zadat množství.
   @enderror
</div>
<h1 class="display-3 text-center mb-4">Přehled nádob</h1>
@auth('admin')
   <a class="btn btn-primary mb-3" href="{{ route('containers.create')}}" class="p-3">Přidat nádobu</a>
@endauth
{{-- Tabulka se vsemi nadobami v systemu --}}
<table class="table">
   <thead>
      <tr>
         <th scope="col">Typ nádoby</th>
         <th scope="col">Objem(v litrech)</th>
         <th scope="col">Na skladě</th>
         <th scope="col">Cena</th>
         {{-- Zobrazeni pouze pro admina --}}
         @auth('admin')
            <th scope="col">Upravit</th>
            <th scope="col">Naskladnit</th>
            <th scope="col">Odstranit</th>
         @endauth
         {{-- Zobrazeni pouze pro zamestnance --}}
         @auth('employee')
            <th scope="col">Naskladnit</th>
         @endauth
      </tr>
   </thead>
   <tbody>
      {{-- Prochazime vsechny nadoby --}}
      @foreach ($containers as $container)
      <tr>
         <td>{{ $container->type }}</td>
         <td>{{ $container->bulk }} (litr)</td>
         <td>{{ $container->on_store }} ks</td>
         <td>{{ $container->prize }} Kč</td>
         @auth('employee')
         <td  style="width: 135px">
            <form action="{{ route('containers.addStore', $container->id) }}" method="post">
               @csrf
               @method('PUT')
               <div class="form-group">
                  <label for="ammount" class="sr-only">Množství</label>
                  <input type="number" style="width: 125px"  id="ammount" name="ammount" class="form-control" placeholder="Počet">
               </div>
               <button type="submit" class="btn btn-primary">Naskladnit</button>
            </form>
         </td>
         @endauth
         {{-- Zobrazeni pouze pro admina --}}
         @auth('admin')
            <td><a href="{{ route('containers.edit', $container->id) }}" type="submit" class="btn btn-primary">Upravit</a></td>
            <td style="width: 200px">
               <form action="{{ route('containers.addStore', $container->id) }}" method="post">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                     <label for="ammount" class="sr-only">Množství</label>
                     <input type="number"  id="ammount" name="ammount" class="form-control ">
                  </div>
                  <button type="submit" class="btn btn-primary">Naskladnit</button>
               </form>
            </td>
            <td>
               <form action="{{ route('containers.destroy', $container->id) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Smazat</button>
               </form>
            </td>
         @endauth
      </tr>
      @endforeach
   </tbody>
</table>
@endsection