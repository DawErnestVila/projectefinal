export const validateNum = (telefon) => {
    const errorTelefonn = document.querySelector("#errorTelefon");

    if (telefon === "") {
        errorTelefonn.innerHTML = "El tèlefon és obligatori";
        const telefon = document.querySelector("#telefon");
        telefon.focus();
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

export const validate = (nom, cognoms, email) => {
    const errorNom = document.querySelector("#errorNom");
    const errorCognoms = document.querySelector("#errorCognoms");
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

    const nomRegex = /^[a-zA-ZÀ-ÿ\s]{1,40}$/;
    if (!nomRegex.test(nom)) {
        if (errorNom) {
            errorNom.innerHTML =
                "El nom no és vàlid, només es permeten lletres i espais, fins a 40 caràcters";
            const nom = document.querySelector("#nom");
            nom.focus();
        }
        return false;
    } else {
        if (errorNom) {
            errorNom.innerHTML = "";
        }
    }

    if (cognoms === "" || cognoms === null || cognoms === undefined) {
        if (errorCognoms) {
            errorCognoms.innerHTML = "Els cognoms són obligatoris";
            const cognoms = document.querySelector("#cognoms");
            cognoms.focus();
        }
        return false;
    } else {
        if (errorCognoms) {
            errorCognoms.innerHTML = "";
        }
    }

    const cognomsRegex = /^[a-zA-ZÀ-ÿ\s]{1,80}$/;
    if (!cognomsRegex.test(cognoms)) {
        if (errorCognoms) {
            errorCognoms.innerHTML =
                "Els cognoms no són vàlids, només es permeten lletres i espais, fins a 80 caràcters";
            const cognoms = document.querySelector("#cognoms");
            cognoms.focus();
        }
        return false;
    } else {
        if (errorCognoms) {
            errorCognoms.innerHTML = "";
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
