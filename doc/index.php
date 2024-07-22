<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Documentation de l'API Location de Véhicules</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Documentation de l'API Location de Véhicules</h1>
        <p>Cette documentation décrit les endpoints et les méthodes disponibles pour interagir avec l'API.</p>
    </header>

    <main class="container">
        <h2>Endpoints</h2>

        <h3>Utilisateurs</h3>

        <div class="accordion" id="utilisateursAccordion">

            <!-- GET /API/utilisateurs -->
            <div class="card">
                <div class="card-header" id="headingUtilisateurs">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseUtilisateurs" aria-expanded="true" aria-controls="collapseUtilisateurs">
                        <td><span class="method-badge get">GET</span></td> /API/utilisateurs
                        </button>
                    </h2>
                </div>

                <div id="collapseUtilisateurs" class="collapse show" aria-labelledby="headingUtilisateurs" data-parent="#utilisateursAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Récupère la liste de tous les utilisateurs.</p>
                        <p><strong>Succès:</strong></p>
                        <pre>
                  HTTP Status Code: 200 OK
                  [
                    {
                      "id_utilisateur": 1,
                      "nom": "Martin",
                      "prenom": "Sophie",
                      "email": "sophie.martin@example.com",
                      // ... autres champs ...
                    },
                    {
                      "id_utilisateur": 2,
                      "nom": "Bernard",
                      "prenom": "Pierre",
                      "email": "pierre.bernard@example.com",
                      // ... autres champs ...
                    },
                    // ... autres utilisateurs ...
                  ]
                </pre>
                    </div>
                </div>
            </div>

            <!-- GET /API/utilisateurs/{id} -->
            <div class="card">
                <div class="card-header" id="headingUtilisateurById">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseUtilisateurById" aria-expanded="false" aria-controls="collapseUtilisateurById">
                        <td><span class="method-badge get">GET</span></td> /API/utilisateurs/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseUtilisateurById" class="collapse" aria-labelledby="headingUtilisateurById" data-parent="#utilisateursAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Récupère un utilisateur par son ID.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID de l'utilisateur à récupérer.</li>
                        </ul>
                        <p><strong>Succès:</strong></p>
                        <pre>
                  HTTP Status Code: 200 OK
                  {
                    "id_utilisateur": 1,
                    "nom": "Martin",
                    "prenom": "Sophie",
                    "email": "sophie.martin@example.com",
                    // ... autres champs ...
                  }
                </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li>
                                <code>404 Not Found</code>: Aucun utilisateur trouvé avec cet ID.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- POST /API/utilisateurs -->
            <div class="card">
                <div class="card-header" id="headingCreateUser">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseCreateUser" aria-expanded="false" aria-controls="collapseCreateUser">
                        <td><span class="method-badge post">POST</span></td> /API/utilisateurs
                        </button>
                    </h2>
                </div>
                <div id="collapseCreateUser" class="collapse" aria-labelledby="headingCreateUser" data-parent="#utilisateursAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Crée un nouvel utilisateur.</p>
                        <p><strong>Champs:</strong></p>
                        <ul>
                            <li><code>nom</code> (string): Nom de l'utilisateur (obligatoire).</li>
                            <li><code>prenom</code> (string): Prénom de l'utilisateur (obligatoire).</li>
                            <li><code>email</code> (string): Adresse email de l'utilisateur (obligatoire, unique).</li>
                            <li><code>mot_de_passe</code> (string): Mot de passe de l'utilisateur (obligatoire).</li>
                            <li><code>adresse</code> (string): Adresse de l'utilisateur (obligatoire).</li>
                            <li><code>code_postal</code> (string): Code postal de l'utilisateur (obligatoire).</li>
                            <li><code>ville</code> (string): Ville de l'utilisateur (obligatoire).</li>
                            <li><code>pays</code> (string): Pays de l'utilisateur (obligatoire).</li>
                            <li><code>telephone</code> (string): Numéro de téléphone de l'utilisateur (obligatoire).</li>
                            <li><code>date_naissance</code> (date): Date de naissance de l'utilisateur (obligatoire).</li>
                            <li><code>permis_conduire</code> (string): Numéro de permis de conduire de l'utilisateur (obligatoire).</li>
                        </ul>
                        <p><strong>Exemple de requête:</strong></p>
                        <pre>
                  {
                    "nom": "Doe",
                    "prenom": "John",
                    "email": "john.doe@example.com",
                    "mot_de_passe": "password123",
                    "adresse": "123 Main Street",
                    "code_postal": "12345",
                    "ville": "Anytown",
                    "pays": "USA",
                    "telephone": "555-123-4567",
                    "date_naissance": "1990-01-01",
                    "permis_conduire": "1234567890"
                  }
                </pre>
                        <p><strong>Succès:</strong></p>
                        <pre>
                  HTTP Status Code: 201 Created
                  {
                    "message": "Utilisateur créé avec succès",
                    "id": 123 // ID du nouvel utilisateur
                  }
                </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>400 Bad Request</code>: Données invalides, avec des détails sur les erreurs de validation.
                                <pre>
                    {
                      "error": "Données invalides",
                      "details": {
                        "email": "L'email est invalide"
                        // ... autres erreurs de validation ...
                      }
                    }
                  </pre>
                            </li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la création de l'utilisateur (par exemple, email déjà existant).
                                <pre>
                    {
                      "error": "Erreur : Un utilisateur avec cet email existe déjà."
                    }
                  </pre>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- PUT /API/utilisateurs/{id} -->
            <div class="card">
                <div class="card-header" id="headingUpdateUser">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseUpdateUser" aria-expanded="false" aria-controls="collapseUpdateUser">
                        <td><span class="method-badge put">PUT</span></td> /API/utilisateurs/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseUpdateUser" class="collapse" aria-labelledby="headingUpdateUser" data-parent="#utilisateursAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Met à jour un utilisateur existant.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID de l'utilisateur à mettre à jour.</li>
                        </ul>
                        <p><strong>Champs:</strong></p>
                        <ul>
                            <li><code>nom</code> (string): Nom de l'utilisateur.</li>
                            <li><code>prenom</code> (string): Prénom de l'utilisateur.</li>
                            <li><code>email</code> (string): Adresse email de l'utilisateur (unique).</li>
                            <li><code>mot_de_passe</code> (string): Mot de passe de l'utilisateur.</li>
                            <li><code>adresse</code> (string): Adresse de l'utilisateur.</li>
                            <li><code>code_postal</code> (string): Code postal de l'utilisateur.</li>
                            <li><code>ville</code> (string): Ville de l'utilisateur.</li>
                            <li><code>pays</code> (string): Pays de l'utilisateur.</li>
                            <li><code>telephone</code> (string): Numéro de téléphone de l'utilisateur.</li>
                            <li><code>date_naissance</code> (date): Date de naissance de l'utilisateur.</li>
                            <li><code>permis_conduire</code> (string): Numéro de permis de conduire de l'utilisateur.</li>
                        </ul>
                        <p><strong>Exemple de requête:</strong></p>
                        <pre>
                  {
                    "nom": "Doe",
                    "prenom": "Jane",
                    "email": "jane.doe@example.com",
                    // ... autres champs à modifier ...
                  }
                </pre>
                        <p><strong>Succès:</strong></p>
                        <pre>
                  HTTP Status Code: 200 OK
                  {
                    "message": "Utilisateur mis à jour avec succès"
                  }
                </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>400 Bad Request</code>: Données invalides, avec des détails sur les erreurs de validation.</li>
                            <li><code>404 Not Found</code>: Aucun utilisateur trouvé avec cet ID.</li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la mise à jour de l'utilisateur (par exemple, email déjà existant).</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- DELETE /API/utilisateurs/{id} -->
            <div class="card">
                <div class="card-header" id="headingDeleteUser">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseDeleteUser" aria-expanded="false" aria-controls="collapseDeleteUser">
                        <td><span class="method-badge delete">DELETE</span></td> /API/utilisateurs/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseDeleteUser" class="collapse" aria-labelledby="headingDeleteUser" data-parent="#utilisateursAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Supprime un utilisateur.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID de l'utilisateur à supprimer.</li>
                        </ul>
                        <p><strong>Succès:</strong></p>
                        <pre>
                  HTTP Status Code: 200 OK
                  {
                    "message": "Utilisateur supprimé avec succès"
                  }
                </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>404 Not Found</code>: Aucun utilisateur trouvé avec cet ID.</li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la suppression de l'utilisateur.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <h3>Catégories</h3>

        <div class="accordion" id="categoriesAccordion">

            <!-- GET /API/categories -->
            <div class="card">
                <div class="card-header" id="headingCategories">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseCategories" aria-expanded="true" aria-controls="collapseCategories">
                        <td><span class="method-badge get">GET</span></td> /API/categories
                        </button>
                    </h2>
                </div>

                <div id="collapseCategories" class="collapse show" aria-labelledby="headingCategories" data-parent="#categoriesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Récupère la liste de toutes les catégories.</p>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          [
            {
              "id_categorie": 1,
              "nom": "Citadine",
              "description": "Petite voiture idéale pour la ville",
              "prix_journalier": 30.00,
              "image": "citadine.jpg"
            },
            {
              "id_categorie": 2,
              "nom": "Berline",
              "description": "Voiture confortable pour longs trajets",
              "prix_journalier": 50.00,
              "image": "berline.jpg"
            },
            // ... autres catégories ...
          ]
        </pre>
                    </div>
                </div>
            </div>

            <!-- GET /API/categories/{id} -->
            <div class="card">
                <div class="card-header" id="headingCategorieById">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseCategorieById" aria-expanded="false" aria-controls="collapseCategorieById">
                        <td><span class="method-badge get">GET</span></td> /API/categories/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseCategorieById" class="collapse" aria-labelledby="headingCategorieById" data-parent="#categoriesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Récupère une catégorie par son ID.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID de la catégorie à récupérer.</li>
                        </ul>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          {
            "id_categorie": 1,
            "nom": "Citadine",
            "description": "Petite voiture idéale pour la ville",
            "prix_journalier": 30.00,
            "image": "citadine.jpg"
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li>
                                <code>404 Not Found</code>: Aucune catégorie trouvée avec cet ID.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- POST /API/categories -->
            <div class="card">
                <div class="card-header" id="headingCreateCategorie">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseCreateCategorie" aria-expanded="false" aria-controls="collapseCreateCategorie">
                        <td><span class="method-badge post">POST</span></td> /API/categories
                        </button>
                    </h2>
                </div>
                <div id="collapseCreateCategorie" class="collapse" aria-labelledby="headingCreateCategorie" data-parent="#categoriesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Crée une nouvelle catégorie.</p>
                        <p><strong>Champs:</strong></p>
                        <ul>
                            <li><code>nom</code> (string): Nom de la catégorie (obligatoire, unique).</li>
                            <li><code>description</code> (string): Description de la catégorie.</li>
                            <li><code>prix_journalier</code> (decimal): Prix journalier de la catégorie (obligatoire).</li>
                            <li><code>image</code> (string): URL de l'image de la catégorie.</li>
                        </ul>
                        <p><strong>Exemple de requête:</strong></p>
                        <pre>
          {
            "nom": "Nouvelle Catégorie",
            "description": "Description de la nouvelle catégorie",
            "prix_journalier": 45.00,
            "image": "nouvelle_categorie.jpg"
          }
        </pre>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 201 Created
          {
            "message": "Catégorie créée avec succès",
            "id": 123 // ID de la nouvelle catégorie
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>400 Bad Request</code>: Données invalides, avec des détails sur les erreurs de validation.
                                <pre>
            {
              "error": "Données invalides",
              "details": {
                "nom": "Le nom est requis"
                // ... autres erreurs de validation ...
              }
            }
          </pre>
                            </li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la création de la catégorie (par exemple, nom déjà existant).
                                <pre>
            {
              "error": "Erreur : Une catégorie avec ce nom existe déjà."
            }
          </pre>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- PUT /API/categories/{id} -->
            <div class="card">
                <div class="card-header" id="headingUpdateCategorie">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseUpdateCategorie" aria-expanded="false" aria-controls="collapseUpdateCategorie">
                        <td><span class="method-badge put">PUT</span></td> /API/categories/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseUpdateCategorie" class="collapse" aria-labelledby="headingUpdateCategorie" data-parent="#categoriesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Met à jour une catégorie existante.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID de la catégorie à mettre à jour.</li>
                        </ul>
                        <p><strong>Champs:</strong></p>
                        <ul>
                            <li><code>nom</code> (string): Nom de la catégorie (unique).</li>
                            <li><code>description</code> (string): Description de la catégorie.</li>
                            <li><code>prix_journalier</code> (decimal): Prix journalier de la catégorie.</li>
                            <li><code>image</code> (string): URL de l'image de la catégorie.</li>
                        </ul>
                        <p><strong>Exemple de requête:</strong></p>
                        <pre>
          {
            "nom": "Catégorie modifiée",
            "description": "Nouvelle description",
            "prix_journalier": 55.00
            // ... autres champs à modifier ...
          }
        </pre>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          {
            "message": "Catégorie mise à jour avec succès"
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>400 Bad Request</code>: Données invalides, avec des détails sur les erreurs de validation.</li>
                            <li><code>404 Not Found</code>: Aucune catégorie trouvée avec cet ID.</li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la mise à jour de la catégorie (par exemple, nom déjà existant).</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- DELETE /API/categories/{id} -->
            <div class="card">
                <div class="card-header" id="headingDeleteCategorie">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseDeleteCategorie" aria-expanded="false" aria-controls="collapseDeleteCategorie">
                        <td><span class="method-badge delete">DELETE</span></td> /API/categories/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseDeleteCategorie" class="collapse" aria-labelledby="headingDeleteCategorie" data-parent="#categoriesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Supprime une catégorie.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID de la catégorie à supprimer.</li>
                        </ul>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          {
            "message": "Catégorie supprimée avec succès"
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>404 Not Found</code>: Aucune catégorie trouvée avec cet ID.</li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la suppression de la catégorie (par exemple, des véhicules sont associés à cette catégorie).</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <h3>Véhicules</h3>

        <div class="accordion" id="vehiculesAccordion">

            <!-- GET /API/vehicules -->
            <div class="card">
                <div class="card-header" id="headingVehicules">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseVehicules" aria-expanded="true" aria-controls="collapseVehicules">
                        <td><span class="method-badge get">GET</span></td> /API/vehicules
                        </button>
                    </h2>
                </div>

                <div id="collapseVehicules" class="collapse show" aria-labelledby="headingVehicules" data-parent="#vehiculesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Récupère la liste de tous les véhicules.</p>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          [
            {
              "id_vehicule": 1,
              "id_categorie": 1,
              "marque": "Renault",
              "modele": "Clio",
              "annee": 2018,
              "immatriculation": "AA-123-BB",
              "kilometrage": 50000,
              "nombre_places": 5,
              "climatisation": true,
              "gps": false,
              "transmission": "Manuelle",
              "carburant": "Essence",
              "disponible": true,
              "image": "clio.jpg"
            },
            // ... autres véhicules ...
          ]
        </pre>
                    </div>
                </div>
            </div>

            <!-- GET /API/vehicules/{id} -->
            <div class="card">
                <div class="card-header" id="headingVehiculeById">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseVehiculeById" aria-expanded="false" aria-controls="collapseVehiculeById">
                        <td><span class="method-badge get">GET</span></td> /API/vehicules/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseVehiculeById" class="collapse" aria-labelledby="headingVehiculeById" data-parent="#vehiculesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Récupère un véhicule par son ID.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID du véhicule à récupérer.</li>
                        </ul>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          {
            "id_vehicule": 1,
            "id_categorie": 1,
            "marque": "Renault",
            "modele": "Clio",
            "annee": 2018,
            "immatriculation": "AA-123-BB",
            "kilometrage": 50000,
            "nombre_places": 5,
            "climatisation": true,
            "gps": false,
            "transmission": "Manuelle",
            "carburant": "Essence",
            "disponible": true,
            "image": "clio.jpg"
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li>
                                <code>404 Not Found</code>: Aucun véhicule trouvé avec cet ID.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- POST /API/vehicules -->
            <div class="card">
                <div class="card-header" id="headingCreateVehicule">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseCreateVehicule" aria-expanded="false" aria-controls="collapseCreateVehicule">
                        <td><span class="method-badge post">POST</span></td> /API/vehicules
                        </button>
                    </h2>
                </div>
                <div id="collapseCreateVehicule" class="collapse" aria-labelledby="headingCreateVehicule" data-parent="#vehiculesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Crée un nouveau véhicule.</p>
                        <p><strong>Champs:</strong></p>
                        <ul>
                            <li><code>id_categorie</code> (int): ID de la catégorie du véhicule (obligatoire).</li>
                            <li><code>marque</code> (string): Marque du véhicule (obligatoire).</li>
                            <li><code>modele</code> (string): Modèle du véhicule (obligatoire).</li>
                            <li><code>annee</code> (int): Année de fabrication du véhicule (obligatoire).</li>
                            <li><code>immatriculation</code> (string): Numéro d'immatriculation du véhicule (obligatoire, unique).</li>
                            <li><code>kilometrage</code> (int): Kilométrage du véhicule (obligatoire).</li>
                            <li><code>nombre_places</code> (int): Nombre de places du véhicule (obligatoire).</li>
                            <li><code>climatisation</code> (boolean): Indique si le véhicule a la climatisation (obligatoire).</li>
                            <li><code>gps</code> (boolean): Indique si le véhicule a un GPS (obligatoire).</li>
                            <li><code>transmission</code> (string): Type de transmission du véhicule (obligatoire, par défaut "Manuelle").</li>
                            <li><code>carburant</code> (string): Type de carburant du véhicule (obligatoire, par défaut "Essence").</li>
                            <li><code>disponible</code> (boolean): Indique si le véhicule est disponible à la location (obligatoire, par défaut true).</li>
                            <li><code>image</code> (string): URL de l'image du véhicule.</li>
                        </ul>
                        <p><strong>Exemple de requête:</strong></p>
                        <pre>
          {
            "id_categorie": 2,
            "marque": "Peugeot",
            "modele": "308",
            "annee": 2022,
            "immatriculation": "AB-123-CD",
            "kilometrage": 20000,
            "nombre_places": 5,
            "climatisation": true,
            "gps": true,
            "transmission": "Automatique",
            "carburant": "Diesel",
            "disponible": true,
            "image": "peugeot_308.jpg"
          }
        </pre>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 201 Created
          {
            "message": "Véhicule créé avec succès",
            "id": 123 // ID du nouveau véhicule
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>400 Bad Request</code>: Données invalides, avec des détails sur les erreurs de validation.
                                <pre>
            {
              "error": "Données invalides",
              "details": {
                "marque": "La marque est requise."
                // ... autres erreurs de validation ...
              }
            }
          </pre>
                            </li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la création du véhicule (par exemple, immatriculation déjà existante).
                                <pre>
            {
              "error": "Erreur : Un véhicule avec cette immatriculation existe déjà."
            }
          </pre>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- PUT /API/vehicules/{id} -->
            <div class="card">
                <div class="card-header" id="headingUpdateVehicule">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseUpdateVehicule" aria-expanded="false" aria-controls="collapseUpdateVehicule">
                        <td><span class="method-badge put">PUT</span></td> /API/vehicules/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseUpdateVehicule" class="collapse" aria-labelledby="headingUpdateVehicule" data-parent="#vehiculesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Met à jour un véhicule existant.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID du véhicule à mettre à jour.</li>
                        </ul>
                        <p><strong>Champs:</strong></p>
                        <ul>
                            <li><code>id_categorie</code> (int): ID de la catégorie du véhicule.</li>
                            <li><code>marque</code> (string): Marque du véhicule.</li>
                            <li><code>modele</code> (string): Modèle du véhicule.</li>
                            <li><code>annee</code> (int): Année de fabrication du véhicule.</li>
                            <li><code>immatriculation</code> (string): Numéro d'immatriculation du véhicule (unique).</li>
                            <li><code>kilometrage</code> (int): Kilométrage du véhicule.</li>
                            <li><code>nombre_places</code> (int): Nombre de places du véhicule.</li>
                            <li><code>climatisation</code> (boolean): Indique si le véhicule a la climatisation.</li>
                            <li><code>gps</code> (boolean): Indique si le véhicule a un GPS.</li>
                            <li><code>transmission</code> (string): Type de transmission du véhicule.</li>
                            <li><code>carburant</code> (string): Type de carburant du véhicule.</li>
                            <li><code>disponible</code> (boolean): Indique si le véhicule est disponible à la location.</li>
                            <li><code>image</code> (string): URL de l'image du véhicule.</li>
                        </ul>
                        <p><strong>Exemple de requête:</strong></p>
                        <pre>
          {
            "kilometrage": 25000,
            "disponible": false
            // ... autres champs à modifier ...
          }
        </pre>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          {
            "message": "Véhicule mis à jour avec succès"
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>400 Bad Request</code>: Données invalides, avec des détails sur les erreurs de validation.</li>
                            <li><code>404 Not Found</code>: Aucun véhicule trouvé avec cet ID.</li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la mise à jour du véhicule (par exemple, immatriculation déjà existante).</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- DELETE /API/vehicules/{id} -->
            <div class="card">
                <div class="card-header" id="headingDeleteVehicule">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseDeleteVehicule" aria-expanded="false" aria-controls="collapseDeleteVehicule">
                        <td><span class="method-badge delete">DELETE</span></td> /API/vehicules/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseDeleteVehicule" class="collapse" aria-labelledby="headingDeleteVehicule" data-parent="#vehiculesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Supprime un véhicule.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID du véhicule à supprimer.</li>
                        </ul>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          {
            "message": "Véhicule supprimé avec succès"
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>404 Not Found</code>: Aucun véhicule trouvé avec cet ID.</li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la suppression du véhicule.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <h3>Agences</h3>

        <div class="accordion" id="agencesAccordion">

            <!-- GET /API/agences -->
            <div class="card">
                <div class="card-header" id="headingAgences">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseAgences" aria-expanded="true" aria-controls="collapseAgences">
                        <td><span class="method-badge get">GET</span></td> /API/agences
                        </button>
                    </h2>
                </div>

                <div id="collapseAgences" class="collapse show" aria-labelledby="headingAgences" data-parent="#agencesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Récupère la liste de toutes les agences.</p>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          [
            {
              "id_agence": 1,
              "nom": "Agence du Centre",
              "adresse": "12 Rue Principale",
              "code_postal": "75001",
              "ville": "Paris",
              "pays": "France"
            },
            // ... autres agences ...
          ]
        </pre>
                    </div>
                </div>
            </div>

            <!-- GET /API/agences/{id} -->
            <div class="card">
                <div class="card-header" id="headingAgenceById">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseAgenceById" aria-expanded="false" aria-controls="collapseAgenceById">
                        <td><span class="method-badge get">GET</span></td> /API/agences/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseAgenceById" class="collapse" aria-labelledby="headingAgenceById" data-parent="#agencesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Récupère une agence par son ID.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID de l'agence à récupérer.</li>
                        </ul>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          {
            "id_agence": 1,
            "nom": "Agence du Centre",
            "adresse": "12 Rue Principale",
            "code_postal": "75001",
            "ville": "Paris",
            "pays": "France"
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li>
                                <code>404 Not Found</code>: Aucune agence trouvée avec cet ID.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- POST /API/agences -->
            <div class="card">
                <div class="card-header" id="headingCreateAgence">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseCreateAgence" aria-expanded="false" aria-controls="collapseCreateAgence">
                        <td><span class="method-badge post">POST</span></td> /API/agences
                        </button>
                    </h2>
                </div>
                <div id="collapseCreateAgence" class="collapse" aria-labelledby="headingCreateAgence" data-parent="#agencesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Crée une nouvelle agence.</p>
                        <p><strong>Champs:</strong></p>
                        <ul>
                            <li><code>nom</code> (string): Nom de l'agence (obligatoire).</li>
                            <li><code>adresse</code> (string): Adresse de l'agence (obligatoire).</li>
                            <li><code>code_postal</code> (string): Code postal de l'agence (obligatoire).</li>
                            <li><code>ville</code> (string): Ville de l'agence (obligatoire).</li>
                            <li><code>pays</code> (string): Pays de l'agence (obligatoire).</li>
                        </ul>
                        <p><strong>Exemple de requête:</strong></p>
                        <pre>
          {
            "nom": "Nouvelle Agence",
            "adresse": "456 Rue secondaire",
            "code_postal": "67000",
            "ville": "Strasbourg",
            "pays": "France"
          }
        </pre>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 201 Created
          {
            "message": "Agence créée avec succès",
            "id": 123 // ID de la nouvelle agence
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>400 Bad Request</code>: Données invalides, avec des détails sur les erreurs de validation.
                                <pre>
            {
              "error": "Données invalides",
              "details": {
                "nom": "Le nom est requis"
                // ... autres erreurs de validation ...
              }
            }
          </pre>
                            </li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la création de l'agence.
                                <pre>
            {
              "error": "Erreur lors de la création de l'agence. Veuillez réessayer plus tard."
            }
          </pre>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- PUT /API/agences/{id} -->
            <div class="card">
                <div class="card-header" id="headingUpdateAgence">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseUpdateAgence" aria-expanded="false" aria-controls="collapseUpdateAgence">
                        <td><span class="method-badge put">PUT</span></td> /API/agences/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseUpdateAgence" class="collapse" aria-labelledby="headingUpdateAgence" data-parent="#agencesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Met à jour une agence existante.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID de l'agence à mettre à jour.</li>
                        </ul>
                        <p><strong>Champs:</strong></p>
                        <ul>
                            <li><code>nom</code> (string): Nom de l'agence.</li>
                            <li><code>adresse</code> (string): Adresse de l'agence.</li>
                            <li><code>code_postal</code> (string): Code postal de l'agence.</li>
                            <li><code>ville</code> (string): Ville de l'agence.</li>
                            <li><code>pays</code> (string): Pays de l'agence.</li>
                        </ul>
                        <p><strong>Exemple de requête:</strong></p>
                        <pre>
          {
            "adresse": "789 Rue Tertiaire",
            "code_postal": "68000",
            // ... autres champs à modifier ...
          }
        </pre>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          {
            "message": "Agence mise à jour avec succès"
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>400 Bad Request</code>: Données invalides, avec des détails sur les erreurs de validation.</li>
                            <li><code>404 Not Found</code>: Aucune agence trouvée avec cet ID.</li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la mise à jour de l'agence.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- DELETE /API/agences/{id} -->
            <div class="card">
                <div class="card-header" id="headingDeleteAgence">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseDeleteAgence" aria-expanded="false" aria-controls="collapseDeleteAgence">
                        <td><span class="method-badge delete">DELETE</span></td> /API/agences/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseDeleteAgence" class="collapse" aria-labelledby="headingDeleteAgence" data-parent="#agencesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Supprime une agence.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID de l'agence à supprimer.</li>
                        </ul>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          {
            "message": "Agence supprimée avec succès"
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>404 Not Found</code>: Aucune agence trouvée avec cet ID.</li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la suppression de l'agence (par exemple, des véhicules ou des locations sont associés à cette agence).</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <h3>Disponibilités</h3>

        <div class="accordion" id="disponibilitesAccordion">

            <!-- GET /API/disponibilites -->
            <div class="card">
                <div class="card-header" id="headingDisponibilites">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseDisponibilites" aria-expanded="true" aria-controls="collapseDisponibilites">
                        <td><span class="method-badge get">GET</span></td> /API/disponibilites
                        </button>
                    </h2>
                </div>

                <div id="collapseDisponibilites" class="collapse show" aria-labelledby="headingDisponibilites" data-parent="#disponibilitesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Récupère la liste de toutes les disponibilités.</p>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          [
            {
              "id_disponibilite": 1,
              "id_vehicule": 2,
              "id_agence": 1,
              "quantite": 3
            },
            // ... autres disponibilités ...
          ]
        </pre>
                    </div>
                </div>
            </div>

            <!-- GET /API/disponibilites/{id} -->
            <div class="card">
                <div class="card-header" id="headingDisponibiliteById">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseDisponibiliteById" aria-expanded="false" aria-controls="collapseDisponibiliteById">
                        <td><span class="method-badge get">GET</span></td> /API/disponibilites/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseDisponibiliteById" class="collapse" aria-labelledby="headingDisponibiliteById" data-parent="#disponibilitesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Récupère une disponibilité par son ID.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID de la disponibilité à récupérer.</li>
                        </ul>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          {
            "id_disponibilite": 1,
            "id_vehicule": 2,
            "id_agence": 1,
            "quantite": 3
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li>
                                <code>404 Not Found</code>: Aucune disponibilité trouvée avec cet ID.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- POST /API/disponibilites -->
            <div class="card">
                <div class="card-header" id="headingCreateDisponibilite">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseCreateDisponibilite" aria-expanded="false" aria-controls="collapseCreateDisponibilite">
                        <td><span class="method-badge post">POST</span></td> /API/disponibilites
                        </button>
                    </h2>
                </div>
                <div id="collapseCreateDisponibilite" class="collapse" aria-labelledby="headingCreateDisponibilite" data-parent="#disponibilitesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Crée une nouvelle disponibilité.</p>
                        <p><strong>Champs:</strong></p>
                        <ul>
                            <li><code>id_vehicule</code> (int): ID du véhicule (obligatoire).</li>
                            <li><code>id_agence</code> (int): ID de l'agence (obligatoire).</li>
                            <li><code>quantite</code> (int): Quantité de véhicules disponibles (obligatoire).</li>
                        </ul>
                        <p><strong>Exemple de requête:</strong></p>
                        <pre>
          {
            "id_vehicule": 5,
            "id_agence": 2,
            "quantite": 2
          }
        </pre>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 201 Created
          {
            "message": "Disponibilité créée avec succès",
            "id": 123 // ID de la nouvelle disponibilité
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>400 Bad Request</code>: Données invalides, avec des détails sur les erreurs de validation.
                                <pre>
            {
              "error": "Données invalides",
              "details": {
                "id_vehicule": "L'ID du véhicule est invalide."
                // ... autres erreurs de validation ...
              }
            }
          </pre>
                            </li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la création de la disponibilité (par exemple, clé étrangère invalide).
                                <pre>
            {
              "error": "Erreur : Vérifiez que l'ID du véhicule et l'ID de l'agence existent."
            }
          </pre>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- PUT /API/disponibilites/{id} -->
            <div class="card">
                <div class="card-header" id="headingUpdateDisponibilite">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseUpdateDisponibilite" aria-expanded="false" aria-controls="collapseUpdateDisponibilite">
                        <td><span class="method-badge put">PUT</span></td> /API/disponibilites/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseUpdateDisponibilite" class="collapse" aria-labelledby="headingUpdateDisponibilite" data-parent="#disponibilitesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Met à jour une disponibilité existante.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID de la disponibilité à mettre à jour.</li>
                        </ul>
                        <p><strong>Champs:</strong></p>
                        <ul>
                            <li><code>id_vehicule</code> (int): ID du véhicule.</li>
                            <li><code>id_agence</code> (int): ID de l'agence.</li>
                            <li><code>quantite</code> (int): Quantité de véhicules disponibles.</li>
                        </ul>
                        <p><strong>Exemple de requête:</strong></p>
                        <pre>
          {
            "quantite": 5
            // ... autres champs à modifier ...
          }
        </pre>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          {
            "message": "Disponibilité mise à jour avec succès"
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>400 Bad Request</code>: Données invalides, avec des détails sur les erreurs de validation.</li>
                            <li><code>404 Not Found</code>: Aucune disponibilité trouvée avec cet ID.</li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la mise à jour de la disponibilité (par exemple, clé étrangère invalide). </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- DELETE /API/disponibilites/{id} -->
            <div class="card">
                <div class="card-header" id="headingDeleteDisponibilite">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseDeleteDisponibilite" aria-expanded="false" aria-controls="collapseDeleteDisponibilite">
                        <td><span class="method-badge delete">DELETE</span></td> /API/disponibilites/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseDeleteDisponibilite" class="collapse" aria-labelledby="headingDeleteDisponibilite" data-parent="#disponibilitesAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Supprime une disponibilité.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID de la disponibilité à supprimer.</li>
                        </ul>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          {
            "message": "Disponibilité supprimée avec succès"
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>404 Not Found</code>: Aucune disponibilité trouvée avec cet ID.</li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la suppression de la disponibilité.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <h3>Locations</h3>

        <div class="accordion" id="locationsAccordion">

            <!-- GET /API/locations -->
            <div class="card">
                <div class="card-header" id="headingLocations">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseLocations" aria-expanded="true" aria-controls="collapseLocations">
                        <td><span class="method-badge get">GET</span></td> /API/locations
                        </button>
                    </h2>
                </div>

                <div id="collapseLocations" class="collapse show" aria-labelledby="headingLocations" data-parent="#locationsAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Récupère la liste de toutes les locations.</p>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          [
            {
              "id_location": 1,
              "id_utilisateur": 5,
              "id_vehicule": 3,
              "id_agence_depart": 2,
              "id_agence_retour": 2,
              "date_debut": "2023-04-15",
              "date_fin": "2023-04-22",
              "prix_total": 350.00,
              "statut": "Confirmée",
              "date_creation": "2023-04-10 14:30:00"
            },
            // ... autres locations ...
          ]
        </pre>
                    </div>
                </div>
            </div>

            <!-- GET /API/locations/{id} -->
            <div class="card">
                <div class="card-header" id="headingLocationById">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseLocationById" aria-expanded="false" aria-controls="collapseLocationById">
                        <td><span class="method-badge get">GET</span></td> /API/locations/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseLocationById" class="collapse" aria-labelledby="headingLocationById" data-parent="#locationsAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Récupère une location par son ID.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID de la location à récupérer.</li>
                        </ul>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          {
            "id_location": 1,
            "id_utilisateur": 5,
            "id_vehicule": 3,
            "id_agence_depart": 2,
            "id_agence_retour": 2,
            "date_debut": "2023-04-15",
            "date_fin": "2023-04-22",
            "prix_total": 350.00,
            "statut": "Confirmée",
            "date_creation": "2023-04-10 14:30:00"
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li>
                                <code>404 Not Found</code>: Aucune location trouvée avec cet ID.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- POST /API/locations -->
            <div class="card">
                <div class="card-header" id="headingCreateLocation">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseCreateLocation" aria-expanded="false" aria-controls="collapseCreateLocation">
                        <td><span class="method-badge post">POST</span></td> /API/locations
                        </button>
                    </h2>
                </div>
                <div id="collapseCreateLocation" class="collapse" aria-labelledby="headingCreateLocation" data-parent="#locationsAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Crée une nouvelle location.</p>
                        <p><strong>Champs:</strong></p>
                        <ul>
                            <li><code>id_utilisateur</code> (int): ID de l'utilisateur (obligatoire).</li>
                            <li><code>id_vehicule</code> (int): ID du véhicule (obligatoire).</li>
                            <li><code>id_agence_depart</code> (int): ID de l'agence de départ (obligatoire).</li>
                            <li><code>id_agence_retour</code> (int): ID de l'agence de retour (obligatoire).</li>
                            <li><code>date_debut</code> (date): Date de début de la location (obligatoire).</li>
                            <li><code>date_fin</code> (date): Date de fin de la location (obligatoire).</li>
                            <li><code>prix_total</code> (decimal): Prix total de la location (obligatoire).</li>
                            <li><code>statut</code> (string): Statut de la location (obligatoire, par défaut "En attente").</li>
                        </ul>
                        <p><strong>Exemple de requête:</strong></p>
                        <pre>
          {
            "id_utilisateur": 10,
            "id_vehicule": 8,
            "id_agence_depart": 1,
            "id_agence_retour": 3,
            "date_debut": "2023-05-20",
            "date_fin": "2023-05-27",
            "prix_total": 560.00,
            "statut": "Confirmée"
          }
        </pre>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 201 Created
          {
            "message": "Location créée avec succès",
            "id": 123 // ID de la nouvelle location
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>400 Bad Request</code>: Données invalides, avec des détails sur les erreurs de validation.
                                <pre>
            {
              "error": "Données invalides",
              "details": {
                "id_utilisateur": "L'ID utilisateur est invalide."
                // ... autres erreurs de validation ...
              }
            }
          </pre>
                            </li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la création de la location (par exemple, clé étrangère invalide).
                                <pre>
            {
              "error": "Erreur : Vérifiez que les IDs (utilisateur, véhicule, agences) existent."
            }
          </pre>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- PUT /API/locations/{id} -->
            <div class="card">
                <div class="card-header" id="headingUpdateLocation">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseUpdateLocation" aria-expanded="false" aria-controls="collapseUpdateLocation">
                        <td><span class="method-badge put">PUT</span></td> /API/locations/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseUpdateLocation" class="collapse" aria-labelledby="headingUpdateLocation" data-parent="#locationsAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Met à jour une location existante.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID de la location à mettre à jour.</li>
                        </ul>
                        <p><strong>Champs:</strong></p>
                        <ul>
                            <li><code>id_utilisateur</code> (int): ID de l'utilisateur.</li>
                            <li><code>id_vehicule</code> (int): ID du véhicule.</li>
                            <li><code>id_agence_depart</code> (int): ID de l'agence de départ.</li>
                            <li><code>id_agence_retour</code> (int): ID de l'agence de retour.</li>
                            <li><code>date_debut</code> (date): Date de début de la location.</li>
                            <li><code>date_fin</code> (date): Date de fin de la location.</li>
                            <li><code>prix_total</code> (decimal): Prix total de la location.</li>
                            <li><code>statut</code> (string): Statut de la location.</li>
                        </ul>
                        <p><strong>Exemple de requête:</strong></p>
                        <pre>
          {
            "date_fin": "2023-05-30",
            "prix_total": 630.00,
            "statut": "Terminée"
            // ... autres champs à modifier ...
          }
        </pre>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          {
            "message": "Location mise à jour avec succès"
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>400 Bad Request</code>: Données invalides, avec des détails sur les erreurs de validation.</li>
                            <li><code>404 Not Found</code>: Aucune location trouvée avec cet ID.</li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la mise à jour de la location (par exemple, clé étrangère invalide).</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- DELETE /API/locations/{id} -->
            <div class="card">
                <div class="card-header" id="headingDeleteLocation">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseDeleteLocation" aria-expanded="false" aria-controls="collapseDeleteLocation">
                        <td><span class="method-badge delete">DELETE</span></td> /API/locations/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseDeleteLocation" class="collapse" aria-labelledby="headingDeleteLocation" data-parent="#locationsAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Supprime une location.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID de la location à supprimer.</li>
                        </ul>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          {
            "message": "Location supprimée avec succès"
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>404 Not Found</code>: Aucune location trouvée avec cet ID.</li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la suppression de la location.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <h3>Avis</h3>

        <div class="accordion" id="avisAccordion">

            <!-- GET /API/avis -->
            <div class="card">
                <div class="card-header" id="headingAvis">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseAvis" aria-expanded="true" aria-controls="collapseAvis">
                        <td><span class="method-badge get">GET</span></td> /API/avis
                        </button>
                    </h2>
                </div>

                <div id="collapseAvis" class="collapse show" aria-labelledby="headingAvis" data-parent="#avisAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Récupère la liste de tous les avis.</p>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          [
            {
              "id_avis": 1,
              "id_location": 3,
              "note": 4,
              "commentaire": "Très bon véhicule, je recommande.",
              "date_creation": "2023-04-25 10:00:00"
            },
            // ... autres avis ...
          ]
        </pre>
                    </div>
                </div>
            </div>

            <!-- GET /API/avis/{id} -->
            <div class="card">
                <div class="card-header" id="headingAvisById">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseAvisById" aria-expanded="false" aria-controls="collapseAvisById">
                        <td><span class="method-badge get">GET</span></td> /API/avis/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseAvisById" class="collapse" aria-labelledby="headingAvisById" data-parent="#avisAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Récupère un avis par son ID.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID de l'avis à récupérer.</li>
                        </ul>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          {
            "id_avis": 1,
            "id_location": 3,
            "note": 4,
            "commentaire": "Très bon véhicule, je recommande.",
            "date_creation": "2023-04-25 10:00:00"
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li>
                                <code>404 Not Found</code>: Aucun avis trouvé avec cet ID.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- POST /API/avis -->
            <div class="card">
                <div class="card-header" id="headingCreateAvis">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseCreateAvis" aria-expanded="false" aria-controls="collapseCreateAvis">
                        <td><span class="method-badge post">POST</span></td> /API/avis
                        </button>
                    </h2>
                </div>
                <div id="collapseCreateAvis" class="collapse" aria-labelledby="headingCreateAvis" data-parent="#avisAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Crée un nouvel avis.</p>
                        <p><strong>Champs:</strong></p>
                        <ul>
                            <li><code>id_location</code> (int): ID de la location (obligatoire).</li>
                            <li><code>note</code> (int): Note attribuée (obligatoire).</li>
                            <li><code>commentaire</code> (string): Commentaire de l'avis.</li>
                        </ul>
                        <p><strong>Exemple de requête:</strong></p>
                        <pre>
          {
            "id_location": 5,
            "note": 5,
            "commentaire": "Excellent service! Je reviendrai."
          }
        </pre>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 201 Created
          {
            "message": "Avis créé avec succès",
            "id": 123 // ID du nouvel avis
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>400 Bad Request</code>: Données invalides, avec des détails sur les erreurs de validation.
                                <pre>
            {
              "error": "Données invalides",
              "details": {
                "id_location": "L'ID de la location est invalide."
                // ... autres erreurs de validation ...
              }
            }
          </pre>
                            </li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la création de l'avis (par exemple, clé étrangère invalide).
                                <pre>
            {
              "error": "Erreur : Vérifiez que l'ID de la location existe."
            }
          </pre>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- DELETE /API/avis/{id} -->
            <div class="card">
                <div class="card-header" id="headingDeleteAvis">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseDeleteAvis" aria-expanded="false" aria-controls="collapseDeleteAvis">
                        <td><span class="method-badge delete">DELETE</span></td> /API/avis/{id}
                        </button>
                    </h2>
                </div>
                <div id="collapseDeleteAvis" class="collapse" aria-labelledby="headingDeleteAvis" data-parent="#avisAccordion">
                    <div class="card-body">
                        <p><strong>Description:</strong> Supprime un avis.</p>
                        <p><strong>Paramètres:</strong></p>
                        <ul>
                            <li><code>id</code> (int): ID de l'avis à supprimer.</li>
                        </ul>
                        <p><strong>Succès:</strong></p>
                        <pre>
          HTTP Status Code: 200 OK
          {
            "message": "Avis supprimé avec succès"
          }
        </pre>
                        <p><strong>Erreurs:</strong></p>
                        <ul>
                            <li><code>404 Not Found</code>: Aucun avis trouvé avec cet ID.</li>
                            <li><code>500 Internal Server Error</code>: Erreur lors de la suppression de l'avis.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ajoutez ici d'autres sections pour les autres entités de votre API (ex: Véhicules, Agences, etc.) -->
    </main>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>

</html>