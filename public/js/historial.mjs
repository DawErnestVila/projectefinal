const API_URL = "http://localhost/api";

const getTractaments = async () => {
    try {
        const tractaments = await fetch(`${API_URL}/gettractaments`);
        const tractamentsJson = await tractaments.json();
        // console.log(tractamentsJson.data);
        tractamentsData = tractamentsJson.data;
        const select = document.querySelector("#tractaments");
        tractamentsData.forEach((element) => {
            const option = document.createElement("option");
            option.value = element.nom;
            option.textContent = element.nom;
            select.appendChild(option);
        });
    } catch (error) {
        console.log(error);
    }
};

const realitzarCerca = async () => {
    const tbody = document.querySelector("#tbody");
    tbody.innerHTML = "";
    const nomClient = document.querySelector("#clientSearch").value;
    const nomTractament = document.querySelector("#tractaments").value;
    const data = document.querySelector("#dateSearch").value;
    const nomEstudiant = document.querySelector("#studentSearch").value;
    const dataFormat = data.split("/").reverse().join("-");
    const cancelada = document.querySelector("#cancelada").checked;
    document.querySelector("#clientSearch").value = "";
    document.querySelector("#tractaments").value = "";
    document.querySelector("#dateSearch").value = "";
    document.querySelector("#studentSearch").value = "";
    document.querySelector("#cancelada").checked = false;

    const cerca = {
        client_name: nomClient,
        tractament_name: nomTractament,
        data: dataFormat,
        alumne_name: nomEstudiant,
        cancelada: cancelada,
    };

    try {
        const response = await fetch(`${API_URL}/getfilteredhistorial`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(cerca),
        });
        const responseJson = await response.json();
        if (responseJson.data !== null) {
            responseJson.data.forEach((element) => {
                const tr = document.createElement("tr");
                const tdClient = document.createElement("td");
                tdClient.textContent = element.client_name;
                tdClient.setAttribute("scope", "row");
                tdClient.setAttribute(
                    "class",
                    "px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                );
                const tdTractament = document.createElement("td");
                tdTractament.textContent = element.tractament_name;
                tdTractament.setAttribute("class", "px-6 py-4");
                const tdData = document.createElement("td");
                tdData.textContent = element.data;
                tdData.setAttribute("class", "px-6 py-4");
                const tdHora = document.createElement("td");
                const dataFormat = tdData.textContent.split("-");
                tdData.textContent =
                    dataFormat[2] + "/" + dataFormat[1] + "/" + dataFormat[0];
                tdHora.textContent = element.hora;
                tdHora.setAttribute("class", "px-6 py-4");
                const hora = tdHora.textContent.split(":");
                tdHora.textContent = hora[0] + ":" + hora[1];
                const tdAlumne = document.createElement("td");
                tdAlumne.textContent = element.user_name;
                tdAlumne.setAttribute("class", "px-6 py-4");
                const tdDataCancelacio = document.createElement("td");
                tdDataCancelacio.textContent = element.data_cancelacio;
                tdDataCancelacio.setAttribute("class", "px-6 py-4");
                element.data_cancelacio === null
                    ? (tdDataCancelacio.textContent = "-")
                    : (tdDataCancelacio.textContent = element.data_cancelacio);
                const tdMotiuCancelacio = document.createElement("td");
                tdMotiuCancelacio.textContent = element.motiu_cancelacio;
                tdMotiuCancelacio.setAttribute("class", "px-6 py-4");
                element.motiu_cancelacio === null
                    ? (tdMotiuCancelacio.textContent = "-")
                    : (tdMotiuCancelacio.textContent =
                          element.motiu_cancelacio);
                tr.appendChild(tdClient);
                tr.appendChild(tdTractament);
                tr.appendChild(tdAlumne);
                tr.appendChild(tdData);
                tr.appendChild(tdHora);
                tr.appendChild(tdDataCancelacio);
                tr.appendChild(tdMotiuCancelacio);
                tbody.appendChild(tr);
            });
        } else {
            //ha de posar un tr que digui que no hi ha res
            const tr = document.createElement("tr");
            const td = document.createElement("td");
            td.setAttribute("colspan", "7");
            td.setAttribute("class", "px-6 py-4 text-center");
            td.textContent = "No hi ha resultats";
            tr.appendChild(td);
            tbody.appendChild(tr);
        }
    } catch (error) {
        console.log(error);
    }
};

getTractaments();
