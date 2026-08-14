CREATE DATABASE app_week OWNER khadija;
CREATE TABLE roles (
    id   SERIAL PRIMARY KEY,
    nom  VARCHAR(30) NOT NULL UNIQUE
        CHECK (nom IN ('admin', 'vente', 'stock', 'inventaire'))
);

CREATE TABLE modes_paiement (
    id   SERIAL PRIMARY KEY,
    mode VARCHAR(30) NOT NULL UNIQUE
);

CREATE TABLE statuts_appro (
    id  SERIAL PRIMARY KEY,
    nom VARCHAR(30) NOT NULL UNIQUE
        CHECK (nom IN ('EN_COURS', 'RECEPTIONNE_PARTIEL', 'RECEPTIONNE'))
);



CREATE TABLE utilisateurs (
    id           SERIAL PRIMARY KEY,
    nom_complet  VARCHAR(100) NOT NULL,
    email        VARCHAR(120) NOT NULL UNIQUE,
    mot_passe    VARCHAR(255) NOT NULL,
    adresse      VARCHAR(150),
    tel          VARCHAR(20),
    role_id      INTEGER NOT NULL REFERENCES roles(id) ON DELETE RESTRICT,
    cree_le      TIMESTAMP NOT NULL DEFAULT now()
);



CREATE TABLE clients (
    id            SERIAL PRIMARY KEY,
    nom           VARCHAR(60) NOT NULL,
    prenom        VARCHAR(60) NOT NULL,
    email         VARCHAR(120),
    tel           VARCHAR(20),
    limite_credit NUMERIC(12,2) NOT NULL DEFAULT 0
        CHECK (limite_credit >= 0)
);

CREATE TABLE fournisseurs (
    id      SERIAL PRIMARY KEY,
    nom     VARCHAR(100) NOT NULL,
    email   VARCHAR(120),
    tel     VARCHAR(20),
    adresse VARCHAR(150)
);



CREATE TABLE produits (
    id            SERIAL PRIMARY KEY,
    libelle       VARCHAR(120) NOT NULL,
    prix_vente    NUMERIC(12,2) NOT NULL CHECK (prix_vente > 0),
    stock_initial INTEGER NOT NULL DEFAULT 0 CHECK (stock_initial >= 0),
    stock_actuel  INTEGER NOT NULL DEFAULT 0 CHECK (stock_actuel >= 0),
    seuil_alerte  INTEGER NOT NULL DEFAULT 5 CHECK (seuil_alerte >= 0)
);



CREATE TABLE commandes (
    id               SERIAL PRIMARY KEY,
    client_id        INTEGER NOT NULL REFERENCES clients(id) ON DELETE RESTRICT,
    utilisateur_id   INTEGER NOT NULL REFERENCES utilisateurs(id) ON DELETE RESTRICT,
    mode_paiement_id INTEGER REFERENCES modes_paiement(id) ON DELETE RESTRICT,
    date_commande    TIMESTAMP NOT NULL DEFAULT now(),
    montant_initial  NUMERIC(12,2) NOT NULL CHECK (montant_initial >= 0),
    montant_total    NUMERIC(12,2) NOT NULL CHECK (montant_total >= 0),
    statut           VARCHAR(20) NOT NULL DEFAULT 'EN_COURS'
        CHECK (statut IN ('EN_COURS', 'SOLDEE', 'ANNULEE'))
);

CREATE TABLE lignes_commande (
    id            SERIAL PRIMARY KEY,
    commande_id   INTEGER NOT NULL REFERENCES commandes(id) ON DELETE CASCADE,
    produit_id    INTEGER NOT NULL REFERENCES produits(id) ON DELETE RESTRICT,
    qte_commande  INTEGER NOT NULL CHECK (qte_commande > 0),
    prix_reel     NUMERIC(12,2) NOT NULL CHECK (prix_reel >= 0)
);


CREATE TABLE dettes (
    id            SERIAL PRIMARY KEY,
    client_id     INTEGER NOT NULL REFERENCES clients(id) ON DELETE RESTRICT,
    commande_id   INTEGER NOT NULL REFERENCES commandes(id) ON DELETE RESTRICT,
    montant_du    NUMERIC(12,2) NOT NULL CHECK (montant_du >= 0),
    montant_paye  NUMERIC(12,2) NOT NULL DEFAULT 0 CHECK (montant_paye >= 0),
    statut        VARCHAR(20) NOT NULL DEFAULT 'NON_SOLDEE'
        CHECK (statut IN ('NON_SOLDEE', 'SOLDEE')),
    date_creation TIMESTAMP NOT NULL DEFAULT now(),
    CHECK (montant_paye <= montant_du)
);

CREATE TABLE reglements (
    id               SERIAL PRIMARY KEY,
    dette_id         INTEGER NOT NULL REFERENCES dettes(id) ON DELETE CASCADE,
    mode_paiement_id INTEGER NOT NULL REFERENCES modes_paiement(id) ON DELETE RESTRICT,
    date             TIMESTAMP NOT NULL DEFAULT now(),
    montant          NUMERIC(12,2) NOT NULL CHECK (montant > 0)
);



CREATE TABLE appros (
    id              SERIAL PRIMARY KEY,
    fournisseur_id  INTEGER NOT NULL REFERENCES fournisseurs(id) ON DELETE RESTRICT,
    utilisateur_id  INTEGER NOT NULL REFERENCES utilisateurs(id) ON DELETE RESTRICT,
    statut_appro_id INTEGER NOT NULL REFERENCES statuts_appro(id) ON DELETE RESTRICT,
    ref_bl          VARCHAR(50) NOT NULL,
    date_appro      TIMESTAMP NOT NULL DEFAULT now()
);

CREATE TABLE lignes_appro (
    id          SERIAL PRIMARY KEY,
    appro_id    INTEGER NOT NULL REFERENCES appros(id) ON DELETE CASCADE,
    produit_id  INTEGER NOT NULL REFERENCES produits(id) ON DELETE RESTRICT,
    qte_appro   INTEGER NOT NULL CHECK (qte_appro > 0),
    qte_recu    INTEGER NOT NULL DEFAULT 0 CHECK (qte_recu >= 0),
    prix_reel   NUMERIC(12,2) NOT NULL CHECK (prix_reel >= 0)
);

