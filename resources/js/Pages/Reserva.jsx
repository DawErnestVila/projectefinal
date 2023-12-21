import React, { useState, useEffect, useRef } from "react";
import BackButton from "./BackButton";
import MyNewDatePicker from "./MyNewDatePicker";
import { getTractaments, getHoraris } from "../apiReserva";

const Reserva = ({ user }) => {
    const [selectedTractament, setSelectedTractament] = useState(null);
    const [selectedDate, setSelectedDate] = useState(null); // Nou estat per la data seleccionada
    const [tractaments, setTractaments] = useState([]);
    const [horaris, setHoraris] = useState([]);
    const [disabledDates, setDisabledDates] = useState([]); // Nou estat per les dates deshabilitades
    const datePickerRef = useRef(null);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await getTractaments();
                setTractaments(response.data);
                const horarisResp = await getHoraris();
                setHoraris(horarisResp.data);
                // Afegeix la lògica per obtenir les dates deshabilitades
            } catch (error) {
                console.error("Error fetching treatments:", error);
            }
        };

        fetchData();
    }, []);

    const isSalonOpenOnDay = (dayOfWeek) => {
        // Implementa la lògica per comprovar si la perruqueria està oberta en el dia proporcionat.
    };

    // Afegeix una funció per obtenir les hores disponibles en funció del dia i tractament seleccionat
    const getAvailableHours = (selectedDay) => {
        // Fes una crida a l'API per obtenir les hores disponibles pel dia i tractament seleccionat.
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        console.log(selectedDate);
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
                <form onSubmit={handleSubmit}>
                    <div className="flex flex-col mb-4">
                        <label htmlFor="nom" className="mb-2 font-semibold">
                            Nom
                        </label>
                        <input
                            type="text"
                            defaultValue={user.nom}
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
                                <MyNewDatePicker
                                    disabledDatesProps={[new Date(2024, 0, 4)]}
                                    setSelectedDate={setSelectedDate}
                                />
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
