# TEAM_PLAN.md

## 1. Gekozen domein
Wij hebben gekozen voor het domein **ERP / administratie-applicatie**.

De applicatie is een eenvoudige ERP-webapp waarmee een bedrijf basisbeheer kan uitvoeren van:
- klanten (customers)
- leveranciers (suppliers)
- producten (products)
- gebruikers (users)

Daarnaast bevat de applicatie ook een dashboard en login/authenticatie.

---

## 2. Entiteiten (minstens 3)
De applicatie werkt met volgende entiteiten:

1. **User**
    - Gebruikers die kunnen inloggen op het admin-platform.

2. **Customer**
    - Klanten van het bedrijf.

3. **Supplier**
    - Leveranciers van producten/diensten.

4. **Product**
    - Producten die beheerd worden binnen het systeem.

---

## 3. Sitestructuur

- /config
    - database.php
- /controllers
    - AuthController.php
    - CustomersController.php
    - ProductsController.php
    - SuppliersController.php
    - UsersController.php
- /repositories
    - CustomerRepository.php
    - ProductRepository.php
    - SupplierRepository.php
    - UserRepository.php
- /views
    - /partials (header/footer/nav)
    - /auth (login)
    - /customers (index/create/edit/show)
    - /products (index/create/edit/show)
    - /suppliers (index/create/edit/show)
    - /users (index/create/edit/show)
- /public
    - index.php
    - assets/ (css/js/img)

---

## 4. Taakverdeling per groepslid
### Jan
- Login en authenticatie (AuthController)
- Users beheer (UsersController + UsersRepository)
- Validatie van login inputs

### Jan
- Customers module (CustomersController + CustomersRepository)
- CRUD-functionaliteit voor klanten
- Views voor customer overzicht + detail

### Warre
- Products module (ProductsController + ProductsRepository)
- CRUD-functionaliteit voor producten
- Koppeling product ↔ supplier

### Warre
- Suppliers module (SuppliersController + SuppliersRepository)
- CRUD-functionaliteit leveranciers
- ErrorController en foutpagina’s

### Jan
- Flash module


---

## 5. Afspraken

### 5.1 Validatie
- Alle form input wordt gevalideerd in de **controller**.
- Voorbeelden van validatie:
    - verplichte velden mogen niet leeg zijn
    - email moet geldig formaat hebben
    - stock en price moeten numeriek zijn
- Bij validatiefouten tonen we een duidelijke foutmelding in de view.

---

### 5.2 Foutafhandeling
- Database errors worden opgevangen met try/catch.
- Als er een fout optreedt:
    - wordt de gebruiker doorverwezen naar een error view
    - of krijgt een duidelijke boodschap op het scherm
- Niet-bestaande routes gaan naar een standaard foutpagina.

---

### 5.3 Views (geen logica)
- Views bevatten enkel HTML + minimale weergavelogica.
- Geen SQL of databanklogica in views.
- Geen berekeningen of business logica in views.
- Views tonen enkel de data die vanuit de controller wordt doorgestuurd.

---

## 6. Evaluatiecriteria

### Correcte toepassing van de cursus
Wij passen de principes toe uit de cursus:
- MVC-structuur (Model / View / Controller)
- Repositories voor databankqueries
- Controllers voor verwerking en validatie
- Views enkel voor presentatie
- duidelijke foutafhandeling en inputvalidatie
- herbruikbare code en gestructureerde mappenindeling

De code is georganiseerd in:
- Controllers
- Repositories
- Config
- Views

Dit zorgt voor overzichtelijke en onderhoudbare code.
