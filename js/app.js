
function togglePassword() {
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    password.type === 'password' ? password.type = 'text' : password.type = 'password'
    togglePassword.classList.toggle("bi-eye")
}


function getJobs(persons) {
    let jobsList = []
    persons.forEach(person => {
        if (!jobsList.includes(person.wanted_job)) {
            jobsList.push(person.wanted_job)
        }
    });
    return jobsList
}


function toggleMouse() {
    const cv = document.querySelector(".show")
    if (cv.style.display == 'none') {
        console.log(cv)
        cv.style = { ..."display : auto" };
    }
    else {
        cv.style.display = " none";
    }
}


function showSelect() {
    let list = ['vincent', 'amaury', 'abderrahman']
    let newSelect = document.createElement("select")
    list.map(person => {
        let newOption = document.createElement("option")
        newOption.text = person
        newOption.id = person
        newOption.onmouseenter = () => toggleMouse(true)
        newOption.onmouseleave = () => toggleMouse(false)
        newSelect.add(newOption)
    })
    return newSelect
}

function hideNavbar() {
    let head = document.querySelector(':root')
    let arrow = document.querySelector('.hide-navbar')
    let navbar = document.querySelector('.left-navbar')
    if (head.classList.contains('navbar-hidden')) {
        head.classList.remove('navbar-hidden')
        arrow.classList.remove('turn')
        for (let i = 0; i < navbar.children.length; i++) {
            console.log(navbar.children.item(i).classList)
            navbar.children.item(i).classList.remove('is-hidden')
        }
    }
    else {
        head.classList.add('navbar-hidden')
        arrow.classList.add('turn')
        for (let i = 0; i < navbar.children.length; i++) {
            navbar.children.item(i).classList.add('is-hidden')
        }
    }
}

function changeTheme() {
    let head = document.querySelector(':root')
    let sun = document.querySelector('.bi-sun')
    let moon = document.querySelector('.bi-moon')
    if (head.classList.contains('is-dark')) {
        head.classList.remove('is-dark')
        sun.classList.add('is-hidden')
        moon.classList.remove('is-hidden')
        localStorage.setItem('gestionnaire_theme', '')
    }
    else {
        head.classList.add('is-dark')
        sun.classList.remove('is-hidden')
        moon.classList.add('is-hidden')
        localStorage.setItem('gestionnaire_theme', 'is-dark')
    }
}

function showCV(e) {
    var target = e.target
    if (window.getSelection().toString().length != 0) {
        return
    }
    while (!target.classList.contains('is-person')) {
        target = target.parentNode
    }
    var iframe = document.querySelector(".pdf-text")
    iframe.src = target.getAttribute("cv")
    var view = document.querySelector(".pdf-screen")
    view.classList.remove('is-hidden')
}

function hideCV() {
    var view = document.querySelector(".pdf-screen")
    view.classList.add('is-hidden')
}

function filterCV() {
    var text = document.querySelector('#searchBar').value.toLowerCase()
    var div = document.querySelector('.people-list')
    var under_div = div.children
    for (let i = 0; i < under_div.length; i++) {
        if (!under_div[i].innerHTML.toLowerCase().includes(text)) {
            under_div[i].style.display = 'none'
        }
        else {
            under_div[i].style.display = 'flex'
        }
    }
}

function canConnect() {
    let trueUser = 'vangoulv'
    let truePW = 'vangoulv12'
    let isUser = document.querySelector('#username').value
    let isPW = document.querySelector('#password').value
    if (trueUser == isUser && isPW == truePW) {
        window.location.href = 'gestionnaire.html'
    }
}

function filterByPoste() {
    const postes = Array.from(document.querySelectorAll('.poste-div'))
    const postesList = postes.map(poste => {
        return { "offre": poste.getAttribute('poste'), "secteur": poste.getAttribute('secteur') }
    })
    const personnes = document.querySelectorAll('.is-person')
    for (let i = 0; i < personnes.length; i++) {
        let postulations = JSON.parse(personnes[i].getAttribute('metier'))
        let shouldAppear = false
        for (let j = 0; j < postesList.length; j++) {
            if (postulations.find(item => item.offre == postesList[j].offre && item.secteur == postesList[j].secteur)) {
                shouldAppear = true
                break
            }
        }
        if (!shouldAppear && postesList.length > 0) {
            personnes[i].style.display = 'none'
        }
        else {
            personnes[i].style.display = 'flex'
        }
    }
}

