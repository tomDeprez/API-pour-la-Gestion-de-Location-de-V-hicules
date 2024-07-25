<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Configuration de la base de données
$db_host = 'localhost';
$db_name = 'location_vehicules';
$db_user = 'root';
$db_pass = '';

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(array('error' => 'Erreur de connexion à la base de données : ' . $e->getMessage()));
    die();
}

// Récupération de la méthode HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Définir l'URL de base de l'API
$baseUrl = "/API";

// Définir les routes de l'API
$routes = [
    'GET' => [
        $baseUrl . '/utilisateurs' => 'getUtilisateurs',
        $baseUrl . '/utilisateurs/([0-9]+)' => 'getUtilisateurById',
        $baseUrl . '/categories' => 'getCategories',
        $baseUrl . '/categories/([0-9]+)' => 'getCategorieById',
        $baseUrl . '/vehicules' => 'getVehicules',
        $baseUrl . '/vehicules/([0-9]+)' => 'getVehiculeById',
        $baseUrl . '/agences' => 'getAgences',
        $baseUrl . '/agences/([0-9]+)' => 'getAgenceById',
        $baseUrl . '/disponibilites' => 'getDisponibilites',
        $baseUrl . '/disponibilites/([0-9]+)' => 'getDisponibiliteById',
        $baseUrl . '/locations' => 'getLocations',
        $baseUrl . '/locations/([0-9]+)' => 'getLocationById',
        $baseUrl . '/avis' => 'getAvis',
        $baseUrl . '/avis/([0-9]+)' => 'getAvisById'
    ],
    'POST' => [
        $baseUrl . '/utilisateurs' => 'createUtilisateur',
        $baseUrl . '/categories' => 'createCategorie',
        $baseUrl . '/vehicules' => 'createVehicule',
        $baseUrl . '/agences' => 'createAgence',
        $baseUrl . '/disponibilites' => 'createDisponibilite',
        $baseUrl . '/locations' => 'createLocation',
        $baseUrl . '/avis' => 'createAvis'
    ],
    'PUT' => [
        $baseUrl . '/utilisateurs/([0-9]+)' => 'updateUtilisateur',
        $baseUrl . '/categories/([0-9]+)' => 'updateCategorie',
        $baseUrl . '/vehicules/([0-9]+)' => 'updateVehicule',
        $baseUrl . '/agences/([0-9]+)' => 'updateAgence',
        $baseUrl . '/disponibilites/([0-9]+)' => 'updateDisponibilite',
        $baseUrl . '/locations/([0-9]+)' => 'updateLocation'
    ],
    'DELETE' => [
        $baseUrl . '/utilisateurs/([0-9]+)' => 'deleteUtilisateur',
        $baseUrl . '/categories/([0-9]+)' => 'deleteCategorie',
        $baseUrl . '/vehicules/([0-9]+)' => 'deleteVehicule',
        $baseUrl . '/agences/([0-9]+)' => 'deleteAgence',
        $baseUrl . '/disponibilites/([0-9]+)' => 'deleteDisponibilite',
        $baseUrl . '/locations/([0-9]+)' => 'deleteLocation',
        $baseUrl . '/avis/([0-9]+)' => 'deleteAvis'
    ]
];


$routeFound = false;
foreach ($routes[$method] as $route => $function) {
    $matches = [];
    if (preg_match('#^' . $route . '$#', $_SERVER['REQUEST_URI'], $matches)) {
        $routeFound = true;
        array_shift($matches);
        call_user_func_array($function, $matches);
        break;
    }
}

if (!$routeFound) {
    http_response_code(404);
    echo json_encode(array('error' => 'Route non trouvée'));
}

function getUtilisateurs()
{
    global $db;
    $stmt = $db->query('SELECT * FROM utilisateur');
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($utilisateurs);
}

function getUtilisateurById($id)
{
    global $db;
    $stmt = $db->prepare('SELECT * FROM utilisateur WHERE id_utilisateur = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($utilisateur) {
        echo json_encode($utilisateur);
    } else {
        http_response_code(404); 
        echo json_encode(array('error' => 'Aucun utilisateur trouvé avec cet ID.'));
    }
}

function createUtilisateur()
{
    global $db;
    $data = json_decode(file_get_contents("php://input"), true);

    $errors = validateUtilisateurData($data);
    if (!empty($errors)) {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Données invalides', 'details' => $errors]);
        return;
    }

    try {
        $stmt = $db->prepare('INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, adresse, code_postal, ville, pays, telephone, date_naissance, permis_conduire) 
                            VALUES (:nom, :prenom, :email, :mot_de_passe, :adresse, :code_postal, :ville, :pays, :telephone, :date_naissance, :permis_conduire)');
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':prenom', $data['prenom']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':mot_de_passe', $data['mot_de_passe']);
        $stmt->bindParam(':adresse', $data['adresse']);
        $stmt->bindParam(':code_postal', $data['code_postal']);
        $stmt->bindParam(':ville', $data['ville']);
        $stmt->bindParam(':pays', $data['pays']);
        $stmt->bindParam(':telephone', $data['telephone']);
        $stmt->bindParam(':date_naissance', $data['date_naissance']);
        $stmt->bindParam(':permis_conduire', $data['permis_conduire']);
        
        $stmt->execute();
        $id = $db->lastInsertId();
        echo json_encode(array('message' => 'Utilisateur créé avec succès', 'id' => $id));
        http_response_code(201);
    } catch (PDOException $e) {
        http_response_code(500); 
        if ($e->getCode() == 23000) { 
            echo json_encode(array('error' => 'Erreur : Un utilisateur avec cet email existe déjà.'));
        } else {
            echo json_encode(array('error' => 'Erreur lors de la création de l\'utilisateur. Veuillez réessayer plus tard.'));
        }
    }
}

