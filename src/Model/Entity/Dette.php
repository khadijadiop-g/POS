<?php

class Dette
{
    private ?int $id;
    private Client $clientId;
    private Commande $commandeId;
    private float $montantInitial;
    private float $montantRestant;
    private string $statut;

    public function __construct(Client $clientId, Commande $commandeId, float $montantInitial, float $montantRestant = 0.0, ?int $id = null, string $statut = 'NON_SOLDEE')
    {
        $this->id = $id;
        $this->clientId = $clientId;
        $this->commandeId = $commandeId;
        $this->montantInitial = $montantInitial;
        $this->montantRestant = $montantRestant 
            ? $montantRestant 
            : $montantInitial;
        $this->statut = $statut;
    }

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }
    public function getClientId(): Client { return $this->clientId; }
    public function getCommandeId(): Commande { return $this->commandeId; }
    public function setClientId(Client $clientId): void { $this->clientId = $clientId; }
    public function setCommandeId(Commande $commandeId): void { $this->commandeId = $commandeId; }
    public function setMontantInitial(float $montantInitial): void { $this->montantInitial = $montantInitial; }
    public function getMontantInitial(): float { return $this->montantInitial; }
    public function getMontantRestant(): float { return $this->montantRestant; }
    public function setMontantRestant(float $montantRestant): void { $this->montantRestant = $montantRestant; }
    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $statut): void { $this->statut = $statut; }

    public function estSoldee(): bool
    {
        return $this->statut === 'SOLDEE';
    }
}
