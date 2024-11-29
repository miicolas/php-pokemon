<?php

require_once 'interfaces/Combattant.php';

abstract class Pokemon implements Combattant
{
    protected string $nom;
    protected string $type;
    protected int $pointsDeVie;
    protected int $pointsAttaque;
    protected int $defense;
    protected Capacite $capaciteNormale;
    protected Capacite $capaciteSpeciale;

    const DEGATS_SUP = 30;

    public function __construct(string $nom, string $type, int $pointsDeVie, int $pointsAttaque, int $defense, Capacite $capaciteNormale, Capacite $capaciteSpeciale)
    {
        $this->nom = $nom;
        $this->type = $type;
        $this->pointsDeVie = $pointsDeVie;
        $this->pointsAttaque = $pointsAttaque;
        $this->defense = $defense;
        $this->capaciteNormale = $capaciteNormale;
        $this->capaciteSpeciale = $capaciteSpeciale;
    }

    public function utiliserAttaqueSpeciale($adversaire)
    {
        $this->capaciteSpeciale($adversaire);
    }

    public function utiliserAttaqueNormale($adversaire)
    {
        $this->attaquer($adversaire, $this->capaciteNormale->getDegats());
    }

    public function attaquer($adversaire, $degats): void
    {
        $adversaire->recevoirDegats($degats - $adversaire->defense);
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
    public function __construct(string $nom, int $pointsDeVie, int $pointsAttaque, int $defense, Capacite $capacite)
    {
        parent::__construct($nom, 'feu', $pointsDeVie, $pointsAttaque, $defense, $capacite, new CapaciteSpecialeFeu());
    }

    public function capaciteSpeciale($adversaire): void
    {
        if ($adversaire->type == 'Plante') {
            $degats = $this->capaciteSpeciale->getDegats() + self::DEGATS_SUP;
        } else {
            $degats = $this->capaciteSpeciale->getDegats();
        }
        $this->attaquer($adversaire, $degats);
    }
}

class PokemonEau extends Pokemon
{
    public function __construct(string $nom, int $pointsDeVie, int $pointsAttaque, int $defense, Capacite $capacite)
    {
        parent::__construct($nom, 'eau', $pointsDeVie, $pointsAttaque, $defense, $capacite, new CapaciteSpecialeEau());
    }

    public function capaciteSpeciale($adversaire): void
    {
        if ($adversaire->type == 'feu') {
            $degats = $this->capaciteSpeciale->getDegats() + self::DEGATS_SUP;
        } else {
            $degats = $this->capaciteSpeciale->getDegats();
        }
        $this->attaquer($adversaire, $degats);
    }
}

class PokemonPlante extends Pokemon
{
    public function __construct(string $nom, int $pointsDeVie, int $pointsAttaque, int $defense, Capacite $capacite)
    {
        parent::__construct($nom, 'plante', $pointsDeVie, $pointsAttaque, $defense, $capacite, new CapaciteSpecialePlante());
    }

    public function capaciteSpeciale($adversaire): void
    {
        if ($adversaire->type == 'eau') {
            $degats = $this->capaciteSpeciale->getDegats() + self::DEGATS_SUP;
        } else {
            $degats = $this->capaciteSpeciale->getDegats();
        }
        $this->attaquer($adversaire, $degats);
    }
}
