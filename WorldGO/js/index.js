const images = [
    "imgs/indexbg1.jpg",
    "imgs/indexbg2.jpg",
    "imgs/indexbg3.jpg",
    "imgs/indexbg4.jpg",
    "imgs/indexbg5.jpg"
];

const backgrounds = document.querySelectorAll(".hero-bg");

let currentImage = 0;
let currentLayer = 0;

// immagine iniziale
backgrounds[0].style.backgroundImage = `url(${images[0]})`;

setInterval(() => {

    // prossimo layer
    const nextLayer = currentLayer === 0 ? 1 : 0;

    // prossima immagine
    currentImage++;

    if (currentImage >= images.length) {
        currentImage = 0;
    }

    // carica immagine nel layer nascosto
    backgrounds[nextLayer].style.backgroundImage =
        `url(${images[currentImage]})`;

    // fade
    backgrounds[nextLayer].classList.add("active");
    backgrounds[currentLayer].classList.remove("active");

    // aggiorna layer attivo
    currentLayer = nextLayer;

}, 7000);