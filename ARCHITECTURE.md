# ARCHITECTURE.md

## 1) MVC-opzet in onze applicatie (Mini-ERP Admin)

Onze applicatie leeft volledig onder de map `admin/` en bestaat uit modules voor:
- **Products** (CRUD + detail + delete-confirm)
- **Customers** (CRUD)
- **Suppliers** (lijst + detail)
- **Users** (CRUD, bedoeld voor admins)
- **Login/Logout** (sessie-auth)

We gebruiken een **MVC-opzet** met een duidelijke extra laag voor databanktoegang (Repositories).

**Globaal:**
- **Controller** = request-flow + validatie + security + redirect/render
- **Model** = databanktoegang via **Repositories** (PDO)
- **View** = HTML-presentatie (met gedeelde includes)

---

## 2) Waar zit welke verantwoordelijkheid (en waarom)

### 2.1 Front Controller + Routing (in onze code: `admin/index.php` + `admin/Classes/Core/Router.php`)
**Waar?**
- `admin/index.php` is het **entry point**: start sessie, laadt autoload, leest `$uri` en `$method`, registreert routes en doet `dispatch`.
- `admin/Classes/Core/Router.php` bevat `get()`, `post()`, route-registratie en `dispatch()`.

**Verantwoordelijkheden**
- **Front Controller** (`admin/index.php`)
    - Centrale plaats waar alle requests binnenkomen.
    - Definieert routes (bv. `/products`, `/customers/create`, `/products/{id}`).
    - Zet een eenvoudige “guard”: alles behalve `/login` vereist een ingelogde user.
    - Redirects naar `/login` als je niet ingelogd bent (omdat Router geen middleware heeft).

- **Router**
    - Matcht URL’s op basis van patronen (bv. `/products/{id}` → `{id}` wordt numeriek gematcht via regex).
    - Roept de juiste handler/controller-method op.
    - Stuurt onbekende routes door naar `ErrorController->notFound(...)`.

**Waarom hier?**
- Dit volgt het **Front Controller pattern** (cursus): één ingang voor routing + cross-cutting concerns.
- Router doet enkel routing (SRP) en houdt controllers vrij van URL-matchlogica.

---

### 2.2 Controllers (in `admin/Classes/Controllers/`)
Controllers in onze app zijn o.a.:
- `ProductsController`, `CustomersController`, `SuppliersController`, `UsersController`, `AuthController`, `ErrorController`.

**Verantwoordelijkheden**
- **Flow bepalen** per route (index/detail/create/edit/store/update/delete).
- **Validatie** van input (vooral in POST-actions):
    - vb. in `ProductsController->store()`:
        - `Csrf::verifyOrAbort()`
        - velden trimmen en controleren (name/sku/prijzen/leverancier)
        - bij errors: dezelfde view opnieuw renderen met `errors` + `old`
- **Repository aanroepen** (CRUD uitvoeren via de juiste repository).
- **Redirecten of renderen**:
    - render via `View::render('products.php', [...])`
    - redirect via `header('Location: ' . ADMIN_BASE_PATH . '/products')`

**Waarom in controllers?**
- Controllers zijn in MVC de **coördinator** van de request.
- Validatie hoort hier omdat het input uit de HTTP-request komt (**input validation / fail fast**).
- Views blijven daardoor “dom” (presentatie-only).

---

### 2.3 Model / Data Access (in onze app: Repositories + Core Database)
**Waar?**
- `admin/Classes/Core/Database.php` (PDO connectie)
- `admin/Classes/Repositories/*Repository.php` (SQL per entiteit)

Repositories in onze app:
- `ProductsRepository`, `CustomersRepository`, `SuppliersRepository`, `UsersRepository`.

**Verantwoordelijkheden**
- Alle **SQL** (SELECT/INSERT/UPDATE/DELETE) zit in repositories.
- Gebruik van **PDO prepared statements** (veilig en onderhoudbaar).
- Controllers roepen enkel methodes aan zoals `getAll()`, `find($id)`, `create(...)`, `update(...)`, `delete(...)`.

**Waarom zo?**
- Dit is het cursusconcept **Data Access Layer** / **Repository pattern**:
    - SQL staat niet verspreid in controllers of views.
    - Minder duplicatie, makkelijker aanpassen bij DB-wijzigingen.
