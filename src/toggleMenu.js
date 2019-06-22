function toggleMenu() {
  var x = document.getElementById("nav");
  if (x.className === "nav") {
      x.className += " responsive";
  } else {
      x.className = "nav";
  }
}