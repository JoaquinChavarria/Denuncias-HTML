<?php
$host = "localhost";
$port = "5432"; 
$dbname = "casos";
$user = "postgres";
$password = "Percusion.";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// Verificar la conexión
if (!$conn) {
    die("Error: No se pudo conectar a la base de datos");
} else {
    echo "Conexión exitosa"; // Mensaje para verificar la conexión
}

// Verificar si se ha enviado el formulario.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $lugarDelito = $_POST["crimeLocation"];
    $estadoCaso = $_POST["caseStatus"];
    $delitos = $_POST["crimesList"];
    $denunciantes = $_POST["complainantsList"];
    $denunciados = $_POST["accusedList"];
    $descripcion = $_POST["description"];
    $lugarDelito = pg_escape_string($conn, $lugarDelito);
    $estadoCaso = pg_escape_string($conn, $estadoCaso);
    $delitos = pg_escape_string($conn, $delitos);
    $denunciantes = pg_escape_string($conn, $denunciantes);
    $denunciados = pg_escape_string($conn, $denunciados);
    $descripcion = pg_escape_string($conn, $descripcion);

    // Insertar los datos en la base de datos
    $query = "INSERT INTO denuncias (lugar_delito, estado_caso, delitos, denunciantes, denunciados, descripcion) 
              VALUES ('$lugarDelito', '$estadoCaso', '$delitos', '$denunciantes', '$denunciados', '$descripcion')";

    $result = pg_query($conn, $query);

    if (!$result) {
        die("Error al insertar los datos en la base de datos: " . pg_last_error($conn));
    }

    // Redirigir de vuelta al formulario o a otra página
    header("Location: formulario.html");
    exit();
} else {
    // Si se intenta acceder directamente a este archivo sin enviar el formulario, redirigir a la página principal
    header("Location: formulario.html");
    exit();
}

// Cerrar la conexión
pg_close($conn);
?>
