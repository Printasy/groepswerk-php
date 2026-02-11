# TEST_LOG.md

## TC-01 — Login (positief): geldige inloggegevens
**Doel:** Verifiëren dat een gebruiker met geldige credentials kan inloggen.

**Stappen**
1. Open de loginpagina.
2. Vul een **bestaande** gebruikersnaam/e-mailadres in.
3. Vul het **correcte** wachtwoord in.
4. Klik op **Login**.

**Verwachte uitkomst**
- De gebruiker wordt succesvol geauthenticeerd.
- De gebruiker wordt doorgestuurd naar het dashboard/homepagina.
- Er verschijnt geen foutmelding.

**Effectieve uitkomst**
- De gebruiker wordt succesvol geauthenticeerd.
- De gebruiker wordt doorgestuurd naar het dashboard/homepagina.
- Er verschijnt geen foutmelding.


---

## TC-02 — Login (positief): fout wachtwoord
**Doel:** Verifiëren dat login wordt geweigerd bij een incorrect wachtwoord.

**Stappen**
1. Open de loginpagina.
2. Vul een **bestaande** gebruikersnaam/e-mailadres in.
3. Vul een **incorrect** wachtwoord in.
4. Klik op **Login**.

**Verwachte uitkomst**
- De gebruiker wordt **niet** ingelogd.
- Er verschijnt een duidelijke foutmelding (bv. “Onjuiste gebruikersnaam of wachtwoord”).
- De gebruiker blijft op de loginpagina.
- Er wordt **geen** sessie aangemaakt.

**Effectieve uitkomst**
- De gebruiker wordt **niet** ingelogd.
- Er verschijnt een duidelijke foutmelding (bv. “Onjuiste gebruikersnaam of wachtwoord”).
- De gebruiker blijft op de loginpagina.
- Er wordt **geen** sessie aangemaakt.

---

## TC-03 — Users (positief): nieuwe user aanmaken
**Doel:** Verifiëren dat een admin/authorized user een nieuwe gebruiker kan aanmaken.

**Stappen**
1. Log in met een account dat **rechten heeft om users te beheren**.
2. Ga naar **Users** (overzicht).
3. Klik op **Nieuwe user** / **Add user**.
4. Vul geldige gegevens in:
    - Naam
    - E-mail (uniek)
    - Rol/rechten (indien van toepassing)
    - Wachtwoord (volgens policy)
5. Klik op **Opslaan**.

**Verwachte uitkomst**
- De nieuwe user wordt aangemaakt en verschijnt in de users-lijst.
- De user kan (indien van toepassing) inloggen met de aangemaakte credentials.
- Validatie werkt: alle verplichte velden zijn ingevuld en correct opgeslagen.


**Effectieve uitkomst**
- De nieuwe user wordt aangemaakt en verschijnt in de users-lijst.
- De user kan (indien van toepassing) inloggen met de aangemaakte credentials.
- Validatie werkt: alle verplichte velden zijn ingevuld en correct opgeslagen.
---

## TC-04 — Klanten (negatief): klant aanmaken met ongeldig e-mailadres
**Doel:** Verifiëren dat validatie foutieve klantgegevens blokkeert.

**Stappen**
1. Log in met een account dat **klanten mag beheren**.
2. Ga naar **Klanten** (overzicht).
3. Klik op **Nieuwe klant** / **Add klant**.
4. Vul geldige klantgegevens in, maar gebruik een **ongeldig e-mailadres** (bv. `jan@@printasy` of zonder `@`).
5. Klik op **Opslaan**.

**Verwachte uitkomst**
- De klant wordt **niet** aangemaakt.
- Er verschijnt een validatiefout bij het e-mailveld (bv. “Voer een geldig e-mailadres in”).
- De ingevoerde (geldige) velden blijven behouden zodat de gebruiker enkel het e-mailveld moet corrigeren.

**Verwachte uitkomst**
- De klant wordt **niet** aangemaakt.
- Er verschijnt een validatiefout bij het e-mailveld (bv. “Voer een geldig e-mailadres in”).
- De ingevoerde (geldige) velden blijven behouden zodat de gebruiker enkel het e-mailveld moet corrigeren.

---

## TC-05 — Producten (positief): nieuw product toevoegen
**Doel:** Verifiëren dat een gebruiker een nieuw product correct kan aanmaken.

**Stappen**
1. Log in met een account dat **rechten heeft om producten te beheren**.
2. Ga naar **Producten** (overzicht).
3. Klik op **Nieuw product**.
4. Vul alle verplichte velden correct in.
5. Klik op **Opslaan**.

**Verwachte uitkomst**
- Het product wordt succesvol aangemaakt.
- Het nieuwe product verschijnt in het productenoverzicht.
- Het product wordt correct opgeslagen in de database.
- Er verschijnt geen foutmelding.

---

## TC-06 — Producten (positief): product bekijken
**Doel:** Verifiëren dat een gebruiker de details van een product kan bekijken.

**Stappen**
1. Log in (indien vereist).
2. Ga naar **Producten** (overzicht).
3. Klik op de **titel** van een bestaand product.

**Verwachte uitkomst**
- De detailpagina van het product wordt geopend.
- Alle opgeslagen productinformatie wordt correct weergegeven.
- De weergegeven gegevens komen overeen met de database.

---

## TC-07 — Producten (positief): product verwijderen
**Doel:** Verifiëren dat een gebruiker een product kan verwijderen.

**Stappen**
1. Log in met een account dat **rechten heeft om producten te beheren**.
2. Ga naar **Producten** (overzicht).
3. Klik op **Verwijder** bij een bestaand product.

**Verwachte uitkomst**
- Het product wordt verwijderd uit het overzicht.
- Het product wordt verwijderd uit de database.
- Het product is niet langer toegankelijk via directe URL.
- Er verschijnt eventueel een bevestigingsmelding (bv. “Product succesvol verwijderd”).

---

## TC-08 — Producten (positief): product bewerken
**Doel:** Verifiëren dat een gebruiker een bestaand product kan wijzigen.

**Stappen**
1. Log in met een account dat **rechten heeft om producten te beheren**.
2. Ga naar **Producten** (overzicht).
3. Klik op **Bewerken** bij een bestaand product.
4. Wijzig één of meerdere velden correct.
5. Klik op **Opslaan**.

**Verwachte uitkomst**
- De wijzigingen worden succesvol opgeslagen.
- Het product toont de bijgewerkte gegevens in het overzicht en op de detailpagina.
- De wijzigingen zijn correct doorgevoerd in de database.
- Er verschijnt geen foutmelding bij geldige invoer.