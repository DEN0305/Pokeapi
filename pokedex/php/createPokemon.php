<?php
include_once("database.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo '<script>alert("The form has not been sent correctly."); window.location ="crearPokemon.php";</script>';
    exit;
}

$nombre_pokemon = isset($_POST['nombre_pokemon']) ? $_POST['nombre_pokemon'] : '';
$nivel_pokemon = isset($_POST['nivel_pokemon']) ? $_POST['nivel_pokemon'] : '';
$tipo_pokemon = isset($_POST['tipo_pokemon']) ? $_POST['tipo_pokemon'] : '';
$tipo_pokemon_dos = isset($_POST['tipo_pokemon_dos']) ? $_POST['tipo_pokemon_dos'] : '';
$foto_name = $_FILES['foto']['name'];
$foto_tmp = $_FILES['foto']['tmp_name'];

if (!empty($foto_tmp) && is_uploaded_file($foto_tmp)) {
    $imagen_info = getimagesize($foto_tmp);
    $ancho = $imagen_info[0];
    $alto = $imagen_info[1];
    
    $dimensiones_permitidas = array("ancho" => 96, "alto" => 96);

    if ($ancho != $dimensiones_permitidas["ancho"] || $alto != $dimensiones_permitidas["alto"]) {
        echo '<script>alert("The image must have the exact dimensions."); window.location ="crearPokemon.php";</script>';
        exit;
    }
  
    $foto_binaria = file_get_contents($foto_tmp);

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=pokedex", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction(); // Comenzar transacción

        $query_pokemon = "INSERT INTO pokemon (Nombre, Nivel, primerTipo, segundoTipo, Foto) VALUES (?, ?, ?, ?, ?)";
        $stmt_pokemon = $pdo->prepare($query_pokemon);
        $stmt_pokemon->bindParam(1, $nombre_pokemon);
        $stmt_pokemon->bindParam(2, $nivel_pokemon);
        $stmt_pokemon->bindParam(3, $tipo_pokemon);
        $stmt_pokemon->bindParam(4, $tipo_pokemon_dos);
        $stmt_pokemon->bindParam(5, $foto_binaria, PDO::PARAM_LOB);
        $stmt_pokemon->execute();



        $rowsAffected = $stmt_pokemon->rowCount(); // Obtener el número de filas afectadas
        $pdo->commit();

        if ($rowsAffected > 0) {
            echo '<script>alert("Pokemon saved successfully"); window.location ="crearPokemon.php";</script>';
        } else {
            echo '<script>alert("Error: No rows affected. Data not saved."); window.location ="crearPokemon.php";</script>';
        }
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo '<script>alert("Error when saving Pokemon: '.$e->getMessage().'"); window.location ="crearPokemon.php";</script>';
    }
} else {
    echo '<script>alert("Please, choose a valid image for the Pokemon."); window.location ="crearPokemon.php";</script>';
}
?>
