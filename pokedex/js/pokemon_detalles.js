document.addEventListener("DOMContentLoaded", () => {
    const pokemonDetailsPage = document.getElementById('pokemon-details-page');
    const urlParams = new URLSearchParams(window.location.search);
    const pokemonId = urlParams.get('id');

    async function fetchPokemonDetails(id) {
        const response = await fetch(`https://pokeapi.co/api/v2/pokemon/${id}`);
        const pokemon = await response.json();
        displayPokemonDetails(pokemon);
    }

    function displayPokemonDetails(pokemon) {
        pokemonDetailsPage.innerHTML = `
            <h1>${pokemon.name}</h1>
            <img src="${pokemon.sprites.front_default}" alt="${pokemon.name}">
            <p>Level: ${pokemon.base_experience}</p>
            <p>Tipo: ${pokemon.types.map(type => type.type.name).join(', ')}</p>
            <p>Altura: ${pokemon.height}</p>
            <p>Peso: ${pokemon.weight}</p>
        `;
    }

    if (pokemonId) {
        fetchPokemonDetails(pokemonId);
    } else {
        pokemonDetailsPage.innerHTML = `<p>No se encontró información del Pokémon.</p>`;
    }
});