$(function () {
    $('#nav-main #nav-language-handler').change(function () {
        $(this).parents('.dropdown').toggleClass('is-active');
    });

    siteAnimations();
});

function siteAnimations()
{
    const animationsCookie = document.cookie.split('; ')
    .find((row) => row.startsWith('animations='))
    ?.split('=')[1];

    if (animationsCookie == 'on' || typeof animationsCookie == 'undefined') {
        $('.has-animation').addClass('animated').removeClass('has-animation');
    }

    $('#animations-switch-handler').change(function () {
        let isChecked = $(this).is(':checked');
        const d = new Date();
        d.setTime(d.getTime() + (180*24*60*60*1000));
        let expires = "expires="+ d.toUTCString();

        if (isChecked) {
            $('.animated').removeClass('animated').addClass('has-animation');
            document.cookie = "animations=off; " + expires + "; path=/; secure; samesite=Strict;";
        } else {
            $('.has-animation').addClass('animated').removeClass('has-animation');
            document.cookie = "animations=on; " + expires + "; path=/; secure; samesite=Strict;";
        }
    });
}

function acceptOnlyTechnicalCookies()
{
    const d = new Date();
    d.setTime(d.getTime() + (180*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = "cookiesConsent=technical; " + expires + "; path=/; secure; samesite=Strict;";

    return document.getElementById('cookie-policy-banner').remove();
}

function acceptAllCookies()
{
    const d = new Date();
    d.setTime(d.getTime() + (180*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = "cookiesConsent=technical,ads; " + expires + "; path=/; secure; samesite=Strict;";
    
    let adsScript = document.getElementById('gads-js');
    let adsScriptSrc = adsScript.getAttribute('data-src');
    adsScript.removeAttribute('data-src');
    adsScript.setAttribute('src', adsScriptSrc);

    return document.getElementById('cookie-policy-banner').remove();
}

function closeMainNavigation()
{
    const navHandler = document.getElementById('navbar-main-handler');

    if (typeof navHandler == 'undefined') {
        return;
    }

    navHandler.checked = false;
}