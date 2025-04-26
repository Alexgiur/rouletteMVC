<?php
class Joueur {
    private $id;
    private $nom;
    private $motdepasse;
    private $argent;
    
    public function __construct($id = null, $nom = null, $motdepasse = null, $argent = 500) {
        $this->id = $id;
        $this->nom = $nom;
        $this->motdepasse = $motdepasse;
        $this->argent = $argent;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getNom() {
        return $this->nom;
    }
    
    public function getMotdepasse() {
        return $this->motdepasse;
    }
    
    public function getArgent() {
        return $this->argent;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setNom($nom) {
        $this->nom = $nom;
    }
    
    public function setMotdepasse($motdepasse) {
        $this->motdepasse = $motdepasse;
    }
    
    public function setArgent($argent) {
        $this->argent = $argent;
    }
    
    // Méthodes métier
    public function ajouterArgent($montant) {
        $this->argent += $montant;
    }
    
    public function retirerArgent($montant) {
        if ($montant > $this->argent) {
            return false;
        }
        $this->argent -= $montant;
        return true;
    }
}