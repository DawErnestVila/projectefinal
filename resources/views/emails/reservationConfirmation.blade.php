<!DOCTYPE html>
<html>

<head>
    <title>Confirmació de Reserva</title>
</head>

<body>
    <h1>Confirmació de Reserva</h1>
    <p>Hola {{ $reserva->client->nom }},</p>
    <p>La teva reserva per al tractament {{ $reserva->tractament->nom }} el dia {{ $reserva->data->format('d/m/Y') }} a
        les {{ $reserva->hora }} ha estat confirmada amb èxit.</p>
    <p>Gràcies per la teva confiança!</p>
</body>

</html>
