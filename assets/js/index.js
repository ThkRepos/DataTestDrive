// include custom site scripts

// checking min/max Age of Birth
function formatBirthday() {
    const today = new Date();
    const minAge = 18;
    const maxAge = 80;
    var birthday = document.getElementById('birthday');
    var birthdayField = document.getElementById('sp_birthday');
    var p1 = /^([0-9]{2})$/;
    var p2 = /^([0-9]{2})\.([0-9]{2})$/;
    var p3 = /^([0-9]{2})\.([0-9]{2})\.([0-9]{4})$/;

    if (birthday.value.length > 1 && p1.test(birthday.value)) {
        if (birthday.value > 31) {
            birthdayField.innerText = "Bitte korrigieren Sie den Tag er darf nich größer 31 Tage sein!";
            birthday.classList.add('is-invalid');
        } else {
            birthday.value = birthday.value + ".";
            birthdayField.innerText = "";
            birthday.classList.remove('is-invalid');
        }
    } else if (birthday.value.length > 4 && p2.test(birthday.value)) {
        if (birthday.value.substr(3) > 12) {
            birthdayField.innerText = "Bitte korrigieren Sie den Monat er darf nich größer 12 Monate sein!";
            birthday.classList.add('is-invalid');
        } else {
            birthday.value = birthday.value + ".";
            birthdayField.innerText = "";
            birthday.classList.remove('is-invalid');
        }
    } else if (birthday.value.length == 10 && p3.test(birthday.value)) {
        if ((today.getFullYear() - birthday.value.substr(6)) < minAge) {
            birthdayField.innerText = "Sie sind leider zu jung, bitte korrigieren Sie Ihr Jahr, Sie müssen " + minAge + " Jahre alt sein!";
            birthday.classList.add('is-invalid');
        } else if ((today.getFullYear() - birthday.value.substr(6)) > maxAge) {
            birthdayField.innerText = "Sie sind leider zu alt, für einen Antrag vielen Dank für das Interesse, Sie dürfen nur max. " + maxAge + " Jahre alt sein!";
            birthday.classList.add('is-invalid');
        } else {
            birthdayField.innerText = "";
            birthday.classList.remove('is-invalid');
        }
    } else {
        birthdayField.innerText = "Bitte korrigieren Sie das Datum!";
    }
}

// check input fields of type is number
function checkTextField(field) {
    var checkField = document.getElementById(field);
    var outputField = document.getElementById('sp_' + field);
    var p1 = /^([a-zA-Z]{0,50})$/;

    if (p1.test(checkField.value) == false) {
        outputField.innerText = "Bitte korrigieren Sie Ihre Eingabe es sind nur Buchstaben erlaubt!";
        checkField.classList.add('is-invalid');
    } else {
        outputField.innerText = "";
        checkField.classList.remove('is-invalid');
    }
}

// check input fields of type is number
function checkNumField(field) {
    var checkField = document.getElementById(field);
    var outputField = document.getElementById('sp_' + field);
    var p1 = /^([0-9]{0,20})$/;

    if (p1.test(checkField.value) == false) {
        outputField.innerText = "Bitte korrigieren Sie Ihre Eingabe es sind nur Zahlen erlaubt!";
        checkField.classList.add('is-invalid');
    } else {
        outputField.innerText = "";
        checkField.classList.remove('is-invalid');
    }
}

// check Email with min Regex
function checkEmail(field) {
    var checkField = document.getElementById(field);
    var outputField = document.getElementById('sp_' + field);
    const p1 = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]{2,3})$/

    if (p1.test(checkField.value) == false) {
        outputField.innerText = "Bitte korrigieren Sie Ihre E-Mail Eingabe!";
        checkField.classList.add('is-invalid');
    } else {
        outputField.innerText = "";
        checkField.classList.remove('is-invalid');
    }
}


