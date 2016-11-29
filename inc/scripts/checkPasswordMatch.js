/**
 * Created by hype_ on 25/11/2016.
 */


/*DOESN'T WORK ATM*/

//I understand what I want this to do but it doesn't work, checking the console it doesn't seem to run the event listener

function checkPasswordMatch() {
    var password = $("#firstPassword").val();
    var confirmPassword = $("#secondPassword").val();

    if (password != confirmPassword)
        $("#body").html("Passwords do not match!");
    else
        $("#body").html("Passwords match.");
}

