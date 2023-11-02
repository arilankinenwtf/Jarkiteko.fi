# Uuden Concrete5 sivustoprojektin aloitus


## Lyhyesti:
1. Luodaan Zoneriin uusi käyttäjä (jos sivusto siirtyy meille) tai tehdään dev-käyttäjän alle kehityssivusto (jos sivusto julkaistaan muualle) ja luodaan tietokanta
2. Tehdään Concrete5-asennus palvelimelle public_html kansioon (deville uusi kansio sen alle)
3. Tehdään Githubissa tästä reposta kopio napilla "Use this template" ja haetaan se omalle koneelle (git clone)
4. Muutetaan .lando.yml sekä .env tiedostoon oikeat tiedot (ja tallenna .env sisältö enpassiin)
5. Lisätään Actions secretit Githubiin
6. Lisätään Zoneriin oma ja Githubin SSH-avain (devillä ne on jo valmiina)
7. Ajetaan projektissa `lando composer install`, `lando start` ja `lando pull-start`, niin saadaan lokaali kehitysympäristö pystyyn ja palvelimelta haettua tietokanta+C5-tiedostot
* Kehitetään teemaa ja blockeja lokaalissa, sisältömuutokset kannattaa tehdä palvelimella olevaan sivustoon, ja tarvittaessa hakea ne lokaaliin `lando pull-db` -komennolla. Teeman ja blockin muutokset menee aina GitHubin kautta, eli pusketaan muutokset ja tehdään pull request -> Github Actions ajaa muutokset palvelimelle.

...................................


### 1. Käyttäjä ja uusi tietokanta
- kirjaudu DirectAdminiin esim. https://www33.zoner.fi:2222
- kirjaudu käyttäjänä:
  - Jos tehdään uusi käyttäjä: Add user (luo käyttäjä ja kirjaudu sitten sillä)
  - Jos tehdään dev-käyttäjän alle: List Users -> dev -> Login as user
- MySQL management -> Create database

### 2. Concrete5-asennus palvelimelle
#### Vaihtoehto 1 (hae ja pura ZIP)
  - Hae uusin Concrete versio concretecms.com/download (zip)
  - Ota Filezillalla yhteys palvelimelle ja vie zip oikeaan kansioon (public_html, tai devillä luo uusi kansio sen alle)
  - Ota SSH-yhteys palvelimeen (esim. `ssh dev@www33.zoner.fi`)
  - Mene kansioon jossa zippi on (esim. `cd public_html`) ja aja `unzip concretepaketinnimi.zip`
  - Purkaessa concrete-tiedostot menee uuteen kansioon, siirrä ne sieltä ylempään kansioon (helppo siirtää Filezillalla)

#### Vaihtoehto 2 (hae concrete composerilla)
  - Ota SSH-yhteys palvelimeen (esim. `ssh dev@www33.zoner.fi`) ja siirry oikeaan kansioon (esim. `cd public_html` tai devillä luo uusi kansio sen alle)
  - hae Concrete5 asennustiedostot composerilla: `composer create-project -n concrete5/composer projektin_nimi` (tämä luo uuden kansion nimeltä projektin_nimi)

#### Kun concrete-tiedostot on haettu:
- siirry kansioon jossa tiedostot on
- aloita C5-asennus komennolla, muuta tähän oikeat tiedot: `php -c /etc/php_composer.ini concrete/bin/concrete5 c5:install --db-server=database --db-username=lamp --db-password="lamp" --db-database=lamp --site="Sivuston nimi" --starting-point=elemental_blank --admin-email=admin@wtfdesign.fi --admin-password="salasana" --language=fi_FI --site-locale=fi_FI`

* joillain palvelimilla asennuksen voi suorittaa myös selaimesta, mutta Zonerissa se ei ole toiminut
* jos asennuksen jälkeen selaimeen tulee is_dir() errori, lisää palvelimelle application/config/ kansioon tiedosto concrete.php, jossa on tämä sisältö:
```php
<?php
return array(
    'session' => array(
        'handler' => 'database'
    )
);
```

### 3. Uusi GitHub repo:
- Tehdään Githubissa tästä Concrete-projektipohjasta kopio napilla "Use this template". Anna uudelle repolle nimeksi sivuston nimi, esim. Domain.fi
- Haetaan uusi repo omalle koneelle: `git clone --recursive git@github.com:WTF-Design/<uuden-git-kansion-nimi-tahan>.git`
- asenna paketit komennolla: `composer install`
- aja komento `git submodule update --remote --merge` (päivittää mahdolliset submoduulit)
- muuta .lando.yml tiedostoon projektin nimi kohtaan `name: muuta_tahan_projektin_nimi`
- lisää .env tiedot (alla ohje)

