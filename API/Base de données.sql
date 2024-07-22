-- Création de la base de données
CREATE DATABASE IF NOT EXISTS location_vehicules;
USE location_vehicules;

-- Table des utilisateurs
CREATE TABLE utilisateur (
  id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255) NOT NULL,
  prenom VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  mot_de_passe VARCHAR(255) NOT NULL,
  adresse VARCHAR(255) NOT NULL,
  code_postal VARCHAR(10) NOT NULL,
  ville VARCHAR(255) NOT NULL,
  pays VARCHAR(255) NOT NULL,
  telephone VARCHAR(20) NOT NULL,
  date_naissance DATE NOT NULL,
  permis_conduire VARCHAR(255) NOT NULL,
  date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table des catégories de véhicules
CREATE TABLE categorie (
  id_categorie INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255) NOT NULL UNIQUE,
  description TEXT,
  prix_journalier DECIMAL(10,2) NOT NULL,
  image VARCHAR(255)
);

-- Table des véhicules
CREATE TABLE vehicule (
  id_vehicule INT AUTO_INCREMENT PRIMARY KEY,
  id_categorie INT NOT NULL,
  marque VARCHAR(255) NOT NULL,
  modele VARCHAR(255) NOT NULL,
  annee INT NOT NULL,
  immatriculation VARCHAR(20) UNIQUE NOT NULL,
  kilometrage INT NOT NULL,
  nombre_places INT NOT NULL,
  climatisation BOOLEAN NOT NULL DEFAULT FALSE,
  gps BOOLEAN NOT NULL DEFAULT FALSE,
  transmission VARCHAR(50) NOT NULL DEFAULT 'Manuelle',
  carburant VARCHAR(50) NOT NULL DEFAULT 'Essence',
  disponible BOOLEAN NOT NULL DEFAULT TRUE,
  image VARCHAR(255),
  FOREIGN KEY (id_categorie) REFERENCES categorie(id_categorie)
);

-- Table des agences de location
CREATE TABLE agence (
  id_agence INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255) NOT NULL,
  adresse VARCHAR(255) NOT NULL,
  code_postal VARCHAR(10) NOT NULL,
  ville VARCHAR(255) NOT NULL,
  pays VARCHAR(255) NOT NULL
);

-- Table de liaison pour les véhicules disponibles dans chaque agence
CREATE TABLE disponibilite (
  id_disponibilite INT AUTO_INCREMENT PRIMARY KEY,
  id_vehicule INT NOT NULL,
  id_agence INT NOT NULL,
  quantite INT NOT NULL DEFAULT 1,
  FOREIGN KEY (id_vehicule) REFERENCES vehicule(id_vehicule),
  FOREIGN KEY (id_agence) REFERENCES agence(id_agence)
);

-- Table des locations
CREATE TABLE location (
  id_location INT AUTO_INCREMENT PRIMARY KEY,
  id_utilisateur INT NOT NULL,
  id_vehicule INT NOT NULL,
  id_agence_depart INT NOT NULL,
  id_agence_retour INT NOT NULL,
  date_debut DATE NOT NULL,
  date_fin DATE NOT NULL,
  prix_total DECIMAL(10,2) NOT NULL,
  statut VARCHAR(50) NOT NULL DEFAULT 'En attente', -- En attente, Confirmée, En cours, Terminée, Annulée
  date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur),
  FOREIGN KEY (id_vehicule) REFERENCES vehicule(id_vehicule),
  FOREIGN KEY (id_agence_depart) REFERENCES agence(id_agence),
  FOREIGN KEY (id_agence_retour) REFERENCES agence(id_agence)
);

-- Table des avis
CREATE TABLE avis (
  id_avis INT AUTO_INCREMENT PRIMARY KEY,
  id_location INT NOT NULL,
  note INT NOT NULL,
  commentaire TEXT,
  date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_location) REFERENCES location(id_location)
);

-- Data de test pour la table categorie
INSERT INTO categorie (nom, description, prix_journalier) VALUES
('Citadine', 'Petite voiture idéale pour la ville', 30.00),
('Berline', 'Voiture confortable pour longs trajets', 50.00),
('SUV', 'Véhicule spacieux pour toute la famille', 70.00),
('Utilitaire', 'Véhicule pour le transport de marchandises', 60.00);

