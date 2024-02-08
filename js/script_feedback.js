//---------Datenbankabfrage (Feedback Page)---------------//
getData();

// Asynchrone Funktion (um Daten zu bekommen)
async function getData() {
  const response = await fetch("js/data.json"); // Fetch-Request
  const data = await response.json();
  displayPosts(data);
}

// Function zum Anzeigen von Posts/Images
function displayPosts(data) {
  // Wir wählen alle Elemente mit der entsprechenden Klasse
  const quoteRight = document.querySelectorAll(".testimonials__quote-right");

  // Durchläuft die Daten
  data.forEach((post, index) => {
    const container = document.createElement("div"); // erstellt für jeden Post einen Container

    const template = `
		<h5 class="text-side__title">${post.title}</h5>
		<h6 class="text-side__autor">${post.name} <span>${post.tags}</span></h6>
		<p class="text-side__comment">${post.body}</p>`;

    container.classList.add("testimonials__body");
    container.innerHTML = template; // Befüllt den Container mit dem Template
    quoteRight[index].before(container); // Fügt den Container vor dem Element mit der Klasse ".testimonials__quote-right"

    // Anzeigen von Images
    const templateImage = `<img src="${post.image}" alt="Foto des Kunden">`;
    const containerMain = document.querySelectorAll(".testimonials__item");
    const div = document.createElement("div");
    div.classList.add("testimonials__image");
    div.innerHTML = templateImage;
    containerMain[index].prepend(div);
  });
}
