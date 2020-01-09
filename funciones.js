//SLIDER PAELLAS
$(document).ready(function ($) {
    $('#myCarousel').carousel({
        interval: 5000
    });
    $('#carousel-text').html($('#slide-content-0').html());
    //Handles the carousel thumbnails
    $('[id^=carousel-selector-]').click(function () {
        var id = this.id.substr(this.id.lastIndexOf("-") + 1);
        var id = parseInt(id);
        $('#myCarousel').carousel(id);
    });
    // When the carousel slides, auto update the text
    $('#myCarousel').on('slid.bs.carousel', function (e) {
        var id = $('.item.active').data('slide-number');
        $('#carousel-text').html($('#slide-content-' + id).html());
    });
});
//BOTON SUBIR
$(document).ready(function () {
    // Show or hide the sticky footer button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 800) {
            $('.go-top').fadeIn(800);
        }
        else {
            $('.go-top').fadeOut(800);
        }
    });
    // Animate the scroll to top
    $('.go-top').click(function (event) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, 900);
    })
});