-- Insertion de 25 véhicules avec des données aléatoires
INSERT INTO vehicule (id_categorie, marque, modele, annee, immatriculation, kilometrage, nombre_places, climatisation, gps, transmission, carburant, disponible, image)
VALUES
(1, 'Renault', 'Clio', 2018, 'AA-123-BB', 50000, 5, 1, 0, 'Manuelle', 'Essence', 1, 'clio.jpg'),
(2, 'Peugeot', '308', 2020, 'CC-456-DD', 30000, 5, 1, 1, 'Automatique', 'Diesel', 1, '308.jpg'),
(3, 'Citroen', 'C4 Picasso', 2019, 'EE-789-FF', 40000, 7, 1, 0, 'Manuelle', 'Essence', 1, 'c4-picasso.jpg'),
(1, 'Fiat', '500', 2021, 'GG-112-HH', 20000, 4, 0, 0, 'Manuelle', 'Essence', 1, 'fiat-500.jpg'),
(2, 'Opel', 'Astra', 2017, 'II-345-JJ', 60000, 5, 1, 1, 'Manuelle', 'Diesel', 1, 'astra.jpg'),
(3, 'Dacia', 'Duster', 2022, 'KK-678-LL', 10000, 5, 0, 1, 'Manuelle', 'Essence', 1, 'duster.jpg'),
(1, 'Toyota', 'Yaris', 2019, 'MM-901-NN', 35000, 5, 1, 0, 'Automatique', 'Hybride', 1, 'yaris.jpg'),
(2, 'Ford', 'Focus', 2020, 'OO-234-PP', 25000, 5, 1, 1, 'Manuelle', 'Diesel', 1, 'focus.jpg'),
(3, 'Nissan', 'Qashqai', 2018, 'QQ-567-RR', 45000, 5, 1, 0, 'Automatique', 'Essence', 1, 'qashqai.jpg'),
(1, 'Volkswagen', 'Polo', 2021, 'SS-890-TT', 15000, 5, 0, 0, 'Manuelle', 'Essence', 1, 'polo.jpg'),
(2, 'Hyundai', 'i30', 2019, 'UU-123-VV', 30000, 5, 1, 1, 'Manuelle', 'Essence', 1, 'i30.jpg'),
(3, 'Kia', 'Sportage', 2020, 'WW-456-XX', 20000, 5, 1, 0, 'Automatique', 'Diesel', 1, 'sportage.jpg'),
(1, 'Seat', 'Ibiza', 2018, 'YY-789-ZZ', 50000, 5, 1, 0, 'Manuelle', 'Essence', 1, 'ibiza.jpg'),
(2, 'Skoda', 'Octavia', 2021, 'A1-123-B2', 10000, 5, 1, 1, 'Automatique', 'Essence', 1, 'octavia.jpg'),
(3, 'BMW', 'X1', 2019, 'C3-456-D4', 40000, 5, 1, 1, 'Automatique', 'Diesel', 1, 'x1.jpg'),
(1, 'Audi', 'A3', 2020, 'E5-789-F6', 30000, 5, 1, 1, 'Manuelle', 'Diesel', 1, 'a3.jpg'),
(2, 'Mercedes', 'Classe A', 2018, 'G7-112-H8', 50000, 5, 1, 1, 'Automatique', 'Essence', 1, 'classe-a.jpg'),
(3, 'Volvo', 'XC40', 2022, 'I9-345-J0', 10000, 5, 1, 1, 'Automatique', 'Hybride', 1, 'xc40.jpg'),
(1, 'Mini', 'Cooper', 2019, 'K1-678-L2', 40000, 4, 1, 0, 'Manuelle', 'Essence', 1, 'cooper.jpg'),
(2, 'Mazda', '3', 2020, 'M3-901-N4', 25000, 5, 1, 1, 'Manuelle', 'Essence', 1, 'mazda-3.jpg'),
(3, 'Jeep', 'Renegade', 2018, 'O5-234-P6', 45000, 5, 1, 0, 'Automatique', 'Essence', 1, 'renegade.jpg'),
(4, 'Renault', 'Trafic', 2019, 'Q7-567-R8', 80000, 3, 0, 0, 'Manuelle', 'Diesel', 1, 'trafic.jpg'),
(4, 'Citroen', 'Jumpy', 2020, 'S9-890-T0', 60000, 3, 0, 1, 'Manuelle', 'Diesel', 1, 'jumpy.jpg'),
(4, 'Peugeot', 'Expert', 2021, 'U1-123-V2', 40000, 3, 1, 0, 'Manuelle', 'Diesel', 1, 'expert.jpg');

