$(document).ready(function () {
    $('form#add_form > :checkbox').on('change', function() {
        let checkbox = $(this);

        console.log(checkbox)
        let name = checkbox.prop('name');
        if (checkbox.is(':checked')) {
            $(':checkbox[name="' + name + '"]').not($(this)).prop({
                'checked': false,
                'required': false
            });
        }
    });
});
