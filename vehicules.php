<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des véhicules</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header class="bg-dark text-white py-3">
        <div class="container">
            <h1 class="mb-0">Panneau d'Administration</h1>
        </div>
    </header>

    <main class="container-fluid">
        <div class="row">
            <div class="col-md-1">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="utilisateurs.php">Utilisateurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="vehicules.php">Véhicules</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="agences.php">Agences</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="disponibilites.php">Disponibilités</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="locations.php">Locations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="avis.php">Avis</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-11">
                <h2>Gestion des véhicules</h2>

                <div class="button-container mb-3">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAjout">
                        Ajouter un véhicule
                    </button>
                </div>

                <table id="table-vehicules" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Marque</th>
                            <th>Modèle</th>
                            <th>Année</th>
                            <th>Immatriculation</th>
                            <th>Kilométrage</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Les données seront chargées ici avec JavaScript -->
                    </tbody>
                </table>

                <!-- Modal d'ajout/modification -->
                <div class="modal fade" id="modalAjout" tabindex="-1" role="dialog" aria-labelledby="modalAjoutLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalAjoutLabel">Ajouter/Modifier un véhicule</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="form-vehicule">
                                    <input type="hidden" id="id_vehicule">
                                    <div class="form-group">
                                        <label for="id_categorie">Catégorie:</label>
                                        <input type="text" class="form-control" id="id_categorie" name="id_categorie">
                                    </div>
                                    <div class="form-group">
                                        <label for="marque">Marque:</label>
                                        <input type="text" class="form-control" id="marque" name="marque">
                                    </div>
                                    <div class="form-group">
                                        <label for="modele">Modèle:</label>
                                        <input type="text" class="form-control" id="modele" name="modele">
                                    </div>
                                    <div class="form-group">
                                        <label for="annee">Année:</label>
                                        <input type="number" class="form-control" id="annee" name="annee">
                                    </div>
                                    <div class="form-group">
                                        <label for="immatriculation">Immatriculation:</label>
                                        <input type="text" class="form-control" id="immatriculation" name="immatriculation">
                                    </div>
                                    <div class="form-group">
                                        <label for="kilometrage">Kilométrage:</label>
                                        <input type="number" class="form-control" id="kilometrage" name="kilometrage">
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre_places">Nombre de places:</label>
                                        <input type="number" class="form-control" id="nombre_places" name="nombre_places">
                                    </div>
                                    <div class="form-group">
                                        <label for="climatisation">Climatisation:</label>
                                        <input type="checkbox" class="form-control" id="climatisation" name="climatisation">
                                    </div>
                                    <div class="form-group">
                                        <label for="gps">GPS:</label>
                                        <input type="checkbox" class="form-control" id="gps" name="gps">
                                    </div>
                                    <div class="form-group">
                                        <label for="transmission">Transmission:</label>
                                        <input type="text" class="form-control" id="transmission" name="transmission">
                                    </div>
                                    <div class="form-group">
                                        <label for="carburant">Carburant:</label>
                                        <input type="text" class="form-control" id="carburant" name="carburant">
                                    </div>
                                    <div class="form-group">
                                        <label for="disponible">Disponible:</label>
                                        <input type="checkbox" class="form-control" id="disponible" name="disponible">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </form>
                                <div id="modal-message"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', chargerVehicules);

        function chargerVehicules() {
            fetch('/API/vehicules')
                .then(response => response.json())
                .then(vehicules => {
                    afficherVehicules(vehicules);
                });
        }

        function afficherVehicules(vehicules) {
            const tbody = document.querySelector('#table-vehicules tbody');
            tbody.innerHTML = ''; // Effacer le contenu précédent

            vehicules.forEach(vehicule => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${vehicule.id_vehicule}</td>
                <td>${vehicule.marque}</td>
                <td>${vehicule.modele}</td>
                <td>${vehicule.annee}</td>
                <td>${vehicule.immatriculation}</td>
                <td>${vehicule.kilometrage}</td>
                <td>
                    <button onclick="ouvrirModalModification(${vehicule.id_vehicule})" class="btn btn-success">Modifier</button>
                    <button onclick="supprimerVehicule(${vehicule.id_vehicule})" class="btn btn-danger">Supprimer</button>
                </td>
            `;
                tbody.appendChild(row);
            });
        }

        function ouvrirModalAjout() {
            document.getElementById('form-vehicule').reset();
            document.getElementById('modal-message').innerHTML = '';
            document.getElementById('modalAjout').style.display = 'block';
        }

        function ouvrirModalModification(id) {
            fetch(`/API/vehicules/${id}`)
                .then(response => response.json())
                .then(vehicule => {
                    document.getElementById('id_vehicule').value = vehicule.id_vehicule;
                    document.getElementById('id_categorie').value = vehicule.id_categorie;
                    document.getElementById('marque').value = vehicule.marque;
                    document.getElementById('modele').value = vehicule.modele;
                    document.getElementById('annee').value = vehicule.annee;
                    document.getElementById('immatriculation').value = vehicule.immatriculation;
                    document.getElementById('kilometrage').value = vehicule.kilometrage;
                    document.getElementById('nombre_places').value = vehicule.nombre_places;
                    document.getElementById('climatisation').checked = vehicule.climatisation;
                    document.getElementById('gps').checked = vehicule.gps;
                    document.getElementById('transmission').value = vehicule.transmission;
                    document.getElementById('carburant').value = vehicule.carburant;
                    document.getElementById('disponible').checked = vehicule.disponible;
                    document.getElementById('modal-message').innerHTML = '';
                    document.getElementById('modalAjout').style.display = 'block';
                });
        }

        function fermerModal() {
            document.getElementById('modalAjout').style.display = 'none';
        }

        document.getElementById('form-vehicule').addEventListener('submit', function(event) {
            event.preventDefault();

            const id = document.getElementById('id_vehicule').value;
            const data = new FormData(this);
            const url = id ? `/API/vehicules/${id}` : '/API/vehicules';
            const method = id ? 'PUT' : 'POST';

            fetch(url, {
                    method: method,
                    body: data
                })
                .then(response => {
                    if (!response.ok) {
                        // Vérifier si la réponse n'est pas OK (status code 200-299)
                        return response.json().then(err => {
                            throw new Error(err.error);
                        });
                    } else {
                        return response.json();
                    }
                })
                .then(result => {
                    // Afficher un message de succès dans le modal
                    document.getElementById('modal-message').innerHTML =
                        `<p class="success">${result.message}</p>`;

                    // Recharger la liste des véhicules
                    chargerVehicules();
                })
                .catch(error => {
                    document.getElementById('modal-message').innerHTML =
                        `<p class="error">${error.message}</p>`;
                });
        });

        function supprimerVehicule(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer ce véhicule ?")) {
                fetch(`/API/vehicules/${id}`, {
                        method: 'DELETE'
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.error);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        alert(data.message); // Afficher le message de succès
                        chargerVehicules();
                    })
                    .catch(error => {
                        alert(`Erreur : ${error.message}`);
                    });
            }
        }
    </script>

</body>

</html>
