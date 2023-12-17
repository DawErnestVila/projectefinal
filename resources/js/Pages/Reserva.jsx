import React from "react";
import BackButton from "./BackButton";

const Reserva = ({ user }) => {
    console.log(user);
    return (
        <div>
            <div className="self-start mb-3">
                <BackButton />
            </div>
            <div className="p-8 bg-[#161A30] rounded-xl shadow-md text-gray-300">
                {/* AIXO NO ES MOSTRARIA, NOMÉS ES FARIA PER ASSIGNAR LA RESERVA*/}
                <h1>Vista de Prova</h1>
                <p>Nom: {user.nom}</p>
                <p>Cognoms: {user.cognoms}</p>
                <p>
                    <b>Telèfon: {user.telefon}</b>
                </p>
                <p>Correu electrònic: {user.email}</p>
                {/* Altres elements que vulguis afegir */}

                <p>AQUI ANIRIA EL FORMULARI PER DEMANAR HORA</p>
            </div>
        </div>
    );
};

export default Reserva;
