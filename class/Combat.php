<?php

class Combat
{
    private Pokemon $pokemon1;
    private Pokemon $pokemon2;
    private int $turn;

    private int $vainqueur = 0;

    public function __construct(Pokemon $pokemon1, Pokemon $pokemon2)
    {
        $this->pokemon1 = $pokemon1;
        $this->pokemon2 = $pokemon2;
    }

    public function demarrerCombat()
    {
        // $this->turn = rand(1, 2);
        $this->turn = 1;
    }

    public function tourDeCombat(int $attaquant, int $defenseur, bool $special = false)
    {
        if ($this->turn != $attaquant) {
            die("Ce n'est pas à vous de jouer");
        }
        if ($this->turn == 1) {
            echo "1 attaque 2";
            if ($special) {
                $this->pokemon1->utiliserAttaqueSpeciale($this->pokemon2);
                echo 'special';
            } else {
                $this->pokemon1->utiliserAttaqueNormale($this->pokemon2);
                echo 'normal';
            }
            echo "{$this->pokemon1->getNom()} attaque {$this->pokemon2->getNom()}<br>";
            echo "{$this->pokemon2->getNom()} a {$this->pokemon2->getPointsDeVie()} points de vie<br>";
            $this->turn = 2;
            $this->determinerVainqueur();
        } else if ($this->turn == 2) {
            if ($special) {
                $this->pokemon2->utiliserAttaqueSpeciale($this->pokemon1);
            } else {
                $this->pokemon2->utiliserAttaqueNormale($this->pokemon1);
            }
            echo "{$this->pokemon2->getNom()} attaque {$this->pokemon1->getNom()}<br>";
            echo "{$this->pokemon1->getNom()} a {$this->pokemon1->getPointsDeVie()} points de vie<br>";
            $this->turn = 1;
            $this->determinerVainqueur();
        }
    }

    public function determinerVainqueur()
    {
        if ($this->pokemon1->estKO()) {
            $this->vainqueur = 2;
            return;
        } elseif ($this->pokemon2->estKO()) {
            $this->vainqueur = 1;
            return;
        } else {
            return;
        }
    }
}
