
var slide = new Array("../assets/img/hotel/2gOxKj594nM.jpg",
"../assets/img/hotel/9IzrXQakxk0.jpg",
"../assets/img/hotel/I5c9i-hooag.jpg",
"../assets/img/hotel/hym8.jpg",
"../assets/img/hotel/u6xqnbsg.jpg",
"../assets/img/hotel/aBNPslolmJM.jpg",
"../assets/img/hotel/w1gguH6xRUc.jpg");
var numero = 0;

function ChangeSlide(sens) {
    numero = numero + sens;
    if (numero < 0)
        numero = slide.length - 1;
    if (numero > slide.length - 1)
        numero = 0;
    document.getElementById("slide").src = slide[numero];
}
setInterval("ChangeSlide(1)", 4000);