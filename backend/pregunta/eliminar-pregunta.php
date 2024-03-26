<?php
if(isset($_POST)){
    require_once 'conexion.php';

    // Obtener y validar el ID de la pregunta a eliminar
    $id_pregunta = isset($_POST['id_pregunta']) ? mysqli_real_escape_string($con, $_POST['id_pregunta']) : false;

    $error = array();

    if(empty($id_pregunta) || !is_numeric($id_pregunta)){
        $error['id_pregunta'] = "El ID de la pregunta no es válido";
    }

    // Si no hay errores, eliminar la pregunta de la base de datos
    if (count($error) == 0){
        $sql = "DELETE FROM preguntas WHERE id_pregunta = $id_pregunta";

        // Ejecutar la consulta SQL
        $query = mysqli_query($con, $sql);

        if ($query) {
            $respuesta = array(
                'status' => 'success',
                'message' => 'Pregunta eliminada exitosamente'
            );
        } else {
            $respuesta = array(
                'status' => 'error',
                'code' => 500,
                'message' => 'Error en la consulta SQL: ' . mysqli_error($con)
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
