<?php

class Produit
{
    private int $id;
    private string $libelle;
    private float $prixVente;
    private int $stockInitial;
    private int $seuilAlerte;

    public function __construct(int $id, string $libelle, float $prixVente, int $seuilAlerte, int $stockInitial = 0)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->prixVente = $prixVente;
        $this->stockInitial = $stockInitial;
        $this->seuilAlerte = $seuilAlerte;
    }

    public function getId(): int { return $this->id; }
    public function getLibelle(): string { return $this->libelle; }
    public function getPrixVente(): float { return $this->prixVente; }
    public function getSeuilAlerte(): int { return $this->seuilAlerte; }

    public function estEnRupture(): bool
    {
        return $this->stockInitial <= $this->seuilAlerte;
    }


}
