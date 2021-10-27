# Centrum Mieszkalne

Nowa wersja projektu, tworzona z powodu utraty hostingu. 
Podobno ludzie dzielą się na tych co robią backupy i na tych, co będą je robić. No cóż, ja najwidoczniej niestety należę do tej drugiej grupy.

## Opis instalacji

Aby uruchomić stronę, trzeba będzie wpisać kilka komend, oraz zedytować plik **.env**

*W pliku **.env**, należy podać dane, do nawiązania połączenia dla nowo utworzonej bazy danych.*

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=cm
    DB_USERNAME=root
    DB_PASSWORD=

### Lista komend, które należy wpisać:
 - `composer install`
 - `npm run dev`
 - `php artisan migrate:fresh --seed`
 - `php artisan serve`
 - `php artisan websocket:serve`


Pod adresem **localhost:8000/cm** znajduje się widok wyświetlany na monitorze, w naszym mieszkaniu.

Dane do logowania znajdują się w seederze, plik: **database/seeders/UserSeeder.php**.