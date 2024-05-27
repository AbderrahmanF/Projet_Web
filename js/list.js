//  import people from '../js/data.js'
// // import { showAdder, showCV } from '../js/app.js'
function getList() {
    const people = []
    var main = document.querySelector('.select-flow')
    var div_primary = document.createElement('div')
    div_primary.classList.add('people-list')
    for (var i = 0; i < people.length; i += 1) {
        var div_option = document.createElement('div')
        div_option.setAttribute('class', 'person-option')
        var div_content = document.createElement('div')
        var newImage = document.createElement("img")
        newImage.setAttribute("src", "../icons/profile.png")
        newImage.setAttribute("alt", "profile_picture")
        var checkbox = document.createElement("input")
        checkbox.setAttribute("type", "checkbox")
        checkbox.setAttribute("class", "checkbox")
        div_option.appendChild(checkbox)
        var modif_icon = document.createElement("i")
        modif_icon.setAttribute("class", "icon bi-pencil-square pointer")
        modif_icon.addEventListener("click", function (event) {
            showAdder()
            event.stopPropagation()
        })
        div_option.appendChild(modif_icon)
        var div1 = document.createElement("div")
        var div1_1 = document.createElement("div")
        div1_1.setAttribute('class', 'flex')
        var div1_2 = document.createElement("div")
        var name1 = document.createElement("p")
        var phone1 = document.createElement("p")
        var mail1 = document.createElement("p")
        name1.innerHTML = people[i]
        name1.setAttribute('class', 'name')
        phone1.innerHTML = 'numéro de téléphone'
        mail1.innerHTML = 'e-mail'
        div1_1.appendChild(newImage)
        div1_2.append(name1, phone1, mail1)
        div1.appendChild(div_option)
        div_content.append(div1_1, div1_2)
        div_content.setAttribute('class', 'flex row person-content')
        div1.append(div_content)
        div1.setAttribute('class', 'flex column is-person')
        div1_2.setAttribute('class', 'flex column person-attribut')
        div1.addEventListener('click', showCV)
        div1.setAttribute("metier", "dev")
        div_primary.appendChild(div1)
    }
    main.appendChild(div_primary)
}
getList()