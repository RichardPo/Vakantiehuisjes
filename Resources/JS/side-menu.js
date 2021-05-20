var sideMenu = document.querySelector(".side-menu");
var overlay = document.querySelector(".overlay");

function OpenSideMenu() {
    sideMenu.style.visibility = "visible";
    sideMenu.style.left = "calc(100% - " + sideMenu.clientWidth + "px)";
    overlay.style.visibility = "visible";
    overlay.style.opacity = "0.4";
}

function CloseSideMenu() {
    sideMenu.style.left = "100%";
    overlay.style.opacity = "0";

    var timeOut = setTimeout(SetVisibility, 300);

    function SetVisibility() {
        sideMenu.style.visibility = "hidden";
        overlay.style.visibility = "hidden";
    }
}