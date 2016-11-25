/**
 * Created by hype_ on 25/11/2016.
 */
$(document).ready(function () {
    $("#secondPassword").onkeyup(checkPasswordMatch);
});

function checkPasswordMatch() {
    var password = $("#firstPassword").val();
    var confirmPassword = $("#secondPassword").val();

    if (password != confirmPassword)
        $("#body").html("Passwords do not match!");
    else
        $("#body").html("Passwords match.");
}