function addPosteModif(offre = null, cat = null) {
    // let verifPosteModif = document.querySelector('#verif-poste-modif')
    // if (verifPosteModif.value == "") {
    //     verifPosteModif.value = "&"
    // }
    let poste = offre != null ? offre : document.querySelector('#select-poste-modif').value
    let secteur = cat != null ? cat : document.querySelector('#select-cat-modif').value
    let filtres = document.querySelector('#choix-poste-modif')
    for (let i = 0; i < filtres.children.length; i++) {
        if (filtres.children[i].id === poste + "-modif") {
            return
        }
    }
    let newPoste = document.createElement('div')
    newPoste.setAttribute('class', 'poste-div')
    newPoste.setAttribute('id', poste + "-modif")
    newPoste.setAttribute('poste', poste)
    newPoste.setAttribute("secteur", secteur)
    let posteName = document.createElement('p')
    posteName.setAttribute('class', 'poste-name')
    posteName.innerHTML = poste
    let secteurName = document.createElement('p')
    secteurName.setAttribute('class', 'secteur-name')
    secteurName.innerHTML = secteur
    let span = document.createElement('span')
    span.setAttribute('class', 'sup-poste pointer')
    span.setAttribute('id', poste + "-modif")
    span.setAttribute('onclick', "SupPosteModif(event)")
    let croix = document.createElement('i')
    croix.setAttribute('class', 'bi-x icon')
    croix.setAttribute('id', poste + "-modif")
    span.appendChild(croix)
    let names = document.createElement('div')
    names.setAttribute('class', 'offre-secteur')
    names.append(secteurName, posteName)
    newPoste.append(names, span)
    let row = document.querySelector('#choix-poste-modif')
    row.appendChild(newPoste)
}

function SupPosteModif(evt) {
    let element_id = evt.target.id
    let filtres = document.querySelector('#choix-poste-modif')
    for (let i = 0; i < filtres.children.length; i++) {
        if (filtres.children[i].id === element_id) {
            filtres.removeChild(filtres.children[i])
            break
        }
    }
    // if (filtres.children.length == 0) {
    //     let verifPoste = document.querySelector('#verif-poste-modif')
    //     verifPoste.value = ""
    // }
}

function addPosteAjout() {
    // let verifPoste = document.querySelector('#verif-poste')
    // if (verifPoste.value == "") {
    //     verifPoste.value = "&"
    // }
    let poste = document.querySelector('#select-poste-ajout').value
    let secteur = document.querySelector('#select-cat-ajout').value
    let filtres = document.querySelector('#choix-poste')
    for (let i = 0; i < filtres.children.length; i++) {
        if (filtres.children[i].id === poste + "-ajout") {
            return
        }
    }
    let newPoste = document.createElement('div')
    newPoste.setAttribute('class', 'poste-div')
    newPoste.setAttribute('id', poste + "-ajout")
    newPoste.setAttribute('poste', poste)
    newPoste.setAttribute("secteur", secteur)
    let posteName = document.createElement('p')
    posteName.setAttribute('class', 'poste-name')
    posteName.innerHTML = poste
    let secteurName = document.createElement('p')
    secteurName.setAttribute('class', 'secteur-name')
    secteurName.innerHTML = secteur
    let span = document.createElement('span')
    span.setAttribute('class', 'sup-poste pointer')
    span.setAttribute('id', poste + "-ajout")
    span.setAttribute('onclick', "SupPosteAjout(event)")
    let croix = document.createElement('i')
    croix.setAttribute('class', 'bi-x icon')
    croix.setAttribute('id', poste + "-ajout")
    span.appendChild(croix)
    let names = document.createElement('div')
    names.setAttribute('class', 'offre-secteur')
    names.append(secteurName, posteName)
    newPoste.append(names, span)
    let row = document.querySelector('#choix-poste')
    row.appendChild(newPoste)
}

function SupPosteAjout(evt) {
    let element_id = evt.target.id
    let filtres = document.querySelector('#choix-poste')
    for (let i = 0; i < filtres.children.length; i++) {
        if (filtres.children[i].id === element_id) {
            filtres.removeChild(filtres.children[i])
            break
        }
    }
    // if (filtres.children.length == 0) {
    //     let verifPoste = document.querySelector('#verif-poste')
    //     verifPoste.value = ""
    // }
}

