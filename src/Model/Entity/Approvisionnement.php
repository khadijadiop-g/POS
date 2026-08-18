<?php

class Approvisionnement
{
    private ?int $id;
    private Fournisseur $fournisseurId;
    private Utilisateur $utilisateurId;
    private string $refBl;
    private StatutAppro $statutId; 


    public function __construct(Fournisseur $fournisseurId, Utilisateur $utilisateurId, string $refBl, ?int $id = null, ?StatutAppro $statut = null)
    {
        $this->id = $id;
        $this->fournisseurId = $fournisseurId;
        $this->utilisateurId = $utilisateurId;
        $this->refBl = $refBl;
        $this->statutId = $statut ?? new StatutAppro('EN_COURS', null);
    }

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }
    public function getFournisseurId(): Fournisseur { return $this->fournisseurId; }
    public function setFournisseurId(Fournisseur $fournisseurId): void { $this->fournisseurId = $fournisseurId; }
    public function getUtilisateurId(): Utilisateur { return $this->utilisateurId; }
    public function setUtilisateurId(Utilisateur $utilisateurId): void { $this->utilisateurId = $utilisateurId; }
    public function getRefBl(): string { return $this->refBl; }
    public function setRefBl(string $refBl): void { $this->refBl = $refBl; }
    public function setStatutId(StatutAppro $statutId): void { $this->statutId = $statutId; }  
    public function getStatutId(): StatutAppro { return $this->statutId; }

}
