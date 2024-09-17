var successfulValidation = true;
var sentRequest = false;
var userExistence = false;
var result = false;

function functionValidation() {

    document.getElementById("errorUsername").innerHTML = "";
    document.getElementById("errorPassword").innerHTML = "";
    document.getElementById("error").innerHTML = "";
    document.getElementById("ajaxError").innerHTML = "";
    document.getElementById("success").innerHTML = "";

    successfulValidation = true;
    userExistence = false;
    sentRequest = false;
    result = false;

    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    var usernameSample = /^(?=.{3,10}$)/;
    var passwordSample = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{6,10}$/;

    if (username.localeCompare("") != 0) {
        document.getElementById("errorUsername").innerHTML = "";
        document.getElementById("username").style.borderColor = "gray";
    }
    else
    {
        document.getElementById("errorUsername").innerHTML = "Please enter username";
        successfulValidation = false;
        document.getElementById("username").style.borderColor = "red";
    }

    if (password.localeCompare("") != 0) {
        document.getElementById("errorPassword").innerHTML = "";
        document.getElementById("password").style.borderColor = "gray";

    }
    else
    {
        document.getElementById("errorPassword").innerHTML = "Please enter password";
        successfulValidation = false;
        document.getElementById("password").style.borderColor = "red";
    }

    if(successfulValidation)
    {
      var xhr = new XMLHttpRequest();
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

      xhr.onload = function () {
        if (xhr.status == 200) {
          settings.success(xhr.response);
        } else {
          console.log(xhr);
        }
      };

      xhr.open("POST", "../controllers/login.php", true);
      xhr.send();
    }
}
