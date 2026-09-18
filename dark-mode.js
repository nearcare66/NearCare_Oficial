(function () {
  const storageKey = "nearcare-dark-mode";

  function isDarkMode() {
    return localStorage.getItem(storageKey) === "1";
  }

  function applyDarkMode(enabled) {
    document.documentElement.classList.toggle("dark-mode", enabled);
    const buttons = document.querySelectorAll("[data-dark-mode-toggle]");

    buttons.forEach(function (button) {
      button.setAttribute("aria-pressed", enabled ? "true" : "false");
      button.setAttribute("aria-label", enabled ? "Activar modo claro" : "Activar modo oscuro");
      button.setAttribute("title", enabled ? "Modo claro" : "Modo oscuro");
      button.classList.toggle("is-dark", enabled);

      const accessibleText = button.querySelector("[data-dark-mode-label]");
      if (accessibleText) {
        accessibleText.textContent = enabled ? "Activar modo claro" : "Activar modo oscuro";
      }
    });
  }

  applyDarkMode(isDarkMode());

  document.addEventListener("DOMContentLoaded", function () {
    applyDarkMode(isDarkMode());

    document.querySelectorAll("[data-dark-mode-toggle]").forEach(function (button) {
      button.addEventListener("click", function () {
        const enabled = !document.documentElement.classList.contains("dark-mode");
        localStorage.setItem(storageKey, enabled ? "1" : "0");
        applyDarkMode(enabled);
      });
    });
  });
})();
