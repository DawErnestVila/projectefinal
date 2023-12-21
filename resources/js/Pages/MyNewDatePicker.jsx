import React, { useEffect, useRef } from "react";
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { Spanish } from "flatpickr/dist/l10n/es.js";
import "flatpickr/dist/themes/dark.css";

flatpickr.l10ns.default.firstDayOfWeek = 1;

const MyNewDatePicker = ({ disabledDatesProps, setSelectedDate }) => {
    const datePickerRef = useRef(null);

    useEffect(() => {
        const today = new Date();
        const instance = flatpickr(datePickerRef.current, {
            disable: [
                function (date) {
                    // Disable days other than Thursday and Friday
                    return !(date.getDay() === 4 || date.getDay() === 5);
                },
                function (date) {
                    // Disable specific dates
                    const disabledDates = [
                        //AQUI HI POSAREM UN PROP DE LA PAGINA RESERVA QUE ES DIU DISABLEDDATES ON HI HAURÀ UN ARRAY DE DATES
                        ...disabledDatesProps,
                    ];
                    return disabledDates.some(
                        (disabledDate) =>
                            date.getTime() === disabledDate.getTime()
                    );
                },
            ],
            locale: {
                ...Spanish,
                firstDayOfWeek: 1,
            },
            onChange: function (selectedDates, dateStr, instance) {
                setSelectedDate(dateStr);
            },
            dateFormat: "d/m/Y",
            locale: {
                weekdays: {
                    shorthand: ["Dg", "Dl", "Dm", "Dx", "Dj", "Dv", "Ds"],
                    longhand: [
                        "Diumenge",
                        "Dilluns",
                        "Dimarts",
                        "Dimecres",
                        "Dijous",
                        "Divendres",
                        "Dissabte",
                    ],
                },
                months: {
                    shorthand: [
                        "Gen",
                        "Feb",
                        "Mar",
                        "Abr",
                        "Maig",
                        "Juny",
                        "Jul",
                        "Ago",
                        "Set",
                        "Oct",
                        "Nov",
                        "Des",
                    ],
                    longhand: [
                        "Gener",
                        "Febrer",
                        "Març",
                        "Abril",
                        "Maig",
                        "Juny",
                        "Juliol",
                        "Agost",
                        "Setembre",
                        "Octubre",
                        "Novembre",
                        "Desembre",
                    ],
                },
            },
            minDate: today,
            defaultDate: today,
            maxDate: new Date().fp_incr(6 * 30),
            theme: "dark",
        });

        // Cleanup function to destroy Flatpickr instance on component unmount
        return () => {
            instance.destroy();
        };
    }, []);

    return (
        <input
            type="text"
            ref={datePickerRef}
            className="bg-[#31304D] rounded-md"
        />
    );
};

export default MyNewDatePicker;