function updateUtilisateur($id)
{
    global $db;
    $data = json_decode(file_get_contents("php://input"), true);

     
    $errors = validateUtilisateurData($data);
    if (!empty($errors)) {
        http_response_code(400); 
        echo json_encode(['error' => 'Données invalides', 'details' => $errors]);
        return;
    }

    try {
        $stmt = $db->prepare('UPDATE utilisateur 
                            SET nom = :nom, 
                                prenom = :prenom, 
                                email = :email, 
                                mot_de_passe = :mot_de_passe, 
                                adresse = :adresse, 
                                code_postal = :code_postal, 
                                ville = :ville, 
                                pays = :pays, 
                                telephone = :telephone, 
                                date_naissance = :date_naissance, 
                                permis_conduire = :permis_conduire 
                            WHERE id_utilisateur = :id');

        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':prenom', $data['prenom']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':mot_de_passe', $data['mot_de_passe']);
        $stmt->bindParam(':adresse', $data['adresse']);
        $stmt->bindParam(':code_postal', $data['code_postal']);
        $stmt->bindParam(':ville', $data['ville']);
        $stmt->bindParam(':pays', $data['pays']);
        $stmt->bindParam(':telephone', $data['telephone']);
        $stmt->bindParam(':date_naissance', $data['date_naissance']);
        $stmt->bindParam(':permis_conduire', $data['permis_conduire']);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) { 
            echo json_encode(array('message' => 'Utilisateur mis à jour avec succès'));
        } else {
            http_response_code(404); 
            echo json_encode(array('error' => 'Aucun utilisateur trouvé avec cet ID.'));
        }
    } catch (PDOException $e) {
        http_response_code(500); 
        if ($e->getCode() == 23000) {
            echo json_encode(array('error' => 'Erreur : Un utilisateur avec cet email existe déjà.'));
        } else {
            echo json_encode(array('error' => 'Erreur lors de la mise à jour de l\'utilisateur. Veuillez réessayer plus tard.'));
        }
    }
}

function deleteUtilisateur($id)
{
    global $db;
    
    try {
        $stmt = $db->prepare('DELETE FROM utilisateur WHERE id_utilisateur = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(array('message' => 'Utilisateur supprimé avec succès'));
        } else {
            http_response_code(404); 
            echo json_encode(array('error' => 'Aucun utilisateur trouvé avec cet ID.'));
        }
    } catch (PDOException $e) {
        http_response_code(500); 
        echo json_encode(array('error' => 'Erreur lors de la suppression de l\'utilisateur. Veuillez réessayer plus tard.'));
    }
}


function validateUtilisateurData($data) {
    $errors = [];

    if (empty($data['nom'])) {
        $errors['nom'] = 'Le nom est requis';
    }
    if (empty($data['prenom'])) {
        $errors['prenom'] = 'Le prénom est requis';
    }
    if (empty($data['email'])) {
        $errors['email'] = 'L\'email est requis';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'L\'email est invalide';
    }
    if (empty($data['mot_de_passe'])) {
        $errors['mot_de_passe'] = 'Le mot de passe est requis';
    } 
    if (empty($data['adresse'])) {
        $errors['adresse'] = 'L\'adresse est requise';
    }
    if (empty($data['code_postal'])) {
        $errors['code_postal'] = 'Le code postal est requis';
    }
    if (empty($data['ville'])) {
        $errors['ville'] = 'La ville est requise';
    }
    if (empty($data['pays'])) {
        $errors['pays'] = 'Le pays est requis';
    }
    if (empty($data['telephone'])) {
        $errors['telephone'] = 'Le téléphone est requis';
    } elseif (!preg_match('/^[0-9+\s-]{8,}$/', $data['telephone'])) { 
        $errors['telephone'] = 'Le numéro de téléphone est invalide';
    }
    if (empty($data['date_naissance'])) {
        $errors['date_naissance'] = 'La date de naissance est requise';
    } elseif (!validateDate($data['date_naissance'])) { 
        $errors['date_naissance'] = 'La date de naissance est invalide';
    }
    if (empty($data['permis_conduire'])) {
        $errors['permis_conduire'] = 'Le permis de conduire est requis';
    }

    return $errors;
}

// Fonctions de gestion des catégories
function getCategories()
{
    global $db;
    $stmt = $db->query('SELECT * FROM categorie');
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($categories);
}

