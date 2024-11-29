<?php

class Capacite
{
    private string $nom;
    private int $degats;
    private int $precision;
    private string $type;

    public function __construct(string $nom, int $degats, int $precision, string $type)
    {
        $this->nom = $nom;
        $this->degats = $degats;
        $this->precision = $precision;
        $this->type = $type;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getDegats(): int
    {
        return $this->degats;
    }

    public function getType(): string
    {
        return $this->type;
    }
    public function getPrecision(): int
    {
        return $this->precision;
    }
}

class CapaciteSpecialeFeu extends Capacite
{
    public function __construct()
    {
        parent::__construct("Lance-Flammes", 110, 90, "feu");
    }
}

class CapaciteSpecialeEau extends Capacite
{
    public function __construct()
    {
        parent::__construct("Hydrocanon", 110, 95, "eau");
    }
}

class CapaciteSpecialePlante extends Capacite
{
    public function __construct()
    {
        parent::__construct("Fouet-Lianne", 110, 95, "plante");
    }
}
