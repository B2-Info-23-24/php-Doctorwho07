function displayError(message) {
  const errorPopup = document.getElementById("errorPopup");
  const errorMessage = document.getElementById("errorMessage");

  errorMessage.textContent = message;
  errorPopup.style.display = "block";
}

function closePopup() {
  const errorPopup = document.getElementById("errorPopup");
  errorPopup.style.display = "none";
}

function displayPopup(message) {
  document.getElementById("errorMessage").innerHTML = message;
  document.getElementById("errorPopup").style.display = "block";
}

function closePopup() {
  document.getElementById("errorPopup").style.display = "none";
}
