-- Active: 1785869972835@@127.0.0.1@5432@app_week
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
        CHECK (nom IN ('EN_COURS',  'RECEPTIONNE'))
);



CREATE TABLE utilisateurs (
    id           SERIAL PRIMARY KEY,
    nom_complet  VARCHAR(100) NOT NULL,
    email        VARCHAR(120) NOT NULL UNIQUE,
    mot_passe    VARCHAR(255) NOT NULL,
    adresse      VARCHAR(150),
    tel          VARCHAR(20),
    role_id      INTEGER NOT NULL REFERENCES roles(id) 
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
    seuil_alerte  INTEGER NOT NULL DEFAULT 5 CHECK (seuil_alerte >= 0)
);



CREATE TABLE commandes (
    id               SERIAL PRIMARY KEY,
    client_id        INTEGER NOT NULL REFERENCES clients(id) ,
    utilisateur_id   INTEGER NOT NULL REFERENCES utilisateurs(id) ,
    mode_paiement_id INTEGER REFERENCES modes_paiement(id) ,
    date_commande     DATE NOT NULL DEFAULT CURRENT_DATE,
    montant_verse  NUMERIC(12,2) NOT NULL CHECK (montant_verse >= 0),
    montant_total    NUMERIC(12,2) NOT NULL CHECK (montant_total >= 0)
);

CREATE TABLE lignes_commande (
    id            SERIAL PRIMARY KEY,
    commande_id   INTEGER NOT NULL REFERENCES commandes(id),
    produit_id    INTEGER NOT NULL REFERENCES produits(id) ,
    qte_commande  INTEGER NOT NULL CHECK (qte_commande > 0),
    prix_reel     NUMERIC(12,2) NOT NULL CHECK (prix_reel >= 0)
);


CREATE TABLE dettes (
    id            SERIAL PRIMARY KEY,
    commande_id   INTEGER NOT NULL REFERENCES commandes(id) ,
    montant_initial    NUMERIC(12,2) NOT NULL CHECK (montant_initial >= 0),
    montant_restant  NUMERIC(12,2) NOT NULL DEFAULT 0 CHECK (montant_restant >= 0),
    date_dette DATE DEFAULT CURRENT_DATE,
    statut        VARCHAR(20) NOT NULL DEFAULT 'NON_SOLDEE'
    CHECK (statut IN ('NON_SOLDEE', 'SOLDEE')),
    CHECK (montant_restant <= montant_initial)
);

CREATE TABLE reglements (
    id               SERIAL PRIMARY KEY,
    dette_id         INTEGER NOT NULL REFERENCES dettes(id),
    mode_paiement_id INTEGER NOT NULL REFERENCES modes_paiement(id) ,
    date_reglement   DATE NOT NULL DEFAULT CURRENT_DATE,
    montant_verse   NUMERIC(12,2) NOT NULL CHECK (montant_verse > 0)
);



CREATE TABLE appros (
    id              SERIAL PRIMARY KEY,
    fournisseur_id  INTEGER NOT NULL REFERENCES fournisseurs(id) ,
    utilisateur_id  INTEGER NOT NULL REFERENCES utilisateurs(id) ,
    statut_appro_id INTEGER NOT NULL REFERENCES statuts_appro(id) ,
    ref_bl          VARCHAR(50) NOT NULL,
    date_appro      DATE NOT NULL DEFAULT CURRENT_DATE
);

CREATE TABLE lignes_appro (
    id          SERIAL PRIMARY KEY,
    appro_id    INTEGER NOT NULL REFERENCES appros(id),
    produit_id  INTEGER NOT NULL REFERENCES produits(id) ,
    qte_appro   INTEGER NOT NULL CHECK (qte_appro > 0),
    qte_recu    INTEGER NOT NULL DEFAULT 0 CHECK (qte_recu >= 0),
    prix_reel   NUMERIC(12,2) NOT NULL CHECK (prix_reel >= 0)
);

