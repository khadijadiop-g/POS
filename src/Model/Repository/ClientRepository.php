<?php
require_once dirname(__DIR__) . "/Entity/Client.php";

class ClientRepository
{

    private Database $dtb;

    public function __construct(Database $dtb)
    {
        $this->dtb = $dtb;

    }

    public static function tabToObjet(array $data): Client
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

    public static function getAllClients(): array
    {
        $sql = "SELECT * FROM clients ORDER BY prenom ASC";
        $lignes = ClientRepository::$dtb->query($sql, false);
        return array_map(fn($ligne) => ClientRepository::tabToObjet($ligne), $lignes);
    }

    public static function saveClient(string $nom, string $prenom, ?string $email, ?string $tel, float $limite_credit): int
    {

        $sql = "INSERT INTO clients (nom, prenom, email, tel, limite_credit)
                VALUES (:nom, :prenom, :email, :tel, :limite_credit)";

        return ClientRepository::$dtb->executeUpdate($sql, [
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'tel' => $tel,
            'limite_credit' => $limite_credit,
        ]);
    }

     public static function getClientById(int $id): ?Client
    {
        $sql = "SELECT * FROM clients WHERE id = :id";
        $ligne = ClientRepository::$dtb->executeQuery($sql, ['id' => $id], true);
        return $ligne ? ClientRepository::tabToObjet($ligne) : null;
    }

    // Somme des dettes NON_SOLDEE du client : sert a verifier la limite de credit dans VenteService
    public static function getTotalDettesEnCours(int $clientId): float
    {
        $sql = "SELECT COALESCE(SUM(montant_restant), 0) AS total
                FROM dettes WHERE client_id = :client_id AND statut = 'NON_SOLDEE'";
        $ligne = ClientRepository::$dtb->executeQuery($sql, ['client_id' => $clientId], true);
        return (float) $ligne['total'];
    }


}
