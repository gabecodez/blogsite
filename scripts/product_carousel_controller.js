let currentSlide = 0;
const slides = document.querySelectorAll(".carousel-image");
const prevButton = document.querySelector(".carousel-nav.prev");
const nextButton = document.querySelector(".carousel-nav.next");

function updateCarousel() {
  const totalSlides = slides.length;
  const offset = -currentSlide * 100;
  document.querySelector(
    ".carousel-images"
  ).style.transform = `translateX(${offset}%)`;

  // Hide navigation buttons if there's only one image
  prevButton.disabled = totalSlides <= 1 || currentSlide === 0;
  nextButton.disabled = totalSlides <= 1 || currentSlide === totalSlides - 1;
}

function prevSlide() {
  if (currentSlide > 0) {
    currentSlide--;
    updateCarousel();
  }
}

function nextSlide() {
  if (currentSlide < slides.length - 1) {
    currentSlide++;
    updateCarousel();
  }
}

// Initialize carousel
updateCarousel();
