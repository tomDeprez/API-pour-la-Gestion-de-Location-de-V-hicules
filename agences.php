<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des agences</title>
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
                        <a class="nav-link active" href="agences.php">Agences</a>
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
                <h2>Gestion des agences</h2>

                <div class="button-container mb-3">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAjout">
                        Ajouter une agence
                    </button>
                </div>

                <table id="table-agences" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Adresse</th>
                            <th>Code Postal</th>
                            <th>Ville</th>
                            <th>Pays</th>
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
                                <h5 class="modal-title" id="modalAjoutLabel">Ajouter/Modifier une agence</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="form-agence">
                                    <input type="hidden" id="id_agence">
                                    <div class="form-group">
                                        <label for="nom">Nom:</label>
                                        <input type="text" class="form-control" id="nom" name="nom">
                                    </div>
                                    <div class="form-group">
                                        <label for="adresse">Adresse:</label>
                                        <input type="text" class="form-control" id="adresse" name="adresse">
                                    </div>
                                    <div class="form-group">
                                        <label for="code_postal">Code Postal:</label>
                                        <input type="text" class="form-control" id="code_postal" name="code_postal">
                                    </div>
                                    <div class="form-group">
                                        <label for="ville">Ville:</label>
                                        <input type="text" class="form-control" id="ville" name="ville">
                                    </div>
                                    <div class="form-group">
                                        <label for="pays">Pays:</label>
                                        <input type="text" class="form-control" id="pays" name="pays">
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
        document.addEventListener('DOMContentLoaded', chargerAgences);

        function chargerAgences() {
            fetch('/API/agences')
                .then(response => response.json())
                .then(agences => {
                    afficherAgences(agences);
                });
        }

        function afficherAgences(agences) {
            const tbody = document.querySelector('#table-agences tbody');
            tbody.innerHTML = ''; // Effacer le contenu précédent

            agences.forEach(agence => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${agence.id_agence}</td>
                <td>${agence.nom}</td>
                <td>${agence.adresse}</td>
                <td>${agence.code_postal}</td>
                <td>${agence.ville}</td>
                <td>${agence.pays}</td>
                <td>
                    <button onclick="ouvrirModalModification(${agence.id_agence})" class="btn btn-success">Modifier</button>
                    <button onclick="supprimerAgence(${agence.id_agence})" class="btn btn-danger">Supprimer</button>
                </td>
            `;
                tbody.appendChild(row);
            });
        }

        function ouvrirModalAjout() {
            document.getElementById('form-agence').reset();
            document.getElementById('modal-message').innerHTML = '';
            document.getElementById('modalAjout').style.display = 'block';
        }

        function ouvrirModalModification(id) {
            fetch(`/API/agences/${id}`)
                .then(response => response.json())
                .then(agence => {
                    document.getElementById('id_agence').value = agence.id_agence;
                    document.getElementById('nom').value = agence.nom;
                    document.getElementById('adresse').value = agence.adresse;
                    document.getElementById('code_postal').value = agence.code_postal;
                    document.getElementById('ville').value = agence.ville;
                    document.getElementById('pays').value = agence.pays;
                    document.getElementById('modal-message').innerHTML = '';
                    document.getElementById('modalAjout').style.display = 'block';
                });
        }

        function fermerModal() {
            document.getElementById('modalAjout').style.display = 'none';
        }

        document.getElementById('form-agence').addEventListener('submit', function(event) {
            event.preventDefault();

            const id = document.getElementById('id_agence').value;
            const data = new FormData(this);
            const url = id ? `/API/agences/${id}` : '/API/agences';
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

                    // Recharger la liste des agences
                    chargerAgences();
                })
                .catch(error => {
                    document.getElementById('modal-message').innerHTML =
                        `<p class="error">${error.message}</p>`;
                });
        });

        function supprimerAgence(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cette agence ?")) {
                fetch(`/API/agences/${id}`, {
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
                        chargerAgences();
                    })
                    .catch(error => {
                        alert(`Erreur : ${error.message}`);
                    });
            }
        }
    </script>

</body>

</html>
