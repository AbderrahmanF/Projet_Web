
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
    console.log(localStorage.getItem('gestionnaire_theme'))
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

function addPoste(e) {
    // console.log()
    parent = e.target.parentNode.parentNode
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

function showAdder() {
    let doc = document.querySelector('#main')
    let div = document.querySelector('#adder-window')
    if (div) {
        div.style.display = 'flex'
    }
    else {
        fetch('../html/ajouterUtilisateur.html')
            .then(response => response.text())
            .then(html => {
                doc.insertAdjacentHTML('beforeend', html);
            })
            .catch(error => {
                console.error('Une erreur s\'est produite : ', error);
            });
    }
}

function hideAdder() {
    let div = document.querySelector('#adder-window')
    div.style.display = 'none'
}

function selectPoste() {
    let select = document.querySelector('#select-cat')
    let value = select.value
    let select_poste = document.querySelector('#select-poste')
    let options = select_poste.children
    let changed = false
    for (let i = 0; i < options.length; i++) {
        if (!(options[i].classList[1] == value)) {
            options[i].style.display = 'none'
        }
        else {
            if (!changed) {
                console.log('pf')
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
        checkboxes[i].checked = checked
    }
}
function deleteSelected() {
    let checkboxes = document.querySelectorAll('.checkbox')
    for (let i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checkboxes[i].parentNode.parentNode.remove()
        }
    }
}