-- Insertion de 20 utilisateurs avec des données plus réalistes
INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, adresse, code_postal, ville, pays, telephone, date_naissance, permis_conduire)
VALUES
('Martin', 'Sophie', 'sophie.martin@example.com', 'password123', '10 Rue des Lilas', '75019', 'Paris', 'France', '0612345678', '1985-03-15', '1234567890123456'),
('Bernard', 'Pierre', 'pierre.bernard@example.com', 'voiture456', '25 Avenue du Général Leclerc', '33000', 'Bordeaux', 'France', '0623456789', '1978-09-22', '9876543210987654'),
('Dubois', 'Léa', 'lea.dubois@example.com', 'conduire789', '8 Rue de la Paix', '69002', 'Lyon', 'France', '0634567890', '1992-06-05', '1011121314151617'),
('Petit', 'Thomas', 'thomas.petit@example.com', 'route2023', '14 Boulevard Victor Hugo', '13008', 'Marseille', 'France', '0645678901', '1989-12-18', '1819202122232425'),
('Robert', 'Camille', 'camille.robert@example.com', 'voyage567', '3 Rue des Remparts', '67000', 'Strasbourg', 'France', '0656789012', '1995-04-02', '2627282930313233'),
('Moreau', 'Lucas', 'lucas.moreau@example.com', 'location890', '19 Place de la République', '44000', 'Nantes', 'France', '0667890123', '1982-07-29', '3435363738394041'),
('Laurent', 'Manon', 'manon.laurent@example.com', 'vehicule123', '7 Avenue Jean Jaurès', '31000', 'Toulouse', 'France', '0678901234', '1998-10-11', '4243444546474849'),
('Simon', 'Hugo', 'hugo.simon@example.com', 'trajet456', '22 Rue du Commerce', '59000', 'Lille', 'France', '0689012345', '1975-01-08', '5051525354555657'),
('Michel', 'Chloé', 'chloe.michel@example.com', 'explorer789', '5 Place de la Comédie', '34000', 'Montpellier', 'France', '0690123456', '2001-05-20', '5859606162636465'),
('Lefebvre', 'Nathan', 'nathan.lefebvre@example.com', 'decouvrir2023', '16 Boulevard de la Liberté', '13001', 'Marseille', 'France', '0701234567', '1987-08-31', '6667686970717273'),
('Leroy', 'Emma', 'emma.leroy@example.com', 'itineraire567', '9 Rue du Faubourg Saint-Honoré', '75008', 'Paris', 'France', '0712345678', '1994-02-14', '7475767778798081'),
('Roux', 'Alexandre', 'alexandre.roux@example.com', 'vacances890', '32 Avenue des Champs-Elysées', '75008', 'Paris', 'France', '0723456789', '1979-11-27', '8283848586878889'),
('David', 'Inès', 'ines.david@example.com', 'sejour123', '11 Rue de Rivoli', '75004', 'Paris', 'France', '0734567890', '1996-09-06', '9091929394959697'),
('Bertrand', 'Quentin', 'quentin.bertrand@example.com', 'kilometres456', '28 Place Bellecour', '69002', 'Lyon', 'France', '0745678901', '1983-04-13', '9899000102030405'),
('Morel', 'Juliette', 'juliette.morel@example.com', 'explorer2023', '15 Rue Saint-Jean', '69005', 'Lyon', 'France', '0756789012', '2000-01-25', '0607080910111213'),
('Fournier', 'Adam', 'adam.fournier@example.com', 'destination789', '4 Rue de la Marne', '33000', 'Bordeaux', 'France', '0767890123', '1991-07-09', '1415161718192021'),
('Girard', 'Eva', 'eva.girard@example.com', 'liberte567', '20 Place Kléber', '67000', 'Strasbourg', 'France', '0778901234', '1977-12-16', '2223242526272829'),
('Bonnet', 'Gabriel', 'gabriel.bonnet@example.com', 'partir890', '8 Quai des Belges', '44000', 'Nantes', 'France', '0789012345', '1999-03-28', '3031323334353637'),
('Vincent', 'Jade', 'jade.vincent@example.com', 'horizon123', '23 Rue de la République', '34000', 'Montpellier', 'France', '0790123456', '1986-06-01', '3839404142434445'),
('Clement', 'Raphaël', 'raphael.clement@example.com', 'aventure456', '13 Rue Gambetta', '59000', 'Lille', 'France', '0700112233', '1993-10-24', '4647484950515253');

-- Insertion de 3 agences
INSERT INTO agence (nom, adresse, code_postal, ville, pays)
VALUES
('Agence du Centre', '12 Rue Principale', '75001', 'Paris', 'France'),
('Agence du Sud', '45 Avenue de la Plage', '13008', 'Marseille', 'France'),
("Agence de l'Est", '87 Rue de la Gare', '67000', 'Strasbourg', 'France');