function addPoste() {
    let poste = document.querySelector('#select-poste').value
    let secteur = document.querySelector('#select-cat').value
    let filtres = document.querySelector('#filtre-poste')
    for (let i = 0; i < filtres.children.length; i++) {
        if (filtres.children[i].id === poste + "-" + secteur) {
            return
        }
    }
    let newPoste = document.createElement('div')
    newPoste.setAttribute('class', 'poste-div')
    newPoste.setAttribute('id', poste + '-' + secteur)
    newPoste.setAttribute('poste', poste)
    newPoste.setAttribute("secteur", secteur)
    let posteName = document.createElement('p')
    posteName.setAttribute('class', 'poste-name')
    posteName.innerHTML = poste
    let secteurName = document.createElement('p')
    secteurName.setAttribute('class', 'secteur-name')
    secteurName.innerHTML = secteur
    let span = document.createElement('span')
    span.setAttribute('class', 'sup-poste pointer')
    span.setAttribute('id', poste + '-' + secteur)
    span.addEventListener('click', SupPoste)
    let croix = document.createElement('i')
    croix.setAttribute('class', 'bi-x icon')
    croix.setAttribute('id', poste + '-' + secteur)
    span.appendChild(croix)
    let names = document.createElement('div')
    names.setAttribute('class', 'offre-secteur')
    names.append(secteurName, posteName)
    newPoste.append(names, span)
    let row = document.querySelector('#filtre-poste')
    row.appendChild(newPoste)
    filterByPoste()
}

function SupPoste(evt) {
    let element_id = evt.target.id
    let filtres = document.querySelector('#filtre-poste')
    for (let i = 0; i < filtres.children.length; i++) {
        if (filtres.children[i].id === element_id) {
            filtres.removeChild(filtres.children[i])
            break
        }
    }
    filterByPoste()

}

function showAdder() {
    let doc = document.querySelector('#main')
    let div = document.querySelector('#adder-window')
    if (div) {
        div.style.display = 'flex'
    }
    else {
        fetch('../html/ajouterUtilisateur.php')
            .then(response => response.text())
            .then(php => {
                doc.insertAdjacentHTML('beforeend', php);
            }).then(() => {
                selectPoste('#select-cat-ajout', '#select-poste-ajout')
            })
            .catch(error => {
                console.error('Une erreur s\'est produite : ', error);
            });
    }
}

function showModifier(evt) {
    let profileDiv = evt.target.parentElement.parentElement
    let attributs = profileDiv.children[1].children[1].children
    let metiers = JSON.parse(profileDiv.getAttribute('metier'))
    let id_postulant = profileDiv.getAttribute('id_postulant')
    let doc = document.querySelector('#main')
    let div = document.querySelector('#modifier-window')
    if (div) {
        div.style.display = 'flex'
        div.setAttribute('id_postulant', id_postulant)
        document.querySelector('#nom-modif').defaultValue = attributs[0].getAttribute("nom")
        document.querySelector('#prenom-modif').defaultValue = attributs[0].getAttribute("prenom")
        document.querySelector('#telephone-modif').defaultValue = attributs[1].innerHTML
        document.querySelector('#courriel-modif').defaultValue = attributs[2].innerHTML
        metiers.forEach(metier => {
            addPosteModif(metier.offre, metier.secteur)
        })
    }
    else {
        fetch('../html/modifierUtilisateur.php')
            .then(response => response.text())
            .then(html => {
                doc.insertAdjacentHTML('beforeend', html);
            }).then(() => {
                selectPoste('#select-cat-modif', '#select-poste-modif')

            })
            .catch(error => {
                console.error('Une erreur s\'est produite : ', error);
            });
    }
}

function showOffers() {
    let doc = document.querySelector('#main')
    let div = document.querySelector('#offer-window')
    if (div) {
        div.style.display = 'flex'
    }
    else {
        fetch('../html/gererOffres.php')
            .then(response => response.text())
            .then(php => {
                doc.insertAdjacentHTML('beforeend', php);
            }).then(() => {
                let selectCatOffer = document.querySelector('#select-cat-offerModif');
                let selectPosteOffer = document.querySelector('#select-poste-offerModif');
                if (selectCatOffer && selectPosteOffer) {
                    selectPoste("#select-cat-offerModif", "#select-poste-offerModif");
                }
                document.querySelector('#offer-window').style.display = 'flex';
            })
            .catch(error => {
                console.error('Une erreur s\'est produite : ', error);
            });
    }

}

