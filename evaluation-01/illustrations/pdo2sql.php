<?php 
// Déclaration des variables CONSTANTES de connexion
include("_variables.php"); // Prenez votre fichier  -ou- remplir en dessous
/*
	Sinon redéfinir ici
	DEFINE("BDD", "votrebdd");
	DEFINE("USER", "utilisateur");
	DEFINE("HOST", "localhost");
	DEFINE("PASSW", "motdepasse");
*/

$balise_titre="Exemples SELECT, INSERT, UPDATE et DELETE (pdo2sql.php)"; // Pour afficher la balise title et h1

$alerte_info=""; // Initialisation comme étant vide par défaut

	
	if(isset($_REQUEST['quelle_action'])){			$quelle_action=$_REQUEST['quelle_action']; }else {$quelle_action="";}
	
	if(isset($_POST['titre_univers'])){				$titre_univers=$_POST['titre_univers']; }else {$titre_univers="";}
	
	if(isset($_REQUEST['id_de_lunivers'])){			$id_de_lunivers=$_REQUEST['id_de_lunivers']; }else {$id_de_lunivers="";}

	if(isset($_GET['id_a_effacer'])){				$id_a_effacer=$_GET['id_a_effacer']; }else {$id_a_effacer="";}
	
	

	// Si j'ai cliqué sur le bouton de suppression pour demander la suppression ET que id_a_effacer n'est pas vide
	if($quelle_action=="effacer" && $id_a_effacer!="") {

		try {
			$db= new PDO("mysql:host=$MONHOST;dbname=".BDD.";charset=utf8mb4", USER, PASSW);
		}

		catch (PDOException $exception){
			echo "<div class=\"alert alert-danger\">Erreur PDO : ".$exception->getMessage()."</div>";
		}

		// Connexion OK, alors on prépare la requete et on l'execute
		$sql = "DELETE FROM univers WHERE id_univers=:id_a_effacer";
		$query = $db->prepare($sql);
		$query->bindValue(':id_a_effacer', $id_a_effacer, PDO::PARAM_INT); // Paramètre INT comme entier
		$query->execute();
		//echo "<div style=\"z-index:1; margin-top:50px;\">$sql</div>"; // Pour réafficher la requete si besoin

		// Préparation du message pour l'action qui vient d'etre faite
		$alerte_info= "<div class=\"alert alert-warning\">Ligne effacée</div>";
	}
	/*
	else {
		// Pour débuger
		echo "PAS BON quelle_action $quelle_action id_a_effacer $id_a_effacer";
	}
	*/





	// Si j'ajoute un nouvel univers ET que le titre_univers n'est pas vide
	if($quelle_action=="ajouter" && $titre_univers!="") {
		try {
			$db= new PDO("mysql:host=".HOST.";dbname=".BDD.";charset=utf8mb4", USER, PASSW);
		}

		catch (PDOException $exception){
			echo "<div class=\"alert alert-danger\">Erreur PDO : ".$exception->getMessage()."</div>";
		}

		$sql = "INSERT INTO univers (titre_univers) VALUES (:titre_univers)";
		$query = $db->prepare($sql);
		$query->bindValue(':titre_univers', strip_tags($titre_univers), PDO::PARAM_STR); // Paramètre STR comme chaine de caractère
		$query->execute();
		//echo "<div style=\"z-index:1; margin-top:50px;\">$sql</div>"; // Pour réafficher la requete si besoin

		// Préparation du message pour l'action qui vient d'etre faite
		$alerte_info= "<div class=\"alert alert-warning\">Ligne insérée</div>";
	}
	



	// Si je demande une modification ET que j'ai bien l'id_univers ET que le titre_univers n'est pas vide
	if($quelle_action=="modifier" && $id_de_lunivers!="" && $titre_univers!="") { // Conditions réunies
		try {
			$db= new PDO("mysql:host=".HOST.";dbname=".BDD.";charset=utf8mb4", USER, PASSW);
		}

		catch (PDOException $exception){
			echo "<div class=\"alert alert-danger\">Erreur PDO : ".$exception->getMessage()."</div>";
		}

		// Connexion OK

		$sql = "UPDATE univers SET titre_univers=:titre_univers WHERE id_univers=:id_de_lunivers ";
		$query = $db->prepare($sql);
		
		$query->bindValue(':titre_univers', strip_tags($titre_univers), PDO::PARAM_STR);// Paramètre STR comme chaine de caractère + strip_tags >> Supprime les balises HTML et PHP d'une chaîne (ésécurité) 
		$query->bindValue(':id_de_lunivers', $id_de_lunivers, PDO::PARAM_INT);// Paramètre INT comme entier
		$query->execute();
		//echo "<div style=\"z-index:1; margin-top:50px;\">$sql</div>"; // Pour réafficher la requete si besoin
	
		// Préparation du message pour l'action qui vient d'etre faite
		$alerte_info= "<div class=\"alert alert-warning\">Ligne $id_de_lunivers modifiée + Possibilité de le modifier encore</div>";
	}
	
?>

