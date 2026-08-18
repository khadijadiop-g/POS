<?php

class Reglement
{
    private ?int $id;
    private Dette $detteId;
    private ModePaiement $modePaiementId;
    private float $montantVerse;
    private DateTime $dateReglement;    

    public function __construct(Dette $detteId, ModePaiement $modePaiementId, float $montantVerse, DateTime $dateReglement , ?int $id = null)
    {
        $this->id = $id;
        $this->detteId = $detteId;
        $this->modePaiementId = $modePaiementId;
        $this->montantVerse = $montantVerse;
        $this->dateReglement = $dateReglement ?? new DateTime();
    }

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }
    public function getModePaiementId(): ModePaiement { return $this->modePaiementId; }
    public function setModePaiementId(ModePaiement $modePaiementId): void { $this->modePaiementId = $modePaiementId; }
    public function setDetteId(Dette $detteId): void { $this->detteId = $detteId; }
    public function setMontantVerse(float $montantVerse): void { $this->montantVerse = $montantVerse; }     
    public function getDetteId(): Dette { return $this->detteId; }
    public function setDateReglement(DateTime $dateReglement): void { $this->dateReglement = $dateReglement; }
    
    public function getMontantVerse(): float { return $this->montantVerse; }
    public function getDateReglement(): DateTime { return $this->dateReglement; }
}
