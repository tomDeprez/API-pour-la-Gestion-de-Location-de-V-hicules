<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des utilisateurs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
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
                        <a class="nav-link active" href="utilisateurs.php">Utilisateurs</a>
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
                        <a class="nav-link" href="locations.php">Locations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="avis.php">Avis</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-11">
                <h2>Gestion des utilisateurs</h2>

                <div class="button-container mb-3">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAjout">
                        Ajouter un utilisateur
                    </button>
                </div>

                <table id="table-utilisateurs" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
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
                                <h5 class="modal-title" id="modalAjoutLabel">Ajouter/Modifier un utilisateur</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="form-utilisateur">
                                    <input type="hidden" id="id_utilisateur">
                                    <div class="form-group">
                                        <label for="nom">Nom:</label>
                                        <input type="text" class="form-control" id="nom" name="nom">
                                    </div>
                                    <div class="form-group">
                                        <label for="prenom">Prénom:</label>
                                        <input type="text" class="form-control" id="prenom" name="prenom">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="mot_de_passe">Mot de passe:</label>
                                        <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe">
                                    </div>
                                    <!-- Autres champs du formulaire -->
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
                                    <div class="form-group">
                                        <label for="telephone">Téléphone:</label>
                                        <input type="text" class="form-control" id="telephone" name="telephone">
                                    </div>
                                    <div class="form-group">
                                        <label for="date_naissance">Date de naissance:</label>
                                        <input type="date" class="form-control" id="date_naissance" name="date_naissance">
                                    </div>
                                    <div class="form-group">
                                        <label for="permis_conduire">Permis de conduire:</label>
                                        <input type="text" class="form-control" id="permis_conduire" name="permis_conduire">
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
        document.addEventListener('DOMContentLoaded', chargerUtilisateurs);

        function chargerUtilisateurs() {
            fetch('/API/utilisateurs')
                .then(response => response.json())
                .then(utilisateurs => {
                    afficherUtilisateurs(utilisateurs);
                });
        }

        function afficherUtilisateurs(utilisateurs) {
            const tbody = document.querySelector('#table-utilisateurs tbody');
            tbody.innerHTML = ''; // Effacer le contenu précédent

            utilisateurs.forEach(utilisateur => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${utilisateur.id_utilisateur}</td>
                <td>${utilisateur.nom}</td>
                <td>${utilisateur.prenom}</td>
                <td>${utilisateur.email}</td>
                <td>
                    <button onclick="ouvrirModalModification(${utilisateur.id_utilisateur})" class="btn btn-success">Modifier</button>
                    <button onclick="supprimerUtilisateur(${utilisateur.id_utilisateur})" class="btn btn-danger">Supprimer</button>
                </td>
            `;
                tbody.appendChild(row);
            });
        }

        function ouvrirModalAjout() {
            document.getElementById('form-utilisateur').reset();
            document.getElementById('modal-message').innerHTML = '';
            document.getElementById('modalAjout').style.display = 'block';
        }

        function ouvrirModalModification(id) {
            fetch(`/API/utilisateurs/${id}`)
                .then(response => response.json())
                .then(utilisateur => {
                    document.getElementById('id_utilisateur').value = utilisateur.id_utilisateur;
                    document.getElementById('nom').value = utilisateur.nom;
                    document.getElementById('prenom').value = utilisateur.prenom;
                    document.getElementById('email').value = utilisateur.email;
                    document.getElementById('mot_de_passe').value = utilisateur.mot_de_passe;
                    document.getElementById('adresse').value = utilisateur.adresse;
                    document.getElementById('code_postal').value = utilisateur.code_postal;
                    document.getElementById('ville').value = utilisateur.ville;
                    document.getElementById('pays').value = utilisateur.pays;
                    document.getElementById('telephone').value = utilisateur.telephone;
                    document.getElementById('date_naissance').value = utilisateur.date_naissance;
                    document.getElementById('permis_conduire').value = utilisateur.permis_conduire;
                    document.getElementById('modal-message').innerHTML = '';
                    document.getElementById('modalAjout').style.display = 'block';
                });
        }

        function fermerModal() {
            document.getElementById('modalAjout').style.display = 'none';
        }

        document.getElementById('form-utilisateur').addEventListener('submit', function(event) {
            event.preventDefault();



            const id = document.getElementById('id_utilisateur').value;
            const data = new FormData(this);
            const url = id ? `/API/utilisateurs/${id}` : '/API/utilisateurs';
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

                    // Recharger la liste des utilisateurs
                    chargerUtilisateurs();
                })
                .catch(error => {
                    document.getElementById('modal-message').innerHTML =
                        `<p class="error">${error.message}</p>`;
                });
        });

        function supprimerUtilisateur(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
                fetch(`/API/utilisateurs/${id}`, {
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
                        chargerUtilisateurs();
                    })
                    .catch(error => {
                        alert(`Erreur : ${error.message}`);
                    });
            }
        }
    </script>

</body>

</html>