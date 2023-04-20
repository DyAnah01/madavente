// // ajouter au panier le panier
// var ajoutPanier = document.getElementById('ajoutPanier')

// // réception rélustat
// var correct = document.getElementById('correct')

// const notifAdd = () => {
//     correct.innerHTML = `<p class="rounded col-md-3 text-center px-5 py-2 bg bg-light"> Ajouté au panier </p>`;        
// }
// ajoutPanier.addEventListener('click', (event) => {
//         event.preventDefault();
//         notifAdd();
// })

/**
 * On target (cible) tous les éléments de notre dom en les affectant a une variable
 * qu'on pourra utiliser pour faire nos conditions.
 * // email
// subject
// message
// valider
 */
let email =  document.getElementById('email')
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

    if(email.value === ""){
        error("email", "Champ vide !")
    }
    else if(!regex_email.test(email.value)){
        error("email", "Error email")
    }
    else{
        succes("email")
    }

    if(message.value === ""){
        error("message", "Champ vide !")
    }
    else{
        succes("message")
    }
    

  });

    // Récupérer l'élément div par son ID
    var info = document.getElementById("info");

    // Attacher un événement de clic à l'élément div
    info.addEventListener("click", function() {
      // Rediriger l'utilisateur vers l'URL souhaitée
      window.location.href = "{{ path('detail_article', { 'id' : item.id } ) }}";
    });


