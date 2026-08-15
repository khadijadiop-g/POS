<?php

class Commande
{
    private ?int $id;
    private Client $clientId;
    private Utilisateur $utilisateurId;
    private ?ModePaiement $modePaiementId;

    private DateTime $dateCreation;

    public function __construct(Client $clientId, Utilisateur $utilisateurId, ?ModePaiement  $modePaiementId = null, ?int $id = null, string $statut = 'EN_COURS')
    {
        $this->id = $id;
        $this->clientId = $clientId;
        $this->utilisateurId = $utilisateurId;
        $this->modePaiementId = $modePaiementId;
        $this->dateCreation = new DateTime();
    }

    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }
    public function getClientId(): Client { return $this->clientId; }
    public function getDateCreation(): DateTime { return $this->dateCreation; }

 

}
