# 📓 Journal de Développement (DEVLOG)
**Nom & Prénom** : Khady Diop  
**Projet** : StoreManager Pro (ERP PHP/POO) 

### Step 1.1
- **Heure de réalisation** : 19:34
- **Ce qui a été fait** : Initialisation GitHub ,Creation du document docs , 
                            diagramme de UseCase et de classe 

- **Difficultés / Obstacles** : confusion entre les dettes et les Ventess
                                Ainsi que sur les modes de paiement pour les dettes
### Step 1.2

- **Heure de réalisation** : 21h20
- **Ce qui a été fait** : ecriture des scripts schema.sql (PostgreSQL) et schema_sqlite.sql
                            du diagramme de classes creation des tables,ajout des
                            contraintes CHECK (montants >= 0, quantités > 0, statuts limités à des
                            valeurs autorisées)
                            rechercher c est quoi sqlite ,la difference entre sqlite et postgresql
                            voici les commandes taper pour l installler: sqlite3 --version,sudo apt update
                                                                        sudo apt install sqlite3
                                                                        ET insatllation de l extension sqlite bd explorer
- **Difficultés / Obstacles** : J ai jammais enttendu parler du sqlite du et comment le manipuler

### Step 1.3

- **Heure de réalisation** : 23:00
- **Ce qui a été fait** : Création de src/Core/Database.php pour singleton et création de src/Core/env.php 
                            pour mes donnees de connexion a la base . Le constructeur est
                            private pour empêcher tout new Database() en dehors de la classe.
                            Une propriété statique $instance garde en mémoire l'unique objet créé :
                            getInstance() vérifie si $instance est null, le crée une seule fois
                            si besoin (self::$instance = new self();), puis renvoie toujours ce
                            même objet à tous les appels suivants. Résultat : une seule connexion PDO
                            ouverte pour toute l'application, quel que soit le nombre d'endroits qui
                            appellent Database::getInstance().
                            Le __construct() tente la connexion PostgreSQL dans un try, et bascule
                            automatiquement sur SQLite (erp.db) dans le catch (PDOException $e) si
                            PostgreSQL est injoignable — avec PRAGMA foreign_keys = ON; en plus côté
                            SQLite, car contrairement à PostgreSQL il ne vérifie pas les clés
                            étrangères par défaut.
                            Ajout de private function __clone() {} pour empêcher de dupliquer
                            l'instance (cloner casserait le principe du Singleton).
                          
- **Difficultés / Obstacles** : la différence entre new self() et
                            new Database() dans getInstance() — équivalents ici car pas d'héritage
                            sur cette classe, self fait juste référence à la classe où le code est
                            écrit.

### PHASE 2 : SAMEDI (09h00 - 20h00) — Cœur POO & Ventes POS
### Step 2.1 (09h00 - 11h00) : Entités POO Pure
- **Heure de réalisation** : 09:00
- **Ce qui a été fait** :Création de toutes les entités dans `src/Model/Entity/` :
                            `Produit`, `Client`, `Fournisseur`, `Utilisateur`,
                            `Commande`, `LigneCommande`, `Dette`, `Reglement`,
                            `Appro`, `LigneAppro`,`role`,`Modepaiement`,`SatutAppro`. 
                            Toutes les propriétés sont`private` (encapsulation), accès uniquement pour 
                            les methodes de la classe .J ai aussi toucher la diagramme de classe pour gerer la relation entre dette et commande
                            et aussi le modifier sur les schema sql et sqlite

- **Difficultés / Obstacles** : les methodes qui doit etre sur les classes ne peut elle as etre ammener par les requettes 

### Step 2.2 Repositories & SQL Sécurisé
- **Heure de réalisation** : 12:00
- **Ce qui a été fait** :`ProduitRepository`, `ClientRepository`,
                            `FournisseurRepository` — Faire des recherchere pour transformer le tableau 
                            associative venant du bd en Objet avec tabToObjet qui prend chaque ligne et le
                            transforme en new Objet ainsi utiliser array_map pour pouvoir avoir un tableau
                            numeric contenant un type d'objet , Ecrire les requetes sql dans le `schema.sql`le tester
                            et l ajouter dasns les repository

- **Difficultés / Obstacles** : inplementer les fontions database fait en POO dans les repository 

### Step 2.3 VenteService & Transaction SQL
- **Heure de réalisation** : 21h30
- **Ce qui a été fait** : `src/Service/VenteService.php` avec `validerVente()` : je verifie d'abord
                            le stock et le montant total AVANT de toucher la BD, puis je verifie la
                            limite de credit du client (somme des dettes en cours + reste a payer <=
                            limite_credit). Ensuite tout se passe dans une transaction PDO
                            (beginTransaction/commit/rollBack) : creation de la commande, des lignes
                            de commande, decrementation du stock produit par produit, et creation
                            d'une dette si le client n'a pas tout paye.
- **Difficultés / Obstacles** : le servive qui appel le model alors que c etait le role du controller 


### Step 2.4 POSController & Vue Caisse
- **Heure de réalisation** : 17h00
- **Ce qui a été fait** : `src/Controller/POSController.php` qui recupere les produits et clients
                            pour affichage, traite le POST du panier  et appelle VenteService. Vue simple
                            `views/pos/index.php`
- **Difficultés / Obstacles** : 