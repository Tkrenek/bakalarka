<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Coloral</title>
    <link rel="stylesheet" href=" {{ asset('css/app.css') }}">
    <link rel="stylesheet" href=" {{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/js/all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" >
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    
</head>
<body class="d-flex flex-column min-vh-100">


    <nav class="navbar navbar-expand-xl navbar-dark bg-dark">
        <a href="/" class="navbar-brand ">Coloral</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav">
                
                
              
                @auth('employee')
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders.index')}}" class="p-3">Všechny objednávky</a>
    
                </li>
               

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('product.index')}}" class="p-3">Seznam produktů</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('containers.index')}}" class="p-3">Seznam nádob</a>
        
                    </li>

                 
        
        
                    
        
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orderWork.index')}}" class="p-3">Práce na objednávce</a>
        
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('google.index')}}" class="p-3">Google kalendář</a>
        
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('stats.index')}}" class="p-3">Statistiky</a>
                    </li>
                @endauth

                @auth('admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('stats.index')}}" class="p-3">Statistiky</a>
    
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admins.index')}}" class="p-3">Registrovat Admina</a>
                
                </li>
                
               
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('employees.index') }}" class="p-3">Zobrazit Zaměstnance</a>
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('departments.index') }}" class="p-3">Seznam oddělení</a>
                </li>
    

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customers.index')}}" class="p-3">Zobrazit Zákazníky</a>
                </li>
    
            
            
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('producers.index')}}" class="p-3">Zobrazit Dodavatele</a>
    
                </li>
                
                

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('product.index')}}" class="p-3">Seznam produktů</a>
    
                </li>
                
    
         
    
               
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('containers.index')}}" class="p-3">Seznam nádob</a>
    
                </li>
    
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders.index')}}" class="p-3">Všechny objednávky</a>
    
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orderWork.index')}}" class="p-3">Práce na objednávce</a>
                </li>
                @endauth
                
                @auth('customer')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('stats.index')}}" class="p-3">Statistiky</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('containers.index')}}" class="p-3">Seznam nádob</a>
                </li>
                

                
                    <a class="nav-link" href="{{ route('orders.myindex',  auth('customer')->user()->id )}}" class="p-3">Moje objednávky</a>
               

               
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('product.index')}}" class="p-3">Seznam produktů</a>
        
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact.create')}}" class="p-3">Přidat kontaktní osobu</a>
        
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact.index.sub', auth('customer')->user()->id)}}" class="p-3">Zobrazit moje kontaktní osoby</a>
        
                    </li>
                @endauth

                
            </ul>
        </div>

    </nav>

   
    
    <!--
    <nav class="navbar navbar-expand navbar-light bg-light">
        <a href="/" class="navbar-brand">Domů</a>
        <ul class="navbar-nav mr-auto">    
            <li class="nav-item"><a class="nav-link" href="{{ route('customers.login') }}"></a> Přihlašení zakazníka</li>

            <li class="nav-item"><a class="nav-link" href="{{ route('customers.create')}}"></a> Registrace zakazníka</li>
        </ul>
    </nav>    
        <ul>
                
                
                <li class="nav-item">
                    <a  class="nav-link" href="{{ route('customers.login') }}" class="p-3">Přihlášení zákazníka</a>
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customers.create')}}" class="p-3">Registrace zákazníka</a>
    
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('employees.create') }}" class="p-3">Registrace Zaměstnance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('employees.index') }}" class="p-3">Upravit Zaměstnance</a>
                </li>
    
            
    
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admins.index') }}" class="p-3">Registrace Admina</a>
                </li>
    
    
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customers.index')}}" class="p-3">Zobrazit Zákazníky</a>
    
                </li>
    
              
    
    
               
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productOriginal.create')}}" class="p-3">Přidat originální produkt</a>
    
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productMixed.create')}}" class="p-3">Přidat míchaný produkt</a>
    
                </li>
     
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('product.index')}}" class="p-3">Seznam produktů</a>
    
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
                    <a class="nav-link" href="{{ route('orderWork.index')}}" class="p-3">Práce na objednávce</a>
    
                </li>
            
    
            
            </ul>
        </div>
        
    -->
        
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script type="text/javascript" src="Scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="Scripts/jquery-2.1.1.min.js"></script>
  
    @auth('employee')

    <nav class=" navbar navbar-expand navbar-white navbar-light  float-left">
        <!--<ul class="navbar-nav ml-auto">-->
        <ul class="navbar-nav ">
      <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             
              <span class="ml-1" >{{ auth('employee')->user()->name }} {{ auth('employee')->user()->surname }}</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('employees.edit', auth('employee')->user()->id) }}" x-ref="profileLink">Upravit profil</a>
              <a class="dropdown-item" href="{{ route('employees.change_password') }}" x-ref="changePasswordLink">Změnit heslo</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('employees.logout') }}">Odhlásit se</a>
          </div>
      </li>
  </ul>

  </nav>
  
    @endauth

    @auth('customer')
    <nav class=" navbar navbar-expand navbar-white navbar-light float-left">
        
        <ul class="navbar-nav ">
      <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             
              <span class="ml-1" >{{ auth('customer')->user()->name }} </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('customers.edit', auth('customer')->user()->id) }}" x-ref="profileLink">Upravit profil</a>
              <a class="dropdown-item" href="{{ route('customers.change_password') }}" x-ref="changePasswordLink">Změnit heslo</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('customers.logout')}}">Odhlásit se</a>
          </div>
      </li>
  </ul>

  </nav>

    
    @endauth
    
    @auth('admin')
    <nav class=" navbar navbar-expand navbar-white navbar-light float-left">
     
        <ul class="navbar-nav ">
      <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             
              <span class="ml-1" >{{ auth('admin')->user()->name }} {{ auth('admin')->user()->surname }}</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('admins.edit', Auth::user()->id) }}" x-ref="profileLink">Upravit profil</a>
              <a class="dropdown-item" href="{{ route('admins.change_password') }}" x-ref="changePasswordLink">Změnit heslo</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('admins.logout')}}">Odhlásit se</a>
          </div>
      </li>
  </ul>

  </nav>
    @endauth
    
    <div class="container">
    @yield('content')
   

    </div>

        <footer class="mt-auto bg-light text-center text-lg-start">
            
            <div class="text-center p-3" style="background-color: #212529;">
              <div class="text-white">© 2022 Tomáš Křenek</div> 
              
            </div>
            
          </footer>
   
    
</body>