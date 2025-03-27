//Gestion des boutons "supprimer"
let links = document.querySelectorAll("[data-delete]");
console.log("Liste des liens trouvés :", links);
// On boucle sur links
for (const link of links) {
    //On écoute le click
    link.addEventListener("click", function (e) {
        e.preventDefault()
        console.log("Lien cliqué :", this.getAttribute("href"));

        // On demande confirmation
        if (confirm("Voulez-vous supprimer ce document")) {
            // On envoi une requête ajax vers le href du lien avec la méthode DELETE
            fetch(this.getAttribute("href"), {
                method: 'DELETE',
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ "_token": this.dataset.token })
            }).then(
                // On récupère la réponse en JSON
                response => response.json()
            ).then(data => {
                if (data.success)
                    this.parentElement.remove()
                else
                    alert(data.error)
            }).catch(e => alert(e))

        }
    })
}




/*function documentDeleteFunction() {
    let links = document.querySelectorAll("[data-deletedoc]");
    console.log("Liste des liens trouvés :", links);

    for (let link of links) {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            console.log("Lien cliqué :", this.getAttribute("href"));

            if (confirm("Voulez-vous supprimer ce document ?")) {
                console.log("Confirmation acceptée, envoi de la requête...");

                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ "_token": this.dataset.token })
                }).then(response => {
                    console.log("Réponse reçue :", response);
                    return response.json();
                }).then(data => {
                    console.log("Données JSON reçues :", data);

                    if (data.success) {
                        console.log("Suppression réussie, suppression de l'élément DOM.");
                        this.parentElement.remove();
                    } else {
                        console.error("Erreur côté serveur :", data.error);
                        alert(data.error);
                    }
                }).catch(e => {
                    console.error("Erreur lors de la requête :", e);
                    alert(e);
                });
            } else {
                console.log("Suppression annulée.");
            }
        });
    }
}

documentDeleteFunction();*/
