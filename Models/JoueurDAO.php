<?php
require_once 'Models/Database.php';
require_once 'Models/Joueur.php';

class JoueurDAO {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getPDO();
    }
    
    public function findById($id) {
        $stmt = $this->db->prepare('SELECT * FROM roulette_joueur WHERE identifiant = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        
        if (!$data) {
            return null;
        }
        
        return new Joueur(
            $data['identifiant'],
            $data['nom'],
            $data['motdepasse'],
            $data['argent']
        );
    }
    
    public function findByCredentials($nom, $motdepasse) {
        $stmt = $this->db->prepare('SELECT * FROM roulette_joueur WHERE nom = ? AND motdepasse = ?');
        $stmt->execute([$nom, $motdepasse]);
        $data = $stmt->fetch();
        
        if (!$data) {
            return null;
        }
        
        return new Joueur(
            $data['identifiant'],
            $data['nom'],
            $data['motdepasse'],
            $data['argent']
        );
    }
    
    public function create(Joueur $joueur) {
        $stmt = $this->db->prepare('INSERT INTO roulette_joueur (nom, motdepasse, argent) VALUES (?, ?, ?)');
        $stmt->execute([
            $joueur->getNom(),
            $joueur->getMotdepasse(),
            $joueur->getArgent()
        ]);
        
        $joueur->setId($this->db->lastInsertId());
        return $joueur;
    }
    
    public function update(Joueur $joueur) {
        $stmt = $this->db->prepare('UPDATE roulette_joueur SET argent = ? WHERE identifiant = ?');
        return $stmt->execute([
            $joueur->getArgent(),
            $joueur->getId()
        ]);
    }
    
    public function processConnexion() {
        $message_erreur = '';
        
        if (isset($_POST['btnConnect'])) {
            if (isset($_POST['nom']) && $_POST['nom'] != '' &&
                isset($_POST['motdepasse']) && $_POST['motdepasse'] != '') {
                
                $joueur = $this->findByCredentials($_POST['nom'], $_POST['motdepasse']);
                
                if ($joueur) {
                    // Connecter l'utilisateur
                    $_SESSION['joueur_id'] = $joueur->getId();
                    $_SESSION['joueur_nom'] = $joueur->getNom();
                    $_SESSION['joueur_argent'] = $joueur->getArgent();
                    
                    // Rediriger vers le jeu
                    header('Location: index.php?action=roulette');
                    exit;
                } else {
                    $message_erreur = 'Utilisateur inconnu';
                }
            } else {
                $message_erreur = 'Il faut remplir les champs!';
            }
        }
        
        return $message_erreur;
    }
    
    public function processInscription() {
        $message_erreur = '';
        
        if (isset($_POST['btnSignup'])) {
            if (isset($_POST['nom']) && $_POST['nom'] != '' &&
                isset($_POST['motdepasse']) && $_POST['motdepasse'] != '') {
                
                // Créer un nouvel utilisateur
                $joueur = new Joueur(null, $_POST['nom'], $_POST['motdepasse']);
                $joueur = $this->create($joueur);
                
                // Connecter l'utilisateur
                $_SESSION['joueur_id'] = $joueur->getId();
                $_SESSION['joueur_nom'] = $joueur->getNom();
                $_SESSION['joueur_argent'] = $joueur->getArgent();
                
                // Rediriger vers le jeu
                header('Location: index.php?action=roulette');
                exit;
            } else {
                $message_erreur = 'Il faut remplir les champs!';
            }
        }
        
        return $message_erreur;
    }
    
    public function processDeconnexion() {
        session_destroy();
        header('Location: index.php');
        exit;
    }
    
    public function getCurrentJoueur() {
        if (!isset($_SESSION['joueur_id'])) {
            return null;
        }
        
        return $this->findById($_SESSION['joueur_id']);
    }
}