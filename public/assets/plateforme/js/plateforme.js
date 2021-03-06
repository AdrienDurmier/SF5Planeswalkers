jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});

/**
 *
 * @param max
 * @returns {number}
 */
function getRandomInt(max) {
    return Math.floor(Math.random() * Math.floor(max));
}

/**
 *
 * @param contenu
 * @returns {*}
 */
function cardSymbol(contenu)
{
    let matches = contenu.match(/{.+?}/g);
    for (let i = 0; i < matches.length; i++) {
        let match = matches[i].replace(/[{}]/g, "");
        contenu = contenu.replace('{'+match+'}', '<div class="card-symbol card-symbol-'+match+'"></div>');
    }

    return contenu;
}