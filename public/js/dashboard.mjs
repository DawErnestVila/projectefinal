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
    let value = input.value.trim(); // Trim to handle whitespace

    // Clear the container if the input value is empty
    if (value === "") {
        const container = document.querySelector("#reserves");
        container.innerHTML = "";
        return; // Exit the function if the input is empty
    }

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

    //POTS ORDERNAR PER LA DATA DE LA RESERVA ELS ELEMENTS
    elements.sort((a, b) => {
        const dateA = new Date(a.reserva.data);
        const dateB = new Date(b.reserva.data);
        return dateA - dateB;
    });

    elements.forEach((element) => {
        buildReservaDom(element, container);
    });
};

const assignarResrva = async (e) => {
    const reservaId = e.currentTarget.dataset.reservaId;
    const idUsuari = document.querySelector("#user_id").value;
    // Necessito fer una petició post a la API a `${API_URL}/assignarreserva` i que un cop s'hagi assignat la reserva, esborri l'element del DOM
    try {
        const response = await fetch(`${API_URL}/assignarreserva`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ reserva_id: reservaId, user_id: idUsuari }),
        });
        const responseJson = await response.json();
        console.log(responseJson);
        if (responseJson.status === "success") {
            // Eliminar l'element del DOM
            const element = document.querySelector(
                `[data-reserva-id="${reservaId}"]`
            );
            element.classList.remove("visible");
            setTimeout(() => {
                element.remove();
            }, 300);

            const flashMessage = document.querySelector("#flash-message");
            flashMessage.classList.remove("hidden-flash");
            flashMessage.classList.add("visible-flash");
            flashMessage.textContent = responseJson.message;

            setTimeout(() => {
                flashMessage.classList.remove("visible-flash");
                flashMessage.classList.add("hidden-flash");
                flashMessage.innerHTML = "";
            }, 3000);

            const reserves = await fetch(`${API_URL}/getreserves`);
            const reservesJson = await reserves.json();
            reservesData = reservesJson.data;
        } else {
            const flashMessage = document.querySelector("#flash-message");
            flashMessage.classList.remove("hidden-flash");
            flashMessage.classList.add("visible-flash");
            flashMessage.classList.add("error-flash");
            flashMessage.textContent = responseJson.message;

            setTimeout(() => {
                flashMessage.classList.remove("visible-flash");
                flashMessage.classList.add("hidden-flash");
                flashMessage.classList.remove("error-flash");
                flashMessage.innerHTML = "";
            }, 3000);
        }
    } catch (error) {
        console.log(error);
    }
};

const buildReservaDom = (element, container) => {
    const reservaElement = document.createElement("div");
    reservaElement.classList.add("reserva");

    // Afegir la ID com a atribut de l'element
    reservaElement.dataset.reservaId = element.reserva.id;

    const headerElement = document.createElement("div");
    headerElement.classList.add("reserva__header");

    const titleElement = document.createElement("h3");
    titleElement.classList.add("reserva__title");
    titleElement.classList.add("bg-slate-400");
    titleElement.textContent = `${element.client.nom} ${element.client.cognoms}`;

    const dateElement = document.createElement("p");
    dateElement.classList.add("reserva__text-label");
    dateElement.textContent = "Data: ";

    // Format the date as dd/mm/yyyy
    const reservaDate = new Date(element.reserva.data);
    const formattedDate = reservaDate.toLocaleDateString("en-GB");
    dateElement.textContent += formattedDate;

    headerElement.appendChild(titleElement);
    headerElement.appendChild(dateElement);

    const bodyElement = document.createElement("div");
    bodyElement.classList.add("reserva__body");

    const textElement1 = document.createElement("p");
    textElement1.classList.add("reserva__text-label");
    textElement1.textContent = "Tractament: ";

    // Display the name of the treatment instead of its ID
    textElement1.textContent += element.tractament.nom;

    const textElement2 = document.createElement("p");
    textElement2.classList.add("reserva__text-label");
    textElement2.textContent = "Hora: ";

    // Extract only hours and minutes using a slice
    const horaString = element.reserva.hora;
    const formattedTime = horaString.slice(0, 5);
    textElement2.textContent += formattedTime;

    bodyElement.appendChild(textElement1);
    bodyElement.appendChild(textElement2);
    if (element.reserva.comentari) {
        const messageLabelElement = document.createElement("p");
        messageLabelElement.classList.add("reserva__text-label");
        messageLabelElement.textContent = "Missatge: ";

        const messageElement = document.createElement("p");
        messageElement.classList.add("reserva__text");
        messageElement.textContent = element.reserva.comentari;

        bodyElement.appendChild(messageLabelElement);
        bodyElement.appendChild(messageElement);
    }

    reservaElement.appendChild(headerElement);
    reservaElement.appendChild(bodyElement);

    container.appendChild(reservaElement);

    // Afegir la classe per activar la transició
    setTimeout(() => {
        reservaElement.classList.add("visible");
    }, 50);

    reservaElement.addEventListener("click", assignarResrva);

    container.appendChild(reservaElement);
};

inputTelf.addEventListener("keyup", filterData);

// Inicia la càrrega de reserves quan es carrega la pàgina
manageReserves();
