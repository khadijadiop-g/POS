<?php

class Client
{
    private int $id;
    private string $nom;
    private string $prenom;
    private ?string $email;
    private ?string $tel;
    private float $limiteCredit;

    public function __construct(int $id, string $nom, string $prenom, ?string $email, ?string $tel, float $limiteCredit)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->tel = $tel;
        $this->limiteCredit = $limiteCredit;
    }

    public function getId(): int { return $this->id; }
    public function getLimiteCredit(): float { return $this->limiteCredit; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getEmail(): ?string { return $this->email; }
    public function getTel(): ?string { return $this->tel; }
    public function getNomComplet(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

}
