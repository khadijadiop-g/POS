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
    public function setId(int $id): void { $this->id = $id; }
    public function setNom(string $nom): void { $this->nom = $nom; }
    public function setPrenom(string $prenom): void { $this->prenom = $prenom; }
    public function setEmail(?string $email): void { $this->email = $email; }
    public function setTel(?string $tel): void { $this->tel = $tel; }
    public function setLimiteCredit(float $limiteCredit): void { $this->limiteCredit = $limiteCredit; } 
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
