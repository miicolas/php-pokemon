<?php

class Combat
{
    private Pokemon $pokemon1;
    private Pokemon $pokemon2;
    private int $turn;
    public function __construct(Pokemon $pokemon1, Pokemon $pokemon2)
    {
        $this->pokemon1 = $pokemon1;
        $this->pokemon2 = $pokemon2;
    }

    public function demarrerCombat()
    {
        $this->turn = rand(1, 2);
    }

    public function tourDeCombat(int $attaquant, int $defenseur)
    {
        if ($this->turn != $attaquant) {
            die("Ce n'est pas à vous de jouer");
        }
        if ($this->turn == 1) {
            $this->pokemon1->attaquer($this->pokemon2);
        }
    }

    public function determinerVainqueur()
    {
        if ($this->pokemon1->estKO()) {
            return $this->pokemon2;
        } elseif ($this->pokemon2->estKO()) {
            return $this->pokemon1;
        } else {
            return null;
        }
    }
}
