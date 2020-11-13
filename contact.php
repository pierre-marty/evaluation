<?php
   $servername = "localhost";
   $username = "root";
   $password = "";


   
   try {
     $conn = new PDO("mysql:host=$servername;dbname=offres", $username, $password);
     // set the PDO error mode to exception
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     echo "Connected successfully";
   } catch(PDOException $e) {
     echo "Connection failed: " . $e->getMessage();
   }

   $sql = "INSERT INTO clients (nom) VALUES (:nom)";
		$query = $conn->prepare($sql);
		$query->bindValue(':nom',  PDO::PARAM_STR); // Paramètre STR comme chaine de caractère
    $query->execute();
        
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="css/bootstrap_modifié.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js" integrity="sha512-WNLxfP/8cVYL9sj8Jnp6et0BkubLP31jhTG9vhL/F5uEZmg5wEzKoXp1kJslzPQWwPT1eyMiSxlKCgzHLOTOTQ==" crossorigin="anonymous"></script>
    <script src="bootstrap-4.5.3/dist/js/bootstrap.js"></script>

    <style>

        body {
            max-width:1000px;
            margin:auto;
        }
    
    </style>
</head>
<body>

<form method="POST">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="nom">Nom</label>
      <input type="text" class="form-control" id="nom">
    </div>
    <div class="form-group col-md-6">
      <label for="prenom">Prénom</label>
      <input type="text" class="form-control" id="prenom" name="prenom">
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Adresse</label>
    <input type="text" class="form-control" id="adresse" placeholder="1234 Main St">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="code_postal">Code Postal</label>
      <input type="text" class="form-control" id="code_postal">
    </div>
    <div class="form-group col-md-4">
      <label for="villee">Ville</label>
      <input type="text" class="form-control" id="ville">
    </div>
    <div class="form-group col-md-4">
      <label for="villee">Télephone</label>
      <input type="text" class="form-control" id="telephone">
    </div>
  </div>
  <button type="submit" value="Envoyer" class="btn btn-primary">Envoyer</button>
</form>

<p>Les données envoyées par ce formulaire seront les votres et ne sont pas utilisées ou vendues à d'autres agences.</p>

<a href="ecodom.php">Retour accueil</a>
</body>
</html>