var menuBars = document.querySelector(".menu-bars");
var menu = document.querySelector(".menu");

function UpdateMenu() {
    console.log("Hoi");

    if (document.body.clientWidth >= 900) {
        menuBars.classList.add("hidden");
        menu.classList.remove("hidden");
    } else {
        menuBars.classList.remove("hidden");
        menu.classList.add("hidden");
    }
}