function getCategorieById($id)
{
    global $db;
    $stmt = $db->prepare('SELECT * FROM categorie WHERE id_categorie = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $categorie = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($categorie) {
        echo json_encode($categorie);
    } else {
        http_response_code(404);
        echo json_encode(array('error' => 'Aucune catégorie trouvée avec cet ID.'));
    }
}

function createCategorie()
{
    global $db;
    $data = json_decode(file_get_contents("php://input"), true);

     
    $errors = validateCategorieData($data);
    if (!empty($errors)) {
        http_response_code(400); 
        echo json_encode(['error' => 'Données invalides', 'details' => $errors]);
        return;
    }

    try {
        $stmt = $db->prepare('INSERT INTO categorie (nom, description, prix_journalier, image) 
                            VALUES (:nom, :description, :prix_journalier, :image)');
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':prix_journalier', $data['prix_journalier']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->execute();
        $id = $db->lastInsertId();
        echo json_encode(array('message' => 'Catégorie créée avec succès', 'id' => $id));
        http_response_code(201);
    } catch (PDOException $e) {
        http_response_code(500); 
        if ($e->getCode() == 23000) { 
            echo json_encode(array('error' => 'Erreur : Une catégorie avec ce nom existe déjà.')); 
        } else {
            echo json_encode(array('error' => 'Erreur lors de la création de la catégorie. Veuillez réessayer plus tard.'));
        }
    }
}

function updateCategorie($id)
{
    global $db;
    $data = json_decode(file_get_contents("php://input"), true);

    $errors = validateCategorieData($data);
    if (!empty($errors)) {
        http_response_code(400); 
        echo json_encode(['error' => 'Données invalides', 'details' => $errors]);
        return;
    }

    try {
        $stmt = $db->prepare('UPDATE categorie SET 
                            nom = :nom, 
                            description = :description, 
                            prix_journalier = :prix_journalier,
                            image = :image 
                            WHERE id_categorie = :id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':prix_journalier', $data['prix_journalier']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(array('message' => 'Catégorie mise à jour avec succès'));
        } else {
            http_response_code(404); 
            echo json_encode(array('error' => 'Aucune catégorie trouvée avec cet ID.'));
        }
    } catch (PDOException $e) {
        http_response_code(500); 
        if ($e->getCode() == 23000) { 
            echo json_encode(array('error' => 'Erreur : Une catégorie avec ce nom existe déjà.')); 
        } else {
            echo json_encode(array('error' => 'Erreur lors de la mise à jour de la catégorie. Veuillez réessayer plus tard.'));
        }
    }
}

function deleteCategorie($id)
{
    global $db;
    try {
        $stmt = $db->prepare('DELETE FROM categorie WHERE id_categorie = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(array('message' => 'Catégorie supprimée avec succès'));
        } else {
            http_response_code(404);
            echo json_encode(array('error' => 'Aucune catégorie trouvée avec cet ID.'));
        }
    } catch (PDOException $e) {
        http_response_code(500); 
        // Vérifier si la suppression est impossible en raison de la contrainte de clé étrangère
        if ($e->getCode() == 23000) {
            echo json_encode(array('error' => 'Erreur : Impossible de supprimer la catégorie. Des véhicules y sont associés.'));
        } else {
            echo json_encode(array('error' => 'Erreur lors de la suppression de la catégorie. Veuillez réessayer plus tard.'));
        }
    }
}


function validateCategorieData($data) {
    $errors = [];

    if (empty($data['nom'])) {
        $errors['nom'] = 'Le nom est requis.';
    }
    if (empty($data['prix_journalier'])) {
        $errors['prix_journalier'] = 'Le prix journalier est requis.';
    } elseif (!filter_var($data['prix_journalier'], FILTER_VALIDATE_FLOAT) || $data['prix_journalier'] <= 0) {
        $errors['prix_journalier'] = 'Le prix journalier doit être un nombre positif.';
    }
    
    return $errors;
}
// Fonctions de gestion des véhicules
function getVehicules()
{
    global $db;
    $stmt = $db->query('SELECT * FROM vehicule');
    $vehicules = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($vehicules);
}

function getVehiculeById($id)
{
    global $db;
    $stmt = $db->prepare('SELECT * FROM vehicule WHERE id_vehicule = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $vehicule = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($vehicule) {
        echo json_encode($vehicule);
    } else {
        http_response_code(404);
        echo json_encode(array('error' => 'Aucun véhicule trouvé avec cet ID.'));
    }
}

function createVehicule()
{
    global $db;
    $data = json_decode(file_get_contents("php://input"), true);

     
    $errors = validateVehiculeData($data);
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['error' => 'Données invalides', 'details' => $errors]);
        return;
    }

    try {
        $stmt = $db->prepare('INSERT INTO vehicule (id_categorie, marque, modele, annee, immatriculation, kilometrage, nombre_places, climatisation, gps, transmission, carburant, disponible, image) 
                            VALUES (:id_categorie, :marque, :modele, :annee, :immatriculation, :kilometrage, :nombre_places, :climatisation, :gps, :transmission, :carburant, :disponible, :image)');

        $stmt->bindParam(':id_categorie', $data['id_categorie']);
        $stmt->bindParam(':marque', $data['marque']);
        $stmt->bindParam(':modele', $data['modele']);
        $stmt->bindParam(':annee', $data['annee']);
        $stmt->bindParam(':immatriculation', $data['immatriculation']);
        $stmt->bindParam(':kilometrage', $data['kilometrage']);
        $stmt->bindParam(':nombre_places', $data['nombre_places']);
        $stmt->bindParam(':climatisation', $data['climatisation']);
        $stmt->bindParam(':gps', $data['gps']);
        $stmt->bindParam(':transmission', $data['transmission']);
        $stmt->bindParam(':carburant', $data['carburant']);
        $stmt->bindParam(':disponible', $data['disponible']);
        $stmt->bindParam(':image', $data['image']);

        $stmt->execute();
        $id = $db->lastInsertId();
        echo json_encode(array('message' => 'Véhicule créé avec succès', 'id' => $id));
        http_response_code(201);
    } catch (PDOException $e) {
        http_response_code(500); 
        if ($e->getCode() == 23000) {
            // Gestion des erreurs de clé dupliquée (par exemple, immatriculation)
            echo json_encode(array('error' => 'Erreur : Un véhicule avec cette immatriculation existe déjà.'));
        } else if ($e->getCode() == 22007) {
            // Gestion des erreurs de format de données (par exemple, date invalide)
            echo json_encode(array('error' => 'Erreur : Vérifiez le format des données saisies (par exemple, date).')); 
        } else {
            echo json_encode(array('error' => 'Erreur lors de la création du véhicule. Veuillez réessayer plus tard.')); 
        }
    }
}

