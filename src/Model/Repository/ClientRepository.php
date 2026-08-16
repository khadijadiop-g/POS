<?php
require_once dirname(__DIR__) . "/Entity/Client.php";

class ClientRepository
{

    private Database $dtb;

    public function __construct(Database $dtb)
    {
        $this->dtb = $dtb;

    }

    public function tabToObjet(array $data): Client
    {

        return new Client(
            (int) $data['id'],
            $data['nom'],
            $data['prenom'],
            $data['email'] ,
            $data['tel'] ,
            (float) $data['limite_credit']
        );
    }

    public function getAllClients(): array
    {
        $sql = "SELECT * FROM clients ORDER BY prenom ASC";
        $lignes = $this->dtb->query($sql, false);
        return array_map(fn($ligne) => $this->tabToObjet($ligne), $lignes);
    }

    public function saveClient(string $nom, string $prenom, ?string $email, ?string $tel, float $limite_credit): int
    {

        $sql = "INSERT INTO clients (nom, prenom, email, tel, limite_credit)
                VALUES (:nom, :prenom, :email, :tel, :limite_credit)";

        return $this->dtb->executeUpdate($sql, [
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'tel' => $tel,
            'limite_credit' => $limite_credit,
        ]);
    }

     public function getClientById(int $id): ?Client
    {
        $sql = "SELECT * FROM clients WHERE id = :id";
        $ligne = $this->dtb->executeQuery($sql, ['id' => $id], true);
        return $ligne ? $this->tabToObjet($ligne) : null;
    }

    // Somme des dettes NON_SOLDEE du client : sert a verifier la limite de credit dans VenteService
    public function getTotalDettesEnCours(int $clientId): float
    {
        $sql = "SELECT COALESCE(SUM(montant_restant), 0) AS total
                FROM dettes WHERE client_id = :client_id AND statut = 'NON_SOLDEE'";
        $ligne = $this->dtb->executeQuery($sql, ['client_id' => $clientId], true);
        return (float) $ligne['total'];
    }


}
