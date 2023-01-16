function toggleMenu() {
    var links = document.querySelector(".links");
    if (links.style.display === "block") {
        links.style.display = "none";
    } else {
        links.style.display = "block";
    }
}