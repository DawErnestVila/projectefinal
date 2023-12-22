//? Validacions a User.jsx del telèfon
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

//? Validacions a User.jsx dels camps de text
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

//? Validacions a Reserva.jsx dels camps del dia i hora
export const validateDiaHora = ({ dia, hora, tractament_id, usuari_id }) => {
    const errorDia = document.querySelector("#errorDia");
    const errorHora = document.querySelector("#errorHora");
    const errorTractament = document.querySelector("#errorTractament");

    if (dia === "" || dia === null || dia === undefined) {
        if (errorDia) {
            errorDia.innerHTML = "El dia és obligatori";
            const dia = document.querySelector("#dia");
            dia.focus();
        }
        return false;
    } else {
        if (errorDia) {
            errorDia.innerHTML = "";
        }
    }

    if (hora === "" || hora === null || hora === undefined) {
        if (errorHora) {
            errorHora.innerHTML = "L'hora és obligatòria";
            const hora = document.querySelector("#hora");
            hora.focus();
        }
        return false;
    } else {
        if (errorHora) {
            errorHora.innerHTML = "";
        }
    }

    if (
        tractament_id === "" ||
        tractament_id === null ||
        tractament_id === undefined
    ) {
        if (errorTractament) {
            errorTractament.innerHTML = "El tractament és obligatori";
            const tractament_id = document.querySelector("#tractament_id");
            tractament_id.focus();
        }
        return false;
    } else {
        if (errorTractament) {
            errorTractament.innerHTML = "";
        }
    }

    return true;
};