function hideAdder() {
    let div = document.querySelector('#adder-window')
    div.style.display = 'none'
    choixpostes = document.querySelector('#choix-poste')
    while (choixpostes && choixpostes.firstChild) {
        choixpostes.removeChild(choixpostes.firstChild)
    }
}

function hideModifier() {
    let div = document.querySelector('#modifier-window')
    div.style.display = 'none'
    choixpostes = document.querySelector('#choix-poste-modif')
    while (choixpostes.firstChild) {
        choixpostes.removeChild(choixpostes.firstChild)
    }
}

function hideOfferWindow() {
    let div = document.querySelector('#offer-window')
    div.style.display = 'none'
}

function selectPoste(cat, poste) {
    if (cat === "#select-cat-offerModif") {
        document.querySelector('#nom-offre-modif').value = ""
    }
    let select = document.querySelector(cat)
    let value = select.value
    let select_poste = document.querySelector(poste)
    let options = select_poste.children
    let changed = false
    for (let i = 0; i < options.length; i++) {
        if (!(options[i].classList[1] == value)) {
            options[i].style.display = 'none'
        }
        else {
            if (!changed) {
                select_poste.value = options[i].value
                changed = true
            }
            options[i].style.display = 'block'
        }
    }

}

function selectAll() {
    let checkboxes = document.querySelectorAll('.checkbox')
    let selectAll = document.querySelector('#select-all')
    let checked = selectAll.checked
    for (let i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].parentElement.parentElement.style.display != 'none') {
            checkboxes[i].checked = checked
        }
    }
}
function deleteSelected() {
    let checkboxes = document.querySelectorAll('.checkbox')
    ids = []
    for (let i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            ids.push(checkboxes[i].getAttribute('id_postulant'))
        }
    }
    if (ids.length > 0) {
        window.location.href = "../php/delete_utils.php?nom=" + "&ids=" + JSON.stringify(ids)
    } else {
        alert('Veuillez sélectionner au moins un profil à supprimer.');
    }
}

function isAdmin() {
    let options = document.querySelectorAll('.is-admin')
    for (let i = 0; i < options.length; i++) {
        if (options[i].classList.contains('not-admin')) {
            options[i].classList.remove('not-admin')
            if (options[i].getAttribute('name') == 'addButton') {
                options[i].setAttribute('onclick', "showAdder()")
            }
            if (options[i].getAttribute('name') == 'delButton') {
                options[i].setAttribute('onclick', "deleteSelected()")
            }
            if (options[i].getAttribute('name') == 'offerButton') {
                options[i].setAttribute('onclick', "showOffers()")
            }
        }
    }
}

function isNotAdmin() {
    let options = document.querySelectorAll('.is-admin')
    for (let i = 0; i < options.length; i++) {
        if (!options[i].classList.contains('not-admin')) {
            options[i].classList.add('not-admin')
            if (options[i].getAttribute('name') == 'addButton' && options[i].getAttribute('onclick')) {
                options[i].removeAttribute('onclick', "showAdder()")
            }
            if (options[i].getAttribute('name') == 'delButton' && options[i].getAttribute('onclick')) {
                options[i].removeAttribute('onclick', "deleteSelected()")
            }
            if (options[i].getAttribute('name') == 'offerButton' && options[i].getAttribute('onclick')) {
                options[i].removeAttribute('onclick', "showOffers()")
            }
        }
    }
}

function tryPoste() {
    // let postes = document.querySelector('#verif-poste')
    postes = document.querySelector('#choix-poste').children
    let nom = document.querySelector('#nom-form')
    let prenom = document.querySelector('#prenom-form')
    let telephone = document.querySelector('#telephone-form')
    let courriel = document.querySelector('#courriel-form')
    let cv = document.querySelector('#pdf-file')
    if (postes.length == 0 || nom.value == "" || prenom.value == "" || telephone.value == "" || courriel.value == "" || cv.files.length == 0) {
        alert('Veuillez remplir tous les champs obligatoires')
    }
    else {
        addPostulant()
    }
}

function tryPosteModif() {
    // let postes = document.querySelector('#choix-poste-modif').children
    let nom = document.querySelector('#nom-modif')
    let prenom = document.querySelector('#prenom-modif')
    let telephone = document.querySelector('#telephone-modif')
    let courriel = document.querySelector('#courriel-modif')
    if (nom.value == "" || prenom.value == "" || telephone.value == "" || courriel.value == "") {
        alert('Veuillez remplir tous les champs obligatoires')
    }
    else {
        updatePostulant()
    }
}

