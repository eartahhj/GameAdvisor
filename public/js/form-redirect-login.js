$(function() {
    $('form').submit(function() {
        window.location.href = window.loginRoute + '?redirect=formhome';
    });

    $('form input, form select, form textarea').focus(function() {
        window.location.href = window.loginRoute + '?redirect=formhome';
    });
});