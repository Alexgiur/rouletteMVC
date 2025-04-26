<?php
session_start();


require_once 'Models/Database.php';
require_once 'Models/Joueur.php';
require_once 'Models/JoueurDAO.php';
require_once 'Models/Partie.php';
require_once 'Models/PartieDAO.php';


$joueurDAO = new JoueurDAO();
$partieDAO = new PartieDAO();


$pageTitle = '';
$message_erreur = '';
$message_info = '';
$message_resultat = '';
$gagne = false;
$joueur = null;


$action = $_GET['action'] ?? 'accueil';

switch ($action) {
    case 'accueil':
        $pageTitle = 'Connexion';
        $message_erreur = $joueurDAO->processConnexion();
        
        require_once 'Views/header.php';
        require_once 'Views/connexion.php';
        require_once 'Views/footer.php';
        break;

    case 'inscription':
        $pageTitle = 'Inscription';
        $message_erreur = $joueurDAO->processInscription();
        
        require_once 'Views/header.php';
        require_once 'Views/inscription.php';
        require_once 'Views/footer.php';
        break;

    case 'connexion':
        $pageTitle = 'Connexion';
        $message_erreur = $joueurDAO->processConnexion();
        
        require_once 'Views/header.php';
        require_once 'Views/connexion.php';
        require_once 'Views/footer.php';
        break;

    case 'roulette':
        // Vérifier que l'utilisateur est connecté
        $joueur = $joueurDAO->getCurrentJoueur();
        if (!$joueur) {
            header('Location: index.php');
            exit;
        }
        
        $pageTitle = 'Jeu de la roulette';
    
        require_once 'Views/header.php';
        require_once 'Views/roulette.php';
        require_once 'Views/footer.php';
        break;

    case 'jouer':
        $pageTitle = 'Jeu de la roulette';
        
        
        $jeuResult = $partieDAO->processJeu();
        
        // Récupérer les variables pour la vue
        $message_erreur = $jeuResult['message_erreur'];
        $message_info = $jeuResult['message_info'];
        $message_resultat = $jeuResult['message_resultat'];
        $gagne = $jeuResult['gagne'];
        $joueur = $jeuResult['joueur'];
        
        require_once 'Views/header.php';
        require_once 'Views/roulette.php';
        require_once 'Views/footer.php';
        break;

    case 'deconnexion':
        $joueurDAO->processDeconnexion();
        break;
        
    default:
        $pageTitle = 'Erreur 404';
        $message_erreur = 'Page non trouvée';
        require_once 'Views/header.php';
        echo '<div class="alert alert-danger">Page non trouvée</div>';
        require_once 'Views/footer.php';
        break;
}