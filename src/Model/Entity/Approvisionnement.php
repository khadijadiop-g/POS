<?php

class Approvisionnement
{
    private ?int $id;
    private Fournisseur $fournisseurId;
    private Utilisateur $utilisateurId;
    private string $refBl;
    private StatutAppro $statutId; 


    public function __construct(Fournisseur $fournisseurId, Utilisateur $utilisateurId, string $refBl, ?int $id = null, StatutAppro $statut = 'EN_COURS')
    {
        $this->id = $id;
        $this->fournisseurId = $fournisseurId;
        $this->utilisateurId = $utilisateurId;
        $this->refBl = $refBl;
        $this->statutId = $statut;
    }

    public function getId(): ?int { return $this->id; }
    public function getStatutId(): StatutAppro { return $this->statutId; }

   

}
