<?php
include_once("database.php");

if (isset($_POST['id'])) {
    $id_pokemon = $_POST['id'];

    try {
        $database = new Database();
        $conn = $database->connect();

        $sql = "DELETE FROM pokemon WHERE id_pokemon = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id_pokemon);
        $stmt->execute();

        // Redirecciona de vuelta a la página que muestra los Pokémon
        header("Location: mostrarPersonalizado.php");
        exit();
    } catch (PDOException $e) {
        echo "Error when deleting Pokemon: " . $e->getMessage();
    }
} else {
    // Si no se proporcionó un ID de Pokémon, redirecciona nuevamente a la página que muestra los Pokémon
    header("Location: mostrarPersonalizado.php");
    exit();
}
