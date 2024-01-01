<!DOCTYPE html>
<html>

<head>
    <title>Cancel·lació de Reserva</title>
    <style>
        /* Afegeix estils CSS en línia aquí */
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        h1 {
            color: #d9534f;
            /* Vermell */
        }

        p {
            margin-bottom: 10px;
        }

        b {
            font-size: 1rem;
        }

        .canceled {
            color: #d9534f;
            /* Vermell */
            font-weight: bold;
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <h1>Cancel·lació de Reserva</h1>
    <p>Hola <b>{{ $reserva->client->nom }}</b>,</p>
    <p>La teva reserva per al tractament <b>{{ $reserva->tractament->nom }}</b> el dia <b>{{ $dataResFormatted }}</b> a
        les <b>{{ substr($reserva->hora, 0, 5) }}</b> ha estat <span class="canceled">cancel·lada</span>.</p>
    <p>Motiu de cancel·lació: <b>{{ $motiu }}</b></p>
    <p>Gràcies per la teva comprensió.</p>
</body>

</html>
