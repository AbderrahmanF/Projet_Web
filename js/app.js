
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
    var text = e.target.querySelector(".name").innerHTML
    console.log(e.target.innerHTML)
    var pdf = document.querySelector(".pdf-text")
    var view = document.querySelector(".pdf-screen")
    pdf.innerHTML = text
    view.classList.remove('is-hidden')
}

function hideCV() {
    console.log('hop')
    var view = document.querySelector(".pdf-screen")
    view.classList.add('is-hidden')

}

function filterCV() {
    var text = document.querySelector('#searchBar').value.toLowerCase()
    var ul = document.querySelector('.people-list')
    var li_list = ul.children
    for (let i = 0; i < li_list.length; i++) {
        if (!li_list[i].innerHTML.toLowerCase().includes(text)) {
            li_list[i].style.display = 'none'
        }
        else {
            li_list[i].style.display = 'block'
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

function addPoste() {
    let poste = document.querySelector('#select-poste').value
    let filtres = document.querySelector('#filtre-poste')
    for (let i = 0; i < filtres.children.length; i++) {
        if (filtres.children[i].id === poste) {
            return
        }
    }
    let newPoste = document.createElement('div')
    newPoste.setAttribute('class', 'poste-div')
    newPoste.setAttribute('id', poste)
    let posteName = document.createElement('p')
    posteName.setAttribute('class', 'poste-name')
    posteName.innerHTML = poste
    let span = document.createElement('span')
    span.setAttribute('class', 'sup-poste pointer')
    span.setAttribute('id', poste)
    span.addEventListener('click', SupPoste)
    let croix = document.createElement('i')
    croix.setAttribute('class', 'bi-x icon')
    croix.setAttribute('id', poste)
    span.appendChild(croix)
    newPoste.append(posteName, span)
    let row = document.querySelector('#filtre-poste')
    row.appendChild(newPoste)
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
}