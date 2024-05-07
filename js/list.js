import people from '../js/data.js'
function getList() {
    var main = document.querySelector('.select-flow')
    var div_primary = document.createElement('div')
    div_primary.classList.add('people-list')
    for (var i = 0; i < people.length; i += 1) {
        var newImage = document.createElement("img")
        newImage.setAttribute("src", "../icons/profile.png")
        newImage.setAttribute("alt", "profile_picture")
        var checkbox = document.createElement("input")
        checkbox.setAttribute("type", "checkbox")
        checkbox.setAttribute("class", "checkbox")
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
        div1_1.appendChild(checkbox)
        div1_1.appendChild(newImage)
        div1_2.append(name1, phone1, mail1)
        div1.append(div1_1, div1_2)
        div1.setAttribute('class', 'flex row is-person')
        div1_2.setAttribute('class', 'flex column person-attribut')
        div1.addEventListener('click', showCV)
        div_primary.appendChild(div1)
    }
    main.appendChild(div_primary)
}
getList()