import { React, useState, useEffect } from "react";
import BackButton from "./BackButton";
import { getTractaments } from "../apiTractaments";

const Reserva = ({ user }) => {
    const [selectedTractament, setSelectedTractament] = useState(null);
    const [tractaments, setTractaments] = useState([]);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await getTractaments();
                setTractaments(response.data);
            } catch (error) {
                console.error("Error fetching treatments:", error);
            }
        };

        fetchData();
    }, []);

    const handleSubmit = (e) => {
        e.preventDefault();
        // Implement reservation logic here
    };

    return (
        <div>
            <div className="self-start mb-3">
                <BackButton />
            </div>
            <div className="p-8 bg-[#161A30] rounded-xl shadow-md text-gray-300">
                <h1 className="text-2xl font-black mb-8">
                    Selecciona un tractament i la data desitjada
                </h1>
                {/* Sortirà un camp amb el nom, però no es podrà modificar,
                primer s'haurà de mostrar els diferents tractaments, els altres camps estaran amagats fins que es seleccioni un tractament i es trobis dies i hores lliures, després
                depenent de les hores disponibles, es mostrarà els dies
                disponibles i les hores disponibles, i finalment es mostrarà un
                botó per confirmar la reserva */}
                <form onSubmit={handleSubmit}>
                    <div className="flex flex-col mb-4">
                        <label htmlFor="nom" className="mb-2 font-semibold">
                            Nom
                        </label>
                        <input
                            type="text"
                            value={user.nom}
                            disabled
                            className="p-2 rounded-md bg-[#151520] text-gray-300 disabled:opacity-50"
                        />
                    </div>
                    <div className="flex flex-col mb-4">
                        <label
                            htmlFor="tractament"
                            className="mb-2 font-semibold"
                        >
                            Tractament
                        </label>
                        <select
                            name="tractament"
                            id="tractament"
                            className="p-2 rounded-md bg-[#31304D] text-gray-300"
                            onChange={(e) =>
                                setSelectedTractament(e.target.value)
                            }
                        >
                            <option value="" disabled selected>
                                Selecciona un tractament
                            </option>
                            {tractaments.map((tractament) => (
                                <option
                                    key={tractament.id}
                                    value={tractament.id}
                                >
                                    {tractament.nom}
                                </option>
                            ))}
                        </select>
                    </div>
                    {selectedTractament && (
                        <>
                            <div className="flex flex-col mb-4">
                                <label
                                    htmlFor="dia"
                                    className="mb-2 font-semibold"
                                >
                                    Dia
                                </label>
                                <select
                                    name="dia"
                                    id="dia"
                                    className="p-2 rounded-md bg-[#31304D] text-gray-300"
                                >
                                    <option value="1">Dilluns 1</option>
                                    <option value="2">Dimarts 2</option>
                                    <option value="3">Dimecres 3</option>
                                </select>
                            </div>
                            <div className="flex flex-col mb-4">
                                <label
                                    htmlFor="hora"
                                    className="mb-2 font-semibold"
                                >
                                    Hora
                                </label>
                                <select
                                    name="hora"
                                    id="hora"
                                    className="p-2 rounded-md bg-[#31304D] text-gray-300"
                                >
                                    <option value="1">10:00</option>
                                    <option value="2">11:00</option>
                                    <option value="3">12:00</option>
                                </select>
                            </div>
                            <button
                                type="submit"
                                className="bg-[#161A30] border-gray-300 border-2 text-gray-300 p-2 rounded-md font-semibold hover:bg-[#B6BBC4] hover:text-[#161A30] transition-colors duration-500"
                            >
                                Confirmar reserva
                            </button>
                        </>
                    )}
                </form>
            </div>
        </div>
    );
};

export default Reserva;
