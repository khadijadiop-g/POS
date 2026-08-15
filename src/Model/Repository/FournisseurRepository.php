<?php
require_once dirname(__DIR__) . "/Entity/Fournisseur.php";

class FournisseurRepository
{

    private Database $dtb;

    public function __construct(Database $dtb)
    {
        $this->dtb = $dtb;

    }

    public function tabToObjet(array $data): Fournisseur
    {

        return new Fournisseur(
            $data['id'],
            $data['nom'],
            $data['email'] ,
            $data['tel'] ,
            $data['adresse'] 
        );
    }

    public function getAllFournisseurs(): array
    {
        $sql = "SELECT * FROM fournisseurs ORDER BY nom ASC";
        $lignes = $this->dtb->query($sql, false);
        return array_map(fn($ligne) => $this->tabToObjet($ligne), $lignes);
    }

  

    public function saveFournisseur(string $nom, ?string $email, ?string $tel, ?string $adresse): int
    {

        $sql = "INSERT INTO fournisseurs (nom, email, tel, adresse)
                VALUES (:nom, :email, :tel, :adresse)";

        return $this->dtb->executeUpdate($sql, [
            'nom' => $nom,
            'email' => $email,
            'tel' => $tel,
            'adresse' => $adresse,
        ]);
    }



}
