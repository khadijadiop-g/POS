<?php
require_once dirname(__DIR__, 2) . "/core/Database.php";
require_once dirname(__DIR__) . "/Entity/Produit.php";

class ProduitRepository
{

    private Database $dtb;

    public function __construct(Database $dtb)
    {
        $this->dtb = $dtb;

    }

    public function tabToObjet(array $data): Produit
    {

        return new Produit(
            (int) $data['id'],
            $data['libelle'],
            (float) $data['prix_vente'],
            (int) $data['seuil_alerte'],
            (int) $data['stock_initial']
        );
    }

    public function getAllProducts(): array
    {
        $sql = "SELECT * FROM produits";
        $lignes = $this->dtb->query($sql, false);
        return array_map(fn($ligne) => $this->tabToObjet($ligne), $lignes);
    }

    public function saveProduct(string $libelle, float $prix, int $stock, int $seuilAlerte = 5): int
    {

        $sql = "INSERT INTO produits (libelle, prix_vente, stock_initial, seuil_alerte)
                VALUES (:libelle, :prix_vente, :stock_initial, :seuil_alerte)";

        return $this->dtb->executeUpdate($sql, [
            'libelle' => $libelle,
            'prix_vente' => $prix,
            'stock_initial' => $stock,
            'seuil_alerte' => $seuilAlerte,
        ]);
    }

    public function getProductEnRupture(): array
    {
        $sql = "SELECT * FROM produits WHERE stock_initial <= seuil_alerte";
        $lignes = $this->dtb->query($sql, false);
        return array_map(fn($ligne) => $this->tabToObjet($ligne), $lignes);
    }

}
