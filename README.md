
# Welkom op mijn eindexamen opdracht!!
- Floris van Kleef 2C 2166895
 
In mijn eindexamen opdracht ga ik laten zien wat ik heb gemaakt, en hoe alles werkt. Ik heb een database gemaakt in mysql (xampp) en heb zo de code gemaakt om de wachtwoorden te hashen, zodat deze beveiligd zijn en niemand ze kan zien.   

# Opdracht beschrijving.

Ik heb de opdracht gekregen om een website te maken voor een restaurant. Het menu moet via een laptop te zien zijn, en moet makkelijk te gebruiken zijn voor zowel personeel als de klant. 

Ik ga een php project maken die een menu displayed, die ervoor zorgt dat de klant kan zien wat er te bestellen is, dit vervolgens doet en zo wordt het doorgestuurd naar de keuken. Ik heb de website toegankelijk gemaakt door alle producten op een plek te zetten, en het makkelijk te maken voor de klant om dingen toe te voegen aan de bestelling.



Ik moest verschillende user stories bedenken, en deze vervolgens uitwerken in mijn code. Ik heb de userstories één voor één aangepakt en uitgewerkt.   
**User Stories**    
ik heb deze user stories uitgewerkt in mijn project.
   
2. Als restaurantbezoeker wil ik een bestelling kunnen plaatsen via het 
menu zodat ik sneller geholpen word zonder te wachten op 
personeel. 
3. Als restaurantbeheerder wil ik alle bestellingen realtime kunnen 
inzien zodat ik de keuken efficiënter kan laten werken. 
4. Als restaurantbeheerder wil ik de inhoud van het menu kunnen 
bewerken zodat ik gemakkelijk wijzigingen kan doorvoeren (zoals 
nieuwe gerechten of prijzen). 
5. Als restaurantbezoeker wil ik een bevestiging van mijn bestelling 
ontvangen zodat ik zeker weet dat deze correct is verwerkt.


Ik gebruik GitHub op mijn repository te bewerken en op te slaan. Ook hou ik hier het versiebeheer bij. Ik doe dit met GitHub, omdat het voor mij makkelijk in gebruik is, en GitHub is gemakkelijk te linken met Microsoft Visual Studio. Hierdoor staat alles gelijk online en kan ik het snel laten zien.     

Ik vind het belangrijk om een repository en versiebeheer te gebruiken, omdat dit een backup biedt voor als er iets onverwachts gebeurd met bijvoorbeeld je laptop of pc.    

---
```
<?php   
require_once 'db-conn.php';   

$result = $conn->query("SELECT id, password FROM users");   
   
while ($row = $result->fetch_assoc()) {   
    $hashed_password = password_hash($row['password'], PASSWORD_BCRYPT);   
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");   
    $stmt->bind_param("si", $hashed_password, $row['id']);    
    $stmt->execute();    
}    
 
echo "Alle wachtwoorden zijn nu gehashd!";    
  

unlink(__FILE__)    
?>  
```
Bij versie 0.02 heb ik wat dingen toegevoegd aan de homepagina, en heb ik mijn resultaten wat meer verbeterd. Ik heb er voor gezorgd dat je dingen kan bestellen. Ik had wat fouten met de naam van het product, deze werd niet doorgestuurd naar mijn database.   


Bij versie 0.03 heb ik heel erg veel dingen toegevoegd. Ik wilde meerdere commits maken, maar dit zit nog niet zo in mijn systeem. Er zijn veel dingen veranderd zoals de bon en bon-klant. Je kan nu zien wat je hebt besteld en bij de kassa kunnen ze nu ook zien wat voor dingen je allemaal hebt besteld. Je kan nu ook bij de kassa je bon afrekenen. 

Ook heb ik de backend gemaakt voor de keuken, zodat deze kan zien wat bijvoorbeeld tafel 1 heeft besteld, en die kunnen ze aanpassen zodat het gemaakt of geserveerd kan worden. Dit is er zodat het personeel weet wat ze nog moeten maken en wat er al klaar is. 

In het admin-dashboard staat de kassa ook. Hier kan de kassa zien wat welke tafel heeft besteld, om vervolgens de betaling door te voeren en de bon te printen. In het admin-dashboard staat ook een knop voor ‘producten toevoegen’ zoals in de user stories al stond “ als restaurant eigenaar wil ik gemakkelijk gerechten/drinken toevoegen aan een bestelling “. Om deze reden heb ik dit toegevoegd aan het admin-dashboard. 

De admin inlog is gehasd, dus deze is veilig. In versie 0.03 heb ik ook aanpassingen gedaan aan de database en aan de home.php. 

Als eerste heb ik een table gemaand admin gemaakt voor de admins, en bij orders heb ik TVG, toevoegingen, toegevoegd. Als een klant bijvoorbeeld bij zijn pasta extra kaas wilt, kan deze dat daar melden en dat wordt dan doorgestuurd naar de keuken. 

Dit staat dus ook in de home.php. Hierin heb ik, zoals eerder genoemd, een optie voor bon inzien toegevoegd, zodat ze klant tussendoor kan kijken wat er besteld is en wat de totaal prijs is. 
Er kwam wel een fout voor. Het gerecht kwam niet op de homepagina terecht, maar alleen de beschrijving van deze. Dit heb ik aangepast en nu werkt het wel zoals het moet.

Bij versie 0.04 en 0.05 heb ik de sql databse toegevoegd dit heb ik gedaan zodat je het gemakkelijk kan instaleren en gebruiken.

# Hierbij de Instalatie handleiding.

Installatiehandleiding voor XAMPP en een PHP-project    
- **Stap 1: Download en installeer XAMPP**
Ga naar de officiële website van XAMPP: [url](https://www.apachefriends.org/)
Download de juiste versie van XAMPP voor jouw besturingssysteem.
Open het installatiebestand en volg de instructies om XAMPP te installeren.
- **Stap 2: Plaats je project in de juiste map**
Navigeer naar de installatiemap van XAMPP (standaard is dit C:\xampp).
Open de map htdocs.
Kopieer en plak je PHP-projectmap in htdocs.
- **Stap 3: Start Apache en MySQL**
Open het XAMPP Control Panel.
Start de Apache-server door op de knop Start naast "Apache" te klikken.
Start de MySQL-server door op de knop Start naast "MySQL" te klikken.
- **Stap 4: Importeer de database**
Klik in het XAMPP Control Panel op Admin bij MySQL om phpMyAdmin te openen.
In phpMyAdmin, klik bovenaan op het tabblad Importeren.
Klik op Bestand kiezen en selecteer het databasebestand (database.sql of feopdr.sql).
Klik op Starten om de database te importeren.
- **Stap 5: Open het project in de browser**
Open een webbrowser.
Ga naar [url](http://localhost/dashboard/) om te controleren of XAMPP correct werkt.
Verander de URL naar [url](http://localhost/examen%20floris%20van%20kleef%202c/login.php) om naar het inlogscherm van je project te gaan.
Je project draait nu lokaal op jouw apparaat en is niet toegankelijk voor anderen. Je kunt nu aan de slag met het testen en ontwikkelen van je PHP-project!
