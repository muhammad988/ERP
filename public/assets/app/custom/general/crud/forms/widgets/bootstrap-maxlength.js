// Class definition
var KTBootstrapMaxlength = function () {
    // Private functions
    var demos = function () {
        // always show
        $('.kt_maxlength_3').maxlength({
            alwaysShow: true,
            threshold: 5,
            warningClass: "kt-badge kt-badge--primary kt-badge--rounded kt-badge--inline",
            limitReachedClass: "kt-badge kt-badge--brand kt-badge--rounded kt-badge--inline"
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
    KTBootstrapMaxlength.init();
});
