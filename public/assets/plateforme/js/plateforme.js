jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});

function getRandomInt(max) {
    return Math.floor(Math.random() * Math.floor(max));
}