const API_URL = "http://localhost/api";

// Get tractaments
export function getTractaments() {
    return fetch(`${API_URL}/gettractaments`).then((response) =>
        response.json()
    );
}

// Get horaris
export function getHoraris() {
    return fetch(`${API_URL}/gethoraris`).then((response) => response.json());
}

// Get dies deshabilitats
export function getDiesDeshabilitats() {
    return fetch(`${API_URL}/getdiesdeshabilitats`).then((response) =>
        response.json()
    );
}

// Get hores disponibles
export function getHoresDisponibles(data) {
    return fetch(`${API_URL}/gethoresdisponibles`, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
        },
    }).then((response) => response.json());
}

// Get reserves del dia
export function getReservesDia(data) {
    return fetch(`${API_URL}/getreservesdia`, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
        },
    }).then((response) => response.json());
}

// Get tractament per id
export function getTractamentId(data) {
    return fetch(`${API_URL}/gettractamentid`, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
        },
    }).then((response) => response.json());
}

// Store reserva
export function storeReserva(data) {
    return fetch(`${API_URL}/storereserva`, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
        },
    }).then((response) => response.json());
}
