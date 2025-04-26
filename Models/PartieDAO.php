<?php
require_once 'Models/Database.php';
require_once 'Models/Partie.php';
require_once 'Models/JoueurDAO.php';

class PartieDAO {
    private $db;
    private $joueurDAO;
    
    public function __construct() {
        $this->db = Database::getInstance()->getPDO();
        $this->joueurDAO = new JoueurDAO();
    }
    
    public function create(Partie $partie) {
        $stmt = $this->db->prepare('INSERT INTO roulette_partie (joueur, date, mise, gain) VALUES (?, ?, ?, ?)');
        $stmt->execute([
            $partie->getJoueurId(),
            $partie->getDate(),
            $partie->getMise(),
            $partie->getGain()
        ]);
        
        $partie->setId($this->db->lastInsertId());
        return $partie;
    }
    
    public function findByJoueurId($joueurId) {
        $stmt = $this->db->prepare('SELECT * FROM roulette_partie WHERE joueur = ? ORDER BY date DESC');
        $stmt->execute([$joueurId]);
        
        $parties = [];
        while ($data = $stmt->fetch()) {
            $parties[] = new Partie(
                $data['identifiant'],
                $data['joueur'],
                $data['date'],
                $data['mise'],
                $data['gain']
            );
        }
        
        return $parties;
    }
    
    public function processJeu() {
        $result = [
            'message_erreur' => '',
            'message_info' => '',
            'message_resultat' => '',
            'gagne' => false
        ];
        
        $joueur = $this->joueurDAO->getCurrentJoueur();
        
        if (!$joueur) {
            header('Location: index.php');
            exit;
        }
        
        if (isset($_GET['btnJouer'])) {
            if ($_GET['mise'] < 0) {
                $result['message_erreur'] = 'La mise doit être positive';
            } else if ($_GET['mise'] == 0) {
                $result['message_erreur'] = 'Il faut miser de l\'argent ...';
            } else if ($_GET['mise'] > $joueur->getArgent()) {
                $result['message_erreur'] = 'On ne mise pas plus que ce qu\'on a ...';
            } else if (empty($_GET['numero']) && !isset($_GET['parite'])) {
                $result['message_erreur'] = 'Il faut miser sur quelquechose!';
            } else {
                $miseJoueur = intval($_GET['mise']);
                $joueur->retirerArgent($miseJoueur);
                $gain = 0;
                $numero = rand(1, 36);

                $result['message_info'] = "La bille s'est arrêtée sur le $numero! ";
                
                if (!empty($_GET['numero'])) {
                    $numeroJoueur = intval($_GET['numero']);
                    $result['message_info'] .= "Vous avez misé sur le ".$numeroJoueur."!";
                    if ($numeroJoueur == $numero) {
                        $result['message_resultat'] = "Jackpot! Vous gagnez ". $miseJoueur*35 ."€ !";
                        $result['gagne'] = true;
                        $gain = $miseJoueur*35;
                        $joueur->ajouterArgent($gain);
                    } else {
                        $result['message_resultat'] = "Raté!";
                    }
                } else {
                    $result['message_info'] .= "Vous avez misé sur le fait que le résultat soit ".$_GET['parite'];
                    $parite = $numero%2 == 0 ? 'pair' : 'impair';
                    if ($parite == $_GET['parite']) {
                        $result['message_resultat'] = "Bien joué! Vous gagnez ". $miseJoueur*2 ."€ !";
                        $result['gagne'] = true;
                        $gain = $miseJoueur*2;
                        $joueur->ajouterArgent($gain);
                    } else {
                        $result['message_resultat'] = "C'est perdu, dommage!";
                    }
                }
                
                $this->joueurDAO->update($joueur);
                
                $partie = new Partie(null, $joueur->getId(), date('Y-m-d H:i:s'), $miseJoueur, $gain);
                $this->create($partie);
                
                $_SESSION['joueur_argent'] = $joueur->getArgent();
            }
        }
        
        $result['joueur'] = $joueur;
        
        return $result;
    }
}