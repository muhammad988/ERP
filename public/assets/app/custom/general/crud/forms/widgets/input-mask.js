// Class definition

var KTInputmask = function () {

    // Private functions
    var demos = function () {
        // date format
        $("#kt_inputmask_1").inputmask("99/99/9999", {
            "placeholder": "mm/dd/yyyy",
            autoUnmask: true
        });

        // custom placeholder
        $("#kt_inputmask_2").inputmask("99/99/9999", {
            "placeholder": "mm/dd/yyyy",
        });

        // phone number format
        $(".phone_mask").inputmask("mask", {
            "mask": "00999 (999) 999-9999",
            autoUnmask: true,
            removeMaskOnSubmit: true,
        });

        // empty placeholder
        $("#kt_inputmask_4").inputmask({
            "mask": "99-9999999",
            placeholder: "" // remove underscores from the input mask
        });

        // repeating mask
        $(".number_mask").inputmask({
            "mask": "9",
            "repeat": 25,
            "greedy": false
        }); // ~ mask "9" or mask "99" or ... mask "9999999999"

        // decimal format
        $(".kt_inputmask_6").inputmask('decimal', {
            "rightAlign": false,
        });
        $(".money").inputmask({
            "alias": "decimal",
            "digits": 2,
            autoUnmask: true,
            "autoGroup": true,
            "allowMinus": true,
            "rightAlign": false,
            "groupSeparator": ",",
            "radixPoint": ".",
        });
        $(".currency").inputmask({
            "alias": "decimal",
            "digits": 2,
            "suffix": " $",
            "autoGroup": true,
            autoUnmask: true,
            removeMaskOnSubmit: true,
            "allowMinus": true,
            "rightAlign": false,
            "groupSeparator": ",",
            "radixPoint": ".",

        });

        // currency format
        $("#kt_inputmask_7").inputmask('€ 999.999.999,99', {
            numericInput: true
        }); //123456  =>  € ___.__1.234,56

        //ip address
        $("#kt_inputmask_8").inputmask({
            "mask": "999.999.999.999"
        });

        //email address
        $("#kt_inputmask_9").inputmask({
            mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
            greedy: false,
            onBeforePaste: function (pastedValue, opts) {
                pastedValue = pastedValue.toLowerCase();
                return pastedValue.replace("mailto:", "");
            },
            definitions: {
                '*': {
                    validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
                    cardinality: 1,
                    casing: "lower"
                }
            }
        });
        $(".mask_email").inputmask({
            mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
            greedy: false,
            onBeforePaste: function (pastedValue, opts) {
                pastedValue = pastedValue.toLowerCase();
                return pastedValue.replace("mailto:", "");
            },
            definitions: {
                '*': {
                    validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
                    cardinality: 1,
                    casing: "lower"
                }
            }
        });
    }

    return {
        // public functions
        init: function() {
            demos();
        }
    };
}();

jQuery(document).ready(function() {
    KTInputmask.init();
});
