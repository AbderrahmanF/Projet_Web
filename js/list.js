// import people from '../js/data.js'
// import { showAdder, showCV } from '../js/app.js'
function getList(L) {
    var main = document.querySelector('.select-flow')
    var div_primary = document.createElement('div')
    div_primary.classList.add('people-list')
    for (var i = 0; i < L.length; i += 1) {
        var div_option = document.createElement('div')
        div_option.setAttribute('class', 'person-option')
        var div_content = document.createElement('div')
        var newImage = document.createElement("img")
        newImage.setAttribute("src", "../icons/profile.png")
        newImage.setAttribute("alt", "profile_picture")
        newImage.setAttribute("class", "profile-picture")
        var checkbox = document.createElement("input")
        checkbox.setAttribute("type", "checkbox")
        checkbox.setAttribute("class", "checkbox")
        checkbox.setAttribute("personName", L[i].prenom + ' ' + L[i].nom)
        checkbox.addEventListener("click", function (event) {
            event.stopPropagation();
        })
        div_option.appendChild(checkbox)
        var modif_icon = document.createElement("i")
        modif_icon.setAttribute("class", "icon bi-pencil-square pointer")
        modif_icon.addEventListener("click", function (event) {
            event.stopPropagation()
            showModifier(event)
        })
        div_option.appendChild(modif_icon)
        var div1 = document.createElement("div")
        var div1_1 = document.createElement("div")
        div1_1.setAttribute('class', 'flex center')
        var div1_2 = document.createElement("div")
        var name1 = document.createElement("p")
        var phone1 = document.createElement("p")
        var mail1 = document.createElement("p")
        name1.innerHTML = L[i].prenom + ' ' + L[i].nom
        name1.setAttribute('class', 'name')
        name1.setAttribute('id', 'nom-prenom')
        name1.setAttribute('nom', L[i].nom)
        name1.setAttribute('prenom', L[i].prenom)
        phone1.innerHTML = L[i].telephone
        phone1.setAttribute('id', 'telephone')
        mail1.innerHTML = L[i].email
        mail1.setAttribute('id', 'email')
        div1_1.appendChild(newImage)
        div1_2.append(name1, phone1, mail1)
        div1.appendChild(div_option)
        div_content.append(div1_1, div1_2)
        div_content.setAttribute('class', 'flex row person-content')
        div1.append(div_content)
        div1.setAttribute('class', 'flex column is-person')
        div1_2.setAttribute('class', 'flex column person-attribut')
        div1.addEventListener('click', showCV)
        div1.setAttribute("metier", "Developpeur")
        div1.setAttribute("cv", L[i].cv)
        div1.setAttribute("metier", JSON.stringify(JSON.parse(L[i].offres)))
        div_primary.appendChild(div1)
    }
    main.appendChild(div_primary)
}
// getList()