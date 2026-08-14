

CREATE TABLE roles (
    id   INTEGER PRIMARY KEY AUTOINCREMENT,
    nom  TEXT NOT NULL UNIQUE
        CHECK (nom IN ('admin', 'vente', 'stock', 'inventaire'))
);

CREATE TABLE modes_paiement (
    id   INTEGER PRIMARY KEY AUTOINCREMENT,
    mode TEXT NOT NULL UNIQUE
);

CREATE TABLE statuts_appro (
    id  INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL UNIQUE
        CHECK (nom IN ('EN_COURS', 'RECEPTIONNE_PARTIEL', 'RECEPTIONNE'))
);



CREATE TABLE utilisateurs (
    id           INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_complet  TEXT NOT NULL,
    email        TEXT NOT NULL UNIQUE,
    mot_passe    TEXT NOT NULL,
    adresse      TEXT,
    tel          TEXT,
    role_id      INTEGER NOT NULL REFERENCES roles(id) ON DELETE RESTRICT,
    cree_le      TEXT NOT NULL DEFAULT (datetime('now'))
);



CREATE TABLE clients (
    id            INTEGER PRIMARY KEY AUTOINCREMENT,
    nom           TEXT NOT NULL,
    prenom        TEXT NOT NULL,
    email         TEXT,
    tel           TEXT,
    limite_credit REAL NOT NULL DEFAULT 0
        CHECK (limite_credit >= 0)
);

CREATE TABLE fournisseurs (
    id      INTEGER PRIMARY KEY AUTOINCREMENT,
    nom     TEXT NOT NULL,
    email   TEXT,
    tel     TEXT,
    adresse TEXT
);



CREATE TABLE produits (
    id            INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle       TEXT NOT NULL,
    prix_vente    REAL NOT NULL CHECK (prix_vente > 0),
    stock_initial INTEGER NOT NULL DEFAULT 0 CHECK (stock_initial >= 0),
    stock_actuel  INTEGER NOT NULL DEFAULT 0 CHECK (stock_actuel >= 0),
    seuil_alerte  INTEGER NOT NULL DEFAULT 5 CHECK (seuil_alerte >= 0)
);



CREATE TABLE commandes (
    id               INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id        INTEGER NOT NULL REFERENCES clients(id) ON DELETE RESTRICT,
    utilisateur_id   INTEGER NOT NULL REFERENCES utilisateurs(id) ON DELETE RESTRICT,
    mode_paiement_id INTEGER REFERENCES modes_paiement(id) ON DELETE RESTRICT,
    date_commande    TEXT NOT NULL DEFAULT (datetime('now')),
    montant_initial  REAL NOT NULL CHECK (montant_initial >= 0),
    montant_total    REAL NOT NULL CHECK (montant_total >= 0),
    statut           TEXT NOT NULL DEFAULT 'EN_COURS'
        CHECK (statut IN ('EN_COURS', 'SOLDEE', 'ANNULEE'))
);

CREATE TABLE lignes_commande (
    id            INTEGER PRIMARY KEY AUTOINCREMENT,
    commande_id   INTEGER NOT NULL REFERENCES commandes(id) ON DELETE CASCADE,
    produit_id    INTEGER NOT NULL REFERENCES produits(id) ON DELETE RESTRICT,
    qte_commande  INTEGER NOT NULL CHECK (qte_commande > 0),
    prix_reel     REAL NOT NULL CHECK (prix_reel >= 0)
);



CREATE TABLE dettes (
    id            INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id     INTEGER NOT NULL REFERENCES clients(id) ON DELETE RESTRICT,
    commande_id   INTEGER NOT NULL REFERENCES commandes(id) ON DELETE RESTRICT,
    montant_du    REAL NOT NULL CHECK (montant_du >= 0),
    montant_paye  REAL NOT NULL DEFAULT 0 CHECK (montant_paye >= 0),
    statut        TEXT NOT NULL DEFAULT 'NON_SOLDEE'
        CHECK (statut IN ('NON_SOLDEE', 'SOLDEE')),
    date_creation TEXT NOT NULL DEFAULT (datetime('now')),
    CHECK (montant_paye <= montant_du)
);

CREATE TABLE reglements (
    id               INTEGER PRIMARY KEY AUTOINCREMENT,
    dette_id         INTEGER NOT NULL REFERENCES dettes(id) ON DELETE CASCADE,
    mode_paiement_id INTEGER NOT NULL REFERENCES modes_paiement(id) ON DELETE RESTRICT,
    date             TEXT NOT NULL DEFAULT (datetime('now')),
    montant          REAL NOT NULL CHECK (montant > 0)
);



CREATE TABLE appros (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    fournisseur_id  INTEGER NOT NULL REFERENCES fournisseurs(id) ON DELETE RESTRICT,
    utilisateur_id  INTEGER NOT NULL REFERENCES utilisateurs(id) ON DELETE RESTRICT,
    statut_appro_id INTEGER NOT NULL REFERENCES statuts_appro(id) ON DELETE RESTRICT,
    ref_bl          TEXT NOT NULL,
    date_appro      TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE lignes_appro (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    appro_id    INTEGER NOT NULL REFERENCES appros(id) ON DELETE CASCADE,
    produit_id  INTEGER NOT NULL REFERENCES produits(id) ON DELETE RESTRICT,
    qte_appro   INTEGER NOT NULL CHECK (qte_appro > 0),
    qte_recu    INTEGER NOT NULL DEFAULT 0 CHECK (qte_recu >= 0),
    prix_reel   REAL NOT NULL CHECK (prix_reel >= 0)
);


