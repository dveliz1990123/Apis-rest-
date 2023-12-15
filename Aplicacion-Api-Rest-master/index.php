<?php
$serve = "127.0.0.1:3308";
$username = "root";
$password = "Danny Sinin";
$dbname = "carros";

// Create connection
$conn = new mysqli($serve, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

header("Content-Type: application/json");
$metodo = $_SERVER['REQUEST_METHOD'];
print_r($metodo);

switch ($metodo) {
    case 'GET':
        echo "Consulta de resgistros - GET";
        consulta($conn);
        break;
    case 'POST':
        echo "Insertar de registros - POST";
        Insertar($conn);
        break;
    case 'PUT';
        echo "Edición de registros -PUT";
        break;
    case 'DELETE':
        echo "Borrado de registros - DELETE";
        break;
    default:
        echo "Método no permitido";
        break;
}

function consulta($conn)
{
    $sql = "SELECT * FROM usuarios";
    $resultado = $conn->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    }
}
function Insertar($conn)
{

    $dato = json_decode(file_get_contents('php://input'), true);
    $nombre = $dato['nombre'];
    $sql = "INSERT INTO usuarios(nombre) VALUES ('$nombre')";
    $resulado = $conn->query($sql);

    if ($resulado) {
        $dato['id'] = $conn->insert_id;
        echo json_encode($dato);
    } else {
        echo json_encode(array('error' => 'Error al crear usuario'));
    }

}
?>