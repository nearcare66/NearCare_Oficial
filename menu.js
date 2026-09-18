const menuButton = document.querySelector(".menu-icon");
const sideMenu = document.querySelector(".side-menu");
const closeTargets = document.querySelectorAll("[data-close-menu]");

function setMenu(open) {
  document.body.classList.toggle("menu-open", open);
  menuButton?.setAttribute("aria-expanded", String(open));
  sideMenu?.setAttribute("aria-hidden", String(!open));
}

menuButton?.addEventListener("click", () => {
  setMenu(!document.body.classList.contains("menu-open"));
});

closeTargets.forEach((target) => {
  target.addEventListener("click", () => setMenu(false));
});

document.addEventListener("keydown", (event) => {
  if (event.key === "Escape") {
    setMenu(false);
  }
});
