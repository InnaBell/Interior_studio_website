//---------Formularvalidierung (Kontakt Page)---------------//

// Validierung beim Absenden des Formulars
// ein Event-Listener für die Submit-Button
document.querySelector("#submit").addEventListener("click", validateForm);

function validateForm(event) {
  event.preventDefault(); // verbieten, Seite neu zu laden

  // Fehlermeldungen entfernen
  document
    .querySelectorAll(".form__error")
    .forEach((element) => element.remove());

  let dataFromUser = {}; // eine Variable für Daten von Benutzer
  let validationErrors = {}; // eine Variable für Validierungsfehler

  // Werte aus den Formularfeldern speichern
  dataFromUser.title = document.querySelector("#title-01").value;
  dataFromUser.firstName = document.querySelector("#first-name-01").value;
  dataFromUser.lastName = document.querySelector("#last-name-01").value;
  dataFromUser.place = document.querySelector("#place-01").value;
  dataFromUser.address = document.querySelector("#address-01").value;
  dataFromUser.postalCode = document.querySelector("#postal-code-01").value;
  dataFromUser.email = document.querySelector("#email-01").value;
  dataFromUser.message = document.querySelector("#message-01").value;

  // ob eine Anrede ausgewählt wurde
  if (!dataFromUser.title) {
    validationErrors.title = "Wählen Sie bitte eine Anrede aus";
  }

  // ob der Vorname eingegeben wurde
  if (!dataFromUser.firstName) {
    validationErrors.firstName = "Geben Sie bitte Ihren Vornamen ein";
  } else {
    if (dataFromUser.firstName.length === 1) {
      validationErrors.firstName = "Geben Sie bitte Ihren vollen Vornamen ein";
    }
  }

  // ob der Nachname eingegeben wurde
  if (!dataFromUser.lastName) {
    validationErrors.lastName = "Geben Sie bitte Ihren Nachnamen ein";
  } else {
    if (dataFromUser.lastName.length === 1) {
      validationErrors.lastName = "Geben Sie bitte Ihren vollen Nachnamen ein";
    }
  }

  // ob die Stadt richtig eingegeben wurde
  if (dataFromUser.place) {
    const cityRegExp = /^[A-Za-züÜäÄöÖß\s-]+$/; // regular expression for city
    if (!cityRegExp.test(dataFromUser.place)) {
      validationErrors.place = "Geben Sie bitte einen gültigen Stadtnamen ein";
    }
  }

  // ob die Email eingegeben wurde
  if (!dataFromUser.email) {
    validationErrors.email = "Geben Sie bitte Ihre E-mail-Adresse ein";
  } else {
    const emailRegExp =
      /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/; // regular expression for email

    // ob die E-Mail-Adresse dem Muster entspricht
    if (!emailRegExp.test(dataFromUser.email)) {
      validationErrors.email =
        "Geben Sie bitte eine gültige E-Mail-Adresse ein";
    }
  }

  // ob eine Nachricht die maximale Länge nicht überschreitet
  if (dataFromUser.message) {
    if (dataFromUser.message.length > 300) {
      validationErrors.message =
        "Ihre Nachricht ist zu lang (max. 300 Zeichen)";
    }
  }

  // Daten an den Server senden
  if (Object.keys(validationErrors).length > 0) {
    displayError(validationErrors); // Fehler anzeigen
  } else {
    if (dataFromUser.title) {
      console.info("Title: ", dataFromUser.title);
    }
    if (dataFromUser.firstName) {
      console.info("First name: ", dataFromUser.firstName);
    }
    if (dataFromUser.lastName) {
      console.info("Last name: ", dataFromUser.lastName);
    }
    if (dataFromUser.place) {
      console.info("Place: ", dataFromUser.place);
    }
    if (dataFromUser.address) {
      console.info("Address: ", dataFromUser.address);
    }
    if (dataFromUser.postalCode) {
      console.info("Postal code: ", dataFromUser.postalCode);
    }
    if (dataFromUser.email) {
      console.info("Email: ", dataFromUser.email);
    }
    if (dataFromUser.message) {
      console.info("Message: ", dataFromUser.message);
    }
    console.info("Daten an den Server gesendet");
    // Formular leeren
    document.querySelector("#title-01").value = "";
    document.querySelector("#first-name-01").value = "";
    document.querySelector("#last-name-01").value = "";
    document.querySelector("#place-01").value = "";
    document.querySelector("#address-01").value = "";
    document.querySelector("#postal-code-01").value = "";
    document.querySelector("#email-01").value = "";
    document.querySelector("#message-01").value = "";

    openModal(); // Modal-Fenster 'Danke für Ihre nachricht'
  }
}

// Fehler in den Formular hinzufügen
function displayError(validationErrors) {
  if (validationErrors.title) {
    const newErrorContainer = document.createElement("span");
    newErrorContainer.innerHTML = validationErrors.title;
    newErrorContainer.classList.add("form__error");
    document.querySelector("#title-01").after(newErrorContainer);
  }

  if (validationErrors.firstName) {
    const newErrorContainer = document.createElement("span");
    newErrorContainer.innerHTML = validationErrors.firstName;
    newErrorContainer.classList.add("form__error");
    document.querySelector("#first-name-01").after(newErrorContainer);
  }

  if (validationErrors.lastName) {
    const newErrorContainer = document.createElement("span");
    newErrorContainer.innerHTML = validationErrors.lastName;
    newErrorContainer.classList.add("form__error");
    document.querySelector("#last-name-01").after(newErrorContainer);
  }

  if (validationErrors.place) {
    const newErrorContainer = document.createElement("span");
    newErrorContainer.innerHTML = validationErrors.place;
    newErrorContainer.classList.add("form__error");
    document.querySelector("#place-01").after(newErrorContainer);
  }

  if (validationErrors.email) {
    const newErrorContainer = document.createElement("span");
    newErrorContainer.innerHTML = validationErrors.email;
    newErrorContainer.classList.add("form__error");
    document.querySelector("#email-01").after(newErrorContainer);
  }

  if (validationErrors.message) {
    const newErrorContainer = document.createElement("span");
    newErrorContainer.innerHTML = validationErrors.message;
    newErrorContainer.classList.add("form__error");
    document.querySelector("#message-01").after(newErrorContainer);
  }
}

