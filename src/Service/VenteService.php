<?php
require_once dirname(__DIR__) . "/core/Database.php";
require_once dirname(__DIR__) . "/Model/Repository/ProduitRepository.php";
require_once dirname(__DIR__) . "/Model/Repository/ClientRepository.php";
require_once dirname(__DIR__) . "/Model/Repository/CommandeRepository.php";
require_once dirname(__DIR__) . "/Model/Repository/DetteRepository.php";

class VenteService
{

    private Database $dtb;
    private ProduitRepository $produitRepo;
    private ClientRepository $clientRepo;
    private CommandeRepository $commandeRepo;
    private DetteRepository $detteRepo;

    public function __construct(Database $dtb, ProduitRepository $produitRepo, ClientRepository $clientRepo,
                                 CommandeRepository $commandeRepo, DetteRepository $detteRepo)
    {
        $this->dtb = $dtb;
        $this->produitRepo = $produitRepo;
        $this->clientRepo = $clientRepo;
        $this->commandeRepo = $commandeRepo;
        $this->detteRepo = $detteRepo;
    }


    public function validerVente(int $clientId, int $utilisateurId, array $panier, ?int $modePaiementId, float $montantVerse): int
    {
        if (empty($panier)) {
            throw new Exception("Le panier est vide.");
        }

        $client = $this->clientRepo->getClientById($clientId);
        if ($client === null) {
            throw new Exception("Client introuvable.");
        }

        $montantTotal = 0;
        $lignesAVerifier = [];

        foreach ($panier as $ligne) {
            $produit = $this->produitRepo->getProductById((int) $ligne['produit_id']);
            $qte = (int) $ligne['qte'];

            if ($produit === null) {
                throw new Exception("Produit introuvable (id {$ligne['produit_id']}).");
            }
            if ($qte <= 0) {
                throw new Exception("Quantite invalide pour {$produit->getLibelle()}.");
            }
            if ($produit->getStockInitial() < $qte) {
                throw new Exception("Stock insuffisant pour {$produit->getLibelle()} (disponible : {$produit->getStockInitial()}).");
            }

            $lignesAVerifier[] = ['produit' => $produit, 'qte' => $qte];
            $montantTotal += $produit->getPrixVente() * $qte;
        }

        $resteAPayer = $montantTotal - $montantVerse;
        if ($resteAPayer > 0) {
            $dettesEnCours = $this->clientRepo->getTotalDettesEnCours($clientId);
            if (($dettesEnCours + $resteAPayer) > $client->getLimiteCredit()) {
                throw new Exception("Limite de credit depassee pour {$client->getNomComplet()}.");
            }
        }

        $pdo = $this->dtb->getConnexion();

        try {
            $pdo->beginTransaction();

            $commandeId = $this->commandeRepo->saveCommande(
                $clientId,
                $utilisateurId,
                $modePaiementId,
                $montantTotal,
                $montantVerse
            );

            foreach ($lignesAVerifier as $item) {
                $produit = $item['produit'];
                $qte = $item['qte'];

                $this->commandeRepo->saveLigneCommande($commandeId, $produit->getId(), $qte, $produit->getPrixVente());
                $this->produitRepo->ajusterStock($produit->getId(), -$qte);
            }

            if ($resteAPayer > 0) {
                $this->detteRepo->saveDette($clientId, $commandeId, $resteAPayer);
            }

            $pdo->commit();

            return $commandeId;
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

}
