$(function () {
    // when the form is submitted
    $('#contact-form').on('submit', function (e) {

        // if the validator does not prevent form submit
    
        var url = "../contact.php";

        // POST values in the background the the script URL
        $.ajax({
            type: "POST",
            url: url,
            data: $(this).serialize(),
            success: function (response_code)
            {
                
                // response_code = html response that contact.php returns
                if (response_code == 200) {
                    var messageText = "Message envoyé !";
                    var messageAlert = "alert-done";
                }
                else{
                    var messageText = "Erreur lors de l'envoi du message !";
                    var messageAlert = "alert-error";
                }               
                 
                // let's compose Bootstrap alert box HTML
                var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';

                // inject the alert to .messages div in our form
                $('#contact-form').find('.toasts').html(alertBox);
                // empty the form
                $('#contact-form')[0].reset();
                
            }
        });
        return false;
        
    })
});