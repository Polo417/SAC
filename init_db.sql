create database SAC;

create table Stock_dispo (
nom_produit CHAR(30) PRIMARY KEY,
quantite_actuelle NUMERIC(6,3) NOT NULL,
quantite_max NUMERIC(6,3) NOT NULL,
check(quantite_actuelle <= quantite_max)
);
 
create table Mesure (
etat CHAR(20) PRIMARY KEY,
unite CHAR(20) NOT NULL
);
 
create table Produit (
nom_precis CHAR(30) PRIMARY KEY References Stock_dispo.nom_produit,
famille_denree CHAR(30),
etat CHAR(20) References Mesure.etat,
prix_unite NUMERIC(6,2) NOT NULL
);
 
create table Info_interne (
num_appart INTEGER(4) PRIMARY KEY,
nom_habitant CHAR(20),
check(nom_habitant = upper(nom_habitant))
);
 
create table Consommation (
num_appart INTEGER(4) References Info_interne.num_appart,
nom_produit CHAR(30) References Produit.nom_precis,
quantite NUMERIC(6,3) NOT NULL,
PRIMARY KEY (num_appart, nom_produit)
);
 
show tables;
