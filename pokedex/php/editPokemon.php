<?php
include_once("database.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo '<script>alert("The form has not been sent correctly."); window.location ="editarPokemon.php";</script>';
    exit;
}

$nombre_pokemon = isset($_POST['nombre_pokemon']) ? $_POST['nombre_pokemon'] : '';
$nivel_pokemon = isset($_POST['nivel_pokemon']) ? $_POST['nivel_pokemon'] : '';
$tipo_pokemon = isset($_POST['tipo_pokemon']) ? $_POST['tipo_pokemon'] : '';
$tipo_pokemon_dos = isset($_POST['tipo_pokemon_dos']) ? $_POST['tipo_pokemon_dos'] : '';
$foto_name = $_FILES['foto']['name'];
$foto_tmp = $_FILES['foto']['tmp_name'];

if (!empty($foto_tmp) && is_uploaded_file($foto_tmp)) {
    // Leer el contenido de la imagen
    $foto_binaria = file_get_contents($foto_tmp);
} else {
    // Si no se proporcionó una imagen válida, mostrar un mensaje de error
    echo '<script>alert("Please, choose a valid image for the Pokemon."); window.location ="editarPokemon.php";</script>';
    exit; // Detener la ejecución del script
}

try {
    // Establecer conexión a la base de datos
    $pdo = new PDO("mysql:host=localhost;dbname=pokedex", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction(); // Comenzar transacción

    // Obtener el ID del Pokémon a actualizar
    $id_pokemon = $_POST['id_pokemon'];

    // Preparar la consulta SQL para actualizar la información del Pokémon
    $query_pokemon = "UPDATE pokemon SET Nombre = :nombre, Nivel = :nivel, primerTipo = :tipo, segundoTipo = :tipo_dos, Foto = :foto WHERE id_pokemon = :id_pokemon";
    $stmt_pokemon = $pdo->prepare($query_pokemon);
    $stmt_pokemon->bindValue(':nombre', $nombre_pokemon);
    $stmt_pokemon->bindValue(':nivel', $nivel_pokemon);
    $stmt_pokemon->bindValue(':tipo', $tipo_pokemon);
    $stmt_pokemon->bindValue(':tipo_dos', $tipo_pokemon_dos);
    $stmt_pokemon->bindValue(':foto', $foto_binaria, PDO::PARAM_LOB);
    $stmt_pokemon->bindValue(':id_pokemon', $id_pokemon);
    $stmt_pokemon->execute();

    $pdo->commit();

    // Si todo sale bien, mostrar mensaje de éxito y redirigir
    echo '<script>alert("The Pokémon information updated successfully"); window.location ="editarPokemon.php";</script>';
} catch (PDOException $e) {
    // Si hay algún error, cancelar transacción, mostrar mensaje de error y mensaje del error específico de PDO
    $pdo->rollBack();
    echo '<script>alert("Error updating Pokémon information: ' . $e->getMessage() . '"); window.location ="editarPokemon.php";</script>';
}
?>
