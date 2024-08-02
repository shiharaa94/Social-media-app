$(document).ready(function() {

    $('#btn_logout').click(function() {
        console.log("btn clicked");
        $.ajax({
            url: 'php/logout-process.php',
            success: function(response) {
                if (response.status == 210) {
                    console.log("successfull");

                    window.location.replace("/");

                } else if (response.status == 211) {
                    console.log("Error in Logout");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    });

});