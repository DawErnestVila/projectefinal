const API_URL = "http://localhost/api";

// USERS
// Check if user exists
export function checkUser(data) {
    return fetch(`${API_URL}/existeixclient`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    }).then((response) => response.json());
}

// Store
export function store(data) {
    return fetch(`${API_URL}/storeclient`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    }).then((response) => response.json());
}
