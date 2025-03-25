$(document).ready(function () {
    //Gestion des boutons "supprimer"
    let links = document.querySelectorAll("[data-delete]");
    // On boucle sur links
    for (const link of links) {
        //On écoute le click
        link.addEventListener("click", function (e) {
            e.preventDefault()
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
})



/*documentDeleteFunction();
function documentDeleteFunction() {
    $(document).ready(function () {
        // Gestion des boutons supprimer
        let links = document.querySelectorAll("[data-deletedoc]");
        console.log(links);

        // On boucle sur links
        for (link of links) {
            link.addEventListener("click", function (e) {
                // On empeche la navigation
                e.preventDefault();
                // On demande Confirmation
                if (confirm("Voulez-vous supprimer ce document ?")) {
                    // On envoie une requete Ajax vers le href du lien avec la Methode DELETE
                    fetch(this.getAttribute("href"), {
                        method: "DELETE", // Utilisez la méthode DELETE ici
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ "_token": this.dataset.token })
                    }).then(
                        // On recupere la reponse en Json
                        response => response.json()
                    ).then(data => {
                        if (data.success)
                            this.parentElement.remove();
                        else
                            alert(data.error);
                    }).catch(e => alert(e));
                }
            });
        }
    });
}*/
