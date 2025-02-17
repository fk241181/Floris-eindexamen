
# Welkom op mijn eindexamen opdracht!!
- Floris van Kleef 2C 2166895


    
hierin ga ik laten zien wat ik heb gemaakt en hoe het werkt 
ik heb een datebase gemaakt in mysql (xampp) en heb zo de code gemaakt om de password te hashen zodat niemand het kan lezen
---

   
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
