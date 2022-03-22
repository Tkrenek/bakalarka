@extends('layouts.navigation')

@section('content')
  
<div class="d-flex justify-content-center">
        
   <table class="table table-bordered table-hover">
      <thead>
        <tr>
       
          <th scope="col">Jméno
           
          </th>
          <th scope="col">Příjmení</th>
          <th scope="col">Email</th>
          <th scope="col">Telefon</th>
          <th scope="col">Datum narození</th>
          <th scope="col">Oddělení</th>
          <th scope="col">Upravit</th>
          <th scope="col">Smazat</th>
        </tr>
      </thead>
      <tbody>
         @foreach ($employees as $employee)
          
       
        <tr>
          
          <td>{{ $employee->name }}</td>
          <td>{{ $employee->surname }}</td>
          <td>{{ $employee->email }}</td>
          <td>{{ $employee->phone }}</td>
          <td>{{ \Carbon\Carbon::parse($employee->birth_date)->format('d.m.Y') }}</td>
          <td>{{ $employee->department->name }}</td>
          <td><a href="{{ route('employees.edit', $employee->id) }}" type="submit" class="btn btn-secondary">Upravit profil</a></td>
          <td>
             <form action="{{ route('employees.destroy', $employee->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Smazat</button>
            </form>
      </tr>
        @endforeach
        
      </tbody>
    </table>
  
</div>

@endsection