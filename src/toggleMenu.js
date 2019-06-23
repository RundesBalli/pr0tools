function toggleMenu() {
  var x = document.getElementById("nav");
  if (x.className === "nav") {
      x.className += " responsive";
  } else {
      x.className = "nav";
  }
}

document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('toggle').addEventListener('click', toggleMenu);
});
