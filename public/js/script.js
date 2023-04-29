let email = document.getElementById('email')
let subject = document.getElementById('subject')
let msg = document.getElementById('msg')
let valider = document.getElementById('valider')

// regex pour l'email
let regex_email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;


/**
 * Methode appelé en cas de succes.
 * @param {string} inputName 
 * @returns 
 */
const succes = (inputName) => {
  document.getElementById(`sucess_${inputName}`).innerHTML = `
      <img src="./img/verifier.png" width="15"/>
    `
  refreshError(inputName)
}

/**
 * Methode appelé en cas d'error.
 * @param {string} inputName 
 * @param {string} message 
 */
const error = (inputName, message) => {
  return document.getElementById(`error_${inputName}`).innerHTML = `
      <p class='error'>${message}</p>
    `
}

/**
 * Methode qui efface les messages d'erreurs.
 * @param {string} inputName 
 * @returns 
 */
const refreshError = (inputName) => {
  return document.getElementById(`error_${inputName}`).innerHTML = ''
}

/**
 * Event Click
 */

button.addEventListener('click', (event) => {
  event.preventDefault();

  if (email.value === "") {
    error("email", "Champ vide !")
  }
  else if (!regex_email.test(email.value)) {
    error("email", "Error email")
  }
  else {
    succes("email")
  }

  if (message.value === "") {
    error("message", "Champ vide !")
  }
  else {
    succes("message")
  }


});

// Récupérer l'élément div par son ID
var info = document.getElementById("info");

// Attacher un événement de clic à l'élément div
info.addEventListener("click", function () {
  // Rediriger l'utilisateur vers l'URL souhaitée
  window.location.href = "{{ path('detail_article', { 'id' : item.id } ) }}";
});


anime({
  targets: '.row svg',
  translateY: 10,
  autoplay: true,
  loop: true,
  easing: 'easeInOutSine',
  direction: 'alternate'
});

anime({
  targets: '#zero',
  translateX: 10,
  autoplay: true,
  loop: true,
  easing: 'easeInOutSine',
  direction: 'alternate',
  scale: [{value: 1}, {value: 1.4}, {value: 1, delay: 250}],
    rotateY: {value: '+=180', delay: 200},
});



