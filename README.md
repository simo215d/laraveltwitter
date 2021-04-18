Jeg har lavet en lite version af twitter, som jeg kalder Twooter
Jeg vil gennemgå hvordan jeg har brugt laravel frameworket til at lave den grundlæggende opsætning ved hjælp af tutorials og hvad jeg selv har lavet.

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

De 2 kommandoer gør en masse ting:
Giver os en User model
Giver os en masse controllers og tilhørende views

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

Nu har jeg et grundlæggende website med brugere, så jeg kan begynde at lave twitter funktioner
Jeg vil have at hvis man er logget ind kan man poste en twoot. Twoots bliver gemt i databasen og alle twoots kan ses og hvem der har twooted dem.
Lav en migration som laver en tabel med twoots
```
php artisan make:migration create_twoots_table --create=twoots
php migrate
```

Gør brug af laravels indbyggede object relationel mapper og lav en twoot model og en controller til håndtering af routes
```
php artisan make:controller TwootController --resource --model=Twoot
```

For, at twoot controlleren virker, skal vi lige lave en reference inden i routes/web.php
```
Route::resource('/twoots', TwootController::class);
```

Vi har nu en model, controller og en database tabel, så vi kan begynde <br>
I vores controller får man brug for, at kunne oprette en twoot, se twoots, og slette

