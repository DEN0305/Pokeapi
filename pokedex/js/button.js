document.addEventListener("DOMContentLoaded", () => {
  const botonMostrarPersonalizado = document.getElementById(
    "botonMostrarPersonalizado"
  );

  const botonHome = document.getElementById("botonHome");

  const botonCrearPokemon = document.getElementById("botonCrearPokemon");

  botonMostrarPersonalizado.addEventListener("click", function () {
    window.location.href = "../php/mostrarPersonalizado.php";
  });

  botonCrearPokemon.addEventListener("click", function () {
    window.location.href = "../php/crearPokemon.php";
  });

  botonHome.addEventListener("click", function () {
    window.location.href = "../pages/main.html";
  });
});
