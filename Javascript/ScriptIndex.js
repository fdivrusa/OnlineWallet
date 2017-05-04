/**
 * Created by Di Vrusa Florian on 29-03-17.
 */

$(document).ready(apparition);

function apparition() {
    $('.welcomePhrase').animate(
        {
            opacity: 1,
            padding: 0

        }, {duration: 1500});

    $('#background').animate(
        {
            opacity: 0.6
        }, {duration: 1500});

    $('#discoverButton').animate(
        {
            opacity: 1
        }, {duration: 1000});
}