function updateVehicule($id)
{
    global $db;
    $data = json_decode(file_get_contents("php://input"), true);

     
    $errors = validateVehiculeData($data);
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['error' => 'Données invalides', 'details' => $errors]);
        return;
    }

    try {
        $stmt = $db->prepare('UPDATE vehicule SET 
                            id_categorie = :id_categorie,
                            marque = :marque, 
                            modele = :modele, 
                            annee = :annee, 
                            immatriculation = :immatriculation, 
                            kilometrage = :kilometrage, 
                            nombre_places = :nombre_places, 
                            climatisation = :climatisation, 
                            gps = :gps, 
                            transmission = :transmission, 
                            carburant = :carburant, 
                            disponible = :disponible, 
                            image = :image 
                            WHERE id_vehicule = :id');

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_categorie', $data['id_categorie']);
        $stmt->bindParam(':marque', $data['marque']);
        $stmt->bindParam(':modele', $data['modele']);
        $stmt->bindParam(':annee', $data['annee']);
        $stmt->bindParam(':immatriculation', $data['immatriculation']);
        $stmt->bindParam(':kilometrage', $data['kilometrage']);
        $stmt->bindParam(':nombre_places', $data['nombre_places']);
        $stmt->bindParam(':climatisation', $data['climatisation']);
        $stmt->bindParam(':gps', $data['gps']);
        $stmt->bindParam(':transmission', $data['transmission']);
        $stmt->bindParam(':carburant', $data['carburant']);
        $stmt->bindParam(':disponible', $data['disponible']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(array('message' => 'Véhicule mis à jour avec succès'));
        } else {
            http_response_code(404);
            echo json_encode(array('error' => 'Aucun véhicule trouvé avec cet ID.'));
        }
    } catch (PDOException $e) {
        http_response_code(500); 
        if ($e->getCode() == 23000) { 
            echo json_encode(array('error' => 'Erreur : Un véhicule avec cette immatriculation existe déjà.')); 
        } else {
            echo json_encode(array('error' => 'Erreur lors de la mise à jour du véhicule. Veuillez réessayer plus tard.'));
        }
    }
}

function deleteVehicule($id)
{
    global $db;
    try {
        $stmt = $db->prepare('DELETE FROM vehicule WHERE id_vehicule = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(array('message' => 'Véhicule supprimé avec succès'));
        } else {
            http_response_code(404); 
            echo json_encode(array('error' => 'Aucun véhicule trouvé avec cet ID.')); 
        }
    } catch (PDOException $e) {
        http_response_code(500); 
        echo json_encode(array('error' => 'Erreur lors de la suppression du véhicule. Veuillez réessayer plus tard.'));
    }
}


