import './styles/global/herobar.css';
import './styles/global/footer.css';
import './styles/global/global.css';

document.getElementById ("loginBtn").addEventListener ("click", connexion, false);
document.getElementById ("signUpBtn").addEventListener ("click", inscription, false);
document.getElementById("overlay").addEventListener("click", overlay, false);

let signIn = document.getElementById("connexionPopUp").style.display;
let signUp = document.getElementById("inscriptionPopUp").style.display;

function connexion() {
  if (signIn != "block") {
    connexionPopUp("block", "block");
  } else {
    connexionPopUp("none", "none");
  }
}

function inscription() {
  if (signUp != "block") {
    inscriptionPopUp("block", "block");
  } else {
    inscriptionPopUp("none", "none");
  }
}

function overlay() {
  if (document.getElementById("connexionPopUp").style.display == "block") {
    document.getElementById("connexionPopUp").style.display = "none";
    document.getElementById("overlay").style.display = "none";
    document.body.style.overflow = "auto";
  }
  if (document.getElementById("inscriptionPopUp").style.display == "block") {
    document.getElementById("inscriptionPopUp").style.display = "none";
    document.getElementById("overlay").style.display = "none";
    document.body.style.overflow = "auto";
  }
}

function connexionPopUp(popup, overlay) {
  document.getElementById("connexionPopUp").style.display = popup;
  document.getElementById("overlay").style.display = overlay;
  document.body.style.overflow = "hidden";
}

function inscriptionPopUp(popup, overlay) {
  document.getElementById("inscriptionPopUp").style.display = popup;
  document.getElementById("overlay").style.display = overlay;
  document.body.style.overflow = "hidden";
}
