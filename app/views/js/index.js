/*!
 * Color mode toggler for Bootstrap's docs (https://getbootstrap.com/)
 * Copyright 2011-2022 The Bootstrap Authors
 * Licensed under the Creative Commons Attribution 3.0 Unported License.
 */

(() => {
  "use strict";

  // Obtener el tema almacenado localmente
  const storedTheme = localStorage.getItem("theme");

  // Obtener el tema preferido
  const getPreferredTheme = () => {
    if (storedTheme) {
      return storedTheme;
    }

    return window.matchMedia("(prefers-color-scheme: dark)").matches
      ? "dark"
      : "light";
  };

  // Establecer el tema en el documento
  const setTheme = function (theme) {
    if (
      theme === "auto" &&
      window.matchMedia("(prefers-color-scheme: dark)").matches
    ) {
      document.documentElement.setAttribute("data-bs-theme", "dark");
    } else {
      document.documentElement.setAttribute("data-bs-theme", theme);
    }
  };

  // Establecer el tema preferido al cargar la página
  setTheme(getPreferredTheme());

  // Mostrar el tema activo
  const showActiveTheme = (theme) => {
    const activeThemeIcon = document.querySelector(".theme-icon-active use");
    const btnToActive = document.querySelector(
      `[data-bs-theme-value="${theme}"]`
    );
    const svgOfActiveBtn = btnToActive
      .querySelector("svg use")
      .getAttribute("href");

    // Remover la clase "active" de todos los elementos de cambio de tema
    document.querySelectorAll("[data-bs-theme-value]").forEach((element) => {
      element.classList.remove("active");
    });

    // Agregar la clase "active" al botón activo
    btnToActive.classList.add("active");
    // Establecer el atributo "href" del ícono activo
    activeThemeIcon.setAttribute("href", svgOfActiveBtn);
  };

  // Cambiar el tema cuando cambia la preferencia del sistema
  window
    .matchMedia("(prefers-color-scheme: dark)")
    .addEventListener("change", () => {
      if (storedTheme !== "light" || storedTheme !== "dark") {
        setTheme(getPreferredTheme());
      }
    });

  // Configurar el tema al cargar la página
  window.addEventListener("DOMContentLoaded", () => {
    // Mostrar el tema activo al cargar la página
    showActiveTheme(getPreferredTheme());

    // Agregar eventos de clic a los elementos de cambio de tema
    document.querySelectorAll("[data-bs-theme-value]").forEach((toggle) => {
      toggle.addEventListener("click", () => {
        const theme = toggle.getAttribute("data-bs-theme-value");
        localStorage.setItem("theme", theme);
        setTheme(theme);
        showActiveTheme(theme);
      });
    });
  });
})();
