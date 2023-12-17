export const validateNum = (telefon) => {
    const errorTelefonn = document.querySelector("#errorTelefon");

    console.log("Entra a la funció validate");

    if (telefon === "") {
        errorTelefonn.innerHTML = "El telefon és obligatori";
        return false;
    } else {
        errorTelefonn.innerHTML = "";
    }

    if (!/^\d+$/.test(telefon)) {
        errorTelefonn.innerHTML = "El telefon ha de ser un número";
        return false;
    } else {
        errorTelefonn.innerHTML = "";
    }

    if (telefon.length !== 9) {
        errorTelefonn.innerHTML = "El telefon ha de tenir 9 digits";
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
        }
        return false;
    } else {
        if (errorNom) {
            errorNom.innerHTML = "";
        }
    }

    if (email === "" || email === null || email === undefined) {
        if (errorEmail) {
            errorEmail.innerHTML = "El email és obligatori";
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
            errorEmail.innerHTML = "El email no és vàlid";
        }
        return false;
    } else {
        if (errorEmail) {
            errorEmail.innerHTML = "";
        }
    }

    return true;
};
