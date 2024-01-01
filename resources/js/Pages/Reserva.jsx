import React, { useState, useEffect, useRef } from "react";
import BackButton from "./BackButton";
import MyNewDatePicker from "./MyNewDatePicker";
import { Inertia } from "@inertiajs/inertia";
import { validateDiaHora } from "../validacions";
import {
    getTractaments,
    getHoraris,
    getDiesDeshabilitats,
    getHoresDisponibles,
    getReservesDia,
    storeReserva,
} from "../apiReserva";
const Reserva = ({ user }) => {
    const [selectedTractament, setSelectedTractament] = useState(null);
    const [selectedDate, setSelectedDate] = useState(null); // Nou estat per la data seleccionada
    const [tractaments, setTractaments] = useState([]);
    const [horaris, setHoraris] = useState([]);
    const [disabledDates, setDisabledDates] = useState([]); // Nou estat per les dates deshabilitades
    const [availableHours, setAvailableHours] = useState([]);
    const [openDays, setOpenDays] = useState([]);
    const [selectedHour, setSelectedHour] = useState(null);
    const [missatge, setMissatge] = useState(null);

    // Funció per obtenir els dies oberts per reserves mitjançant una crida a l'API
    const getOpenDays = async () => {
        try {
            const response = await getHoraris();
            const horaris = response.data;
            // Aconseguir els dies oberts a partir de la resposta de l'API
            const openDays = horaris.map((horari) => {
                return horari.dia;
            });
            setOpenDays(openDays);
        } catch (error) {
            console.error("Error fetching open days:", error);
        }
    };

    // useEffect que s'executa al carregar la pàgina per obtenir els tractaments, horaris i dates deshabilitades
    useEffect(() => {
        getOpenDays();
        const fetchData = async () => {
            try {
                const response = await getTractaments();
                const tractamentsActius = response.data.filter(
                    (tractament) => tractament.actiu
                );
                setTractaments(tractamentsActius);
                const horarisResp = await getHoraris();
                setHoraris(horarisResp.data);
                const disabledDatesResp = await getDiesDeshabilitats();
                // Converteix les dates deshabilitades al format necessari i les emmagatzema a l'array
                const disabledDatesAux = [];
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

    // useEffect que s'executa quan canvia la data o el tractament seleccionat per obtenir les hores disponibles
    useEffect(() => {
        if (selectedDate && selectedTractament) {
            // Funcio per aconseguir les hores disponibles
            getAvailableHours();
        }
    }, [selectedDate, selectedTractament]);

    // Funció per obtenir les hores disponibles sense tenir en compte les reserves
    const getAvailableHoursWithoutReservations = (startHour, endHour) => {
        const availableHours = [];

        for (let hour = startHour; hour < endHour; hour++) {
            availableHours.push(`${hour}:00`);
            availableHours.push(`${hour}:15`);
            availableHours.push(`${hour}:30`);
            availableHours.push(`${hour}:45`);
        }

        return availableHours;
    };

    // Funció per obtenir les hores disponibles en funció del dia i tractament seleccionat
    const getAvailableHours = async () => {
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

            function extractHour(timeString) {
                const [hour] = timeString.split(":");
                return hour;
            }

            const reservesForDay = await getReservesForDay();

            // Eliminar les hores ja reservades
            const availableHours = availableHoursWithoutReservations.map(
                (hour) => {
                    const isReserved = reservesForDay.some(
                        (reserve) =>
                            reserve.horaInicial <= hour &&
                            reserve.horaFinal > hour
                    );

                    return isReserved ? null : hour;
                }
            );

            // Obtenir el tractament seleccionat
            const tractament = tractaments.find(
                (tractament) => tractament.id == selectedTractament
            );
            // Actualitzar l'estat amb les hores disponibles
            setAvailableHours(
                obtenirHoresDisponibles(availableHours, tractament.durada)
            );
        } catch (error) {
            console.error("Error fetching available hours:", error);
        }
    };

    // Funció per obtenir les reserves per al dia seleccionat mitjançant una crida a l'API
    const getReservesForDay = async () => {
        try {
            const reservesResponse = await getReservesDia({
                dia: selectedDate,
            });

            // Processa les reserves per obtenir les hores finals dels tractaments
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

            return horesFinalsTractament;
        } catch (error) {
            console.error("Error fetching reserves:", error);
            return [];
        }
    };

    // Funció per sumar hores a una hora determinada
    function sumarHores(hora1, hora2) {
        // Parseja les hores en minuts
        const [hores1, minuts1] = hora1.split(":").map(Number);
        const [hores2, minuts2] = hora2.split(":").map(Number);

        // Calcula la suma en minuts
        let sumaTotalEnMinuts = hores1 * 60 + minuts1 + (hores2 * 60 + minuts2);

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

    // Funció per convertir el format "hh:mm:ss" a minuts
    function convertirHoraAMinuts(hora) {
        const temps = hora.split(":");
        return parseInt(temps[0]) * 60 + parseInt(temps[1]);
    }

    // Funció per obtenir les hores disponibles considerant la durada del tractament
    function obtenirHoresDisponibles(hores, duradaTractament) {
        // console.log(duradaTractament);
        const horesDisponibles = [];

        // Converteix la durada del tractament a minuts
        const duradaMinuts = convertirHoraAMinuts(duradaTractament);

        // Calcula el nombre d'intervals necessaris
        const intervalsNecessaris = duradaMinuts / 15;

        // Itera sobre les hores disponibles
        for (let i = 0; i < hores.length; i++) {
            // Verifica si l'hora actual no és nula (ja que algunes hores poden ser nules si ja estan reservades)
            if (hores[i] !== null) {
                // Verifica si hi ha prou espai a l'array per als intervals necessaris
                if (i + intervalsNecessaris <= hores.length) {
                    // Verifica la disponibilitat del tractament
                    let tractamentEncaixa = true;
                    // Itera pels intervals necessaris del tractament
                    for (let j = 0; j < intervalsNecessaris; j++) {
                        if (hores[i + j] === null) {
                            // Si un interval està ocupat, el tractament no encaixa
                            tractamentEncaixa = false;
                            break;
                        }
                    }

                    // Emmagatzema les hores disponibles si el tractament encaixa
                    if (tractamentEncaixa) {
                        horesDisponibles.push(hores[i]);
                    }
                }
            }
        }

        return horesDisponibles;
    }

    // Funció que s'executa al fer submit del formulari de reserva
    const handleSubmit = async (e) => {
        e.preventDefault();
        const reserva = {
            dia: selectedDate,
            hora: selectedHour,
            tractament_id: selectedTractament,
            client_id: user.id,
            missatge: missatge,
        };
        const correcte = validateDiaHora(reserva);
        if (correcte) {
            const response = await storeReserva(reserva);
            await Inertia.post("/", {
                status: response.status,
                message: response.message,
            });
        }
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
                    <div className="flex flex-col mb-6">
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
                        <div
                            id="errorTractament"
                            className="text-xs text-red-500 mt-0 mb-2"
                            role="alert"
                        ></div>
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
                                    openDays={openDays}
                                    id="dia"
                                    name="dia"
                                />
                                <div
                                    id="errorDia"
                                    className="text-xs text-red-500 mt-0 mb-2"
                                    role="alert"
                                ></div>
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
                                    className={`p-2 rounded-md bg-[#31304D] text-gray-300 ${
                                        availableHours.length === 0
                                            ? "opacity-50 cursor-not-allowed"
                                            : ""
                                    }`}
                                    onChange={(e) =>
                                        setSelectedHour(e.target.value)
                                    }
                                    disabled={availableHours.length === 0}
                                    title={
                                        availableHours.length === 0
                                            ? "No pots seleccionar una hora ja que no hi ha hores disponibles"
                                            : ""
                                    }
                                >
                                    <option value="" disabled selected>
                                        {availableHours.length === 0
                                            ? "No hi ha hores disponibles"
                                            : "Selecciona una hora"}
                                    </option>
                                    {availableHours.map((hour) => (
                                        <option key={hour} value={hour}>
                                            {hour}
                                        </option>
                                    ))}
                                </select>

                                <div
                                    id="errorHora"
                                    className="text-xs text-red-500 mt-0 mb-2"
                                    role="alert"
                                ></div>
                            </div>
                            <div className="flex flex-col mb-4">
                                <label
                                    htmlFor="missatge"
                                    className="mb-2 font-semibold"
                                >
                                    Missatge (Opcional)
                                </label>
                                <textarea
                                    name="missatge"
                                    id="missatge"
                                    className="p-2 rounded-md bg-[#31304D] text-gray-300"
                                    placeholder="Deixa un missatge"
                                    onChange={(e) =>
                                        setMissatge(e.target.value)
                                    }
                                ></textarea>
                            </div>
                            <button
                                type="submit"
                                className="bg-[#161A30] border-gray-300 border-2 text-gray-300 p-2 rounded-md font-semibold hover:bg-[#B6BBC4] hover:text-[#161A30] transition-colors duration-500 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-transparent disabled:hover:text-gray-300"
                                disabled={
                                    !selectedTractament ||
                                    !selectedDate ||
                                    !selectedHour
                                }
                                title={
                                    !selectedTractament ||
                                    !selectedDate ||
                                    !selectedHour
                                        ? `Et falta seleccionar ${
                                              !selectedTractament
                                                  ? "el tractament"
                                                  : !selectedDate
                                                  ? "la data"
                                                  : "l'hora"
                                          } per poder confirmar la reserva`
                                        : ""
                                }
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
