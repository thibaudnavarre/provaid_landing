$(function () {
    // when the form is submitted
    $(document).ready(function (e) {
        console.log("script called !");
        // if the validator does not prevent form submit
    
        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;
        
            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');
        
                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
        };

        var url = "../unsubscribe.php";
        var hash = getUrlParameter("value");

        // GET values in the background the the script URL
        $.ajax({
            type: 'GET',
            url: url,
            data: 'value='+hash,
            success: function (response_code)
            {
                // response_code = html response that contact.php returns
                if (response_code == 200) {
                    
                    var messageText = "Désinscription effectuée !";
                    var messageAlert = "alert-success";
                }
                else{
                    var messageText = "Une erreur est survenue !";
                    var messageAlert = "alert-error";
                }               
                 
                // let's compose Bootstrap alert box HTML
                var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';

                // inject the alert to .messages div in our form
                $(document).find('.toasts').html(alertBox);
                
            }
        });
        console.log("form submitted !");
        return false;
        
    })
});