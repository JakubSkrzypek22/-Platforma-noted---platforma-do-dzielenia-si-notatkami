(function() {
    // Get stored theme or default to system
    const storedTheme = localStorage.getItem("theme") || "system";
    applyThemeData(storedTheme);
})();

// Helper function to apply theme data-bs-theme attribute
function applyThemeData(theme) {
    const htmlEl = document.querySelector("html");
    if (!htmlEl) return;
    if (theme === "system") {
        const isDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
        htmlEl.dataset.bsTheme = isDark ? "dark" : "light";
    } else {
        htmlEl.dataset.bsTheme = theme;
    }
}

// Function to set and save a theme
function setTheme(theme) {
    localStorage.setItem("theme", theme);
    applyThemeData(theme);
    updateThemeSelectorUI(theme);
}

// Function to update the dropdown indicator in navbar
function updateThemeSelectorUI(theme) {
    const iconActive = document.getElementById("theme-icon-active");
    const textActive = document.getElementById("theme-text-active");
    if (!iconActive || !textActive) return;

    // Define indicators
    const themeMeta = {
        light: { icon: "bi-sun-fill", text: "Jasny" },
        dark: { icon: "bi-moon-stars-fill", text: "Ciemny" },
        beige: { icon: "bi-palette-fill", text: "Kremowy" },
        system: { icon: "bi-circle-half", text: "Systemowy" }
    };

    const current = themeMeta[theme] || themeMeta.system;
    
    // Reset classes
    iconActive.className = `bi ${current.icon} me-2`;
    // If it's the beige theme, add style color
    if (theme === "beige") {
        iconActive.style.color = "#c2593f";
    } else {
        iconActive.style.color = "";
    }
    textActive.innerText = current.text;

    // Update active state inside dropdown list
    const items = document.querySelectorAll("[data-theme-value]");
    items.forEach(item => {
        if (item.getAttribute("data-theme-value") === theme) {
            item.classList.add("active");
        } else {
            item.classList.remove("active");
        }
    });
}

// Listen for system preference changes dynamically
window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", () => {
    const storedTheme = localStorage.getItem("theme") || "system";
    if (storedTheme === "system") {
        applyThemeData("system");
    }
});

// Setup selector UI when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    const storedTheme = localStorage.getItem("theme") || "system";
    updateThemeSelectorUI(storedTheme);
});
