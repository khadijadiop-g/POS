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
    public function setId(int $id): void { $this->id = $id; }
    public function getLibelle(): string { return $this->libelle; }
    public function setLibelle(string $libelle): void { $this->libelle = $libelle; }
    public function getPrixVente(): float { return $this->prixVente; }
    public function setPrixVente(float $prixVente): void { $this->prixVente = $prixVente; }
    public function getSeuilAlerte(): int { return $this->seuilAlerte; }
    public function setSeuilAlerte(int $seuilAlerte): void { $this->seuilAlerte = $seuilAlerte; }
    public function getStockInitial(): int { return $this->stockInitial; }
    public function setStockInitial(int $stockInitial): void { $this->stockInitial = $stockInitial; }

    public function estEnRupture(): bool
    {
        return $this->stockInitial <= $this->seuilAlerte;
    }


}
