@extends('layouts.navigation')

@section('content')
  
@php
  use Carbon\Carbon as carbon;
@endphp

<h1 class="display-2 text-center mb-5">Seznam oddělení</h1>

    <a class="btn btn-secondary mb-3" href="{{ route('departments.create') }}">Přidat Oddělení</a>
   <table class="table table-bordered text-center align-middle">
      <thead>
        <tr>
       
          <th scope="col">Název oddělení</th>
          <th scope="col">Počet pracovníků</th>
          <th scope="col">Odstranit</th>
       
        </tr>
      </thead>
      <tbody>
        @foreach ($departments as $department)
            <tr>
                <td>
                    {{ $department->name }}
                </td>
                <td>
                    
                    {{ $count2 = \DB::table('employees')->where('department_id', '=', $department->id)->count() }}
                </td>
                <td>
                    <form action="{{ route('departments.destroy', $department->id) }}" method="post">
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