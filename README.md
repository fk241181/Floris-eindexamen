
# Welkom op mijn eindexamen opdracht!!
- Floris van Kleef 2C 2166895

In mijn eindexamen opdracht ga ik laten zien wat ik heb gemaakt, en hoe alles werkt. Ik heb een database gemaakt in mysql (xampp) en heb zo de code gemaakt om de wachtwoorden te hashen, zodat deze beveiligd zijn en niemand ze kan zien.     

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
