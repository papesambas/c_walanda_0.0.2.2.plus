const newItem = (e) => {
    const collectionHolder = document.querySelector(e.currentTarget.dataset.collection);

    // Vérifier si c'est #departs et s'il y a déjà un élément
    if (collectionHolder.id === "departs" && collectionHolder.children.length >= 1) {
        alert("Vous ne pouvez ajouter qu'une seule instance de départ.");
        return;
    }

    const item = document.createElement("div");
    item.classList.add("col-12");

    item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(/__name__/g, collectionHolder.dataset.index);

    item.querySelector('.btn-remove').addEventListener('click', () => item.remove());

    collectionHolder.appendChild(item);

    collectionHolder.dataset.index++;

};


document
    .querySelectorAll('.btn-remove')
    .forEach(btn => btn.addEventListener("click", (e) => e.currentTarget.closest(".col-12").remove()));

document
    .querySelectorAll('.btn-new')
    .forEach(btn => btn.addEventListener("click", newItem));
