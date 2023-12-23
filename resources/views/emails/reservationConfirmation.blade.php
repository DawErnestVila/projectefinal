<!DOCTYPE html>
<html>

<head>
    <title>Confirmació de Reserva</title>
</head>

<body>
    <h1>Confirmació de Reserva</h1>
    <p>Hola {{ $reserva->client->nom }},</p>
    <p>La teva reserva per al tractament <b> {{ $reserva->tractament->nom }} </b>el dia
        <b>{{ $reserva->data->format('d/m/Y') }} </b>a
        les<b> {{ $reserva->hora }}h </b>ha estat confirmada amb èxit.
    </p>
    <p>Gràcies per la teva confiança!</p>
</body>

</html>
