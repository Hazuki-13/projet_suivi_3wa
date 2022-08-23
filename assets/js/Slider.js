/* déclaration des variables*/
let slide = new Array("../assets/img/hotel/2gOxKj594nM.jpg",
"../assets/img/hotel/9IzrXQakxk0.jpg",
"../assets/img/hotel/I5c9i-hooag.jpg",
"../assets/img/hotel/hym8.jpg",
"../assets/img/hotel/u6xqnbsg.jpg",
"../assets/img/hotel/aBNPslolmJM.jpg",
"../assets/img/hotel/w1gguH6xRUc.jpg");
let nbr = 0;

function ChangeSlide(direction) {
    nbr = nbr + direction;
    if (nbr < 0)
        nbr = slide.length - 1;
    if (nbr > slide.length - 1)
        nbr = 0;
    document.getElementById("slide").src = slide[nbr];
}
setInterval("ChangeSlide(1)", 3000);