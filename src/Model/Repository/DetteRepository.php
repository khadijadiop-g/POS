<?php
require_once dirname(__DIR__) . "/Entity/Dette.php";
require_once dirname(__DIR__) . "/Entity/Client.php";
require_once dirname(__DIR__) . "/Entity/Commande.php";

class DetteRepository
{

    private Database $dtb;

    public function __construct(Database $dtb)
    {
        $this->dtb = $dtb;
    }

    public static function tabToObjetAffichage(array $data): array
    {
        return [
            'id' => (int) $data['id'],
            'client_id' => (int) $data['client_id'],
            'commande_id' => (int) $data['commande_id'],
            'montant_initial' => (float) $data['montant_initial'],
            'montant_restant' => (float) $data['montant_restant'],
            'statut' => $data['statut'],
        ];
    }

    public static function saveDette(int $clientId, int $commandeId, float $montantInitial): int
    {
        $sql = "INSERT INTO dettes (client_id, commande_id, montant_initial, montant_restant, statut)
                VALUES (:client_id, :commande_id, :montant_initial, :montant_restant, 'NON_SOLDEE')";

        return DetteRepository::$dtb->executeUpdate($sql, [
            'client_id' => $clientId,
            'commande_id' => $commandeId,
            'montant_initial' => $montantInitial,
            'montant_restant' => $montantInitial,
        ]);
    }

    public static function getAllDettesNonSoldees(): array
    {
        $sql = "SELECT d.*, c.nom, c.prenom
                FROM dettes d
                JOIN clients c ON c.id = d.client_id
                WHERE d.statut = 'NON_SOLDEE'
                ORDER BY d.id DESC";
        $lignes = DetteRepository::$dtb->query($sql, false);
        return array_map(fn($ligne) => DetteRepository::tabToObjetAffichage($ligne), $lignes);
    }

    public static function getById(int $id): ?array
    {
        $sql = "SELECT * FROM dettes WHERE id = :id";
        $ligne = DetteRepository::$dtb->executeQuery($sql, ['id' => $id], true);
        return $ligne ? DetteRepository::tabToObjetAffichage($ligne) : null;
    }

    public static function diminuerMontantRestant(int $detteId, float $montantVerse): int
    {
        $sql = "UPDATE dettes
                SET montant_restant = montant_restant - :montant_verse,
                    statut = CASE
                        WHEN montant_restant - :montant_verse <= 0 THEN 'SOLDEE'
                        ELSE 'NON_SOLDEE'
                    END
                WHERE id = :id";

        return DetteRepository::$dtb->executeUpdate($sql, [
            'montant_verse' => $montantVerse,
            'id' => $detteId,
        ]);
    }

}