// Formularvalidierung des jeweiligen Feldes beim 'focusout event'
// Event-Listeners für die Inputs
document.querySelector("#title-01").addEventListener("focusout", validateTitle);
document
  .querySelector("#first-name-01")
  .addEventListener("focusout", validateFirstName);
document
  .querySelector("#last-name-01")
  .addEventListener("focusout", validateLastName);
document.querySelector("#place-01").addEventListener("focusout", validatePlace);
document.querySelector("#email-01").addEventListener("focusout", validateEmail);
document
  .querySelector("#message-01")
  .addEventListener("focusout", validateMessage);

// Validierung des Feldes 'Anrede'
function validateTitle(event) {
  document
    .querySelectorAll(".form__error")
    .forEach((element) => element.remove());

  let validationErrors = {};
  let dataFromUser = document.querySelector("#title-01").value;
  if (!dataFromUser) {
    validationErrors.title = "Wählen Sie bitte eine Anrede aus";
  }

  if (Object.keys(validationErrors).length > 0) {
    displayError(validationErrors);
  }
}

// Validierung des Feldes 'Vorname'
function validateFirstName(event) {
  document
    .querySelectorAll(".form__error")
    .forEach((element) => element.remove());

  let validationErrors = {};
  let dataFromUser = document.querySelector("#first-name-01").value;
  if (!dataFromUser) {
    validationErrors.firstName = "Geben Sie bitte Ihren Vornamen ein";
  } else {
    if (dataFromUser.length === 1) {
      validationErrors.firstName = "Geben Sie bitte Ihren vollen Vornamen ein";
    }
  }

  if (Object.keys(validationErrors).length > 0) {
    displayError(validationErrors);
  }
}

// Validierung des Feldes 'Nachname'
function validateLastName(event) {
  document
    .querySelectorAll(".form__error")
    .forEach((element) => element.remove());

  let validationErrors = {};
  let dataFromUser = document.querySelector("#last-name-01").value;
  if (!dataFromUser) {
    validationErrors.lastName = "Geben Sie bitte Ihren Nachnamen ein";
  } else {
    if (dataFromUser.length === 1) {
      validationErrors.lastName = "Geben Sie bitte Ihren vollen Nachnamen ein";
    }
  }

  if (Object.keys(validationErrors).length > 0) {
    displayError(validationErrors);
  }
}

// Validierung des Feldes 'Place'
function validatePlace(event) {
  document
    .querySelectorAll(".form__error")
    .forEach((element) => element.remove());

  let validationErrors = {};
  let dataFromUser = document.querySelector("#place-01").value;

  if (dataFromUser) {
    const cityRegExp = /^[^\d]+$/;
    if (!cityRegExp.test(dataFromUser)) {
      validationErrors.place = "Geben Sie bitte einen gültigen Stadtnamen ein";
    }
  }

  if (Object.keys(validationErrors).length > 0) {
    displayError(validationErrors);
  }
}

// Validierung des Feldes 'Email'
function validateEmail(event) {
  document
    .querySelectorAll(".form__error")
    .forEach((element) => element.remove());

  let validationErrors = {};
  let dataFromUser = document.querySelector("#email-01").value;

  if (!dataFromUser) {
    validationErrors.email = "Geben Sie bitte Ihre E-mail-Adresse ein";
  } else {
    const emailRegExp =
      /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    if (!emailRegExp.test(dataFromUser)) {
      validationErrors.email =
        "Geben Sie bitte eine gültige E-Mail-Adresse ein";
    }
  }

  if (Object.keys(validationErrors).length > 0) {
    displayError(validationErrors);
  }
}

// Validierung des Feldes 'Message'
function validateMessage(event) {
  document
    .querySelectorAll(".form__error")
    .forEach((element) => element.remove());

  let validationErrors = {};
  let dataFromUser = document.querySelector("#message-01").value;

  if (dataFromUser) {
    if (dataFromUser.length > 300) {
      validationErrors.message =
        "Ihre Nachricht ist zu lang (max. 300 Zeichen)";
    }
  }

  if (Object.keys(validationErrors).length > 0) {
    displayError(validationErrors);
  }
}

// Modal-Fenster 'Danke für Ihre nachricht'
let modalActive = false;
function openModal() {
  modalActive = true;
  const container = document.createElement("div");
  let template = `
  <span class="modal__close" onclick="closeModal()">&times;</span>
  <p>Danke für Ihre Nachricht!</p>`;
  container.classList.add("modal");
  container.innerHTML = template;
  document.querySelector(".request__form").append(container);

  document.addEventListener("click", clickOutsideModal);
}

function closeModal() {
  modalActive = false;
  const modal = document.querySelector(".modal");
  if (modal) {
    modal.remove();
  }
}

function clickOutsideModal(event) {
  document.addEventListener("click", (e) => {
    if (modalActive) {
      closeModal();
    }
  });
}
