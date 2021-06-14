var houseIndex = 0;

function HouseAnimation() {
    if (document.querySelector(".houses")) {
        var houses = document.querySelector(".houses").children;
        var house = houses[houseIndex];

        if (house) {
            house.firstElementChild.classList.add("slide");
            house.firstElementChild.addEventListener("animationend", () => {
                HouseAnimation();
            });

            houseIndex++;
        }
    }
}