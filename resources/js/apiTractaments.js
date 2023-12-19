const API_URL = "http://localhost/api";

// Get tractaments
export function getTractaments() {
    return fetch(`${API_URL}/gettractaments`).then((response) =>
        response.json()
    );
}
