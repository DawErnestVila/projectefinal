// import { getReserves } from "../../resources/js/apiDashboard";
const inputTelf = document.querySelector("#phone");
const API_URL = "http://localhost/api";
let reservesData; // Variable per emmagatzemar les reserves

const manageReserves = async () => {
    try {
        const reserves = await fetch(`${API_URL}/getreserves`);
        const reservesJson = await reserves.json();
        // console.log(reservesJson.data);
        reservesData = reservesJson.data;
    } catch (error) {
        console.log(error);
    }
};

const filterData = (e) => {
    let input = e.target;
    let value = input.value;

    // Ara pots fer servir la variable reservesData aquí dins
    // reservesData.filter(({ client }) => {
    //     console.log(client.phone);
    // });

    const elements = reservesData
        .map((element) => {
            const telefon = element.client.telefon.toString();
            if (telefon.includes(value)) {
                return element;
            }
        })
        .filter((element) => element !== undefined);
    const container = document.querySelector("#reserves");
    container.innerHTML = "";

    elements.forEach((element) => {
        buildReservaDom(element, container);
    });

    console.log(elements);
};

const buildReservaDom = (element, container) => {
    const reservaElement = document.createElement("div");
    reservaElement.classList.add("reserva");

    const headerElement = document.createElement("div");
    headerElement.classList.add("reserva__header");

    const titleElement = document.createElement("h3");
    titleElement.classList.add("reserva__title");
    titleElement.classList.add("bg-slate-400");
    titleElement.textContent = `${element.client.nom} ${element.client.cognoms}`;

    const dateElement = document.createElement("p");
    dateElement.classList.add("reserva__date");
    dateElement.textContent = element.reserva.data;

    headerElement.appendChild(titleElement);
    headerElement.appendChild(dateElement);

    const bodyElement = document.createElement("div");
    bodyElement.classList.add("reserva__body");

    const textElement1 = document.createElement("p");
    textElement1.classList.add("reserva__text");
    textElement1.textContent = element.reserva.tractament_id;

    const textElement2 = document.createElement("p");
    textElement2.classList.add("reserva__text");
    textElement2.textContent = element.reserva.hora;

    bodyElement.appendChild(textElement1);
    bodyElement.appendChild(textElement2);

    reservaElement.appendChild(headerElement);
    reservaElement.appendChild(bodyElement);

    container.appendChild(reservaElement);

    //! POSAR CLASSES AMB CSS I POSARLES AMB LES CLASSES AQUI, COM A LA SWAPI
};

inputTelf.addEventListener("keyup", filterData);

// Inicia la càrrega de reserves quan es carrega la pàgina
manageReserves();
