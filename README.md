#	Sistemos uždavinio aprašymas

1.1.	Sistemos paskirtis

Ši sistema siekia sucentruoti technines pagalbos užklausas, norint užtikrinti skaidrią komunikaciją ir greitinti problemų sprendimą.
Sistemos sandara yra iš dviejų dalių:
•	Internetinė svetainė, kurią naudoja darbovietės atstovas. Čia jis gales kurti ir stebėti biletus.
•	API, kuriuo vykdomi duomenų mainai ir JWT technologijomis užtikrinamas konfidencialumas.

1.2.	Funkciniai reikialavimai

Sistema pagrįsta hierarchiniu ryšiu:
Darbovietė → Bilietas → Įrenginys
•	Darbovietė: vartotojo identifikacija, priskirti įrenginiai, priskirti sukurti biletai.
•	Biletas: kūrimas bileto, peržiūra, redagavimas, sąrašo filtravimas.
•	Įrenginys:  sąrašo gavimas, filtravimas pagal būsena.

1.3.	Sistemos architektūra

Žemiau pavaizduota sistemos diagrama. Sistema talpinama Railway debesų serveryje, kuris sukuria HTTPS protokolą. REST principai įgyvendinti naudojant API, kuris skirtas užtikrinti leistiną CRUD naudojimą ORM komunikacijai tarp SQLite duombazės.
 
#	Naudotojo sąsajos projektas

2.1.	Atitinkantys langai:

Pirmasis langas įvedus svetainę (Prisijungimo langas): 

---------------------------------
|           LOGO                |
---------------------------------
|        Prisijungimo forma     |
|  [Email]                      |
|  [Slaptažodis]                |
|  [Prisijungti]                |
---------------------------------
|        Footer info            |
---------------------------------


Valdymo skydas:

-----------------------------------------------------
| LOGO | Meniu (desktop) / Hamburger (mobile)       |
-----------------------------------------------------
|  Kortelė: Visi bilietai   |  Kortelė: Įrenginiai  |
-----------------------------------------------------
|   Paskutiniai biletai     | Naujas Biletas        |
-----------------------------------------------------
|                      Biletai                      |
-----------------------------------------------------
| Footer                                            |
-----------------------------------------------------


Bileto sukūrimo/redagavimo puslapis:

-----------------------------------------------------
| Header + Meniu                                    |
-----------------------------------------------------
| Naujas bilietas (Redaguoti biletą)                |
-----------------------------------------------------
| [Darbovietes Pavadinimas - dropdown]              |
| [Įrenginys - dropdown]                            |
| [Prioritetas - dropdown]                          |
| [Statusas - dropdown]                             |
| [Specialistas - textarea]                         |
| [Aprašymas - textarea]                            |
| [Sukurti (Išsaugoti)]                             |
-----------------------------------------------------
| Footer                                            |
-----------------------------------------------------

Bileto peržiūros langelis (Modal):

-----------------------------------------------------
| X (uždaryti)                                      |
-----------------------------------------------------
| Bilieto pavadinimas                               |
| Statusas                                          |
| Aprašymas                                         |
| Susietas įrenginys                                |
| Veiksmai: [Redaguoti] [Trinti]                    |
-----------------------------------------------------


Biletų sąrašo puslapis, jei neleistinas vartotojas duomenys nepateikiami:

 -----------------------------------------------------
| Header + Meniu                                     |
------------------------------------------------------
| [Filtras] [Paieška] [Naujas bilietas]              |
------------------------------------------------------
| # | Statusas    | Priority | Sukurta   | Veiksmai  |
------------------------------------------------------
| 1 | ...         | ...      | ...       | [C/R/D]   |
| 2 | ...         | ...      | ...       | [C/R/D]   |
------------------------------------------------------
| Footer                                             |
------------------------------------------------------


Įrenginių sąrašo puslapis:

 -----------------------------------------------------
| Header + Meniu                                     |
------------------------------------------------------
| [Filtras] [Paieška] [Naujas bilietas]              |
------------------------------------------------------
| # | Pavadinimas | Tipas | Statusas | Specialistas  |
------------------------------------------------------
| 1 | ...         | ...      | ...       | ...       |
| 2 | ...         | ...      | ...       | ...       |
------------------------------------------------------
| Footer                                             |
------------------------------------------------------
 
#	API specifikacija

API pritaiktas CRUD implementacijai ir JWT tokenų realizacijai. 
Detalizuota API specifikacija pasiekiama /api/documentation svetainėje arba api-docs.json faile.

#	Išvados

Projektas, kuris sukurtas pritaikant modernius saugumo ir inkapsuliacijos metodus sėkmingai gali būti pritaikytas rinkai. Kadangi jo tikslas darbuotojams prisijungti ir pateikti norimas užklausas, saugumo reikalavimai riboti, o JWT technologijos skirtos duomenų nutekėjimo prevencijai. Integracija į debesija yra, bet nėra projekto atžvilgiu nėra aktuali, nebent imonė yra kelių lokacijų.


