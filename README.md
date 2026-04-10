# Oefen Examen Project

Welkom bij dit Laravel 11 project! Dit is de hoofddocumentatie voor jou en de groepsleden.

## Setup Instructies (Lokaal)

Zorg dat je XAMPP of MAMP of Laragon hebt gestart (inclusief MySQL en Apache/Nginx).

1. Kloon of download dit project naar je lokale folder (`htdocs` of vergelijkbaar).
2. Start een terminal in de project map en installeer pakketten:
   ```bash
   composer install
   npm install
   ```
3. Zorg dat je een `.env` bestand hebt (als deze nog niet bestaat, kopieer dan `.env.example` naar `.env`).
4. **BELANGRIJK:** Maak handmatig een database aan via phpMyAdmin genaamd **`oefen_examen`**.
5. Genereer een app key en voer de databasemigraties uit (die maken de tabellen voor je aan):
   ```bash
   php artisan key:generate
   php artisan migrate
   ```
6. Bouw de CSS (Tailwind):
   ```bash
   npm run build
   ```
7. Start de applicatie via localhost indien je via htdocs werkt, óf via de testserver:
   ```bash
   php artisan serve
   ```

---

## 🎭 Hoe werken de Rollen? (Role System)

We hebben een simpele, overzichtelijke en solide variant van een rollensysteem opgezet in dit project. Dit is hoe jullie ermee te werk gaan:

### 1. Waar staat de 'Role' in de Database?
Elke gebruiker krijgt standaard een `role` toegekend. 
- **Locatie in de code**: `database/migrations/0001_01_01_000000_create_users_table.php`
- Standaardwaarde in de tabel: `user`

Zodra er een account is geregistreerd, is dit een gewone "user". Wil je dat iemand een **administrator** is? Pas die rol waarde in de database (bijv. via phpMyAdmin) dan handmatig aan naar `admin`. 

### 2. Hoe maak je een Role aanpasbaar in laravel forms? (The Model)
Als jullie later via een beheerderspaneel de rollen van gebruikers willen updaten, moeten jullie in **`app/Models/User.php`** de string `'role'` toevoegen aan de `$fillable` array. (Voorbeeld: `protected $fillable = ['name', 'email', 'password', 'role'];`).

### 3. Hoe check je in jullie Views (HTML/Blade) welke rol iemand heeft?
Je kan heel makkelijk knoppen of paginadelen verbergen als iemand de verkeerde rol heeft:
```html
@if(auth()->check() && auth()->user()->role === 'admin')
   <div class="p-4 bg-red-100 text-red-800">
        Menu item: Admin Paneel (Alleen zichtbaar voor admins!)
   </div>
@endif

@if(auth()->check() && auth()->user()->role === 'user')
   <p>Welkom normale gebruiker.</p>
@endif
```

### 4. Pagina's en Routes server-sided beveiligen
Als jullie een compleet nieuwe weergave maken die `admin` rollen vereist, kunnen jullie dit handig in `routes/web.php` inbouwen:

```php
use Illuminate\Support\Facades\Route;

Route::get('/mijn-admin-paneel', function () {
    // Controlleren of ingelogd AND aantonen dat het een admin is.
    if (auth()->check() && auth()->user()->role === 'admin') {
        return view('admin.dashboard');
    }
    
    // Wegsturen met een error als dat niet lukt:
    abort(403, 'Geen toegang. Je bent geen beheerder.');
})->middleware('auth');
```

> **🔥 Pro-Tip voor het examen**: We raden aan om samen als groep een **Middleware** (`php artisan make:middleware CheckRole`) te maken als je deze check voor veel admin routes nodig gaat hebben. Dat scoort altijd goed.

Succes met het project!
