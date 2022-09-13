
window.addEventListener("DOMContentLoaded", (event) => {
  console.log("DOM entièrement chargé et analysé");

  let colonnes = document.querySelectorAll('.nbr');
  let nbrOfColumn;
  
  for ( let colonne of colonnes ){
    nbrOfColumn = colonnes.length
    // tr = colonne;
    // console.log(tr);
    for (i=0; i <= nbrOfColumn; i++) {
      console.log(i);
      // colonnes.innerHTML = `${i}`;
    }
    console.log(nbrOfColumn);
    colonnes.innerHTML = "toto";
  }
  
  
});

/*
* je créer ce code pour afficher 
* un numéro dans une colone pour chaque rangée
* 
*/