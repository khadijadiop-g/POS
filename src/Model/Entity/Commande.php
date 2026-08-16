<?php

class Commande
{
    private ?int $id;
    private Client $clientId;
    private Utilisateur $utilisateurId;
    private ?ModePaiement $modePaiementId;
    private float $montantTotal;
    private float $montantVerse;

    private DateTime $dateCreation;

     public function __construct(Client $clientId, Utilisateur $utilisateurId, ?ModePaiement $modePaiementId = null, float $montantTotal = 0.0, float $montantVerse = 0.0, ?int $id = null)
    {
        $this->id = $id;
        $this->clientId = $clientId;
        $this->utilisateurId = $utilisateurId;
        $this->modePaiementId = $modePaiementId;
        $this->montantTotal = $montantTotal;
        $this->montantVerse = $montantVerse;
        $this->dateCreation = new DateTime();
    }

    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }
    public function getClientId(): Client { return $this->clientId; }
    public function getDateCreation(): DateTime { return $this->dateCreation; }
    public function getUtilisateurId(): Utilisateur { return $this->utilisateurId; }
    public function getModePaiementId(): ?ModePaiement { return $this->modePaiementId; }
    public function getMontantTotal(): float { return $this->montantTotal; }
    public function getMontantVerse(): float { return $this->montantVerse; }

      public function getResteAPayer(): float
    {
        return $this->montantTotal - $this->montantVerse;
    }

}
