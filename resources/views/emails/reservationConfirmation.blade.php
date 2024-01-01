<!DOCTYPE html>
<html>

<head>
    <title>Confirmació de Reserva</title>
    <style>
        /* Afegeix estils CSS en línia aquí */
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        h1 {
            color: #5bc0de;
            /* Blau */
        }

        p {
            margin-bottom: 10px;
        }

        b {
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <h1>Confirmació de Reserva</h1>
    <p>Hola <b>{{ $reserva->client->nom }}</b>,</p>
    <p>La teva reserva per al tractament <b>{{ $reserva->tractament->nom }}</b> el dia
        <b>{{ $reserva->data->format('d/m/Y') }}</b> a
        les <b>{{ $reserva->hora }}h</b> ha estat confirmada amb èxit.
    </p>
    <p>Gràcies per la teva confiança!</p>
</body>

</html>