function validateVehiculeData($data) {
    $errors = [];

    if (empty($data['id_categorie'])) {
        $errors['id_categorie'] = 'L\'ID de la catégorie est requis.';
    } elseif (!filter_var($data['id_categorie'], FILTER_VALIDATE_INT) || $data['id_categorie'] <= 0) { 
        $errors['id_categorie'] = 'L\'ID de la catégorie est invalide.';
    }
    if (empty($data['marque'])) {
        $errors['marque'] = 'La marque est requise.';
    }
    if (empty($data['modele'])) {
        $errors['modele'] = 'Le modèle est requis.';
    }
    if (empty($data['annee'])) {
        $errors['annee'] = 'L\'année est requise.';
    } elseif (!filter_var($data['annee'], FILTER_VALIDATE_INT) || $data['annee'] > date('Y')) { 
        $errors['annee'] = 'L\'année est invalide.';
    }
    if (empty($data['immatriculation'])) {
        $errors['immatriculation'] = 'L\'immatriculation est requise.';
    }
    if (empty($data['kilometrage'])) {
        $errors['kilometrage'] = 'Le kilométrage est requis.';
    } elseif (!filter_var($data['kilometrage'], FILTER_VALIDATE_INT) || $data['kilometrage'] < 0) {
        $errors['kilometrage'] = 'Le kilométrage est invalide.';
    }
    if (empty($data['nombre_places'])) {
        $errors['nombre_places'] = 'Le nombre de places est requis.';
    } elseif (!filter_var($data['nombre_places'], FILTER_VALIDATE_INT) || $data['nombre_places'] <= 0) { 
        $errors['nombre_places'] = 'Le nombre de places est invalide.'; 
    }
    if (!isset($data['climatisation'])) { 
        $errors['climatisation'] = 'La climatisation est requise.'; 
    }
    if (!isset($data['gps'])) { 
        $errors['gps'] = 'Le GPS est requis.'; 
    }
    if (empty($data['transmission'])) {
        $errors['transmission'] = 'La transmission est requise.';
    }
    if (empty($data['carburant'])) {
        $errors['carburant'] = 'Le carburant est requis.';
    }
    if (!isset($data['disponible'])) {
        $errors['disponible'] = 'La disponibilité est requise.';
    }

    return $errors;
}

// Fonctions de gestion des agences
function getAgences()
{
    global $db;
    $stmt = $db->query('SELECT * FROM agence');
    $agences = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($agences);
}

function getAgenceById($id)
{
    global $db;
    $stmt = $db->prepare('SELECT * FROM agence WHERE id_agence = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $agence = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($agence) {
        echo json_encode($agence);
    } else {
        http_response_code(404);
        echo json_encode(array('error' => 'Aucune agence trouvée avec cet ID.'));
    }
}

function createAgence()
{
    global $db;
    $data = json_decode(file_get_contents("php://input"), true);

     
    $errors = validateAgenceData($data);
    if (!empty($errors)) {
        http_response_code(400); 
        echo json_encode(['error' => 'Données invalides', 'details' => $errors]);
        return;
    }

    try {
        $stmt = $db->prepare('INSERT INTO agence (nom, adresse, code_postal, ville, pays) 
                            VALUES (:nom, :adresse, :code_postal, :ville, :pays)');
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':adresse', $data['adresse']);
        $stmt->bindParam(':code_postal', $data['code_postal']);
        $stmt->bindParam(':ville', $data['ville']);
        $stmt->bindParam(':pays', $data['pays']);
        $stmt->execute();
        $id = $db->lastInsertId();
        echo json_encode(array('message' => 'Agence créée avec succès', 'id' => $id));
        http_response_code(201);
    } catch (PDOException $e) {
        http_response_code(500); 
        echo json_encode(array('error' => 'Erreur lors de la création de l\'agence. Veuillez réessayer plus tard.'));
    }
}

function updateAgence($id)
{
    global $db;
    $data = json_decode(file_get_contents("php://input"), true);

     
    $errors = validateAgenceData($data);
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['error' => 'Données invalides', 'details' => $errors]);
        return;
    }

    try {
        $stmt = $db->prepare('UPDATE agence SET 
                            nom = :nom, 
                            adresse = :adresse, 
                            code_postal = :code_postal,
                            ville = :ville,
                            pays = :pays 
                            WHERE id_agence = :id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':adresse', $data['adresse']);
        $stmt->bindParam(':code_postal', $data['code_postal']);
        $stmt->bindParam(':ville', $data['ville']);
        $stmt->bindParam(':pays', $data['pays']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) { 
            echo json_encode(array('message' => 'Agence mise à jour avec succès'));
        } else {
            http_response_code(404); 
            echo json_encode(array('error' => 'Aucune agence trouvée avec cet ID.'));
        }
    } catch (PDOException $e) {
        http_response_code(500); 
        echo json_encode(array('error' => 'Erreur lors de la mise à jour de l\'agence. Veuillez réessayer plus tard.'));
    }
}

function deleteAgence($id)
{
    global $db;
    try {
        $stmt = $db->prepare('DELETE FROM agence WHERE id_agence = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(array('message' => 'Agence supprimée avec succès'));
        } else {
            http_response_code(404);
            echo json_encode(array('error' => 'Aucune agence trouvée avec cet ID.'));
        }
    } catch (PDOException $e) {
        http_response_code(500); 
        // Vérifier si la suppression est impossible en raison de contraintes de clés étrangères
        if ($e->getCode() == 23000) { 
            echo json_encode(array('error' => 'Erreur : Impossible de supprimer l\'agence. Des éléments y sont associés (véhicules, locations, etc.).')); 
        } else {
            echo json_encode(array('error' => 'Erreur lors de la suppression de l\'agence. Veuillez réessayer plus tard.')); 
        }
    }
}