TRUNCATE TABLE disponibilite;

-- Procédure stockée pour ajouter des véhicules disponibles de manière aléatoire mais contrôlée
DELIMITER //
CREATE PROCEDURE RemplirDisponibilite(IN idAgence INT, IN quantiteMin INT, IN quantiteMax INT)
BEGIN
  DECLARE i INT DEFAULT 1;
  WHILE i <= (SELECT FLOOR(RAND() * (quantiteMax - quantiteMin + 1)) + quantiteMin) DO
    INSERT INTO disponibilite (id_vehicule, id_agence, quantite)
    SELECT 
        FLOOR(RAND() * 25) + 1, -- ID véhicule aléatoire
        idAgence, 
        FLOOR(RAND() * 3) + 1 -- Quantité aléatoire entre 1 et 3
    FROM vehicule
    WHERE NOT EXISTS (
        SELECT 1 
        FROM disponibilite 
        WHERE id_vehicule = FLOOR(RAND() * 25) + 1 AND id_agence = idAgence
    )
    LIMIT 1;
    SET i = i + 1;
  END WHILE;
END //
DELIMITER ;

-- Remplissage pour chaque agence
CALL RemplirDisponibilite(1, 5, 10); -- Agence du Centre
CALL RemplirDisponibilite(2, 5, 10); -- Agence du Sud
CALL RemplirDisponibilite(3, 5, 10); -- Agence de l'Est

-- Suppression de la procédure stockée
DROP PROCEDURE RemplirDisponibilite;


-- Création de 10 locations avec des données cohérentes
INSERT INTO location (id_utilisateur, id_vehicule, id_agence_depart, id_agence_retour, date_debut, date_fin, prix_total, statut)
SELECT
    u.id_utilisateur,
    v.id_vehicule,
    d.id_agence,
    -- Sélectionner une agence de retour différente de celle de départ avec une probabilité de 50%
    CASE WHEN FLOOR(RAND() * 2) = 0 THEN d.id_agence ELSE (SELECT id_agence FROM agence WHERE id_agence != d.id_agence ORDER BY RAND() LIMIT 1) END,
    DATE_ADD(CURDATE(), INTERVAL -FLOOR(RAND() * 90) DAY), -- Date de début aléatoire sur les 90 derniers jours
    -- Calculer la date de fin en ajoutant 1 à 21 jours à la date de début
    DATE_ADD(DATE_ADD(CURDATE(), INTERVAL -FLOOR(RAND() * 90) DAY), INTERVAL FLOOR(RAND() * 21) + 1 DAY), 
    -- Calculer le prix total en fonction du nombre de jours de location et du prix journalier de la catégorie
    (DATEDIFF(DATE_ADD(DATE_ADD(CURDATE(), INTERVAL -FLOOR(RAND() * 90) DAY), INTERVAL FLOOR(RAND() * 21) + 1 DAY), DATE_ADD(CURDATE(), INTERVAL -FLOOR(RAND() * 90) DAY)) * c.prix_journalier) + (FLOOR(RAND() * 50) - 25), 
    CASE FLOOR(RAND() * 5)
        WHEN 0 THEN 'En attente'
        WHEN 1 THEN 'Confirmée'
        WHEN 2 THEN 'En cours'
        WHEN 3 THEN 'Terminée'
        ELSE 'Annulée'
    END
FROM utilisateur u
JOIN disponibilite d ON u.id_utilisateur BETWEEN d.id_vehicule AND (d.id_vehicule + 10) 
JOIN vehicule v ON d.id_vehicule = v.id_vehicule
JOIN categorie c ON v.id_categorie = c.id_categorie
ORDER BY RAND()
LIMIT 10;

-- Insertion de 10 avis pour des locations aléatoires
INSERT INTO avis (id_location, note, commentaire, date_creation)
SELECT 
    l.id_location,
    FLOOR(RAND() * 5) + 1, -- Note aléatoire entre 1 et 5
    CASE FLOOR(RAND() * 5)
        WHEN 0 THEN 'Très bon véhicule, je recommande.'
        WHEN 1 THEN 'Service client à améliorer.'
        WHEN 2 THEN 'Prix attractif, voiture propre et en bon état.'
        WHEN 3 THEN 'Rien à redire, tout s\'est bien passé.'
        ELSE 'A éviter, problème avec la location.'
    END,
    DATE_ADD(l.date_fin, INTERVAL FLOOR(RAND() * 3) DAY) -- Date de création de l'avis dans les 3 jours suivant la fin de la location
FROM location l
ORDER BY RAND()
LIMIT 10;

