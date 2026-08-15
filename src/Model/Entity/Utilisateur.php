<?php

class Utilisateur
{
    private int $id;
    private string $nomComplet;
    private string $email;
    private string $motPasse; // hash, jamais en clair
    private Role $roleId; 

    public function __construct(int $id, string $nomComplet, string $email, string $motPasse, Role $roleId)
    {
        $this->id = $id;
        $this->nomComplet = $nomComplet;
        $this->email = $email;
        $this->motPasse = $motPasse;
        $this->roleId = $roleId;
    }

    public function getId(): int { return $this->id; }
    public function getNomComplet(): string { return $this->nomComplet; }
    public function getEmail(): string { return $this->email; }
    public function getMotPasseHache(): string { return $this->motPasse; }
    public function getRole(): Role { return $this->roleId; }


}
