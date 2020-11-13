<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eco dom</title>
  <!-- Bootstrap modifié de scss à css (uniquement des couleurs ont été changées) -->
  <link rel="stylesheet" href="css/bootstrap_modifié.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js" integrity="sha512-WNLxfP/8cVYL9sj8Jnp6et0BkubLP31jhTG9vhL/F5uEZmg5wEzKoXp1kJslzPQWwPT1eyMiSxlKCgzHLOTOTQ==" crossorigin="anonymous"></script>
  <script src="bootstrap-4.5.3/dist/js/bootstrap.js"></script>

  <!-- CSS Perso -->
  <style>
    .logo {
      width:150px;
    }

    .d-block {
      height:800px;
    }

  </style>
</head>

<body>

  <!-- navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="ecodom.php"><img class="logo" src="img/logo.png" alt="logo eco'dom"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="ecodom.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="photovoltaiques.php">Nos photovoltaïques</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="eoliennes.php">Nos éoliennes</a>
        </li>
      </ul>
    </div>
  </nav>

  <img src="img/windmill-62257_1920.jpg" class="d-flex m-auto w-50" alt="éolienne">

  
    <h2 class="text-center mb-4">Nos Eoliennes</h2>


    <?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=offres;charset=utf8', 'root', '');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

$reponse = $bdd->query('SELECT * FROM offres WHERE designation LIKE "%eolienne%" ORDER BY prix');

while ($donnees = $reponse->fetch()){

?>

<table class="table table-striped m-auto w-50">
  <tbody>
    <tr>
      <td class="col-4"><a href="#"><?php echo $donnees['designation']?></a></td>
      <td class="col-4"><?php echo $donnees['détails']?></td>
      <td class="col-4"><?php echo $donnees['prix']?></td>
    </tr>
  </tbody>
</table>
   

    <?php
}
$reponse->closeCursor();
    ?>


  <div class="text-center mt-4">
  <h4>Nos coordonnées</h4>
    <p>ECO'DOM</p>
    <p>197 Rue du Soleil - 84000 Avignon</p>
    <p>Téléphone : 0892 05 06 07</p>
    <p>Email : ecodom84@gmail.com</p>
  </div>

</body>

</html>