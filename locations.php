<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des locations</title>
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
                        <a class="nav-link" href="vehicules.php">Véhicules</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="agences.php">Agences</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="disponibilites.php">Disponibilités</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="locations.php">Locations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="avis.php">Avis</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-11">
                <h2>Gestion des locations</h2>

                <div class="button-container mb-3">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAjout">
                        Ajouter une location
                    </button>
                </div>

                <table id="table-locations" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Utilisateur</th>
                            <th>Véhicule</th>
                            <th>Agence Départ</th>
                            <th>Agence Retour</th>
                            <th>Date Début</th>
                            <th>Date Fin</th>
                            <th>Prix Total</th>
                            <th>Statut</th>
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
                                <h5 class="modal-title" id="modalAjoutLabel">Ajouter/Modifier une location</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="form-location">
                                    <input type="hidden" id="id_location">
                                    <div class="form-group">
                                        <label for="id_utilisateur">Utilisateur:</label>
                                        <input type="text" class="form-control" id="id_utilisateur" name="id_utilisateur">
                                    </div>
                                    <div class="form-group">
                                        <label for="id_vehicule">Véhicule:</label>
                                        <input type="text" class="form-control" id="id_vehicule" name="id_vehicule">
                                    </div>
                                    <div class="form-group">
                                        <label for="id_agence_depart">Agence de départ:</label>
                                        <input type="text" class="form-control" id="id_agence_depart" name="id_agence_depart">
                                    </div>
                                    <div class="form-group">
                                        <label for="id_agence_retour">Agence de retour:</label>
                                        <input type="text" class="form-control" id="id_agence_retour" name="id_agence_retour">
                                    </div>
                                    <div class="form-group">
                                        <label for="date_debut">Date de début:</label>
                                        <input type="date" class="form-control" id="date_debut" name="date_debut">
                                    </div>
                                    <div class="form-group">
                                        <label for="date_fin">Date de fin:</label>
                                        <input type="date" class="form-control" id="date_fin" name="date_fin">
                                    </div>
                                    <div class="form-group">
                                        <label for="prix_total">Prix total:</label>
                                        <input type="number" class="form-control" id="prix_total" name="prix_total">
                                    </div>
                                    <div class="form-group">
                                        <label for="statut">Statut:</label>
                                        <input type="text" class="form-control" id="statut" name="statut">
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
        document.addEventListener('DOMContentLoaded', chargerLocations);

        function chargerLocations() {
            fetch('/API/locations')
                .then(response => response.json())
                .then(locations => {
                    afficherLocations(locations);
                });
        }

        function afficherLocations(locations) {
            const tbody = document.querySelector('#table-locations tbody');
            tbody.innerHTML = ''; // Effacer le contenu précédent

            locations.forEach(location => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${location.id_location}</td>
                <td>${location.id_utilisateur}</td>
                <td>${location.id_vehicule}</td>
                <td>${location.id_agence_depart}</td>
                <td>${location.id_agence_retour}</td>
                <td>${location.date_debut}</td>
                <td>${location.date_fin}</td>
                <td>${location.prix_total}</td>
                <td>${location.statut}</td>
                <td>
                    <button onclick="ouvrirModalModification(${location.id_location})" class="btn btn-success">Modifier</button>
                    <button onclick="supprimerLocation(${location.id_location})" class="btn btn-danger">Supprimer</button>
                </td>
            `;
                tbody.appendChild(row);
            });
        }

        function ouvrirModalAjout() {
            document.getElementById('form-location').reset();
            document.getElementById('modal-message').innerHTML = '';
            document.getElementById('modalAjout').style.display = 'block';
        }

        function ouvrirModalModification(id) {
            fetch(`/API/locations/${id}`)
                .then(response => response.json())
                .then(location => {
                    document.getElementById('id_location').value = location.id_location;
                    document.getElementById('id_utilisateur').value = location.id_utilisateur;
                    document.getElementById('id_vehicule').value = location.id_vehicule;
                    document.getElementById('id_agence_depart').value = location.id_agence_depart;
                    document.getElementById('id_agence_retour').value = location.id_agence_retour;
                    document.getElementById('date_debut').value = location.date_debut;
                    document.getElementById('date_fin').value = location.date_fin;
                    document.getElementById('prix_total').value = location.prix_total;
                    document.getElementById('statut').value = location.statut;
                    document.getElementById('modal-message').innerHTML = '';
                    document.getElementById('modalAjout').style.display = 'block';
                });
        }

        function fermerModal() {
            document.getElementById('modalAjout').style.display = 'none';
        }

        document.getElementById('form-location').addEventListener('submit', function(event) {
            event.preventDefault();

            const id = document.getElementById('id_location').value;
            const data = new FormData(this);
            const url = id ? `/API/locations/${id}` : '/API/locations';
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

                    // Recharger la liste des locations
                    chargerLocations();
                })
                .catch(error => {
                    document.getElementById('modal-message').innerHTML =
                        `<p class="error">${error.message}</p>`;
                });
        });

        function supprimerLocation(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cette location ?")) {
                fetch(`/API/locations/${id}`, {
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
                        chargerLocations();
                    })
                    .catch(error => {
                        alert(`Erreur : ${error.message}`);
                    });
            }
        }
    </script>

</body>

</html>