function addCats(dest, options) {
    let selectCat = document.querySelector(dest)
    options.forEach(option => {
        let newOption = document.createElement('option')
        newOption.setAttribute('value', option.nom_secteur)
        newOption.innerHTML = option.nom_secteur
        newOption.classList.add("is-option")
        selectCat.appendChild(newOption)
    })
}

function addOffres(dest, options) {
    let selectPosteList = document.querySelector(dest)
    options.forEach(option => {
        let newOption = document.createElement('option')
        newOption.setAttribute('value', option.nom_offre)
        newOption.innerHTML = option.nom_offre
        newOption.classList.add("is-option")
        newOption.classList.add(option.nom_secteur)
        selectPosteList.appendChild(newOption)
    })
    if (dest.includes("ajout")) {
        selectPoste('#select-cat-ajout', '#select-poste-ajout')
    }
    else if (dest.includes("modif")) {
        selectPoste('#select-cat-modif', '#select-poste-modif')
    }
    else if (dest.includes("offerModif")) {
        selectPoste("#select-cat-offerModif", "#select-poste-offerModif")
    }
    else {
        selectPoste('#select-cat', '#select-poste')
    }
}

function checkOffres(secteurId, offre) {
    let secteurSelect = document.querySelector(secteurId)
    let offres = JSON.parse(secteurSelect.getAttribute('offres'))
    let newValue = document.querySelector(offre).value
    let secteur = secteurSelect.value
    if (offres.find(offre => offre.nom_offre.toLowerCase() == newValue.toLowerCase() && offre.nom_secteur == secteur)) {
        document.querySelector('.warning').style.color = 'red'
    }
    else if (document.querySelector('.warning').style.color != 'transparent') {
        document.querySelector('.warning').style.color = 'transparent'
    }
}

// function loadCurrentOffres(offre){
//     let verifPosteModif = document.querySelector('#verif-poste-modif')
//     if (verifPosteModif.value == "") {
//         verifPosteModif.value = "&"
//     }
//     let poste = document.querySelector('#select-poste-modif').value
//     let secteur = document.querySelector('#select-cat-modif').value
//     let filtres = document.querySelector('#choix-poste-modif')
//     for (let i = 0; i < filtres.children.length; i++) {
//         if (filtres.children[i].id === poste + "-modif") {
//             return
//         }
//     }
//     let newPoste = document.createElement('div')
//     newPoste.setAttribute('class', 'poste-div')
//     newPoste.setAttribute('id', poste + "-modif")
//     newPoste.setAttribute('poste', poste)
//     newPoste.setAttribute("secteur", secteur)
//     let posteName = document.createElement('p')
//     posteName.setAttribute('class', 'poste-name')
//     posteName.innerHTML = poste
//     let span = document.createElement('span')
//     span.setAttribute('class', 'sup-poste pointer')
//     span.setAttribute('id', poste + "-modif")
//     span.setAttribute('onclick', "SupPosteModif(event)")
//     let croix = document.createElement('i')
//     croix.setAttribute('class', 'bi-x icon')
//     croix.setAttribute('id', poste + "-modif")
//     span.appendChild(croix)
//     newPoste.append(posteName, span)
//     let row = document.querySelector('#choix-poste-modif')
//     row.appendChild(newPoste)
// }

function updatePostulant() {
    let nom = document.querySelector('#nom-modif').value
    let prenom = document.querySelector('#prenom-modif').value
    let telephone = document.querySelector('#telephone-modif').value
    let courriel = document.querySelector('#courriel-modif').value
    let postes = document.querySelector('#choix-poste-modif').children
    let cv = document.querySelector('#pdf-file-modif').files.length > 0 ? "../pdfs/" + document.querySelector('#pdf-file-modif').files[0].name : ""
    let id = document.querySelector('#modifier-window').getAttribute('id_postulant')
    let metier = []
    for (let i = 0; i < postes.length; i++) {
        metier.push({ "offre": postes[i].getAttribute('poste'), "secteur": postes[i].getAttribute('secteur') })
    }

    if (cv != "") {
        window.location.href = "../php/update_util.php?nom=" + nom + "&prenom=" + prenom + "&telephone=" + telephone + "&courriel=" + courriel + "&cv=" + cv + "&metier=" + JSON.stringify(metier) + "&id=" + id
    }
    else {
        window.location.href = "../php/update_util.php?nom=" + nom + "&prenom=" + prenom + "&telephone=" + telephone + "&courriel=" + courriel + "&id=" + id + "&metier=" + JSON.stringify(metier)
    }
    hideModifier()
    return false
}

