import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "./styles/app.css";
import "flowbite";
import "@fortawesome/fontawesome-free/css/all.min.css";
// import "@fortawesome/fontawesome-free/js/all.min.js";

//#region Autodetect dark mode

// On page load or when changing themes, best to add inline in `head` to avoid FOUC
if (
	localStorage.theme === "dark" ||
	(!("theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches)
) {
	document.documentElement.classList.add("dark");
} else {
	document.documentElement.classList.remove("dark");
}

//#endregion

//#region Toggle dark mode

var themeToggleDarkIcon = document.getElementById("theme-toggle-dark-icon");
var themeToggleLightIcon = document.getElementById("theme-toggle-light-icon");

// Change the icons inside the button based on previous settings
if (
	localStorage.getItem("color-theme") === "dark" ||
	(!("color-theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches)
) {
	themeToggleLightIcon.classList.remove("hidden");
} else {
	themeToggleDarkIcon.classList.remove("hidden");
}

var themeToggleBtn = document.getElementById("theme-toggle");

themeToggleBtn.addEventListener("click", function () {
	// toggle icons inside button
	themeToggleDarkIcon.classList.toggle("hidden");
	themeToggleLightIcon.classList.toggle("hidden");

	// if set via local storage previously
	if (localStorage.getItem("color-theme")) {
		if (localStorage.getItem("color-theme") === "light") {
			document.documentElement.classList.add("dark");
			localStorage.setItem("color-theme", "dark");
		} else {
			document.documentElement.classList.remove("dark");
			localStorage.setItem("color-theme", "light");
		}

		// if NOT set via local storage previously
	} else {
		if (document.documentElement.classList.contains("dark")) {
			document.documentElement.classList.remove("dark");
			localStorage.setItem("color-theme", "light");
		} else {
			document.documentElement.classList.add("dark");
			localStorage.setItem("color-theme", "dark");
		}
	}
});

//#endregion
