// public/js/loader.js

function showLoader() {
    $('#loader-container').addClass('active');
    $('body').addClass('no-scroll');
}

function hideLoader() {
    $('#loader-container').removeClass('active');
    $('body').removeClass('no-scroll');
}