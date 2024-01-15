const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");
const loginForm = document.querySelector(".sign-in-form");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});

loginForm.addEventListener("submit", (event) => {
  event.preventDefault();

  // Add the logic to redirect to "page_d’acceuil.html"
  window.location.replace("file:///Users/andreas/Documents/ASPE/Site%20Web%232/index%20+%20connecter.html");
});
