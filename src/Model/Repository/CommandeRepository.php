<?php
require_once dirname(__DIR__) . "/Entity/Commande.php";
require_once dirname(__DIR__) . "/Entity/LigneCommande.php";
class CommandeRepository {
private Database $dtb;

 public function __construct(Database $dtb)
    {
        $this->dtb = $dtb;
    }

    public function getLignesByCommande(int $commandeId): array
    {
        $sql = "SELECT lc.*, p.libelle
                FROM lignes_commande lc
                JOIN produits p ON p.id = lc.produit_id
                WHERE lc.commande_id = :commande_id";
        return $this->dtb->executeQuery($sql, ['commande_id' => $commandeId], false);
    }

    public function saveCommande(int $clientId, int $utilisateurId, ?int $modePaiementId, float $montantTotal, float $montantVerse): int
    {
        $sql = "INSERT INTO commandes (client_id, utilisateur_id, mode_paiement_id, montant_total, montant_verse)
                VALUES (:client_id, :utilisateur_id, :mode_paiement_id, :montant_total, :montant_verse)";

        return $this->dtb->executeUpdate($sql, [
            'client_id' => $clientId,
            'utilisateur_id' => $utilisateurId,
            'mode_paiement_id' => $modePaiementId,
            'montant_total' => $montantTotal,
            'montant_verse' => $montantVerse,
        ]);
    }

    public function saveLigneCommande(int $commandeId, int $produitId, int $qteCommande, float $prixReel): int
    {
        $sql = "INSERT INTO lignes_commande (commande_id, produit_id, qte_commande, prix_reel)
                VALUES (:commande_id, :produit_id, :qte_commande, :prix_reel)";

        return $this->dtb->executeUpdate($sql, [
            'commande_id' => $commandeId,
            'produit_id' => $produitId,
            'qte_commande' => $qteCommande,
            'prix_reel' => $prixReel,
        ]);
    }

}