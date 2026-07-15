(function () {
  const storageKey = "nearcare-dark-mode";

  function isDarkMode() {
    return localStorage.getItem(storageKey) === "1";
  }

  function applyDarkMode(enabled) {
    document.documentElement.classList.toggle("dark-mode", enabled);
    const button = document.querySelector("[data-dark-mode-toggle]");

    if (button) {
      button.textContent = enabled ? "Modo claro" : "Modo oscuro";
      button.setAttribute("aria-pressed", enabled ? "true" : "false");
    }
  }

  applyDarkMode(isDarkMode());

  document.addEventListener("DOMContentLoaded", function () {
    applyDarkMode(isDarkMode());

    const button = document.querySelector("[data-dark-mode-toggle]");

    if (!button) {
      return;
    }

    button.addEventListener("click", function () {
      const enabled = !document.documentElement.classList.contains("dark-mode");
      localStorage.setItem(storageKey, enabled ? "1" : "0");
      applyDarkMode(enabled);
    });
  });
})();
