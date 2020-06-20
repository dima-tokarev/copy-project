$(document).ready( function() {
    $("#elem").click(function () {


        $.ajax({
            type: "POST",
            url: "preworks/attr-val",
            data: {
                "class" : elem.getAttribute('class_select'),
                "_token": $("input[name='_token']").val()
            },
            success: function(msg){
                $('#att_val').html(msg);
            }
        });
    });
    $("#att_val").change(function (e) {
      $('#client').val($("#att_val").val());
    });


});

$('.modal > form').submit( function(ev){

    ev.preventDefault();

    //later you decide you want to submit
    $(this).unbind('submit').submit()

});


