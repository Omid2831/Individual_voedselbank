# Handleiding Rollen Aanmaken en Beheren

Dit document legt simpel en stap-voor-stap uit hoe jij en je projectgroep de rollen kunnen toewijzen en beheren binnen het **Oefen-examen** project. 

In plaats van een zeer lastig systeem, hebben we het makkelijk gehouden door elke gebruiker in de `users` tabel één standaard rol-kolom te geven genaamd `role`. 

---

## 🛠️ Stap 1: Een nieuwe gebruiker (account) aanmaken
Om een test-gebruiker te hebben in de database, moet er natuurlijk éérst iemand geregistreerd zijn!
1. Start je lokale server (`php artisan serve`).
2. Ga via je browser naar `http://127.0.0.1:8000` of de URL van je XAMPP.
3. Klik op **Registreer** en maak een nieuw account aan (bijv. `admin@mijnschool.nl`).
4. **Let op:** Zodra je registreert, krijg je in de database **automatisch** de rol `user` toegewezen.

---

## 🗄️ Stap 2: Iemand "Admin" of een andere Rol maken
Nu we een account hebben, willen we de rol veranderen. Omdat we momenteel nog geen uitgebreid controlepaneel in de website zelf hebben ingebouwd, doen we dit aan de achterkant via de database.

1. Open **phpMyAdmin** in je browser via `http://localhost/phpmyadmin`.
2. Klik aan de linkerkant op jouw database: **`oefen_examen`**.
3. Klik op de tabel genaamd **`users`**.
4. Zoek de gebruiker op die je zojuist hebt geregistreerd.
5. Bij die rij zie je een kolom genaamd **`role`**. Klik dubbel op het woordje `user` (onder die kolom) en verander het naar:
   - `admin` (om er een administrator van te maken)
   - `docent`
   - `student`
   - *(Je kunt elke willekeurige tekst neerzetten die jullie handig vinden voor het project!)*
6. Druk op Enter of klik ergens anders om het op te slaan. Klaar! Je account is nu geüpdatet.
7. Wachtwoord voor alle rollen is 12345678.



---

## 🔒 Stap 3: Wat kan ik hier in de code mee?
Nu je in de database een "admin" rol hebt gemaakt, kan je deze controleren in de Laravel bestanden. 

### Knoppen verbergen of tonen (In Blade HTML)
Als je bijvoorbeeld de "Admin Dashboard"-knop onzichtbaar wilt maken voor normale gebruikers, gebruik je de volgende code in een bestand zoals `resources/views/welcome.blade.php`:

```html
@if(auth()->check() && auth()->user()->role === 'admin')
    <a href="/admin-paneel" class="btn btn-primary">Admin Paneel (Alleen voor Beheerders)</a>
@endif
```

### Routes (URL's) blokkeren voor niet-admins
Wil je een volledige link blokkeren zodat normale "users" hem niet stiekem kunnen bezoeken? In `routes/web.php` zet je dan:

```php
Route::get('/geheime-admin-pagina', function () {
    // 1. Is hij ingelogd?
    // 2. Is zijn rol exact 'admin'?
    if (auth()->check() && auth()->user()->role === 'admin') {
        return view('admin.index');
    }
    
    // Niet ingelogd, of verkeerde rol? Geef een rood scherm of stuur weg:
    abort(403, 'Je hebt hier geen rechten voor!');
})->middleware('auth');
```

---

## 🚀 Voor Gevorderden: Automatisch aanmaken via een Formulier
Als jullie straks in het examen een echt "Beheerderspaneel" moeten bouwen waarbij een Admin zelf de lay-out en rollen van *andere* mensen verandert via de website:
1. Maak een HTML-formulier in Blade met een `<select>` menu (User, Admin).
2. Let er dan wel op dat de string `'role'` wordt toegevoegd aan de lijst `$fillable` bovenaan in het bestand `app/Models/User.php`.
3. Anders kan de database vanuit het formulier niet geüpdatet worden in de Controller!
