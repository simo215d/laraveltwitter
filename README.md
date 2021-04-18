Jeg har lavet en lite version af twitter, som jeg kalder Twooter <br>
Jeg vil gennemgå hvordan jeg har brugt laravel frameworket til at lave den grundlæggende opsætning ved hjælp af tutorials og hvad jeg selv har lavet.<br>

Jeg bruger composer (en slags package manager til php) til at hente en frisk laravel projekt
```
composer create-project laravel/laravel twitter
```

laravel har et authentication pakke vi kan bruge som hedder ui 
```
composer require laravel/ui
```

i mit projekt har jeg tænkt mig at bruge bootstrap til frontend styling, så jeg bruger laravels cli ‘artisan’ til at lave en bootstrap opsætning til min ui authentication
```
php artisan ui bootstrap --auth
```

De 2 kommandoer gør en masse ting: <br>
Giver os en User model <br>
Giver os en masse controllers og tilhørende views <br>

Før det virker skal vi migrere User til vores database. Database indstillinger findes i .env filen. Jeg skrev 
```
DB_CONNECTION=mysql 
DB_HOST=127.0.0.1 
DB_PORT=3306 
DB_DATABASE=twotter 
DB_USERNAME=root 
DB_PASSWORD= 
```

og så 
```
php artisan migrate
```

Nu har jeg et grundlæggende website med brugere, så jeg kan begynde at lave twitter funktioner <br>
Jeg vil have at hvis man er logget ind kan man poste en twoot. Twoots bliver gemt i databasen og alle twoots kan ses og hvem der har twooted dem. <br>
Lav en migration som laver en tabel med twoots
```
php artisan make:migration create_twoots_table --create=twoots
php migrate
```

Gør brug af laravels indbyggede object relationel mapper og lav en twoot model og en controller til håndtering af routes
```
php artisan make:controller TwootController --resource --model=Twoot
```

For, at twoot controlleren virker, skal vi lige lave en reference inden i twitter/routes/web.php
```php
Route::resource('/twoots', TwootController::class);
```

Vi har nu en model, controller og en database tabel, så vi kan begynde <br>
I vores controller får man brug for, at kunne oprette en twoot, se twoots, og slette. <br>
inde i twitter/app/Http/Controllers/TwootController.php (læs //kommentarene for uddybning) <br>

```php
    public function index()
    {
        //jeg bruger mine models til at tilgå deres all metode. :: betyder at det er en static metode
        $twoots = Twoot::all();
        $users = User::all();

        //da det ikke er normale php arrays, men laravel collections kan jeg nemt bruge metoderne, som laravel har lavet
        //sortby sortere mine twoots i en ascending (lav til høj)
        $sortedtwootsAsc = $twoots->sortBy('created_at');
        //men jeg vil have nyeste twoots (højest) øverst, så jeg bruger sortDesc som vender min liste om
        $sortedtwootsDesc = $sortedtwootsAsc->sortDesc();

        //jeg returnere viewet twoots.index blade filen, som kan modtage variabler ligesom handlebars i nodejs
        return view('twoots.index',['twoots'=>$sortedtwootsDesc], ['users'=>$users]);
    }
```
Da index er default route, så hvis vi går til http://localhost:8000/twoots får vi <br>
<img alt="Screenshot 2021-04-18 at 16 15 37" src="https://user-images.githubusercontent.com/54975711/115148757-5ac40600-a061-11eb-8a51-d2c0b826f510.png">


