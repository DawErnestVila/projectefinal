document.addEventListener("DOMContentLoaded", function () {
    const horaInputs = document.querySelectorAll(".hora-input");

    horaInputs.forEach(function (input) {
        input.addEventListener("change", function () {
            let value = this.value;

            // Afegir zero al davant si és inferior a 10
            if (value.length === 4 && value.indexOf(":") === 1) {
                value = "0" + value;
            }

            this.value = value;
        });
    });
});
