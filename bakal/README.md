# Návod na zprovoznění informačního systému pro prodejce nátěrových hmot([Laravel](https://laravel.com/) projekt)

## Přístup k webové aplikaci
Kompletní webová aplikace je nasazena na webovou stránku pomocí [hostingeru](https://www.hostinger.cz/) a je dostupná na této webové adrese: 
http://bakal-colors.online/


## Instalace a spuštění na localhostu
1. Nejdříve je potřeba nainstalovat [xampp](https://www.apachefriends.org/index.html), který obsahuje [MySql](https://www.mysql.com/) a [PHP](https://www.php.net/).
2. Po instalaci je potřeba nastavit jazyk PHP jako systémovou proměnnou, aby mohlo být PHP ovládáno z příkazové řádky,
 [zde](https://www.forevolve.com/en/articles/2016/10/27/how-to-add-your-php-runtime-directory-to-your-windows-10-path-environment-variable/) je návod.
3. Po spuštění xamppu, spusťte apache a mySql. Stiskněte tlačítko Admin v řádku mySql. Měl by se otevřít phpMyAdmin, zde vytvořte novou databázi. Ve složce instalace, je společně s tímto souborem(readme.md) soubor **bakal.sql**, ten importujte do nově vyvořené databáze, obsahuje data informačního systému.
4. V kořenové složce projektu(složka "bakal") otevřete soubor **.env**, a upravte následující údaje:
-  *DB_DATABASE* - název databáze, která byla vytvořena v předchozím kroku,
-  *DB_USERNAME* - uživatelské jméno(defaultně root),
-  *DB_PASSWORD* - heslo(defaultně bez hesla).
5. Nyní stačí v příkazové řádce kořenového adresáře projektu(složka bakal), kde se nacází soubor **artisan** spustit příkaz php artisan serve, poté zadejte ve webovém prohlížeči adresu **http://127.0.0.1:8000/**
    


## Licence
- Framework Laravel: [MIT](https://opensource.org/licenses/MIT).
- Chart.js: [MIT](https://github.com/chartjs/Chart.js/blob/master/LICENSE.md).
- jQuery: [MIT](https://jquery.org/license/).
- Bootstrap: [MIT](https://github.com/twbs/bootstrap/blob/main/LICENSE)


