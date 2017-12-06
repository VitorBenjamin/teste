$(function () {

      //Masked Input ============================================================================================================================
      var $demoMaskedInput = $('.demo-masked-input');
      $('.valor').inputmask("currency", {
        groupSeparator: '.',
        prefix: "",
        placeholder: '0.00',
        numericInput: true,
        autoGroup: false
    });

    //Numero de Processo
    $demoMaskedInput.find('.processo').inputmask('9999999-99.9999.9.99.9999');

});

//Get noUISlider Value and write on
function getNoUISliderValue(slider, percentage) {
    slider.noUiSlider.on('update', function () {
        var val = slider.noUiSlider.get();
        if (percentage) {
            val = parseInt(val);
            val += '%';
        }
        $(slider).parent().find('span.js-nouislider-value').text(val);
    });
}