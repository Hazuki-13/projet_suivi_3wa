
window.addEventListener("DOMContentLoaded", (event) => {
  console.log("DOM entièrement chargé et analysé");

  let colonnes = document.querySelectorAll('.nbr');
  let nbrOfColumn;
  nbrOfColumn = colonnes.length
  for (i=0; i <= nbrOfColumn; i++) {
    colonnes[i].innerHTML = `${i+1}`;
  }

}
);
  
  