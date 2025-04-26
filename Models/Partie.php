<?php
class Partie {
    private $id;
    private $joueurId;
    private $date;
    private $mise;
    private $gain;
    
    public function __construct($id = null, $joueurId = null, $date = null, $mise = null, $gain = null) {
        $this->id = $id;
        $this->joueurId = $joueurId;
        $this->date = $date ?: date('Y-m-d H:i:s');
        $this->mise = $mise;
        $this->gain = $gain;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getJoueurId() {
        return $this->joueurId;
    }
    
    public function getDate() {
        return $this->date;
    }
    
    public function getMise() {
        return $this->mise;
    }
    
    public function getGain() {
        return $this->gain;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setJoueurId($joueurId) {
        $this->joueurId = $joueurId;
    }
    
    public function setDate($date) {
        $this->date = $date;
    }
    
    public function setMise($mise) {
        $this->mise = $mise;
    }
    
    public function setGain($gain) {
        $this->gain = $gain;
    }
}
