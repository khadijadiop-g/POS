<?php
require_once dirname(__DIR__) . "/core/Database.php";
require_once dirname(__DIR__) . "/Model/Repository/ProduitRepository.php";
require_once dirname(__DIR__) . "/Model/Repository/ClientRepository.php";
require_once dirname(__DIR__) . "/Model/Repository/CommandeRepository.php";
require_once dirname(__DIR__) . "/Model/Repository/DetteRepository.php";
require_once dirname(__DIR__) . "/Service/VenteService.php";

class POSController
{

    private ProduitRepository $produitRepo;
    private ClientRepository $clientRepo;
    private VenteService $venteService;

    private ?string $erreur = null;
    private ?string $succes = null;

    public function __construct()
    {
        $dtb = Database::getInstance();
        $this->produitRepo = new ProduitRepository($dtb);
        $this->clientRepo = new ClientRepository($dtb);
        $commandeRepo = new CommandeRepository($dtb);
        $detteRepo = new DetteRepository($dtb);
        $this->venteService = new VenteService($dtb, $this->produitRepo, $this->clientRepo, $commandeRepo, $detteRepo);
    }

    public function index(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->traiterVente();
        }

        $produits = $this->produitRepo->getAllProducts();
        $clients = $this->clientRepo->getAllClients();

        require dirname(__DIR__, 2) . "/views/pos/index.php";
    }

    private function traiterVente(): void
    {
        try {
            $clientId = (int) ($_POST['client_id'] ?? 0);
            $utilisateurId = (int) ($_SESSION['utilisateur_id'] ?? 1);
            $modePaiementId = !empty($_POST['mode_paiement_id']) ? (int) $_POST['mode_paiement_id'] : null;
            $montantVerse = (float) ($_POST['montant_verse'] ?? 0);

            $panier = [];
            $produitIds = $_POST['produit_id'] ?? [];
            $qtes = $_POST['qte'] ?? [];

            foreach ($produitIds as $index => $produitId) {
                $qte = (int) ($qtes[$index] ?? 0);
                if ($qte > 0) {
                    $panier[] = ['produit_id' => (int) $produitId, 'qte' => $qte];
                }
            }

            $commandeId = $this->venteService->validerVente($clientId, $utilisateurId, $panier, $modePaiementId, $montantVerse);

            $this->succes = "Vente enregistree (commande n°{$commandeId}).";
        } catch (Exception $e) {
            $this->erreur = $e->getMessage();
        }
    }

}

