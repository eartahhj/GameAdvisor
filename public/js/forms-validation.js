var _Form;
var _FormOnClickSelector = '[type="submit"]';
var _defaultFieldParentContainerSelector = '.field';

var _FormErrors = [];
var _FormFields = [];

function formHasErrors() {
    if (window._FormErrors.length) {
        var currentField = null;
        $(window._FormErrors).each(function(i, error) {
            if (typeof $('#' + error.fieldIdentifier) == 'undefined') {
                currentField = $('[name="' + error.fieldIdentifier + '"]');
            } else {
                currentField = $('#' + error.fieldIdentifier);
            }

            if (typeof currentField == 'undefined') {
                return false;
            }

            var fieldSelector = '';

            addErrorToField(error, currentField);

            $(currentField).change(function() {
                if (typeof $('#' + $(currentField).attr('id')) != 'undefined') {
                    fieldSelector = '#' + $(currentField).attr('id');
                } else {
                    fieldSelector = '#' + $(currentField).attr('name');
                }
                // console.log(fieldSelector + ' has changed now');
                validateFields(fieldSelector);
            });
        });

        return true;
    }

    return false;
}

function addErrorToField(error, field) {
    var container = $(field).parents(window._defaultFieldParentContainerSelector);

    if (typeof container == 'undefined') {
        return false;
    }

    var html = '<div class="field-js-error"><h3>' + error + '</h3></div>';

    $(container).prepend(html);

    return true;
}

function removeErrorFromField(error, field) {
    var container = $(field).parents(window._defaultFieldParentContainerSelector);

    if (typeof container == 'undefined') {
        return false;
    }

    var error = $(container).find('.field-js-error');

    $(container).prepend(html);

    return true;
}

function scanFormForTinymceEditor() {
    var fieldSelectors = 'textarea.tinymce[required]';
    var textarea = null;

    if ($(window._Form).has(fieldSelectors)) {
        $(fieldSelectors).each(function() {
            textarea = $(this);

            var fieldValidators = [];

            fieldValidators.push({
                'type': 'required',
                'errorMessage': 'Required field'
            }, {
                'type': 'maxlength',
                'value': 100,
                'errorMessage': 'Text too long'
            });

            window._FormFields.push({
                'type': 'textarea',
                'object': textarea,
                'validators': fieldValidators
            });
        });
    }
    //
    // $(window.tinyMCE.triggerSave());
    //
    // if (typeof textarea != undefined && validateFields(textarea)) {
    //     return true;
    // }
    //
    // return false;
}

function scanFormForSelectChosen() {
    var fieldSelectors = '.chosen[required]';
    var select = null;

    if ($(window._Form).has(fieldSelectors)) {
        $(fieldSelectors).each(function() {
            select = $(this);

            var fieldValidators = [];

            fieldValidators.push({
                'type': 'required',
                'errorMessage': 'Required field',
                'callbackFunctionOnError': 'chosenAddRequired',
                'callbackFunctionOnSuccess': 'chosenRemoveRequired',
            });

            window._FormFields.push({
                'type': 'select',
                'object': select,
                'validators': fieldValidators
            });
        });
    }

    // if ($(form).has(fieldSelectors)) {
    //     select = $(form).find(fieldSelectors);
    // }
    //
    // if (typeof select != undefined && validateFields(select)) {
    //     return true;
    // }
    //
    // return false;
}

function scanFormForLanguageTabs() {
    var fieldSelectors = '.tab-language input[required]';
    var inputTabs = null;

    var fieldValidators = [];

    fieldValidators.push({
        'type': 'required',
        'errorMessage': 'Required field'
    });

    if ($(window._Form).has(fieldSelectors)) {
        $(fieldSelectors).each(function() {
            input = $(this);
            window._FormFields.push({
                'type': $(this).attr('type'),
                'object': input,
                'validators': fieldValidators
            });
        });
    }
    //
    // if ($(form).has(fieldSelectors)) {
    //     inputTabs = $(form).find(fieldSelectors);
    // }
    //
    // if (typeof inputTabs != undefined && validateFields(inputTabs)) {
    //     return true;
    // }
    //
    // return false;
}

function validateForm() {
    scanFormForTinymceEditor();
    scanFormForSelectChosen();
    scanFormForLanguageTabs();

    validateFields();
}

function validateFields() {
    $(window._FormFields).each(function(i, field) {
        $(field.validators).each(function(j, validator) {
            if (validator.type == 'required') {
                var success = validateRequiredField(field);
                if (success === false) {
                    $(field.object).addClass('required');
                    if (typeof validator.callbackFunctionOnError != 'null') {
                        window[validator.callbackFunctionOnError](field.object);
                    }
                } else {
                    $(field.object).removeClass('required');
                    if (typeof validator.callbackFunctionOnSuccess != 'null') {
                        window[validator.callbackFunctionOnSuccess](field.object);
                    }
                }
            }
        });
    });
}

function validateRequiredField(field) {
    if (!$(field.object).val() || $(field.object).val() == '') {
        return false;
    } else {
        return true;
    }
}

function chosenAddRequired(field) {
    let target = $(field).parents(window._defaultFieldParentContainerSelector);
    $(target).addClass('chosen-required');
    $('html,body').animate({
        'scrollTop': $(target).offset().top
    }, 400)
}

function chosenRemoveRequired(field) {
    $(field).removeClass('chosen-required');
}

$(function() {
    // console.log(window._FormErrors);
    $(window._FormOnClickSelector).click(function(event) {
        window._FormErrors = [];
        var submit = $(this);
        window._Form = $(submit).parents('form');
        validateForm();

        if (formHasErrors()) {
            event.preventDefault();
            return false;
        } else {
            return true;
        }
    });
});
