import React, { useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import { validateNum, validate } from "../validacions";
import { checkUser, store } from "../apiClient";

const Usuari = () => {
    const [phoneNumber, setPhoneNumber] = useState("");
    const [userData, setUserData] = useState({
        name: "",
        cognoms: "",
        email: "",
        // Altres propietats de l'usuari
    });
    const [showUserDataForm, setShowUserDataForm] = useState(false);
    const [isUserExist, setIsUserExist] = useState(false);

    const handleCancel = () => {
        setShowUserDataForm(false);
        setUserData({
            name: "",
            cognoms: "",
            email: "",
        });
        setPhoneNumber("");
        const errorTelefon = document.getElementById("errorTelefon");
        errorTelefon.innerHTML = "";
        const errorNom = document.getElementById("errorNom");
        errorNom.innerHTML = "";
        const errorCognoms = document.getElementById("errorCognoms");
        errorCognoms.innerHTML = "";
        const errorEmail = document.getElementById("errorEmail");
        errorEmail.innerHTML = "";
    };

    const handleFormSubmit = async (e) => {
        e.preventDefault();

        const validatNum = validateNum(phoneNumber);
        // Falta verificar si l'usuari ja existeix

        if (validatNum) {
            let userExist = false;
            const response = await checkUser({ telefon: phoneNumber });
            // console.log(response);
            userExist = response.data;

            if (userExist) {
                //Si l'usuari ja existeix, el redirigeix a la pàgina de reserva
                await Inertia.post("/demanar-hora", { telefon: phoneNumber });
            } else {
                setShowUserDataForm(true);
                const validat = validate(
                    userData.name,
                    userData.cognoms,
                    userData.email
                );

                if (validat) {
                    // Realiza la solicitud POST aquí después de validar el nombre y el correo electrónico
                    const response = await store({
                        nom: userData.name,
                        cognoms: userData.cognoms,
                        correu: userData.email,
                        telefon: phoneNumber,
                    });
                    console.log(response);
                    if (response.status === "success") {
                        await Inertia.post("/demanar-hora", {
                            telefon: phoneNumber,
                        });
                    } else {
                        console.log("Error al crear l'usuari");
                    }
                } else {
                    setIsUserExist(false);
                }
            }
        }
    };

    return (
        <div className="p-8 bg-[#161A30] rounded-xl shadow-md text-gray-300">
            <h1 className="text-2xl font-semibold mb-4">
                Introdueix les dades
            </h1>
            <form
                onSubmit={handleFormSubmit}
                className="max-w-md mx-auto mt-8 p-8 mb-4"
            >
                <label className="block mb-2">
                    Numero de telèfon:
                    <input
                        type="tel"
                        name="telefon"
                        placeholder="123456789"
                        value={phoneNumber}
                        id="telefon"
                        onChange={(e) => setPhoneNumber(e.target.value)}
                        className="mt-2 p-2 w-full rounded bg-[#292f55] text focus:border-2 border-[#B6BBC4]"
                    />
                </label>
                <div
                    id="errorTelefon"
                    className="text-xs text-red-500 mt-0 mb-2"
                    role="alert"
                ></div>

                {showUserDataForm && (
                    <>
                        <label className="block mb-4">
                            Nom:
                            <input
                                type="text"
                                name="nom"
                                id="nom"
                                placeholder="Nom"
                                value={userData.name}
                                onChange={(e) =>
                                    setUserData((prevUserData) => ({
                                        ...prevUserData,
                                        name: e.target.value,
                                    }))
                                }
                                className="mt-2 p-2 w-full rounded bg-[#292f55] text focus:border-2 border-[#B6BBC4]"
                            />
                        </label>
                        <div
                            id="errorNom"
                            className="text-xs text-red-500 mt-0 mb-2"
                            role="alert"
                        ></div>
                        <label className="block mb-4">
                            Cognoms:
                            <input
                                type="text"
                                name="cognoms"
                                id="cognoms"
                                placeholder="Cognoms"
                                value={userData.cognoms}
                                onChange={(e) =>
                                    setUserData((prevUserData) => ({
                                        ...prevUserData,
                                        cognoms: e.target.value,
                                    }))
                                }
                                className="mt-2 p-2 w-full rounded bg-[#292f55] text focus:border-2 border-[#B6BBC4]"
                            />
                        </label>
                        <div
                            id="errorCognoms"
                            className="text-xs text-red-500 mt-0 mb-2"
                            role="alert"
                        ></div>
                        <label className="block mb-4">
                            Email:
                            <input
                                type="email"
                                name="email"
                                id="email"
                                placeholder="Email"
                                value={userData.email}
                                onChange={(e) =>
                                    setUserData((prevUserData) => ({
                                        ...prevUserData,
                                        email: e.target.value,
                                    }))
                                }
                                className="mt-2 p-2 w-full rounded bg-[#292f55] text focus:border-2 border-[#B6BBC4]"
                            />
                        </label>
                        <div
                            id="errorEmail"
                            className="text-xs text-red-500 mt-0 mb-2"
                            role="alert"
                        ></div>
                        {/* Otros campos del formulario del usuario */}
                    </>
                )}
                <button
                    onClick={handleCancel}
                    type="reset"
                    className="bg-[#F0ECE5] hover:bg-[#87858d] text-[#161A30] font-semibold py-2 px-4 border border-F0ECE5 hover:border-transparent rounded transition-colors duration-300 mr-4"
                >
                    Cancel·la
                </button>
                <button
                    type="submit"
                    className="bg-[#F0ECE5] hover:bg-[#87858d] text-[#161A30] font-semibold py-2 px-4 border border-F0ECE5 hover:border-transparent rounded transition-colors duration-300 mt-2"
                >
                    Envia
                </button>
            </form>
        </div>
    );
};

export default Usuari;
