$(document).ready(function() {
    $('#short_button').click(function() {
        $.post('save.php', {
            link : $('#link').attr('value'),
            what : $('#what').attr('value'),
            auto : $('#auto').attr('checked'),
            nolink : $('#nolink').attr('checked'),
            captcha : $('form').serialize()
        }, function(data) {
            $('#user_data').html(data);
        });
    });

    $('#save_button').click(function() {
        $.post('save.php', {
            link : $('#link').attr('value'),
            what : $('#what').attr('value'),
            auto : $('#auto').attr('checked'),
            image : 'checked',
            nolink : $('#nolink').attr('checked')
        }, function(data) {
            $('#user_data').html(data);
        });//
    });


    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover",
        container: 'body'
    });

    $('.dropdown-toggle').dropdown();

    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').focus()
    })

});