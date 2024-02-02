# covoiturage

projet tp advenced web
EQUIPE : OULD SLIMANE NEILA HIOUANI LYDIA
Technologie utiliser : php, mysql, javacript, html, css
BDD : phpmyadmin
Pour faire fonctionner le projet :

1. Créer une base de donner nommer « covoiturage »

2. Executer les requete sql suivante pour créer les tables :
CREATE TABLE administrateur (
    mat_etd VARCHAR(100) NOT NULL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    mdp VARCHAR(255) NOT NULL
);

CREATE TABLE reservation (
    id_reservation INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    user VARCHAR(100) NOT NULL,
    user VARCHAR(100) NOT NULL,
    conducteur VARCHAR(100) NOT NULL,
    trajet INT(100) NOT NULL,
    depart VARCHAR(100) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    nom_cond VARCHAR(50) NOT NULL,
    nom_voyageur VARCHAR(50) NOT NULL,
    date_dep DATE NOT NULL,
    heure_dep TIME(6) NOT NULL
);

CREATE TABLE trajet (
    id_trajet INT(11) INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    depart VARCHAR(100) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    date_dep DATE NOT NULL,
    heure_dep TIME(6) NOT NULL,
    nb_passager INT(11) NOT NULL,
    latitude DOUBLE,
    longitude DOUBLE,
    conducteur VARCHAR(100) NOT NULL,
    place_dispo INT(10) NOT NULL,
    FOREIGN KEY (conducteur) REFERENCES utilisateur(mat_etd)
);

CREATE TABLE user (
    mat_etd VARCHAR(100) NOT NULL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    num_tel INT(12) NOT NULL,
    email VARCHAR(30) NOT NULL,
    mdp VARCHAR(100) NOT NULL,
    latitude DOUBLE NOT NULL,
    longitude DOUBLE NOT NULL
);
CREATE TABLE utilisateur (
    mat_etd VARCHAR(100) NOT NULL PRIMARY KEY,
    nom VARCHAR(20) NOT NULL,
    prenom VARCHAR(20) NOT NULL,
    num_tel INT(12) NOT NULL,
    email VARCHAR(30) NOT NULL,
    mdp VARCHAR(100) NOT NULL,
    matricule_v VARCHAR(25) NOT NULL,
    UNIQUE KEY email (email),
    UNIQUE KEY matricule_v (matricule_v)
);

CREATE TABLE utilisateur (
    mat_etd VARCHAR(100) NOT NULL PRIMARY KEY,
    nom VARCHAR(20) NOT NULL,
    prenom VARCHAR(20) NOT NULL,
    num_tel INT(12) NOT NULL,
    email VARCHAR(30) NOT NULL,
    mdp VARCHAR(100) NOT NULL,
    matricule_v VARCHAR(25) NOT NULL,
    UNIQUE KEY email (email),
    UNIQUE KEY matricule_v (matricule_v)
);