- **Separation of Concerns**: databanklogica is gescheiden van request-flow en presentatie.

> Opmerking: `admin/Classes/Models/` bestaat, maar in onze implementatie zit “Model”-logica praktisch in de repositories (dus we gebruiken geen “rijke Model-classes” met businesslogica).

---

### 2.4 Views (in `admin/Views/`)
Voorbeelden:
- `products.php`, `product-create.php`, `product-edit.php`, `product-view.php`, `product-delete.php`
- `customers.php`, `customer-create.php`, `customer-edit.php`
- `suppliers.php`, `supplier-view.php`
- `users.php`, `user-create.php`, `user-edit.php`
- `login.php`, `errors/404.php`
- gedeelde layout: `Views/includes/*` + `Views/partials/flash.php`

**Verantwoordelijkheden**
- HTML tonen + data weergeven die controller meegeeft.
- Formulieren tonen en foutmeldingen weergeven (bv. `$errors`).
- Layout hergebruiken via includes (header/sidebar/topbar/footer).

**Wat doen views NIET (afspraak, ook in onze code)**
- Geen SQL of repository-calls.
- Geen businesslogica.
- Geen security-beslissingen (die liggen in controller/core).

**Waarom?**
- Dit is de **Presentation Layer** uit MVC: focus op UI.
- Houdt onderhoud eenvoudig en voorkomt “spaghetti” (logica verspreid over templates).

---

### 2.5 Cross-cutting concerns: Auth, CSRF, Flash, View (in `admin/Classes/Core/`)
**Waar?**
- `Core/Auth.php`: sessie-checks (`check()`, `isAdmin()`, `login()`, `logout()`)
- `Core/Csrf.php`: token genereren + `verifyOrAbort()` bij POST
- `Core/Flash.php`: flash messages tussen redirects
- `Core/View.php`: centrale render + includes/layout

**Waarom in Core?**
- Dit zijn generieke infrastructuurfuncties die meerdere controllers/views gebruiken.
- Past bij het cursusidee “infrastructuurlaag” / herbruikbare services.

---

## 3) 2 concrete ontwerpkeuzes (met cursusbegrippen)

### Ontwerpkeuze 1 — Front Controller + eigen Router (routing centraal in `admin/index.php`)
**Wat hebben we gedaan?**
- Alle requests gaan via `admin/index.php`.
- Routes worden daar geregistreerd en gedispatched via `Core/Router`.
- Omdat onze Router geen middleware kent, doen we een **eenvoudige guard** in `admin/index.php`:
    - alles behalve `/login` vereist een ingelogde user.

**Waarom (cursusbegrippen)?**
- **Front Controller pattern**: één centrale toegang → consistent routing & guards.
- **Separation of Concerns**: Router matcht routes, controllers doen de business-flow.
- **SRP**: routing niet verspreid over controllers of views.

---

### Ontwerpkeuze 2 — Repository Pattern als Data Access Layer (SQL enkel in repositories)
**Wat hebben we gedaan?**
- Voor elke entiteit een repository:
    - bv. `ProductsRepository` bevat `getAll/find/create/update/delete`
- Controllers bevatten geen SQL; ze roepen repository-methodes aan.
- We gebruiken **PDO prepared statements** voor veilige queries.

**Waarom (cursusbegrippen)?**
- **Repository Pattern / Data Access Layer**: databanktoegang achter een API (methodes).
- **Maintainability**: DB-wijzigingen pas je vooral in repositories aan.
- **Defensive Programming** (security): prepared statements verminderen SQL-injection risico.
- **Separation of Concerns**: request-flow ≠ databanklogica.

---

## 4) Samenvatting
Onze MVC-opzet matcht met de code:
- `admin/index.php` + `Core/Router.php` regelen routing/dispatch + login-guard.
- Controllers (`Classes/Controllers`) doen flow + validatie + security checks (CSRF/Auth) en kiezen views.
- Repositories (`Classes/Repositories`) doen alle databankoperaties via PDO.
- Views (`Views/`) tonen HTML en gebruiken includes voor layout, zonder databank- of businesslogica.
