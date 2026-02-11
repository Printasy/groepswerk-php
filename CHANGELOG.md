# CHANGELOG.md

## Project: ERP Admin Applicatie (Groepswerk)
Deze changelog beschrijft per groepslid welke onderdelen werden uitgewerkt en welke bestanden onder hun verantwoordelijkheid vielen.  
De taakverdeling werd vooraf afgesproken en is hieronder verwerkt volgens de effectieve mappenstructuur van de applicatie.

---

# Jan

## 1) Login & Authenticatie
### Uitgewerkt
- Loginfunctionaliteit uitgewerkt via `AuthController`
- Authenticatie met sessies (login/logout)
- Controle of gebruiker ingelogd is voor toegang tot admin-pagina’s
- Validatie van login-inputs (leeg veld, foute login, foutmeldingen tonen)

### Bestanden onder verantwoordelijkheid
- `admin/Classes/Controllers/AuthController.php`
- `admin/Views/login.php`
- `admin/Classes/Core/Auth.php`

---

## 2) Users beheer (CRUD)
### Uitgewerkt
- Users overzicht tonen
- User toevoegen
- User bewerken
- User verwijderen
- Rollenbeheer (admin/user)
- Toegangscontrole voor userbeheer (admin-only)

### Bestanden onder verantwoordelijkheid
- `admin/Classes/Controllers/UsersController.php`
- `admin/Classes/Repositories/UsersRepository.php`
- `admin/Views/users.php`
- `admin/Views/user-create.php`
- `admin/Views/user-edit.php`

---

## 3) Customers module (CRUD)
### Uitgewerkt
- Customers overzicht tonen
- Customer toevoegen
- Customer bewerken
- Customer verwijderen
- Customer detailpagina (view)
- Validatie van customer-inputs (naam, email, telefoon, btw-nummer, ...)

### Bestanden onder verantwoordelijkheid
- `admin/Classes/Controllers/CustomersController.php`
- `admin/Classes/Repositories/CustomersRepository.php`
- `admin/Views/customers.php`
- `admin/Views/customer-create.php`
- `admin/Views/customer-edit.php`
- `admin/Views/customer-view.php`

---

## 4) Flash module
### Uitgewerkt
- Flash messages voor success/error meldingen (bv. na create/update/delete)
- Flash integratie in layout zodat meldingen op alle pagina’s zichtbaar zijn

### Bestanden onder verantwoordelijkheid
- `admin/Classes/Core/Flash.php`
- `admin/Views/partials/flash.php`

---

# Warre

## 1) Products module (CRUD + supplier koppeling)
### Uitgewerkt
- Products overzicht tonen
- Product toevoegen
- Product bewerken
- Product verwijderen
- Product detailpagina
- Koppeling product ↔ supplier via `supplier_id`
- Validatie van product-inputs (naam, SKU, prijzen, ...)

### Bestanden onder verantwoordelijkheid
- `admin/Classes/Controllers/ProductsController.php`
- `admin/Classes/Repositories/ProductsRepository.php`
- `admin/Views/products.php`
- `admin/Views/product-create.php`
- `admin/Views/product-edit.php`
- `admin/Views/product-view.php`
- `admin/Views/product-delete.php`

---

## 2) Suppliers module
### Uitgewerkt
- Suppliers overzicht tonen
- Supplier detailpagina tonen
- CRUD-functionaliteit leveranciers (create/update/delete)
- Suppliers koppelen aan producten via databankrelatie

### Bestanden onder verantwoordelijkheid
- `admin/Classes/Controllers/SuppliersController.php`
- `admin/Classes/Repositories/SuppliersRepository.php`
- `admin/Views/suppliers.php`
- `admin/Views/supplier-view.php`
- `admin/Views/supplier-create.php`
- `admin/Views/supplier-edit.php`

---

## 3) ErrorController + foutpagina’s
### Uitgewerkt
- 404 error handling bij niet-bestaande routes
- Foutpagina als view
- Router fallback naar errorcontroller

### Bestanden onder verantwoordelijkheid
- `admin/Classes/Controllers/ErrorController.php`
- `admin/Views/errors/404.php`
- `admin/Classes/Core/Router.php`

---
