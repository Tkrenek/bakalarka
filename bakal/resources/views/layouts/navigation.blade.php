<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel</title>
    <link rel="stylesheet" href=" {{ asset('css/app.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a href="/" class="navbar-brand">Colorex</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav">
                @auth('subscriber')
                {{ auth('subscriber')->user()->name }} {{ auth('subscriber')->user()->surname }}
                <form action="{{ route('subscribers.logout') }}" method="POST">
                    @csrf
                    <button>Odhlásit se</button>
                </form>
                @endauth
                @auth('employee')
                <div class="primary">{{ auth('employee')->user()->name }} {{ auth('employee')->user()->surname }}</div>
                
                <form action="{{ route('employees.logout') }}" method="POST">
                    @csrf
                    <button>Odhlásit se</button>
                </form>
                @endauth
                @auth
                {{ auth()->user()->name }} {{ auth()->user()->surname }}
                <form action="{{ route('admins.logout') }}" method="POST">
                    @csrf
                    <button>Odhlásit se</button>
                </form>
                    
                @endauth

                @auth('employee')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orderWork.create')}}" class="p-3">Označit práci na objednávce</a>
        
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('productOriginal.index')}}" class="p-3">Seznam produktů</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('containers.index')}}" class="p-3">Seznam nádob</a>
        
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('mixingProduct.create')}}" class="p-3">Přidat recept</a>
        
                    </li>
        
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('mixingProduct.index')}}" class="p-3">Recepty</a>
        
                    </li>
        
                    
        
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orderWork.index')}}" class="p-3">Práce na objednávce</a>
        
                    </li>
                @endauth

                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orderWork.create')}}" class="p-3">Označit práci na objednávce</a>
    
                </li>
                <li class="nav-item">
                    <a  class="nav-link" href="{{ route('employees.login') }}" class="p-3">Přihlášení zaměstnance</a>
                </li>
                
                <li class="nav-item">
                    <a  class="nav-link" href="{{ route('admins.login') }}" class="p-3">Přihlášení admina</a>
                </li>
                <li class="nav-item">
                    <a  class="nav-link" href="{{ route('subscribers.login') }}" class="p-3">Přihlášení zákazníka</a>
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('subscribers.create')}}" class="p-3">Registrace zákazníka</a>
    
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('employees.create') }}" class="p-3">Registrace Zaměstnance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('employees.index') }}" class="p-3">Upravit Zaměstnance</a>
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('departments.index') }}" class="p-3">Přidat oddělení</a>
                </li>
    
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admins.index') }}" class="p-3">Registrace Admina</a>
                </li>
    
    
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('subscribers.index')}}" class="p-3">Zobrazit Zákazníky</a>
    
                </li>
    
              
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact.index')}}" class="p-3">Přidat kontaktní osobu</a>
    
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('producers.index')}}" class="p-3">Registrace Dodavatele</a>
    
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productOriginal.create')}}" class="p-3">Přidat originální produkt</a>
    
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productMixed.create')}}" class="p-3">Přidat míchaný produkt</a>
    
                </li>
     
                

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productOriginal.index')}}" class="p-3">Seznam produktů</a>
    
                </li>
                
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('containers.create')}}" class="p-3">Přidat nádobu</a>
    
                </li>
    
               
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('containers.index')}}" class="p-3">Seznam nádob</a>
    
                </li>
    
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders.index')}}" class="p-3">Všechny objednávky</a>
    
                </li>

              
                
                    
               
               
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mixingProduct.create')}}" class="p-3">Přidat recept</a>
    
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mixingProduct.index')}}" class="p-3">Recepty</a>
    
                </li>
    
                
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orderWork.index')}}" class="p-3">Práce na objednávce</a>
    
                </li>
                @endauth

                @auth('subscriber')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('containers.index')}}" class="p-3">Seznam nádob</a>
    
                </li>
                

                
                    <a class="nav-link" href="{{ route('orders.myindex',  auth('subscriber')->user()->id )}}" class="p-3">Moje objednávky</a>
               

               
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('productOriginal.index')}}" class="p-3">Seznam produktů</a>
        
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact.index')}}" class="p-3">Přidat kontaktní osobu</a>
        
                    </li>
                @endauth

                
            </ul>
        </div>

    </nav>
    <!--
    <nav class="navbar navbar-expand navbar-light bg-light">
        <a href="/" class="navbar-brand">Domů</a>
        <ul class="navbar-nav mr-auto">    
            <li class="nav-item"><a class="nav-link" href="{{ route('subscribers.login') }}"></a> Přihlašení zakazníka</li>

            <li class="nav-item"><a class="nav-link" href="{{ route('subscribers.create')}}"></a> Registrace zakazníka</li>
        </ul>
    </nav>    
        <ul>
                
                
                <li class="nav-item">
                    <a  class="nav-link" href="{{ route('subscribers.login') }}" class="p-3">Přihlášení zákazníka</a>
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('subscribers.create')}}" class="p-3">Registrace zákazníka</a>
    
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('employees.create') }}" class="p-3">Registrace Zaměstnance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('employees.index') }}" class="p-3">Upravit Zaměstnance</a>
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('departments.index') }}" class="p-3">Přidat oddělení</a>
                </li>
    
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admins.index') }}" class="p-3">Registrace Admina</a>
                </li>
    
    
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('subscribers.index')}}" class="p-3">Zobrazit Zákazníky</a>
    
                </li>
    
              
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact.index')}}" class="p-3">Přidat kontaktní osobu</a>
    
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('producers.index')}}" class="p-3">Registrace Dodavatele</a>
    
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productOriginal.create')}}" class="p-3">Přidat originální produkt</a>
    
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productMixed.create')}}" class="p-3">Přidat míchaný produkt</a>
    
                </li>
     
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productOriginal.index')}}" class="p-3">Seznam produktů</a>
    
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('containers.create')}}" class="p-3">Přidat nádobu</a>
    
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('containers.index')}}" class="p-3">Seznam nádob</a>
    
                </li>
    
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders.index')}}" class="p-3">Moje objednávky</a>
    
                </li>
               
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mixingProduct.create')}}" class="p-3">Přidat recept</a>
    
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mixingProduct.index')}}" class="p-3">Recepty</a>
    
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orderWork.create')}}" class="p-3">Označit práci na objednávce</a>
    
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orderWork.index')}}" class="p-3">Práce na objednávce</a>
    
                </li>
            
    
            
            </ul>
        </div>
        
    -->
        
    

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    @auth
    <div>{{ auth()->user()->name }} {{ auth()->user()->surname }}</div>
        <form action="{{ route('orders.store') }}" method="post">
            @csrf
            <button type="submit" class="btn-primary">Vytvořit novou objednávku</button>
        </form>  
    @endauth

    @auth('subscriber')
    <div><a href="{{ route('subscribers.edit', auth('subscriber')->user()->id) }}">{{ auth('subscriber')->user()->name }}</a></div>
    <form action="{{ route('orders.store') }}" method="post">
        @csrf
        <button type="submit" class="btn-primary">Vytvořit novou objednávku</button>
    </form>  
    @endauth
    


    @yield('content')
   
</body>