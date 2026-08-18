<?php

class LigneCommande
{
    private ?int $id;
    private Produit $produitId;
    private int $qteCommande;
    private float $prixReel;

    public function __construct(Produit $produitId, int $qteCommande, float $prixReel, ?int $id = null)
    {
        $this->id = $id;
        $this->produitId = $produitId;
        $this->qteCommande = $qteCommande;
        $this->prixReel = $prixReel;
    }

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }
    public function getProduitId(): Produit { return $this->produitId; }
    public function setProduitId(Produit $produitId): void { $this->produitId = $produitId; }
    public function getQteCommande(): int { return $this->qteCommande; }
    public function setQteCommande(int $qteCommande): void { $this->qteCommande = $qteCommande; }
    public function getPrixReel(): float { return $this->prixReel; }
    public function setPrixReel(float $prixReel): void { $this->prixReel = $prixReel; }

    public function getSousTotal(): float
    {
        return $this->qteCommande * $this->prixReel;
    }
}
