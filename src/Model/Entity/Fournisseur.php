<?php

class Fournisseur
{
    private int $id;
    private string $nom;
    private ?string $email;
    private ?string $tel;
    private ?string $adresse;

    public function __construct(int $id, string $nom, ?string $email, ?string $tel, ?string $adresse)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->tel = $tel;
        $this->adresse = $adresse;
    }

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }
    public function setNom(string $nom): void { $this->nom = $nom; }
    public function setEmail(?string $email): void { $this->email = $email; }
    public function setTel(?string $tel): void { $this->tel = $tel; }
    public function setAdresse(?string $adresse): void { $this->adresse = $adresse; }
    public function getNom(): string { return $this->nom; }
    public function getEmail(): ?string { return $this->email; }
    public function getTel(): ?string { return $this->tel; }
    public function getAdresse(): ?string { return $this->adresse; }
}
