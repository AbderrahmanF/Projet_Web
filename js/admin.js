function admin_buttons() {
    let admin_div = document.querySelector("#admin-options")
    // let filtres_poste = document.querySelector('#filtre-poste')
    // let choix_poste = document.querySelector('#choix-poste')
    fetch('../html/admin.html')
        .then(response => response.text())
        .then(html => {
            admin_div.innerHTML = html;
        })
        .catch(error => {
            console.error('Une erreur s\'est produite : ', error);
        });
    // fetch('../html/postes.html')
    //     .then(response => response.text())
    //     .then(html2 => {
    //         filtres_poste.innerHTML = html2;
    //         choix_poste.innerHTML = html2
    //     })
    //     .catch(error => {
    //         console.error('Une erreur s\'est produite : ', error);
    //     });
}
// window.onload = (event) => { admin_buttons() }