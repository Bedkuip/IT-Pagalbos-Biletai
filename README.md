# IT-Pagalbos-Biletai
Bendrieji projekto reikalavimai:
Parengta ir su dėstytoju suderinta projekto užduotis. Minimalūs užduoties apimties reikalavimai:
bent 3 taikomosios srities objektai tarpusavyje susieti prasminiu ir hierarchiniu ryšiu (pvz.: tema->įrašas->komentaras);
bent 5 sąsajos (API) metodai (4 CRUD metodai ir 1 metodas grąžinantis sąrašą) kiekvienam taikomosios srities objektui;
Iš viso 15 skirtingų API metodų.
bent 1 iš realizuotų sąsajos (API) metodas turi būti hierarchinis, pvz.: grąžinti visus konkretaus namo butus.
bent 3 rolės (pvz.: svečias, narys, administratorius); 
Programinis sprendimas turi naudoti duomenų bazę;
Projektas turi būti realizuotas taikant REST principus;
Turi būti realizuota autentifikacija ir autorizacija naudojant OAUTH2 arba JWT (naudojant JWT pasirinkti tinkamą žetonų atnaujinimo strategiją);
Parengta grafinė naudotojo sąsaja (GUI);
Realizuotas produktas turi būti pasiekiamas saityne, tam panaudojant debesų technologijas.
Parengta sukurto programinio produkto dokumentacija: uždavinio aprašymas, architektūros diagrama, sąsajų specifikacija naudojant OpenAPI, panaudojimo pavyzdžiai, darbo išvados.

Reikalavimai 1 laboratorinam darbui
Suprojektuoti ir realizuoti REST principais veikiančią API sąsają. Turi būti realizuoti visi užduotyje numatyti API sąsajos metodai!
Pateikti OpenAPI specifikaciją kiekvienam API metodui;
Paruošti programavimo aplinką leidžiančią atsiskaitymo metu patogiai paleisti ir pademonstruoti programą.
Duomenų saugojimui turi būti panaudotas pasirinktas DB sprendimas. Gynimo metu DB turi būti užpildyta prasmingais (uždavinį atitinkančiais) duomenimis;
Turi būti galimybė iškviesti sąsajos funkcijas (naudojantis naršykle, Postman ar kitu įrankiu) ir gauti teisingai suformuotą atsakymą: prasmingas turinys, teisingas turinio tipas (json, xml, atom, text ar kt.), teisingas atsako kodas (http reponse code);
Pasiruošti ir pademonstruoti, jog veikia visi 15 API metodų. Demonstracija turėtų trukti iki ~15s. Pavyzdžiui, su Postman collections ir tests. Taupome jūsų ir savo laiką. Papildomai pasiruošti pademonstruoti:
Kai resursas negali būti rastas (turi grąžinti 404)
Kai paduodamas blogas payload, turi grąžinti 400/422 priklausomai nuo situacijos
Kai resursas sukuriamas - 201
Kai resursas ištrinamas - 200/204 priklausomai, ar grąžinamas response body
Projekto kodas turi būti laikomas Git saugykloje (github, bitbucket, gitlab ar kt.). Dokumentacija - projektui sukurtame wiki arba projekto kodo Git saugykloje (.readme).
