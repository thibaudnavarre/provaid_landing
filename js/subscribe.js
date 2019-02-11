$(function () {
    // when the form is submitted
    $('#contact-form').on('submit', function (e) {
        console.log("script called !");
        // if the validator does not prevent form submit
    
        var url = "../subscribe.php";

        // POST values in the background the the script URL
        $.ajax({
            type: "POST",
            url: url,
            data: $(this).serialize(),
            success: function (response_code)
            {
                
                // response_code = html response that contact.php returns
                if (response_code == 200) {
                    console.log("Subscription is a success !");
                    var messageText = "Inscription enregistrée !";
                    var messageAlert = "alert-success";
                }
                else{
                    console.log("Subscription error : code : " + response_code);
                    var messageText = "Une erreur est survenue !";
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
        console.log("form submitted !");
        return false;
        
    })
});