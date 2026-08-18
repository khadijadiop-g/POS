<?php
require_once dirname(__DIR__, 2) . "/core/Database.php";
require_once dirname(__DIR__) . "/Entity/Produit.php";

class ProduitRepository
{

    private static Database $dtb;

    public function __construct(Database $dtb)
    {
        $this->dtb = $dtb;

    }

    public static function tabToObjet(array $data): Produit
    {

        return new Produit(
            (int) $data['id'],
            $data['libelle'],
            (float) $data['prix_vente'],
            (int) $data['seuil_alerte'],
            (int) $data['stock_initial']
        );
    }

    public static function getAllProducts(): array
    {
        $sql = "SELECT * FROM produits";
        $lignes = ProduitRepository::$dtb->query($sql, false);
        return array_map(fn($ligne) => ProduitRepository::tabToObjet($ligne), $lignes);
    }

    public  static function saveProduct(string $libelle, float $prix, int $stock, int $seuilAlerte = 5): int
    {

        $sql = "INSERT INTO produits (libelle, prix_vente, stock_initial, seuil_alerte)
                VALUES (:libelle, :prix_vente, :stock_initial, :seuil_alerte)";

        return ProduitRepository::$dtb->executeUpdate($sql, [
            'libelle' => $libelle,
            'prix_vente' => $prix,
            'stock_initial' => $stock,
            'seuil_alerte' => $seuilAlerte,
        ]);
    }

    public static function getProductEnRupture(): array
    {
        $sql = "SELECT * FROM produits WHERE stock_initial <= seuil_alerte";
        $lignes = ProduitRepository::$dtb->query($sql, false);
        return array_map(fn($ligne) => ProduitRepository::tabToObjet($ligne), $lignes);
    }

     public static function getProductById(int $id): ?Produit
    {
        $sql = "SELECT * FROM produits WHERE id = :id";
        $ligne = ProduitRepository::$dtb->executeQuery($sql, ['id' => $id], true);
        return $ligne ? ProduitRepository::tabToObjet($ligne) : null;
    }

  public static function ajusterStock(int $produitId, int $quantite): int
    {
        $sql = "UPDATE produits SET stock_initial = stock_initial + :quantite WHERE id = :id";
        return ProduitRepository::$dtb->executeUpdate($sql, [
            'quantite' => $quantite,
            'id' => $produitId,
        ]);
    }

}
