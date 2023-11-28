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
