const API_URL = "http://localhost/api";

// Afegeix un esdeveniment de clic a tots els elements amb l'ID 'edita-tractament'
document.querySelectorAll("#edita-tractament").forEach(function (button) {
    button.addEventListener("click", function () {
        const inputNom = document.querySelector("#nom");
        const inputDescripcio = document.querySelector("#descripcio");
        const inputHores = document.querySelector("#hores");
        const inputMinuts = document.querySelector("#minuts");
        const inputTractamentId = document.querySelector("#tractament_id");

        // Obtinguem l'ID del tractament des de l'atribut personalitzat
        const tractamentId = this.getAttribute("data-tractament-id");

        // Obtenir la informació de la fila corresponent utilitzant l'ID del tractament
        const fila = document.querySelector(
            'tr[data-tractament-id="' + tractamentId + '"]'
        );

        // Obté tots els elements td dins la fila
        const [nom, descripcio, durada, estat, boto] =
            fila.querySelectorAll("td");

        // Canviar el text del botó en funció de l'estat del tractament
        const botoEditar = document.querySelector("#toggle-tractament-btn");

        if (estat.textContent.trim() === "Actiu") {
            botoEditar.innerHTML = "Desactivar Tractament";
            botoEditar.classList.remove("bg-green-500", "hover:bg-green-700");
            botoEditar.classList.add("bg-orange-500", "hover:bg-orange-700");
        } else {
            botoEditar.innerHTML = "Activar Tractament";
            botoEditar.classList.remove("bg-orange-500", "hover:bg-orange-700");
            botoEditar.classList.add("bg-green-500", "hover:bg-green-700");
        }

        // Omple els camps del formulari amb la informació del tractament
        inputNom.value = nom.innerText;
        inputDescripcio.value = descripcio.innerText;
        inputHores.value = durada.innerText.split(":")[0];
        inputMinuts.value = durada.innerText.split(":")[1].replace("h", "");
        inputTractamentId.value = tractamentId;

        // Mostra l'element amb la id 'editar-tractament'
        const editarTractamentElement =
            document.getElementById("editar-tractament");
        if (editarTractamentElement) {
            editarTractamentElement.style.display = "block";
            editarTractamentElement.scrollIntoView({
                behavior: "smooth",
            });
        }
    });
});

//Desactivar tractament
document
    .querySelector("#toggle-tractament-btn")
    .addEventListener("click", async () => {
        const tractamentId = document.querySelector("#tractament_id").value;
        try {
            const response = await fetch(`${API_URL}/deletetractament`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ tractament_id: tractamentId }),
            });
            const responseJson = await response.json();
            console.log(responseJson);
            if (responseJson.status === "success") {
                // Eliminar l'element del DOM
                const element = document.querySelector(
                    `[data-tractament-id="${tractamentId}"]`
                );

                const estatElement = element.querySelector(".estat");

                // Canviar el text de l'element d'estat en funció de l'estat actual
                estatElement.textContent =
                    estatElement.textContent.trim() === "Actiu"
                        ? "Inactiu"
                        : "Actiu";

                estatElement.classList.remove("text-green-600", "text-red-600");
                estatElement.classList.add(
                    estatElement.textContent.trim() === "Actiu"
                        ? "text-green-600"
                        : "text-red-600"
                );

                const flashMessage = document.querySelector("#flash-message");
                flashMessage.classList.remove("hidden-flash");
                flashMessage.classList.add("visible-flash");
                flashMessage.textContent = responseJson.message;

                setTimeout(() => {
                    flashMessage.classList.remove("visible-flash");
                    flashMessage.classList.add("hidden-flash");
                    flashMessage.innerHTML = "";
                }, 3000);

                const tractaments = await fetch(`${API_URL}/gettractaments`);
                const tractamentsJson = await tractaments.json();
                tractamentsData = tractamentsJson.data;
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
    });

// Afegeix un esdeveniment de clic al botó 'Editar'
document
    .getElementById("editar-tractament-btn")
    .addEventListener("click", function () {
        // Amaga l'element amb la id 'editar-tractament'
        document.getElementById("editar-tractament").style.display = "none";
    });

// Afegeix un esdeveniment de clic al botó 'Eliminar Tractament'
document
    .getElementById("toggle-tractament-btn")
    .addEventListener("click", function () {
        // Amaga l'element amb la id 'editar-tractament'
        document.getElementById("editar-tractament").style.display = "none";
    });
