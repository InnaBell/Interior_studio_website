//---------Slider Funktion (Main Page)---------------//

let offset = 0; // Verschiebung
let carouselItems = document.querySelector(".carousel__items");
let totalSlides = document.querySelectorAll(".carousel-item").length;
let slidesInViewport = window.innerWidth <= 991.98 ? 2 : 3; // 2 oder 3 Slides in Viewport?
let slideWidth = 33.33; // Standardbreite jedes Slides
let interval = setInterval(slideForward, 3000); // Auto-Play Funktion

if (window.innerWidth <= 991.98) {
  slideWidth = 50; // Wenn der Bildschirm kleiner als 991.98px ist: slideWidth = 50vw
}

function slideForward() {
  offset = offset - slideWidth; // offset verschieben
  // ob das Ende des Karussells erreicht ist
  if (-offset > (totalSlides - slidesInViewport) * slideWidth) {
    offset = 0; // zum ersten Slide
  }
  carouselItems.style.left = offset + "vw";
}

function slideBackward() {
  offset = offset + slideWidth;
  if (-offset < 0) {
    offset = -((totalSlides - slidesInViewport) * slideWidth); // zum letzten Slide
  }
  carouselItems.style.left = offset + "vw";
}

// Play/Pause Buttons wechseln und aktivieren
let buttonPause = document.querySelector(".button__pause");
let buttonPlay = document.querySelector(".button__play");
document.querySelector(".button__pause").addEventListener("click", function () {
  buttonPause.style.display = "none";
  buttonPlay.style.display = "block";
  clearInterval(interval);
});
document.querySelector(".button__play").addEventListener("click", function () {
  buttonPlay.style.display = "none";
  buttonPause.style.display = "block";
  interval = setInterval(slideForward, 3000);
});

// Event-Listener für die "Nach rechts" Taste
document
  .querySelector(".carousel__btn-right")
  .addEventListener("click", function () {
    slideForward();
    clearInterval(interval); // Interval zurücksetzen wenn wir "Nach rechts" drücken
    buttonPause.style.display = "none";
    buttonPlay.style.display = "block";
  });
// Event-Listener für die "Nach links" Taste
document
  .querySelector(".carousel__btn-left")
  .addEventListener("click", function () {
    slideBackward();
    clearInterval(interval); // Interval zurücksetzen wenn wir "Nach links" drücken
    buttonPause.style.display = "none";
    buttonPlay.style.display = "block";
  });
