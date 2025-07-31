// Setzt slide Variable auf 1
let slideIndex = 1;
//Zeigt aktuelles bild an
showSlides(slideIndex);

//Funktion die zum nächsten Bild wechselt.
function plusSlides(n) {
  showSlides(slideIndex += n); //Es wird n = n +1 gerechnet
}

//Funktion die das aktuelle Bild "anzeigt" 
function currentSlide(n) {
  showSlides(slideIndex = n); //Es wird der Index der funktion plusSlides übernommen
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("slide"); //Alle Elemente mit dem Namen (keiene ID!) slide
  let dots = document.getElementsByClassName("dot"); // " dot "
  if (n > slides.length) { slideIndex = 1 } // Bei drei Bildern wird der slideIndex auf 1 gesetzt wenn vier mal auf den Pfeil geklickt wird
  if (n < 1) { slideIndex = slides.length } //Wenn man bei ersten Bild ist slideIndex[1] und auf zurück drückt kommt man zum letzen slide (slide.length)

  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none"; // Macht ALLE slides unsichtbar
    slides[i].classList.remove("fade"); //Entfernt  Fade-Animation
  }

  for (i = 0; i < dots.length; i++) {
    dots[i].classList.remove("active");  // ändert in Verbindung mit einer CSS den Style ( hier slides wird hellgrau)
}


  slides[slideIndex - 1].style.display = "block"; //-> block gegenteil von none DAS AKTUELLE slide wird angezeigt
  slides[slideIndex - 1].classList.add("fade"); //add("fade") Fade animation wird angezeigt
  dots[slideIndex - 1].classList.add("active"); //ändert in Verbindung mit einer CSS den Style ( hier dot des aktellen slides wird dunkelrau)
}