function addPostulant() {
    let nom = document.querySelector('#nom-form').value
    let prenom = document.querySelector('#prenom-form').value
    let telephone = document.querySelector('#telephone-form').value
    let liste = document.querySelector('.people-list')
    for (let i = 0; i < liste.children.length; i++) {
        let attributs = liste.children[i].children[1].children[1].children
        if (attributs[0].getAttribute('nom').toLowerCase() == nom.toLowerCase() && attributs[0].getAttribute('prenom').toLowerCase() == prenom.toLowerCase() && attributs[1].innerHTML == telephone) {
            alert('Ce postulant déjà')
            return
        }
    }
    let courriel = document.querySelector('#courriel-form').value
    let postes = document.querySelector('#choix-poste').children
    let cv = "../pdfs/" + document.querySelector('#pdf-file').files[0].name
    let metier = []
    for (let i = 0; i < postes.length; i++) {
        metier.push({ "offre": postes[i].getAttribute('poste'), "secteur": postes[i].getAttribute('secteur') })
    }
    let person = new FormData()
    person.append('nom', nom)
    person.append('prenom', prenom)
    person.append('telephone', telephone)
    person.append('courriel', courriel)
    person.append('cv', cv)
    person.append('metier', JSON.stringify(metier))
    // console.log(person.get('nom'), person.get('prenom'), person.get('telephone'), person.get('courriel'), person.get('cv'), person.get('metier'))

    var xhr = new XMLHttpRequest();
    xhr.open("post", "../php/ajout_util.php");
    xhr.onload = function () {
        // console.log(this.responseText);
        location.reload();
    }
    xhr.send(person);
    // window.location.href = "../php/ajout_util.php?nom=" + nom + "&prenom=" + prenom + "&telephone=" + telephone + "&courriel=" + courriel + "&cv=" + cv + "&metier=" + JSON.stringify(metier)
    hideAdder()
    return false
}

function changeOfferForm(event) {
    let choix = event.target.value
    let adder = document.querySelector('#add-offer')
    let modifier = document.querySelector('#modif-offer')
    let deleter = document.querySelector('#del-offer')
    let formulaire = document.querySelector('#form-offer')
    let offres = JSON.parse(document.querySelector('#offer-gestion').getAttribute('offres'))
    let secteurs = JSON.parse(document.querySelector('#offer-gestion').getAttribute('secteurs'))
    if (choix === "ajouter") {
        if (adder.classList.contains('is-hidden')) {
            adder.classList.remove('is-hidden')
        }
        if (!modifier.classList.contains('is-hidden')) {
            modifier.classList.add('is-hidden')
        }
        if (!deleter.classList.contains('is-hidden')) {
            deleter.classList.add('is-hidden')
        }
        document.querySelector('#nom-offre-add').required = true
        document.querySelector('#nom-offre-modif').required = false
        formulaire.setAttribute('action', '../php/addOffer.php')
    }
    else if (choix === "modifier") {
        if (!adder.classList.contains('is-hidden')) {
            adder.classList.add('is-hidden')
        }
        if (modifier.classList.contains('is-hidden')) {
            modifier.classList.remove('is-hidden')
            addCats('#select-cat-offerModif', secteurs);
            addOffres('#select-poste-offerModif', offres);

        }
        if (!deleter.classList.contains('is-hidden')) {
            deleter.classList.add('is-hidden')
        }
        document.querySelector('#nom-offre-add').required = false
        document.querySelector('#nom-offre-modif').required = true
        formulaire.setAttribute('action', '../php/modifyOffer.php')

    }
    else {

        if (!adder.classList.contains('is-hidden')) {
            adder.classList.add('is-hidden')
        }
        if (!modifier.classList.contains('is-hidden')) {
            modifier.classList.add('is-hidden')
        }
        if (deleter.classList.contains('is-hidden')) {
            deleter.classList.remove('is-hidden')
            addCats('#select-cat-offerDel', secteurs);
            addOffres('#select-poste-offerDel', offres);
        }
        document.querySelector('#nom-offre-add').required = false
        document.querySelector('#nom-offre-modif').required = false
        selectPoste('#select-cat-offerDel', '#select-poste-offerDel')
        formulaire.setAttribute('action', '../php/deleteOffer.php')

    }
}