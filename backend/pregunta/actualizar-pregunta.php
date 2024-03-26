<?php
if(isset($_POST)){
    require_once 'conexion.php';

    // Obtener y validar los datos de la pregunta a actualizar
    $id_pregunta = isset($_POST['id_pregunta']) ? mysqli_real_escape_string($conexion, $_POST['id_pregunta']) : false;
    $pregunta = isset($_POST['pregunta']) ? mysqli_real_escape_string($conexion, $_POST['pregunta']) : false;
    $imagen = isset($_POST['imagen']) ? mysqli_real_escape_string($conexion, $_POST['imagen']) : false;

    $error = array();

    if(empty($id_pregunta) || !is_numeric($id_pregunta)){
        $error['id_pregunta'] = "El ID de la pregunta no es válido";
    }

    if(empty($pregunta)){
        $error['pregunta'] = "La pregunta no puede estar vacía";
    }

    if(empty($imagen)){
        $error['imagen'] = "La imagen no puede estar vacía";
    }

    // Si no hay errores, actualizar la pregunta en la base de datos
    if (count($error) == 0){
        $sql = "UPDATE preguntas SET pregunta = '$pregunta', imagen = '$imagen' WHERE id_pregunta = $id_pregunta";

        // Ejecutar la consulta SQL
        $query = mysqli_query($conexion, $sql);

        if ($query) {
            $respuesta = array(
                'status' => 'success',
                'message' => 'Pregunta actualizada exitosamente'
            );
        } else {
            $respuesta = array(
                'status' => 'error',
                'code' => 500,
                'message' => 'Error en la consulta SQL: ' . mysqli_error($conexion)
            );
        }
    } else {
        // Si hay errores en los datos, construir respuesta de error
        $respuesta = array(
            'status' => 'error',
            'code' => 400,
            'message' => 'Error en los datos',
            'error' => $error
        );
    }

    // Devolver respuesta como JSON
    echo json_encode($respuesta);
}
?>
