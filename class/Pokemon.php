<?php

abstract class Pokemon
{
    protected string $nom;
    protected string $type;
    protected int $pointsDeVie;
    protected int $pointsAttaque;
    protected int $defense;
    protected string $nomCapaciteSpeciale;

    const DEGATS_SUP = 1;

    public function __construct(string $nom, string $type, int $pointsDeVie, int $pointsAttaque, int $defense, string $nomCapaciteSpeciale)
    {
        $this->nom = $nom;
        $this->type = $type;
        $this->pointsDeVie = $pointsDeVie;
        $this->pointsAttaque = $pointsAttaque;
        $this->defense = $defense;
        $this->nomCapaciteSpeciale = $nomCapaciteSpeciale;
    }

    public function attaquer($adversaire): void
    {
        $adversaire->recevoirDegats($this->pointsAttaque - $adversaire->defense);
    }

    public function recevoirDegats($degats): void
    {
        $this->pointsDeVie -= $degats;
    }

    public function estKO()
    {
        return $this->pointsDeVie <= 0;
    }

    abstract public function capaciteSpeciale($adversaire): void;

    public function getNomCapaciteSpeciale(): string
    {
        return $this->nomCapaciteSpeciale;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPointsDeVie(): string
    {

        return $this->pointsDeVie;
    }
}

class PokemonFeu extends Pokemon
{
    public function __construct(string $nom, int $pointsDeVie, int $pointsAttaque, int $defense)
    {
        parent::__construct($nom, 'Feu', $pointsDeVie, $pointsAttaque, $defense, 'Lance-Flammes');
    }

    public function capaciteSpeciale($adversaire): void
    {
        if ($adversaire->type == 'Plante') {
            $adversaire->recevoirDegats($this->pointsAttaque + self::DEGATS_SUP);
            var_dump($this->pointsAttaque);
            var_dump($adversaire->pointsDeVie);
            var_dump(self::DEGATS_SUP);
        } else {
            $adversaire->recevoirDegats($this->pointsAttaque);
        }
    }
}

class PokemonEau extends Pokemon
{
    public function __construct(string $nom, int $pointsDeVie, int $pointsAttaque, int $defense)
    {
        parent::__construct($nom, 'Eau', $pointsDeVie, $pointsAttaque, $defense, 'Hydrocanon');
    }

    public function capaciteSpeciale($adversaire): void
    {
        if ($adversaire->type == 'Feu') {
            $adversaire->recevoirDegats($this->pointsAttaque + self::DEGATS_SUP);
        }
    }
}

class PokemonPlante extends Pokemon
{
    public function __construct(string $nom, int $pointsDeVie, int $pointsAttaque, int $defense)
    {
        parent::__construct($nom, 'Plante', $pointsDeVie, $pointsAttaque, $defense, 'Fouet-Lianes');
    }

    public function capaciteSpeciale($adversaire): void
    {
        if ($adversaire->type == 'Eau') {
            $adversaire->recevoirDegats($this->pointsAttaque + self::DEGATS_SUP);
        }
    }
}
