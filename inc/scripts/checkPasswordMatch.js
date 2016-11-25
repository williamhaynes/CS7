/**
 * Created by hype_ on 25/11/2016.
 */
function checkPasswordMatch() {
    var password = $("#password").val();
    var confirmPassword = $("#confirmPassword").val();

    if (password != confirmPassword)
        $("#body").html("Passwords do not match!");
    else
        $("#body").html("Passwords match.");
}

$(document).ready(function () {
    $("#confirmPassword").keyup(checkPasswordMatch);
});