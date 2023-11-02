Tänne voidaan tallentaa eri versiot .htaccessista, niin löytyy tarvittaessa helposti. Lokaalin kehitysympäristön htaccess löytyy www-kansiosta.

## password-protect
Tämän kansion .htaccess ja .htpasswd/ avulla saa laitettua kehityssivuston palvelimella salasanasuojatuksi.
- Vie .htpasswd/ kansio palvelimella domainin kansioon (huom. *ei* public_html:ään)
- Muuta .htaccess tiedostoon oikea polku joka osoittaa tuohon .htpasswd tiedostoon

## production
Tämän kansion .htaccess on käytettäväksi julkaistulla sivustolla. Käy sellaisenaan, mutta muista lisätä ensin SSL-suojaus sivustolle (htaccessissa on ohjaus https://www... alkuiseen osoitteeseen)