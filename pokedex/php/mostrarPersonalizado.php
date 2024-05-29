<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>
    <div class="main-page">
        <img src="../resources/logo.png" alt="Logo Pokedex">
        <div class="navbar">
            <button class="search-icon" onclick="toggleSearch()"><i class="fas fa-search"></i></button>
            <input type="text" class="search-input" placeholder="Search..." style="display: none;">
            <button class="botones">Order</button>
            <button id="botonCrearPokemon" class="botones">Create Pokemon</button>
            <button id="botonMostrarPersonalizado" class="botones">View custom Pokemon</button>
            <button id="botonHome" class="botones">Home</button>
        </div>
        <div class="pokemon-container">
            <div id="pokemon-grid" class="pokemon-grid">
                <?php
                include_once("database.php");

                $database = new Database();
                $conn = $database->connect();

                // Número máximo de Pokémon por página
                $pokemonsPorPagina = 20;

                // Obtener el número total de Pokémon
                $sqlTotal = "SELECT COUNT(*) AS total FROM pokemon";
                $stmtTotal = $conn->prepare($sqlTotal);
                $stmtTotal->execute();
                $totalPokemons = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

                // Calcular el número total de páginas
                $totalPaginas = ceil($totalPokemons / $pokemonsPorPagina);

                // Obtener la página actual
                $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                $paginaActual = max(1, min($totalPaginas, intval($paginaActual)));

                // Calcular el índice de inicio y fin para la consulta LIMIT
                $indiceInicio = ($paginaActual - 1) * $pokemonsPorPagina;
                $sql = "SELECT * FROM pokemon LIMIT $indiceInicio, $pokemonsPorPagina";

                $stmt = $conn->prepare($sql);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='pokemon-card'>";
                        echo "<div class='pokemon-details'>";
                        echo "<img src='data:image/jpeg;base64," . base64_encode($row['Foto']) . "' alt='" . $row['Nombre'] . "'>";
                        echo "<h3>" . $row['Nombre'] . "</h3>";
                        echo "<p>Level " . $row['Nivel'] . "</p>";
                        echo "<p>" . $row['primerTipo'];
                        if (!empty($row['segundoTipo'])) {
                            echo ", " . $row['segundoTipo'];
                        }
                        echo "</p>";

                        // Botón Editar
                        echo "<form action='editarPokemon.php' method='get'>";
                        echo "<input type='hidden' name='id' value='" . $row['id_pokemon'] . "'>";
                        echo "<button type='submit' class='btn-editar'>Edit</button>";
                        echo "</form>";

                        // Botón Eliminar
                        echo "<form id='formEliminar' action='eliminarPokemon.php' method='post'>";
                        echo "<input type='hidden' name='id' value='" . $row['id_pokemon'] . "'>";
                        echo "<button type='button' class='btn-eliminar' onclick='confirmarEliminacion()'>Eliminate</button>";
                        echo "</form>";
                        
                        echo "<script>";
                        echo "function confirmarEliminacion() {";
                        echo "    if (confirm('Are you sure you want to eliminate this Pokemon?')) {";
                        echo "        document.getElementById('formEliminar').submit();";
                        echo "    }";
                        echo "}";
                        echo "</script>";

                        echo "</div>"; // Cierre de pokemon-details
                        echo "</div>"; // Cierre de pokemon-card
                    }
                } else {
                    echo "No se encontraron Pokémon";
                }

                $conn = null;
                ?>
            </div>
        </div>

        <div class="navigation">
            <?php if ($paginaActual > 1) : ?>
                <button onclick="window.location.href='?pagina=<?php echo $paginaActual - 1; ?>'" id="prevButton">Anterior</button>
            <?php else : ?>
                <button id="prevButton" class="disabled" disabled>Previous</button>
            <?php endif; ?>
            <span>Página: <?php echo $paginaActual; ?></span>
            <input type="number" id="pageInput" min="1" max="<?php echo $totalPaginas; ?>" value="<?php echo $paginaActual; ?>">
            <button id="goButton" onclick="window.location.href='?pagina=' + document.getElementById('pageInput').value;">Go</button>
            <?php if ($paginaActual < $totalPaginas) : ?>
                <button onclick="window.location.href='?pagina=<?php echo $paginaActual + 1; ?>'" id="nextButton">Next</button>
            <?php else : ?>
                <button id="nextButton" class="disabled" disabled>Next</button>
            <?php endif; ?>
        </div>

        <audio id="miAudio" controls autoplay loop autobuffer>
            <source src="/resources/Pokemon Soundtrack.mp3" type="audio/mpeg">
            Tu navegador no soporta el elemento de audio.
        </audio>

        <script src="../js/button.js"></script>
</body>

</html>