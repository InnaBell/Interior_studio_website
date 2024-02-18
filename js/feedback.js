//---------Datenbankabfrage (Feedback Page)---------------//
getData();

// Asynchrone Funktion um Daten zu bekommen
async function getData() {
  // Keine Verbindung, Datei nicht gefunden usw
  try {
    const response = await fetch("js/data.json");
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    const data = await response.json();
    displayPosts(data);
  } catch (error) {
    console.error("Could not fetch the data: ", error.message);
  }
}

// Function zum Anzeigen von Posts
function displayPosts(data) {
  const postsContainer = document.querySelector(".testimonials");

  // Durchläuft die Daten
  data.forEach((post) => {
    const postContainer = document.createElement("div"); // erstellt für jeden Post einen Container
    postContainer.classList.add("testimonials__item");
    const postTemplate = `
		<div class="testimonials__image">
		<img src="${post.image}" alt="Foto des Kunden">
		</div>
		
		<div class="testimonials__text-side">
		
		<div class="testimonials__quote-left"><svg xmlns="http://www.w3.org/2000/svg" width="42"
		height="32" viewBox="0 0 42 32" fill="none">
		<path
		d="M0.45459 32V23.2727C0.45459 20.697 0.939438 17.9849 1.90914 15.1364C2.87883 12.2879 4.22732 9.56061 5.95459 6.95455C7.68186 4.34849 9.71217 2.12122 12.0455 0.272736L18.7728 5.09091C16.9243 7.78788 15.3485 10.6061 14.0455 13.5455C12.7425 16.4849 12.091 19.6818 12.091 23.1364V32H0.45459ZM23.6364 32V23.2727C23.6364 20.697 24.1213 17.9849 25.091 15.1364C26.0607 12.2879 27.4091 9.56061 29.1364 6.95455C30.8637 4.34849 32.894 2.12122 35.2273 0.272736L41.9546 5.09091C40.1061 7.78788 38.5304 10.6061 37.2273 13.5455C35.9243 16.4849 35.2728 19.6818 35.2728 23.1364V32H23.6364Z"
		fill="#E06337" fill-opacity="0.95" />
		</svg></div>
		
		<div class="testimonials__body">
		<h5 class="text-side__title">${post.title}</h5>
		<h6 class="text-side__autor">${post.name} <span>${post.tags}</span></h6>
		<p class="text-side__comment">${post.body}</p>
		</div>
		
		<div class="testimonials__quote-right"><svg xmlns="http://www.w3.org/2000/svg"
		width="42" height="33" viewBox="0 0 42 33" fill="none">
		<path
		d="M18.8181 0.909058V9.63633C18.8181 12.2121 18.3333 14.9242 17.3636 17.7727C16.4242 20.5909 15.0909 23.303 13.3636 25.9091C11.6363 28.5151 9.60602 30.7575 7.27268 32.6363L0.54541 27.8181C2.33329 25.2121 3.87874 22.4394 5.18177 19.5C6.51511 16.5606 7.18177 13.3181 7.18177 9.7727V0.909058H18.8181ZM41.9545 0.909058V9.63633C41.9545 12.2121 41.4697 14.9242 40.5 17.7727C39.5606 20.5909 38.2272 23.303 36.5 25.9091C34.7727 28.5151 32.7424 30.7575 30.409 32.6363L23.6818 27.8181C25.4697 25.2121 27.0151 22.4394 28.3181 19.5C29.6515 16.5606 30.3181 13.3181 30.3181 9.7727V0.909058H41.9545Z"
		fill="#E06337" fill-opacity="0.95" />
		</svg></div>
		</div>`;
    postContainer.innerHTML = postTemplate;
    postsContainer.appendChild(postContainer);
  });
}
