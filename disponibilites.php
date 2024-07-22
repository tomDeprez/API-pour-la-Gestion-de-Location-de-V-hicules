<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des disponibilités</title>
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
                        <a class="nav-link active" href="disponibilites.php">Disponibilités</a>
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
                <h2>Gestion des disponibilités</h2>

                <div class="button-container mb-3">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAjout">
                        Ajouter une disponibilité
                    </button>
                </div>

                <table id="table-disponibilites" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Véhicule</th>
                            <th>Agence</th>
                            <th>Quantité</th>
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
                                <h5 class="modal-title" id="modalAjoutLabel">Ajouter/Modifier une disponibilité</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="form-disponibilite">
                                    <input type="hidden" id="id_disponibilite">
                                    <div class="form-group">
                                        <label for="id_vehicule">Véhicule:</label>
                                        <input type="text" class="form-control" id="id_vehicule" name="id_vehicule">
                                    </div>
                                    <div class="form-group">
                                        <label for="id_agence">Agence:</label>
                                        <input type="text" class="form-control" id="id_agence" name="id_agence">
                                    </div>
                                    <div class="form-group">
                                        <label for="quantite">Quantité:</label>
                                        <input type="number" class="form-control" id="quantite" name="quantite">
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
        document.addEventListener('DOMContentLoaded', chargerDisponibilites);

        function chargerDisponibilites() {
            fetch('/API/disponibilites')
                .then(response => response.json())
                .then(disponibilites => {
                    afficherDisponibilites(disponibilites);
                });
        }

        function afficherDisponibilites(disponibilites) {
            const tbody = document.querySelector('#table-disponibilites tbody');
            tbody.innerHTML = ''; // Effacer le contenu précédent

            disponibilites.forEach(disponibilite => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${disponibilite.id_disponibilite}</td>
                <td>${disponibilite.id_vehicule}</td>
                <td>${disponibilite.id_agence}</td>
                <td>${disponibilite.quantite}</td>
                <td>
                    <button onclick="ouvrirModalModification(${disponibilite.id_disponibilite})" class="btn btn-success">Modifier</button>
                    <button onclick="supprimerDisponibilite(${disponibilite.id_disponibilite})" class="btn btn-danger">Supprimer</button>
                </td>
            `;
                tbody.appendChild(row);
            });
        }

        function ouvrirModalAjout() {
            document.getElementById('form-disponibilite').reset();
            document.getElementById('modal-message').innerHTML = '';
            document.getElementById('modalAjout').style.display = 'block';
        }

        function ouvrirModalModification(id) {
            fetch(`/API/disponibilites/${id}`)
                .then(response => response.json())
                .then(disponibilite => {
                    document.getElementById('id_disponibilite').value = disponibilite.id_disponibilite;
                    document.getElementById('id_vehicule').value = disponibilite.id_vehicule;
                    document.getElementById('id_agence').value = disponibilite.id_agence;
                    document.getElementById('quantite').value = disponibilite.quantite;
                    document.getElementById('modal-message').innerHTML = '';
                    document.getElementById('modalAjout').style.display = 'block';
                });
        }

        function fermerModal() {
            document.getElementById('modalAjout').style.display = 'none';
        }

        document.getElementById('form-disponibilite').addEventListener('submit', function(event) {
            event.preventDefault();

            const id = document.getElementById('id_disponibilite').value;
            const data = new FormData(this);
            const url = id ? `/API/disponibilites/${id}` : '/API/disponibilites';
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

                    // Recharger la liste des disponibilités
                    chargerDisponibilites();
                })
                .catch(error => {
                    document.getElementById('modal-message').innerHTML =
                        `<p class="error">${error.message}</p>`;
                });
        });

        function supprimerDisponibilite(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cette disponibilité ?")) {
                fetch(`/API/disponibilites/${id}`, {
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
                        chargerDisponibilites();
                    })
                    .catch(error => {
                        alert(`Erreur : ${error.message}`);
                    });
            }
        }
    </script>

</body>

</html>
