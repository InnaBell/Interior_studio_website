// Burger-Menu
document.addEventListener("click", function (e) {
  const targetElement = e.target;

  if (targetElement.closest(".header__burger")) {
    document.documentElement.classList.toggle("burger__open"); // Klasse wird dem html-Element hinzugefügt
    // gleichzeitig die Styles anderer Elemente (Burger icon) ändern
    e.preventDefault();
  }
});

// Burger-Menu mit einem Outside-Klick schließen
document.addEventListener("click", function (e) {
  const targetElement = e.target;
  const burgerMenu = document.querySelector(".header__menu-container");
  const burgerButton = document.querySelector(".header__burger");

  const clickInsideMenu =
    burgerMenu.contains(targetElement) || burgerButton.contains(targetElement);

  if (!clickInsideMenu) {
    document.documentElement.classList.remove("burger__open");
  }
});