// Fonction de validation des données d'agence
function validateAgenceData($data) {
    $errors = [];

    if (empty($data['nom'])) {
        $errors['nom'] = 'Le nom est requis.';
    }
    if (empty($data['adresse'])) {
        $errors['adresse'] = 'L\'adresse est requise.';
    }
    if (empty($data['code_postal'])) {
        $errors['code_postal'] = 'Le code postal est requis.';
    }
    if (empty($data['ville'])) {
        $errors['ville'] = 'La ville est requise.';
    }
    if (empty($data['pays'])) {
        $errors['pays'] = 'Le pays est requis.';
    }

    return $errors;
}
// Fonctions de gestion des disponibilités
// Fonctions de gestion des disponibilités
function getDisponibilites()
{
    global $db;
    $stmt = $db->query('SELECT * FROM disponibilite');
    $disponibilites = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($disponibilites);
}

function getDisponibiliteById($id)
{
    global $db;
    $stmt = $db->prepare('SELECT * FROM disponibilite WHERE id_disponibilite = :id');
    $stmt->bindParam(':id', $id - 1);
    $stmt->execute();
    $disponibilite = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($disponibilite) {
        echo json_encode($disponibilite);
    } else {
        http_response_code(404);
        echo json_encode(array('error' => 'Aucune disponibilité trouvée avec cet ID.'));
    }
}

function createDisponibilite()
{
    global $db;
    $data = json_decode(file_get_contents("php://input"), true);

     
    $errors = validateDisponibiliteData($data);
    if (!empty($errors)) {
        http_response_code(400); 
        echo json_encode(['error' => 'Données invalides', 'details' => $errors]);
        return;
    }

    try {
        $stmt = $db->prepare('INSERT INTO disponibilite (id_vehicule, id_agence, quantite) 
                            VALUES (:id_vehicule, :id_agence, :quantite)');
        $stmt->bindParam(':id_vehicule', $data['id_vehicule']);
        $stmt->bindParam(':id_agence', $data['id_agence']);
        $stmt->bindParam(':quantite', $data['quantite']);
        $stmt->execute();
        $id = $db->lastInsertId();
        echo json_encode(array('message' => 'Disponibilité créée avec succès', 'id' => $id));
        http_response_code(201);
    } catch (PDOException $e) {
        http_response_code(500);
        if ($e->getCode() == 23000) { 
            // Gestion des erreurs de clé étrangère
            echo json_encode(array('error' => 'Erreur : Vérifiez que l\'ID du véhicule et l\'ID de l\'agence existent.'));
        } else {
            echo json_encode(array('error' => 'Erreur lors de la création de la disponibilité. Veuillez réessayer plus tard.'));
        }
    }
}

function updateDisponibilite($id)
{
    global $db;
    $data = json_decode(file_get_contents("php://input"), true);

     
    $errors = validateDisponibiliteData($data);
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['error' => 'Données invalides', 'details' => $errors]);
        return;
    }

    try {
        $stmt = $db->prepare('UPDATE disponibilite SET 
                            id_vehicule = :id_vehicule, 
                            id_agence = :id_agence, 
                            quantite = :quantite
                            WHERE id_disponibilite = :id');
        $stmt->bindParam(':id', $id + 1);
        $stmt->bindParam(':id_vehicule', $data['id_vehicule']);
        $stmt->bindParam(':id_agence', $data['id_agence']);
        $stmt->bindParam(':quantite', $data['quantite']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) { 
            echo json_encode(array('message' => 'Disponibilité mise à jour avec succès'));
        } else {
            http_response_code(404);
            echo json_encode(array('error' => 'Aucune disponibilité trouvée avec cet ID.'));
        }
    } catch (PDOException $e) {
        http_response_code(500); 
        if ($e->getCode() == 23000) {
            echo json_encode(array('error' => 'Erreur : Vérifiez que l\'ID du véhicule et l\'ID de l\'agence existent.')); 
        } else {
            echo json_encode(array('error' => 'Erreur lors de la mise à jour de la disponibilité. Veuillez réessayer plus tard.'));
        }
    }
}

function deleteDisponibilite($id)
{
    global $db;
    try {
        $stmt = $db->prepare('DELETE FROM disponibilite WHERE id_disponibilite = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) { 
            echo json_encode(array('message' => 'Disponibilité supprimée avec succès'));
        } else {
            http_response_code(404); 
            echo json_encode(array('error' => 'Aucune disponibilité trouvée avec cet ID.'));
        }
    } catch (PDOException $e) {
        http_response_code(500); 
        echo json_encode(array('error' => 'Erreur lors de la suppression de la disponibilité. Veuillez réessayer plus tard.'));
    }
}

