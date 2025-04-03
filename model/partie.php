<?php

class Partie {

	private int $id;
	private int $joueur;
	private date $date;
	private int $mise;
	private int $gain;

	public function __construct(t $i, int $j, date $d, int $m, int $g) {

		$this->id = $i;
		$this->joueur = $j;
		$this->date = $d;
		$this->mise = $m;
		$this->gain = $g;
	}

	public function getId() {
		return $this->id;
	}

	public function getJoueur() {
		return $this->joueur;
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

	public function __set($attr, $value) {
		switch($attre) {
			case 'id' :
			    $this->id = $value;
			    break;
			case 'joueur' :
			    $this->joueur = $value;
			    break;
			case 'date' :
			    $this->date = $value;
			    break;
			case 'mise' :
			    $this->mise = $value;
			    break;
			case 'gain' :
			    $this->gain = $value;
			    break;
			default:
			    echo 'ERROR';
			    break;
		}
	}
}


