<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pokemon</title>
    <link rel="stylesheet" href="../css/pokemon.css">
</head>

<body>
    <div class="container">
        <img src="../resources/logo.png" alt="Logo Pokedex">
        <form action="editPokemon.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_pokemon" value="<?php echo htmlspecialchars($_GET['id']); ?>">
            <div class="form-group">
                <label for="nombre">Pokemon name:</label>
                <input type="text" id="nombre" name="nombre_pokemon" required placeholder="Edit the Pokemon name">
            </div>
            
            <div class="form-group">
                <label for="nivel">Level:</label>
                <input type="number" id="nivel" name="nivel_pokemon" required placeholder="Edit the pokemon level">
            </div>
            
            <div class="form-group">
                <label for="tipo"> First type:</label>
                <select id="tipo" name="tipo_pokemon">
                    <option value="steel">Steel</option>
                    <option value="water">Water</option>
                    <option value="bug">Bug</option>
                    <option value="dragon">Dragon</option>
                    <option value="electric">Electric</option>
                    <option value="ghost">Ghost</option>
                    <option value="fire">Fire</option>
                    <option value="fairy">Fairy</option>
                    <option value="ice">Ice</option>
                    <option value="fighting">Fighting</option>
                    <option value="normal">Normal</option>
                    <option value="grass">Grass</option>
                    <option value="psychic">Psychic</option>
                    <option value="rock">Rock</option>
                    <option value="dark">Dark</option>
                    <option value="ground">Ground</option>
                    <option value="poison">Poison</option>
                    <option value="flying">Flying</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tipo"> Second type:</label>
                <select id="tipo" name="tipo_pokemon_dos">
                    <option value="steel">Steel</option>
                    <option value="water">Water</option>
                    <option value="bug">Bug</option>
                    <option value="dragon">Dragon</option>
                    <option value="electric">Electric</option>
                    <option value="ghost">Ghost</option>
                    <option value="fire">Fire</option>
                    <option value="fairy">Fairy</option>
                    <option value="ice">Ice</option>
                    <option value="fighting">Fighting</option>
                    <option value="normal">Normal</option>
                    <option value="grass">Grass</option>
                    <option value="psychic">Psychic</option>
                    <option value="rock">Rock</option>
                    <option value="dark">Dark</option>
                    <option value="ground">Ground</option>
                    <option value="poison">Poison</option>
                    <option value="flying">Flying</option>
                </select>
            </div>

            <div class="form-group">
                <label for="foto">Image:</label>
                <small>Edit the pokemon image with a dimension of (96 x 96) </small><br>
                <input type="file" id="foto" name="foto" required >
            </div>

           <!-- <div class="form-group">
                <label for="movimiento">Movement:</label>
                <input type="text" id="movimiento" name="movimiento_pokemon"  placeholder="Choose the Movements"> 
            </div>-->
            
            <div class="form-group">
                <input type="submit" value="Update">
            

                
            </div>
        </form>
    </div>

</body>


</html>