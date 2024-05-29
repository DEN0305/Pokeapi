function toggleSearch() {
  var input = document.querySelector(".search-input");
  input.style.display === "none"
    ? (input.style.display = "inline-block")
    : (input.style.display = "none");
}

document.addEventListener("DOMContentLoaded", () => {
  const pokemonGrid = document.getElementById("pokemon-grid");
  const prevButton = document.getElementById("prevButton");
  const nextButton = document.getElementById("nextButton");
  const currentPageSpan = document.getElementById("currentPage");
  const pageInput = document.getElementById("pageInput");
  const goButton = document.getElementById("goButton");

  let currentPage = 1;
  const loadBatchSize = 20;

  async function fetchPokemonBatch(offset, limit, orderBy) {
    const response = await fetch(
      `https://pokeapi.co/api/v2/pokemon?offset=${offset}&limit=${limit}&order_by=${orderBy}`
    );
    const data = await response.json();
    for (const pokemon of data.results) {
      const pokemonResponse = await fetch(pokemon.url);
      const pokemonData = await pokemonResponse.json();
      displayPokemon(pokemonData);
    }
  }

  botonMostrarPersonalizado.addEventListener("click", function () {
    window.location.href = "../php/mostrarPersonalizado.php";
  });

  botonCrearPokemon.addEventListener("click", function () {
    window.location.href = "../php/crearPokemon.php";
  });

  function displayPokemon(pokemon) {
    const pokemonCard = document.createElement("div");
    pokemonCard.classList.add("pokemon-card");

    const pokemonImage = document.createElement("img");
    pokemonImage.src = pokemon.sprites.front_default;
    pokemonImage.alt = pokemon.name;
    pokemonImage.classList.add("pokemon-image");

    const pokemonDetails = document.createElement("div");
    pokemonDetails.classList.add("pokemon-details");

    pokemonDetails.innerHTML = `
            <h3>${pokemon.name}</h3>
            <p>Level: ${pokemon.base_experience}</p>
            <p>Type:${pokemon.types
              .map((type) => type.type.name)
              .join(", ")}</p>
            <button onclick="location.href='detalles.html?id=${
              pokemon.id
            }'">More details</button>
        `;

    pokemonCard.appendChild(pokemonImage);
    pokemonCard.appendChild(pokemonDetails);

    pokemonGrid.appendChild(pokemonCard);
  }

  function clearPokemonGrid() {
    pokemonGrid.innerHTML = "";
  }

  function loadPage(page) {
    clearPokemonGrid();
    const offset = (page - 1) * loadBatchSize;
    fetchPokemonBatch(offset, loadBatchSize);
    currentPageSpan.textContent = page;
  }

  prevButton.addEventListener("click", () => {
    if (currentPage > 1) {
      currentPage--;
      loadPage(currentPage);
      updateButtons();
    }
  });

  nextButton.addEventListener("click", () => {
    currentPage++;
    loadPage(currentPage);
    updateButtons();
  });

  goButton.addEventListener("click", () => {
    const page = parseInt(pageInput.value);
    if (page >= 1 && page <= Math.ceil(1010 / loadBatchSize)) {
      currentPage = page;
      loadPage(currentPage);
      updateButtons();
    } else {
      alert("Número de página no válido.");
    }
  });

  function updateButtons() {
    prevButton.disabled = currentPage === 1;
    nextButton.disabled = currentPage * loadBatchSize >= 1010;
  }

  loadPage(currentPage);
  updateButtons();
});
