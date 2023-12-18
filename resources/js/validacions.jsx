export const validateNum = (telefon) => {
    const errorTelefonn = document.querySelector("#errorTelefon");

    console.log("Entra a la funció validate");

    if (telefon === "") {
        errorTelefonn.innerHTML = "El tèlefon és obligatori";
        const telefon = document.querySelector("#telefon");
        telefon.focus();
        telefon.classList.add("border-red-500");
        return false;
    } else {
        errorTelefonn.innerHTML = "";
    }

    if (!/^\d+$/.test(telefon)) {
        errorTelefonn.innerHTML = "El tèlefon ha de ser un número";
        const telefon = document.querySelector("#telefon");
        telefon.focus();
        return false;
    } else {
        errorTelefonn.innerHTML = "";
    }

    if (telefon.length !== 9) {
        errorTelefonn.innerHTML = "El telèfon ha de tenir 9 digits";
        const telefon = document.querySelector("#telefon");
        telefon.focus();
        return false;
    } else {
        errorTelefonn.innerHTML = "";
    }

    return true;
};

export const validate = (nom, email) => {
    const errorNom = document.querySelector("#errorNom");
    const errorEmail = document.querySelector("#errorEmail");

    console.log(email);
    console.log(nom);

    if (nom === "" || nom === null || nom === undefined) {
        if (errorNom) {
            errorNom.innerHTML = "El nom és obligatori";
            const nom = document.querySelector("#nom");
            nom.focus();
        }
        return false;
    } else {
        if (errorNom) {
            errorNom.innerHTML = "";
        }
    }

    if (email === "" || email === null || email === undefined) {
        if (errorEmail) {
            errorEmail.innerHTML = "L'email és obligatori";
            const email = document.querySelector("#email");
            email.focus();
        }
        return false;
    } else {
        if (errorEmail) {
            errorEmail.innerHTML = "";
        }
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        if (errorEmail) {
            errorEmail.innerHTML = "L'email no és vàlid";
            const email = document.querySelector("#email");
            email.focus();
        }
        return false;
    } else {
        if (errorEmail) {
            errorEmail.innerHTML = "";
        }
    }

    return true;
};
