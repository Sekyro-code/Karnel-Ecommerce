export default class AddCart {
    constructor() {

    }

    addToCart(id, slug) {

        console.log(`Le bouton avec l'id ${id} a été cliqué.`);

        fetch(`/panier/add/${id}`)
            .then(response => response.text())
            .then(data => {
                console.log(data);
                if (data === 'true') {
                    fetch(`/produit/${slug}`)
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);
                        })
                }
            })
            .catch(error => {
                console.error(error);
            });
    }

}