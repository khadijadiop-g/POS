<?php

class LigneAppro
{
    private ?int $id;
    private Produit $produitId;
    private Approvisionnement $approId;
    private int $qteAppro; 
    private int $qteRecu; 
    private float $prixReel;

    public function __construct(Produit $produitId, Approvisionnement $approId, int $qteAppro, float $prixReel, int $qteRecu = 0, ?int $id = null)
    {
        $this->id = $id;
        $this->produitId = $produitId;
        $this->approId = $approId;
        $this->qteAppro = $qteAppro;
        $this->qteRecu = $qteRecu;
        $this->prixReel = $prixReel;
    }

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }
    public function getProduitId(): Produit { return $this->produitId; }
    public function setProduitId(Produit $produitId): void { $this->produitId = $produitId; }
    public function getApproId(): Approvisionnement { return $this->approId; }
    public function setApproId(Approvisionnement $approId): void { $this->approId = $approId; }
    public function getQteAppro(): int { return $this->qteAppro; }
    public function setQteAppro(int $qteAppro): void { $this->qteAppro = $qteAppro; }
    public function getQteRecu(): int { return $this->qteRecu; }
    public function setQteRecu(int $qteRecu): void { $this->qteRecu = $qteRecu; }
    public function getPrixReel(): float { return $this->prixReel; }
    public function setPrixReel(float $prixReel): void { $this->prixReel = $prixReel; }

    public function estCompletementRecu(): bool
    {
        return $this->qteRecu >= $this->qteAppro;
    }
}
