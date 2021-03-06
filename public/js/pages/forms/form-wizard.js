$(function () {
    //Horizontal form basic
    $('#wizard_horizontal').steps({
        headerTag: 'h2',
        bodyTag: 'section',
        transitionEffect: 'slideLeft',
        onInit: function (event, currentIndex) {
            setButtonWavesEffect(event);
        },
        onStepChanged: function (event, currentIndex, priorIndex) {
            setButtonWavesEffect(event);
        }
    });

    //Vertical form basic
    $('#wizard_vertical').steps({
        headerTag: 'h2',
        next :'Proximo',
        bodyTag: 'section',
        transitionEffect: 'slideLeft',
        stepsOrientation: 'vertical',
        onInit: function (event, currentIndex) {
            setButtonWavesEffect(event);
        },
        onStepChanged: function (event, currentIndex, priorIndex) {
            setButtonWavesEffect(event);
        }
    });

    //Advanced form with validation
    var form = $('#wizard_with_validation').show();
    form.steps({

        headerTag: 'h3',
        next: 'Proximo',
        bodyTag: 'fieldset',
        transitionEffect: 'slideLeft',
        labels: 
        {
            cancel: "Cancelar",
            current: "current step:",
            pagination: "Pagination",
            finish: "Finalizar",
            next: "Próximo",
            previous: "Anterior",
            loading: "Carregando..."
        },
        onInit: function (event, currentIndex) {
            $.AdminBSB.input.activate();

            //Set tab width
            var $tab = $(event.currentTarget).find('ul[role="tablist"] li');
            var tabCount = $tab.length;
            $tab.css('width', (100 / tabCount) + '%');

            //set button waves effect
            setButtonWavesEffect(event);
        },
        onStepChanging: function (event, currentIndex, newIndex) {
            if (currentIndex > newIndex) { return true; }

            if (currentIndex < newIndex) {
                form.find('.body:eq(' + newIndex + ') label.error').remove();
                form.find('.body:eq(' + newIndex + ') .error').removeClass('error');
            }

            form.validate().settings.ignore = ':disabled,:hidden';
            return form.valid();
        },
        onStepChanged: function (event, currentIndex, priorIndex) {
            setButtonWavesEffect(event);
        },
        onFinishing: function (event, currentIndex) {
            form.validate().settings.ignore = ':disabled';
            return form.valid();
        },
        onFinished: function(e, currentIndex) {
                // Uncomment the following line to submit the form using the defaultSubmit() method
                //$('#wizard_with_validation').formValidation('defaultSubmit');
                $( "#wizard_with_validation" ).submit();
                // For testing purpose
                //$('#welcomeModal').modal();
            }
        // onFinished: function (event, currentIndex) {
        //     swal("Good job!", "Submitted!", "success");
        // }
    });

    form.validate({
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            console.log(error);
            $(element).parents('.form-group').append(error);
        },
        rules: {
            'password_confirmation': {
                equalTo: '#password'
            }
        },
        messages: {
            nome: {
                required: "Digite um nome",
            },
            email: {
                required: "Digite um e-mail válido...",
                email: "Seu endereço de e-mail precisar ter um formato válido nome@dominio.com"
            },
            password: {
                required: "Digite uma senha! min 6 caracteres...",
                email: "Seu endereço de e-mail precisar ter um formato válido nome@dominio.com"
            },
            password_confirmation: {
                equalTo: "Senhas Diferentes. Por Favor Digite a mesma senha do campo a cima!"
            }

        }
    });
});

function setButtonWavesEffect(event) {
    $(event.currentTarget).find('[role="menu"] li a').removeClass('waves-effect');
    $(event.currentTarget).find('[role="menu"] li:not(.disabled) a').addClass('waves-effect');
}