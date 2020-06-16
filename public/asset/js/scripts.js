// On attend que le DOM soit chargé
window.onload = () => {

  let password = document.querySelector("[name=password]") ;
  let confirmPassword = document.querySelector("[name=confirmPassword]") ;
  confirmPassword.addEventListener("keyup", checkPw) ;
  password.addEventListener("keyup", checkPw);

  // On écoute le clic sur l'oeil
  let oeil = document.querySelector("#eye");
  oeil.addEventListener("click", changeType);

  let oeil2 = document.querySelector("#eye2");
  oeil2.addEventListener("click", changeType);

  let yeux = document.querySelectorAll("i") ;

  //On parcourt les balises i (yeux)
  for (let ligne = 0; ligne < yeux.length ; ligne++){
      // On ajoute l'écouteur "click" sur l'oeil en cours correspondant à la ligne sur laquelle on se trouve
      yeux[ligne].addEventListener("click", changeType) ;
  }

  // Verif firstname
  let firstname = document.querySelector("#firstname") ;
  firstname.addEventListener("keyup", changeColor);

  // Verif lastname
  let lastname = document.querySelector("#lastname") ;
  lastname.addEventListener("keyup", changeColor);

  // Verif pseudo
   let pseudo = document.querySelector("#pseudo") ;
   pseudo.addEventListener("keyup", changeColor);

   // Verif email
   let email = document.querySelector("#email") ;
   email.addEventListener("keyup", validateEmail);

} // fin de window.onload

function checkPw () {

  if (password.value != confirmPassword.value) {
      confirmPassword.style.border = "3px solid red" ;
      password.style.border = "3px solid red" ;
  } else {
      confirmPassword.style.border = "3px solid green" ;
      password.style.border = "3px solid green" ;
  }
}

/**
*  Cette fonction change le type de password à text et inversement
*/
function changeType () {
  //On va chercher la balise qui précède l'oeil dans le html
  let input = this.previousElementSibling;

  if (input.getAttribute("type") == "text"){
      input.setAttribute("type", "password") ;
  } else {
      input.setAttribute("type", "text") ;
  }

}

/**
*  Cette fonction change la couleur de l'input FIRSTNAME , LASTNAME, PSEUDO en tapant
*/
function changeColor () {

  if (firstname.value.length >= 3 & firstname.value.length <= 20){
      firstname.style.border = "3px solid green" ;
  } else {
    firstname.style.border = "3px solid red" ;
  }

  if (lastname.value.length >= 3 & lastname.value.length <= 20){
    lastname.style.border = "3px solid green" ;
  } else {
    lastname.style.border = "3px solid red" ;
  }

  if (pseudo.value.length >= 3 & pseudo.value.length <= 20){
    pseudo.style.border = "3px solid green" ;
  } else {
    pseudo.style.border = "3px solid red" ;
  }
}

function validateEmail(emailField){
  var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
  let email = document.querySelector("#email") ;

  if (reg.test(emailField.value) == false) 
  {
    email.style.border = "3px solid green" ;
    return false;
  } else {
    email.style.border = "3px solid red" ;
    return true;
  }
}

