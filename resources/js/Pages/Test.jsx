import React, { useState } from "react";
import { Inertia } from "@inertiajs/inertia";

const Test = () => {
    const [phoneNumber, setPhoneNumber] = useState("");
    const [userData, setUserData] = useState({
        name: "",
        email: "",
        // Altres propietats de l'usuari
    });
    const [showUserDataForm, setShowUserDataForm] = useState(false);
    const [isUserExist, setIsUserExist] = useState(false);

    const handleFormSubmit = async (e) => {
        e.preventDefault();

        if (!phoneNumber) {
            alert("Si us plau, introdueix un número de telèfon.");
            return;
        }
        // s'hauria de fer un fetch de post que hi hagi una funció que comprovi si hi ha l'usuari amb el numero de telefon
        // a la base de dades per comprovar si l'usuari ja existeix
        // si l'usuari ja existeix a la variable isUserExist s'assigna true

        if (isUserExist) {
            console.log("isUserExist = true");
            // Si l'usuari ja existeix, redirigeix a la vista de sol·licitud d'hora amb el número de telèfon
            Inertia.post("/demanar-hora", { telefon: phoneNumber });
        } else {
            console.log("isUserExist = false");
            setIsUserExist(true);
            setShowUserDataForm(true);
        }
    };

    return (
        <div className="p-8 bg-[#161A30] rounded-xl shadow-md text-gray-300">
            <h1 className="text-2xl font-semibold mb-4">
                Introdueix les dades
            </h1>
            <form
                onSubmit={handleFormSubmit}
                className="max-w-md mx-auto mt-8 p-8"
            >
                <label className="block mb-4">
                    Numero de telèfon:
                    <input
                        type="text"
                        name="telefon"
                        value={phoneNumber}
                        onChange={(e) => setPhoneNumber(e.target.value)}
                        className="mt-2 p-2 w-full rounded bg-[#292f55] text focus:border-2 border-[#B6BBC4]"
                    />
                </label>

                {showUserDataForm && (
                    <>
                        <label className="block mb-4">
                            Nom:
                            <input
                                type="text"
                                name="nom"
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
                        <label className="block mb-4">
                            Email:
                            <input
                                type="email"
                                name="email"
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
                        {/* Otros campos del formulario del usuario */}
                    </>
                )}

                <button
                    type="submit"
                    className="bg-[#F0ECE5] hover:bg-[#87858d] text-[#161A30] font-semibold py-2 px-4 border border-F0ECE5 hover:border-transparent rounded"
                >
                    Envia
                </button>
            </form>
        </div>
    );
};

export default Test;
