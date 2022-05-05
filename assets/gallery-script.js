function openModal() {
    document.getElementById("galleryModal").style.display = "block";
}

function closeModal() {
    document.getElementById("galleryModal").style.display = "none";
}

var slideIndex = 1;

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("gallerySlides");
    var captionText = document.getElementById("caption");

    if (slides.length < 1) return;

    if (n > slides.length) slideIndex = 1

    if (n < 1) slideIndex = slides.length

    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    slides[slideIndex - 1].style.display = "block";

}

window.onload = function() {
    showSlides(slideIndex);
}