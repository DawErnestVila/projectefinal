import React, { useState, useEffect, useRef } from "react";
import BackButton from "./BackButton";
import MyNewDatePicker from "./MyNewDatePicker";
import {
    getTractaments,
    getHoraris,
    getDiesDeshabilitats,
    getHoresDisponibles,
    getReservesDia,
} from "../apiReserva";

const Reserva = ({ user }) => {
    const [selectedTractament, setSelectedTractament] = useState(null);
    const [selectedDate, setSelectedDate] = useState(null); // Nou estat per la data seleccionada
    const [tractaments, setTractaments] = useState([]);
    const [horaris, setHoraris] = useState([]);
    const [disabledDates, setDisabledDates] = useState([]); // Nou estat per les dates deshabilitades
    const [availableHours, setAvailableHours] = useState([]);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await getTractaments();
                setTractaments(response.data);
                const horarisResp = await getHoraris();
                setHoraris(horarisResp.data);
                const disabledDatesResp = await getDiesDeshabilitats();
                let disabledDatesAux = [];
                disabledDatesResp.data.forEach((date) => {
                    disabledDatesAux.push(
                        new Date(date.data).toISOString().split("T")[0]
                    );
                });
                setDisabledDates(disabledDatesAux);
            } catch (error) {
                console.error("Error fetching treatments:", error);
            }
        };

        fetchData();
    }, []);

    useEffect(() => {
        // Assegura't que la funció només s'executi quan selectedDate és diferent de null
        if (selectedDate) {
            // Aquí pots cridar la funció que necessites
            getAvailableHours(selectedTractament);
        }
    }, [selectedDate]);

    const getAvailableHoursWithoutReservations = (startHour, endHour) => {
        const availableHours = [];

        for (let hour = startHour; hour <= endHour; hour++) {
            availableHours.push(`${hour}:00`);
            availableHours.push(`${hour}:15`);
            availableHours.push(`${hour}:30`);
            availableHours.push(`${hour}:45`);
        }

        // console.log(availableHours);
        return availableHours;
    };

    // Afegeix una funció per obtenir les hores disponibles en funció del dia i tractament seleccionat
    const getAvailableHours = async (selectedTreatment) => {
        try {
            const reservedHoursData = await getHoresDisponibles({
                dia: selectedDate,
            });

            let data = reservedHoursData.data;
            data = data[0];

            // Obtenir les hores disponibles sense tenir en compte les reserves
            const availableHoursWithoutReservations =
                getAvailableHoursWithoutReservations(
                    extractHour(data.hora_obertura),
                    extractHour(data.hora_tancament)
                );

            console.log(availableHoursWithoutReservations);

            function extractHour(timeString) {
                const [hour] = timeString.split(":");
                return hour;
            }

            const reservesForDay = await getReservesForDay();
            // console.log(reservesForDay);

            // console.log(reservesForDay);

            // Eliminar les hores ja reservades
            const availableHours = availableHoursWithoutReservations.map(
                (hour) => {
                    const isReserved = reservesForDay.some(
                        (reserve) =>
                            reserve.horaInicial <= hour &&
                            reserve.horaFinal >= hour
                    );

                    return isReserved ? null : hour;
                }
            );

            // Actualitzar l'estat amb les hores disponibles
            console.log(availableHours);

            // // Actualitzar l'estat amb les hores disponibles
            // setAvailableHours(availableHours);
        } catch (error) {
            console.error("Error fetching available hours:", error);
        }
    };

    const getReservesForDay = async () => {
        try {
            const reservesResponse = await getReservesDia({
                dia: selectedDate,
            });

            const horesFinalsTractament = reservesResponse.data.map(
                (reserva) => {
                    const [hora, minuts, segons] = reserva.hora.split(":");
                    const horaReserva = `${hora}:${minuts}`;
                    const idTractament = reserva.tractament_id;
                    const duradaTractament = tractaments.find(
                        (tractament) => tractament.id === idTractament
                    ).durada;
                    const horaFinalTractament = sumarHores(
                        horaReserva,
                        duradaTractament
                    );

                    // Construeix l'objecte amb l'hora inicial i final del tractament
                    return {
                        horaInicial: horaReserva,
                        horaFinal: horaFinalTractament,
                    };
                }
            );

            function sumarHores(hora1, hora2) {
                // Parseja les hores en minuts
                const [hores1, minuts1] = hora1.split(":").map(Number);
                const [hores2, minuts2] = hora2.split(":").map(Number);

                // Calcula la suma en minuts
                let sumaTotalEnMinuts =
                    hores1 * 60 + minuts1 + (hores2 * 60 + minuts2);

                // Obté les noves hores i minuts
                const horesResultat = Math.floor(sumaTotalEnMinuts / 60);
                const minutsResultat = sumaTotalEnMinuts % 60;

                // Formata les noves hores i minuts com a cadena de text
                const resultatFinal = `${String(horesResultat).padStart(
                    2,
                    "0"
                )}:${String(minutsResultat).padStart(2, "0")}`;

                return resultatFinal;
            }

            return horesFinalsTractament;
        } catch (error) {
            console.error("Error fetching reserves:", error);
            return [];
        }
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        // console.log(selectedDate);
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
                                    disabledDatesProps={disabledDates}
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
