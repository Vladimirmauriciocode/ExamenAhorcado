<?php
include('../conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);

    $errores = array();

    if (empty($name)) {
        $errores['name'] = "El nombre no puede estar vacío";
    }

    if (empty($password)) {
        $errores['password'] = "La contraseña no puede estar vacía";
    } else {
        // Validar la fortaleza de la contraseña si es necesario
        // por ejemplo, verificar longitud, caracteres especiales, etc.
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    if (empty($errores)) {
        $sql = "INSERT INTO Usuario (name, password) VALUES ('$name', '$hashed_password')";
        $crear = mysqli_query($con, $sql);

        if ($crear) {
            echo "Usuario creado exitosamente.";
        } else {
            echo "Error al crear el usuario: " . mysqli_error($con);
        }
    } else {
        foreach ($errores as $val) {
            echo $val . '<br>';
        }
    }
}

mysqli_close($con);
?>

