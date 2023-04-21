// function([string1, string2],target id,[color1,color2])    
consoleText(['Bienvenue chez MadaVente', 'Découvrez notre séléction à petit prix', 'On attendait que vous !!!'], 'text', ['tomato', 'tomato', 'tomato']);

function consoleText(words, id, colors) {
  if (colors === undefined) colors = ['#fff'];
  var visible = true;
  var con = document.getElementById('console');
  var letterCount = 1;
  var x = 1;
  var waiting = false;
  var target = document.getElementById(id)
  target.setAttribute('style', 'color:' + colors[0])
  window.setInterval(function () {

    if (letterCount === 0 && waiting === false) {
      waiting = true;
      target.innerHTML = words[0].substring(0, letterCount)
      window.setTimeout(function () {
        var usedColor = colors.shift();
        colors.push(usedColor);
        var usedWord = words.shift();
        words.push(usedWord);
        x = 1;
        target.setAttribute('style', 'color:' + colors[0])
        letterCount += x;
        waiting = false;
      }, 1000)
    } else if (letterCount === words[0].length + 1 && waiting === false) {
      waiting = true;
      window.setTimeout(function () {
        x = -1;
        letterCount += x;
        waiting = false;
      }, 1000)
    } else if (waiting === false) {
      target.innerHTML = words[0].substring(0, letterCount)
      letterCount += x;
    }
  }, 120)
  window.setInterval(function () {
    if (visible === true) {
      // con.className = 'console-underscore hidden'
      visible = false;

    } else {
      // con.className = 'console-underscore hidden'

      visible = true;
    }
  }, 400)
}

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