### 4. TÄRKEÄ: Tarkista löytyykö env tiedot enpassista ja kopioi tiedot sieltä. Mikäli .env tiedostoa ei löydy enpassista, muuta tässä vaiheessa .env tiedoston oikein polut ja tunnukset:
- `CONCRETE5_ENV=development/local` tämä saa jäädä näin
- `LP_DB_USER=dev_wtfdev` muuta tähän tietokannan käyttäjänimi (jos eri kuin dev)
- `LP_DB=dev_c5testi` muuta tähän tietokannan nimi
- `LP_DB_PWD=salasana_enpassista` muuta tähän tietokannan salasana
- `LP_SITE_ROOT=/home/dev/domains/wtf-dev.git@github.com:WTF-Design/new-c5-project-template.git/public_html/c5-testi` muuta tähän oikea polku palvelimella olevan projektin juureen
- `LP_DB_BACK_PATH=/home/dev/domains/wtf-dev.www33.zoner-asiakas.fi/backups/c5-testi/db/c5testi.sql`muuta tähän polku johon tietokantadumppi tallentuu haettaessa
- `LP_FILES_BACK_PATH=/home/dev/domains/wtf-dev.www33.zoner-asiakas.fi/backups/c5-testi/files/c5testi.tar.gz` muuta tähän polku johon tar.gz pakkaus tallentuu haettaessa
- `LP_SSH_CMD=dev@www33.zoner.fi` muuta tähän tarvittaessa ssh-kirjautumiseen vaadittava tunnus@host osoite (jos eri kuin dev)
* Tallenna koko .env tiedoston sisältö enpassiin, josta se on helppo muidenkin hakea

### 5. Ohjeet Github Actions luontiin uudella nettisivulla ja workflown muutoksiin
- GitHubissa määritellään yleinen private key projektille: WTF Design -päänäkymässä (ei projektissa) siirry Settings -> Secrets -> Actions -> **SSH_PRIVATE_KEY** ✏️ Update secret -> Klikkaa rataskuvaketta -> Lisää valinta kys. projektille -> Save changes
- Kopioi enpassista WORKFLOW_SECRET *public-osuus* avaimesta ja lisää se serverin .ssh kansioon authorized_keys tiedostoon (tai DirectAdminissa SSH-asetuksissa)
- Lisää käyttäjätunnus **REMOTE_USER**-secretiksi, esim `dev`
- Lisää palvelimen osoite **REMOTE_HOST**-secretiksi, esim. `www33.zoner.fi`
- Lisää palvelimen `public_html`-polku **TARGET** secretiksi, esim: `/home/username/domains/domainname.fi/public_html`
  - esim. FileZillasta tai `.env`-tiedostosta löytää oikean polun
  - Tästä asetuksesta ja [.github/workflows](.github/workflows)-hakemiston jobien SOURCE-määrittelystä löytyy erilaisia versioita eri projekteista. Osassa pusku tuotantoon rajoittuu `application`-hakemistoon. Tässä on kuitenkin 2022-11-04 toimivaksi vahvistettu yhdistelmä, joka synkkaa kaiken `www`:n alla.
    - `SOURCE: "www/"` -> **TARGET**: `[...]/public_html`

Mikäli käytetään erillistä staging sivustoa täytyy kaikki vaiheet tehä myös repoon sekä staging serverille. Ainoa ero on, että secret muuttujien perään lisätään _STAGING

Linkki käytetyn actionin dokumentaatioon: https://github.com/marketplace/actions/ssh-deploy

..................................


## Ennen kehittämistä tehtävät jutut
Kannattaa tehdä suoraan palvelimelle
(vois tutkia saako näitä automatisoitua configeilla ym)

*.htaccess ym*
- lisää palvelimelle sivustolle salasanasuojaus .htaccess ja .htpasswd tiedostoilla, jos luotiin uusi käyttäjä. (devissä on valmiiksi salasanasuojaus `wtfdesign`/`wtfdev2020`)
- Varmista, että palvelimella sivuston kansiossa on .htaccess tiedosto, jossa on vähintään tämä (tämä poistaa index.php:n urlista):
````
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME}/index.html !-f
RewriteCond %{REQUEST_FILENAME}/index.php !-f
RewriteRule . index.php [L]
</IfModule>
````
* Huom, muuta `RewriteBase /`kohtaan `RewriteBase /kansionnimi` jos sivusto on devillä omassa kansiossaan

*Järjestelmä ja asetukset*
- Asenna Suomen kieli /index.php/dashboard/system/basics/multilingual
- Asenna teema (muista muuttaa koodissa ensin teeman nimi, kuvaus jne) /index.php/dashboard/pages/themes
- Kirjautumisen kohdesivu -> tämä usein parempi ohjata kotisivulle
- Myöhemmässä vaiheessa yleensä otetaan käyttöön SMTP-asetukset (Sähköposti-asetuksissa), ei tarvitse asentaa heti alussa

*Muut*
- Lisää palvelimelle app.php tiedosto, jossa määritellään login-sivu käyttämään teeman tyyliä. Se pitää viedä Filezillalla palvelimelle.
- Lisää `404` niminen pino
- Lisää `Mobile Menu` niminen pino