<!doctype html>
<html lang="fr">
	<?php 
	include("_header.php"); // Contient l'ensemble des balises du head (utile pour les changer une seule fois pour toutes les pages)
	?>
	<body>
		<div class="container" style="margin-top:100px;">
			<h1>
				<?php 
				echo $balise_titre; // Affichage dynamique du contenu de la variable définie en haut de page
				?>
			</h1>

			<div class="row">
				<div class="col-7">

					<?php 
					// Message après la requete SQL si alerte_info n'est pas vide (il a été initialisé en haut de page)
					if($alerte_info!="") {
						echo "$alerte_info"; 
					} // Sinon, il n'affiche rien
					?>


					<?php 
					// Si un lien de modification a été déclenché contenant un id_de_lunivers
					if($id_de_lunivers!="") { 

						// On va rechercher le titre de l'univers pour le réafficher dans le <input name="titre_univers" value="ICI ON LE REAFFICHE" --> 
						try {
							$pdo= new PDO("mysql:host=".HOST.";dbname=".BDD.";charset=utf8mb4", USER, PASSW);
						}

						catch (PDOException $exception){
							echo "<div class=\"alert alert-danger\">Erreur PDO : ".$exception->getMessage()."</div>";
						}
						$sql = "SELECT titre_univers FROM univers WHERE id_univers ='$id_de_lunivers'";
						$query = $pdo->query("$sql");
						$data=$query->fetch();
						$recup_titre_univers=$data['titre_univers'];
						$query->closeCursor();

						$laction_a_faire="modifier";

					}
					else { // Sinon, la prochaine action sera : AJOUTER UN NOUVEL UNIVERS (par défaut)
						$laction_a_faire="ajouter";
					}
					?>

					
					
					
					<!-- formulaire servant à ajouter et modifier -->
					<form action="pdo2sql.php" method="POST">
						
						<div class="input-group pt-2">
							<span class="input-group-text">quelle_action (hidden)</span>
							<!-- Bascule quelle_action dans la variable $laction_a_faire selon que $id_de_lunivers : est vide (ajouter) ou pas vide (modifier)-->
							<input type="text" name="quelle_action" value="<?= $laction_a_faire ?>" class="form-control" readonly>
						</div>

					<?php 
					// Si un lien de modification a été déclenché contenant un id_de_lunivers on récupère $id_de_lunivers pour le renvoyer avec le formulaire
					if($id_de_lunivers!="") { 
					?>
						<div class="input-group pt-2">
							<span class="input-group-text">id_de_lunivers (hidden)</span>
							<input type="text" name="id_de_lunivers" value="<?= $id_de_lunivers ?>" class="form-control" readonly>
						</div>
					<?php 
					// FIN de condition 
					}
					?>

						<div class="input-group pt-2">
							<span class="input-group-text">titre_univers</span>
							<input type="text" name="titre_univers" class="form-control form-control-lg <?=($recup_titre_univers!="") ? "is-valid" : "" ?>" value="<?= $recup_titre_univers ?>">
						</div>

						<button type="submit" class="mt-3 btn btn-block btn-lg btn-primary">Enregistrer en BDD</button>

					</form>
					<!-- Fin du formulaire -->

				</div>






				<div class="col-5">
					<?php
					//Récupération de tous les univers déjà existants
					try {
						$pdo= new PDO("mysql:host=".HOST.";dbname=".BDD.";charset=utf8mb4", USER, PASSW);
					}

					catch (PDOException $exception){
						echo "<div class=\"alert alert-danger\">Erreur PDO : ".$exception->getMessage()."</div>";
					}

					// La connexion est OK, on fait la requete d'affichage des univers déjà créés
					$sql = "SELECT id_univers, titre_univers FROM univers WHERE 1 ORDER BY titre_univers LIMIT 10 ";
					$reponse = $pdo->query("$sql");
					?>					
				
					<!-- Force la possibilité de créer un nouveau -->
					<a href="pdo2sql.php" class="list-group-item list-group-item-action list-group-item-info">Ajouter nouvel univers</a> 
					
					<?php 
					// Affiche la boucle de tous les univers déjà créés
					while ($donnees=$reponse->fetch())
					{
						?>

						<li class="list-group-item list-group-item-action">

						<!-- affiche id_univers et titre_univers sous forme de lien GET pour le modifier -->
						<a href="pdo2sql.php?id_de_lunivers=<?php echo $donnees['id_univers'];?>" class="btn btn-sm btn-transparent"><?php echo "".$donnees['id_univers']." - ".$donnees['titre_univers']."";?></a> 
						
						<!-- Bouton pour supprimer en GET la ligne de données -->
						<a  href="pdo2sql.php?quelle_action=effacer&id_a_effacer=<?php echo $donnees['id_univers'];?>" class="btn btn-sm btn-danger float-right">Supprimer le <?php echo $donnees['id_univers'];?></a>
						
						</li>

						<?php 
					}
					$reponse->closeCursor();
					//FIN Récupération de tous les univers déjà existants
					?>






					<?php
// SECTION D'AIDE pour la table utilisée dans votre BDD
// Effacer toute cette section si cela vous gène -> Alle n'affiche que les noms des champs pour bien vérifier le nommage des champs et de vos requetes SQL
					
					//Récupèration des champs de la table univers pour vous aider sur la structure de la table
					$mysqli = new mysqli(HOST, USER, PASSW, BDD);
					$mysqli->set_charset("utf8");
					$req = "SELECT * FROM univers ";
					$result = $mysqli->query("$req");
					$finfo = $result->fetch_fields();
					echo "<div class=\"alert alert-info\">AIDE Table : univers";
					foreach ($finfo as $val) {
						printf("<li>Champ :      %s\n",   $val->name);
					}
					$result->free();
					echo "</div>";

// FIN SECTION D'AIDE pour la BDD
					?>


					
				</div>
			</div>
		</div>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>
