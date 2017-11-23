var $contactForm = $('#contact-form');
var $dialogBox = $('.dialog-box');

$contactForm.find('input, textarea').blur(function() {
    var $this = $(this);

    $.ajax('php/contact.php', {
        method: 'POST',
        dataType: 'json',
        data: $this.serialize() + '&partial=true',
        success: function(data) {
            if (data.status === 'error') {
                $this.next('.error').text(data.info[0].message);
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}).focus(function() {
    $(this).next('.error').text('');
});

$contactForm.find('input[type="submit"], input[type="reset"]').click(function(){
    $(this).closest('form').find('.error').text('');
});

$contactForm.submit(function(event) {
    event.preventDefault();

    $.post('php/contact.php',
        $(this).serialize(),
        function(data) {
            if (data.status === 'error') {
                $.each(data.info, function(index, elem) {
                    $('#' + elem.field).next('.error').text(elem.message);
                });
            }
            $dialogBox.children('.title').text(data.status);
            $dialogBox.children('.message').text(data.message);
            $dialogBox.finish().show('fast');
        },
        'json'
    );
});
$dialogBox.children('button').click(function () {
    $(this).parent().slideUp();
});