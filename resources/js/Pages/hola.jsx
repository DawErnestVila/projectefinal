import React from "react";

const hola = ({ user }) => {
    console.log(user);
    return (
        <div>
            {/* AIXO NO ES MOSTRARIA, NOMÉS ES FARIA PER ASSIGNAR LA RESERVA*/}
            <h1>Vista de Prova</h1>
            <p>Nom: {user.nom}</p>
            <p>Cognoms: {user.cognoms}</p>
            <p>Telèfon: {user.telefon}</p>
            <p>Correu electrònic: {user.email}</p>
            {/* Altres elements que vulguis afegir */}

            <p>AQUI ANIRIA EL FORMULARI PER DEMANAR HORA</p>
        </div>
    );
};

export default hola;
