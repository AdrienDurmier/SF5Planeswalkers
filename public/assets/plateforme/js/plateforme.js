$(document).ready(function($) {
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
 * Planeswalkers card symbols
 * @param contenu
 * @returns {*}
 */
function cardSymbol(contenu)
{
    if(contenu){
        let matches = contenu.match(/{.+?}/g);
        if(matches){
            for (let i = 0; i < matches.length; i++) {
                let match = matches[i].replace(/[{}]/g, "");
                contenu = contenu.replace('{'+match+'}', '<div class="card-symbol card-symbol-'+match+'"></div>');
            }
        }
    }
    return contenu;
}

/**
 * Planeswalkers legality
 * @param card
 * @returns {*}
 */
function legality(card)
{
    let response = '';
    switch (card) {
        case "not_legal":
            response = '<i class="fas fa-times text-danger"></i>';
            break;
        case "banned":
            response = '<i class="fas fa-ban text-danger"></i>';
            break;
        case "restricted":
            response = '<i class="fas fa-exclamation text-warning"></i>';
            break;
        case "legal":
            response = '<i class="fas fa-check text-success"></i>';
            break;
    }
    return response;
}