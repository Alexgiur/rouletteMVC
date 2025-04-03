<?php
require_once('joueur.php');

class JoueurDAO {

	private ?PDO $bdd;

	public function initialiseConnexionBDD() {
	$bdd = null;
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=roulette_cybersecu;charset=utf8', 
			'root', 
			''
		);	
	} catch(Exception $e) {
		die('Erreur connexion BDD : '.$e->getMessage());
	}

	return $bdd;
}

    public function connecteUtilisateur($utilisateur, $motdepasse) {
	$res = '';
	$bdd = initialiseConnexionBDD();
	if($bdd) {
		$sql = 'SELECT * FROM roulette_joueur 
		WHERE nom ="'.$utilisateur.'" AND motdepasse = "'.$motdepasse.'";';
		$result = $bdd->query($sql);
		/* DEBUG pour vérifier la requête
			var_dump($sql);
			var_dump($result->fetch());
			die();
		 */
			$data = $result->fetch();
		if($data) {
			$_SESSION['joueur_id'] = intval($data['identifiant']);
			$_SESSION['joueur_nom'] = $data['nom'];
			$_SESSION['joueur_argent'] = intval($data['argent']);
		} else {
			$res = 'Utilisateur inconnu ou mot de passe erroné';
		}
	}
	return $res;	
}

    public function ajouteUtilisateur($nom, $motdepasse) {
	$bdd = initialiseConnexionBDD();
	if($bdd) {
		$query = $bdd->prepare('INSERT INTO roulette_joueur (nom, motdepasse, argent) VALUES (:t_nom, :t_mdp, 500);');
		$query->execute(array('t_nom' => $nom, 't_mdp' => $motdepasse));
	}
}

    public function majUtilisateur($id_joueur, $argent) {
	$bdd = initialiseConnexionBDD();
	if($bdd) {
		$query = $bdd->prepare('UPDATE roulette_joueur SET argent = :t_argent WHERE identifiant = :t_id;');
		$query->execute(array('t_argent' => $argent, 't_id' => $id_joueur));
	}
}
}