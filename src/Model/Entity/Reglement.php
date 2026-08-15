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
    public function getDetteId(): Dette { return $this->detteId; }
    public function getMontantVerse(): float { return $this->montantVerse; }
    public function getDateReglement(): DateTime { return $this->dateReglement; }
}
