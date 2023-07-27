import './bootstrap';

window.Swal = require('sweetalert2');


document.body.style="background-color: var(--bs-dark);transition: 0.5s;"
const sun = "bi-sun";
const moon = "bi-moon-stars"

var theme = "light";
const root = document.querySelector(":root");
const container = document.getElementsByClassName("theme-container")[0];
const themeIcon = document.getElementById("theme-icon");
const navb = document.getElementById("navb");
container.addEventListener("click", setTheme);

function setTheme() {
    switch (theme) {
        case "dark":
            setLight();
            theme = "light";
            break;
        case "light":
            setDark();
            theme = "dark";
            break;
    }
}

function setLight() {
    root.style.setProperty(
        "--bs-dark",
        "rgb(242, 255, 255)"
    );
    container.classList.remove("shadow-dark");
    themeIcon.classList.remove(moon);
    navb.classList.remove("nav-dark");
    setTimeout(() => {
        container.classList.add("shadow-light");
        themeIcon.classList.remove("change");
    }, 300);
    themeIcon.classList.add("change");
    navb.classList.add("nav-light");
    themeIcon.classList.add(sun);
}

function setDark() {
    root.style.setProperty("--bs-dark", "#212529");
    container.classList.remove("shadow-light");
    themeIcon.classList.remove(sun);
    navb.classList.remove("nav-light");
    setTimeout(() => {
        container.classList.add("shadow-dark");
        themeIcon.classList.remove("change");
    }, 300);
    themeIcon.classList.add("change");
    navb.classList.add("nav-dark");
    themeIcon.classList.add(moon);
}