// Fonction de validation des données de disponibilité
function validateDisponibiliteData($data) {
    $errors = [];

    if (!isset($data['id_vehicule']) || !filter_var($data['id_vehicule'], FILTER_VALIDATE_INT) || $data['id_vehicule'] <= 0) {
        $errors['id_vehicule'] = 'L\'ID du véhicule est invalide.'; 
    }
    if (!isset($data['id_agence']) || !filter_var($data['id_agence'], FILTER_VALIDATE_INT) || $data['id_agence'] <= 0) {
        $errors['id_agence'] = 'L\'ID de l\'agence est invalide.';
    }
    if (!isset($data['quantite']) || !filter_var($data['quantite'], FILTER_VALIDATE_INT) || $data['quantite'] <= 0) {
        $errors['quantite'] = 'La quantité doit être un entier positif.';
    }

    return $errors;
}
// Fonctions de gestion des locations
function getLocations()
{
    global $db;
    $stmt = $db->query('SELECT * FROM location');
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($locations);
}

function getLocationById($id)
{
    global $db;
    $stmt = $db->prepare('SELECT * FROM location WHERE id_location = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $location = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($location) {
        echo json_encode($location);
    } else {
        http_response_code(404);
        echo json_encode(array('error' => 'Aucune location trouvée avec cet ID.'));
    }
}

