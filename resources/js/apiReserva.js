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
