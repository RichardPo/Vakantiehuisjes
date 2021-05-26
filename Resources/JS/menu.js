var menuBars = document.querySelector(".menu-bars");
var menu = document.querySelector(".menu");

window.onresize = function () {
    UpdateMenu();
}

window.onload = function () {
    UpdateMenu();
}

function UpdateMenu() {
    if (document.body.clientWidth >= 900) {
        menuBars.classList.add("hidden");
        menu.classList.remove("hidden");
    } else {
        menuBars.classList.remove("hidden");
        menu.classList.add("hidden");
    }
}