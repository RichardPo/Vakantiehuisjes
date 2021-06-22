var houseIndex = 0;

function HouseAnimation() {
    if (document.querySelector(".houses")) {
        var houses = document.querySelector(".houses").children;
        var house = houses[houseIndex];

        if (house) {
            house.classList.add("slide");
            house.addEventListener("animationend", () => {
                HouseAnimation();
            });

            houseIndex++;
        }
    }
}