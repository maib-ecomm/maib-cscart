[![N|Solid](https://www.maib.md/images/logo.svg)](https://www.maib.md)

# Maib Payment Gateway pentru platforma CS-Cart
Acest modul vă permite să integrați magazinul dvs. online cu noul **API e-commerce** de la **Modulul Maib Payment Gateway** pentru a accepta plăți online (Visa / Mastercard / Google Pay / Apple Pay).

## Descriere
Cu etapele de integrare și cerințele către website puteți face cunoștință [aici](https://docs.maibmerchants.md/ro/etape-si-cerinte-pentru-integrare).

Pentru a testa integrarea veți avea nevoie de datele de acces a unui Proiect de Test (Project ID / Proejct Secret / Signature Key). Pentru aceasta vă rugăm să veniți cu o solicitare la adresa de email: ecom@maib.md.

Pentru a efectua plăți reale, trebuie să aveți contractul e-commerce semnat și să efectuați cel puțin o tranzacție reușită folosind datele Proiectului de Test și datele cardului pentru teste. 

După semnarea contractului veți primi acces la platforma maibmerchants și veți avea posibilitatea să activați Proiectul de Producție.

## Funcțional
**Plăți online**: Visa / Mastercard / Apple Pay / Google Pay.

**Trei valute**: MDL / USD / EUR (în dependență de setările Proiectului dvs).

**Returnare plată**: Pentru a returna plata, este necesar să actualizați starea comenzii (vedeți _refund.png_) la starea selectată pentru _Plată returnată_ în setările extensiei **Modulul Maib Payment Gateway** (vedeți _settings-1.png_ and _settings-2.png_). Suma plății va fi returnată pe cardul clientului.

## Cerințe 
- Înregistrare pe platforma maibmerchants.md
- CS-Cart platforma (versiune > 4.7.2)
- extensiile _curl_ and _json_ activate

## Installation
1. Descărcați fișierul cu extensie din Github sau CS-Cart.
2. În panoul de administrare CS-Cart accesați _Add-on-uri_.
3. Căutați în câmpul de introducere/căutare "maib" sau găsiți **Modulul Maib Payment Gateway** în listă.
4. Faceți clic pe butonul _Instalare_ și CS-Cart va începe procesul de instalare.
5. După ce vedeți că add-on-ul a fost instalat cu succes, accesați _Administrare_ > _Metode de plată_ și faceți clic pe „+” (adăugați o metodă de plată).
6. În lista dropdown _Procesorul_ din tabul _General_ căutați sau găsiți **MAIB** și selectați-l. Va apărea un nou tab _Configurați_.
7. În tabul _Configurați_ veți vedea două secțiuni: _Setări maibmerchants.md_ și _Setãri stare comandã_. Completați toate câmpurile necesare și faceți clic pe butonul _Creați_.

## Setări
1. Project ID - Project ID din maibmerchants.md
2. Project Secret - Project Secret din maibmerchants.md. Este disponibil după activarea proiectului.
3. Signature Key - Signature Key pentru validarea notificărilor pe Callback URL. Este disponibil după activarea proiectului.
4. Ok URL / Fail URL / Callback URL - adăugați aceste link-uri în câmpurile respective ale setărilor Proiectului în maibmerchants.
5. Plată în așteptare - Starea comenzii când plata este în așteptare.
6. Plată cu succes - Starea comenzii când plata este finalizată cu succes.
7. Plată eșuată - Starea comenzii când plata a eșuat.
8. Platã returnatã - Starea comenzii când plata este returnată. Pentru returnarea plății, actualizați starea comenzii la starea selectată aici (vedeți _refund.png_).

## Depanare
Dacă aveți nevoie de asistență suplimentară, vă rugăm să nu ezitați să contactați echipa de asistență ecommerce **Modulul Maib Payment Gateway**, expediind un e-mail la ecom@maib.md.

În e-mailul dvs., asigurați-vă că includeți următoarele informații:
- Numele comerciantului
- Project ID
- Data și ora tranzacției cu erori
- Erori din fișierul cu log-uri