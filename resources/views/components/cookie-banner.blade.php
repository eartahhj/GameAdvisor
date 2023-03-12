<div id="cookie-policy-banner">
    <div class="container">
        <button class="handler" onclick="return acceptOnlyTechnicalCookies();">
            <span class="sr-only"><?=_('Close this message') ?></span>
        </button>
        <div class="text">
            <p><?= _('This website uses Matomo for statistics purposes. The data is anonymized by default and is stored in an European server controlled only by us. We do not share the data with third parties nor sell it to anyone.') ?></p>
            <p><?= _('If you accept all cookies, it will also use Google Ads to show advertisement banners and allow us to support the costs for the server and the development of the platform.')?></p>
            <p class="buttons">
                <button class="button background-1" onclick="return acceptOnlyTechnicalCookies();"><?= _('Accept only technical cookies') ?></button>
                <button class="button background-1" onclick="return acceptAllCookies();"><?= _('Accept all cookies') ?></button>
                <a href="<?= page_url(4) ?>" class="button is-dark"><?= _('Read the full cookie policy') ?></a>
            </p>
        </div>
    </div>
</div>