function createLocation()
{
    global $db;
    $data = json_decode(file_get_contents("php://input"), true);

     
    $errors = validateLocationData($data);
    if (!empty($errors)) {
        http_response_code(400); 
        echo json_encode(['error' => 'Données invalides', 'details' => $errors]);
        return;
    }

    try {
        $stmt = $db->prepare('INSERT INTO location (id_utilisateur, id_vehicule, id_agence_depart, id_agence_retour, date_debut, date_fin, prix_total, statut) 
                            VALUES (:id_utilisateur, :id_vehicule, :id_agence_depart, :id_agence_retour, :date_debut, :date_fin, :prix_total, :statut)');
        $stmt->bindParam(':id_utilisateur', $data['id_utilisateur']);
        $stmt->bindParam(':id_vehicule', $data['id_vehicule']);
        $stmt->bindParam(':id_agence_depart', $data['id_agence_depart']);
        $stmt->bindParam(':id_agence_retour', $data['id_agence_retour']);
        $stmt->bindParam(':date_debut', $data['date_debut']);
        $stmt->bindParam(':date_fin', $data['date_fin']);
        $stmt->bindParam(':prix_total', $data['prix_total']);
        $stmt->bindParam(':statut', $data['statut']);
        $stmt->execute();
        $id = $db->lastInsertId();
        echo json_encode(array('message' => 'Location créée avec succès', 'id' => $id));
        http_response_code(201);
    } catch (PDOException $e) {
        http_response_code(500); 
        if ($e->getCode() == 23000) {
            // Gestion des erreurs de clé étrangère
            echo json_encode(array('error' => 'Erreur : Vérifiez que les IDs (utilisateur, véhicule, agences) existent.'));
        } else {
            echo json_encode(array('error' => 'Erreur lors de la création de la location. Veuillez réessayer plus tard.'));
        }
    }
}

function updateLocation($id)
{
    global $db;
    $data = json_decode(file_get_contents("php://input"), true);

     
    $errors = validateLocationData($data);
    if (!empty($errors)) {
        http_response_code(400); 
        echo json_encode(['error' => 'Données invalides', 'details' => $errors]);
        return;
    }

    try {
        $stmt = $db->prepare('UPDATE location SET 
                            id_utilisateur = :id_utilisateur, 
                            id_vehicule = :id_vehicule, 
                            id_agence_depart = :id_agence_depart, 
                            id_agence_retour = :id_agence_retour, 
                            date_debut = :date_debut, 
                            date_fin = :date_fin, 
                            prix_total = :prix_total,
                            statut = :statut
                            WHERE id_location = :id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_utilisateur', $data['id_utilisateur']);
        $stmt->bindParam(':id_vehicule', $data['id_vehicule']);
        $stmt->bindParam(':id_agence_depart', $data['id_agence_depart']);
        $stmt->bindParam(':id_agence_retour', $data['id_agence_retour']);
        $stmt->bindParam(':date_debut', $data['date_debut']);
        $stmt->bindParam(':date_fin', $data['date_fin']);
        $stmt->bindParam(':prix_total', $data['prix_total']);
        $stmt->bindParam(':statut', $data['statut']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(array('message' => '???????????????????????????????????????????'));
        } else {
            http_response_code(404); 
            echo json_encode(array('error' => 'Aucune location trouvée avec cet ID.'));
        }
    } catch (PDOException $e) {
        http_response_code(500);
        if ($e->getCode() == 23000) { 
            echo json_encode(array('error' => 'Erreur : Vérifiez que les IDs (utilisateur, véhicule, agences) existent.'));
        } else {
            echo json_encode(array('error' => 'Erreur lors de la mise à jour de la location. Veuillez réessayer plus tard.'));
        }
    }
}

function deleteLocation($id)
{
    global $db;
    try {
        $stmt = $db->prepare('DELETE FROM location WHERE id_location = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(array('message' => 'Location supprimée avec succès'));
        } else {
            http_response_code(404);
            echo json_encode(array('error' => 'Aucune location trouvée avec cet ID.'));
        }
    } catch (PDOException $e) {
        http_response_code(500); 
        echo json_encode(array('error' => 'Erreur lors de la suppression de la location. Veuillez réessayer plus tard.'));
    }
}

// Fonction de validation des données de location
function validateLocationData($data) {
    $errors = [];

    if (!isset($data['id_utilisateur']) || !filter_var($data['id_utilisateur'], FILTER_VALIDATE_INT) || $data['id_utilisateur'] <= 0) {
        $errors['id_utilisateur'] = 'L\'ID utilisateur est invalide.';
    }
    if (!isset($data['id_vehicule']) || !filter_var($data['id_vehicule'], FILTER_VALIDATE_INT) || $data['id_vehicule'] <= 0) {
        $errors['id_vehicule'] = 'L\'ID du véhicule est invalide.'; 
    }
    if (!isset($data['id_agence_depart']) || !filter_var($data['id_agence_depart'], FILTER_VALIDATE_INT) || $data['id_agence_depart'] <= 0) {
        $errors['id_agence_depart'] = 'L\'ID de l\'agence de départ est invalide.';
    }
    if (!isset($data['id_agence_retour']) || !filter_var($data['id_agence_retour'], FILTER_VALIDATE_INT) || $data['id_agence_retour'] <= 0) {
        $errors['id_agence_retour'] = 'L\'ID de l\'agence de retour est invalide.';
    }
    if (empty($data['date_debut'])) {
        $errors['date_debut'] = 'La date de début est requise.';
    } elseif (!validateDate($data['date_debut'])) {
        $errors['date_debut'] = 'La date de début est invalide.';
    }
    if (empty($data['date_fin'])) {
        $errors['date_fin'] = 'La date de fin est requise.';
    } elseif (!validateDate($data['date_fin'])) {
        $errors['date_fin'] = 'La date de fin est invalide.';
    }
    if (empty($data['prix_total'])) {
        $errors['prix_total'] = 'Le prix total est requis.';
    } elseif (!filter_var($data['prix_total'], FILTER_VALIDATE_FLOAT) || $data['prix_total'] <= 0) {
        $errors['prix_total'] = 'Le prix total doit être un nombre positif.';
    }
    if (empty($data['statut'])) {
        $errors['statut'] = 'Le statut est requis.';
    }

    return $errors;
}


// Fonctions de gestion des avis
function getAvis()
{
    global $db;
    $stmt = $db->query('SELECT * FROM avis');
    $avis = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($avis);
}

function getAvisById($id)
{
    global $db;
    $stmt = $db->prepare('SELECT * FROM avis WHERE id_avis = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $avis = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($avis) {
        echo json_encode($avis);
    } else {
        http_response_code(404);
        echo json_encode(array('error' => 'Aucun avis trouvé avec cet ID.'));
    }
}

function createAvis()
{
    global $db;
    $data = json_decode(file_get_contents("php://input"), true);

     
    $errors = validateAvisData($data);
    if (!empty($errors)) {
        http_response_code(400); 
        echo json_encode(['error' => 'Données invalides', 'details' => $errors]);
        return;
    }

    try {
        $stmt = $db->prepare('INSERT INTO avis (id_location, note, commentaire) 
                            VALUES (:id_location, :note, :commentaire)');
        $stmt->bindParam(':id_location', $data['id_location']);
        $stmt->bindParam(':note', $data['note']);
        $stmt->bindParam(':commentaire', $data['commentaire']);
        $stmt->execute();
        $id = $db->lastInsertId();
        echo json_encode(array('message' => 'Avis créé avec succès', 'id' => $id));
        http_response_code(201);
    } catch (PDOException $e) {
        http_response_code(500); 
        if ($e->getCode() == 23000) { 
            echo json_encode(array('error' => 'Erreur : Vérifiez que l\'ID de la location existe.'));
        } else {
            echo json_encode(array('error' => 'Erreur lors de la création de l\'avis. Veuillez réessayer plus tard.'));
        }
    }
}

function deleteAvis($id)
{
    global $db;
    try {
        $stmt = $db->prepare('DELETE FROM avis WHERE id_avis = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(array('message' => 'Avis supprimé avec succès'));
        } else {
            http_response_code(404);
            echo json_encode(array('error' => 'Aucun avis trouvé avec cet ID.'));
        }
    } catch (PDOException $e) {
        http_response_code(500); 
        echo json_encode(array('error' => 'Erreur lors de la suppression de l\'avis. Veuillez réessayer plus tard.')); 
    }
}

// Fonction de validation des données d'avis
function validateAvisData($data) {
    $errors = [];

    if (!isset($data['id_location']) || !filter_var($data['id_location'], FILTER_VALIDATE_INT) || $data['id_location'] <= 0) {
        $errors['id_location'] = 'L\'ID de la location est invalide.'; 
    }
    if (!isset($data['note']) || !filter_var($data['note'], FILTER_VALIDATE_INT) || $data['note'] < 1 || $data['note'] > 5) {
        $errors['note'] = 'La note doit être un entier entre 1 et 5.';
    }

    return $errors;
}

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}