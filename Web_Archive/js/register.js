var successfulValidation = true;
var sentRequest = false;
var userExistence = false;
var result = false;

function functionValidation() {

    document.getElementById("errorUsername").innerHTML = "";
    document.getElementById("errorEmail").innerHTML = "";
    document.getElementById("errorPassword").innerHTML = "";
    document.getElementById("errorRepeatPassword").innerHTML = "";
    document.getElementById("error").innerHTML = "";
    document.getElementById("ajaxError").innerHTML = "";
    document.getElementById("success").innerHTML = "";

    successfulValidation = true;
    userExistence = false;
    sentRequest = false;
    result = false;

    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var repeatPassword = document.getElementById("repeatPassword").value;


    var usernameSample = /^(?=.{3,10}$)/;
    var emailSample = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var passwordSample = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{6,10}$/;

    if (fieldValidation(username, usernameSample)) {
        document.getElementById("errorUsername").innerHTML = "";
        document.getElementById("username").style.borderColor = "gray";
    }
    else
    {
        document.getElementById("errorUsername").innerHTML = "Invaid username";
        successfulValidation = false;
        document.getElementById("username").style.borderColor = "red";
    }

    if (fieldValidation(email, emailSample)) {
        document.getElementById("errorEmail").innerHTML = "";
        document.getElementById("email").style.borderColor = "gray";

    }
    else
    {
        document.getElementById("errorEmail").innerHTML = "Invaid email";
        successfulValidation = false;
        document.getElementById("email").style.borderColor = "red";
    }

    if (fieldValidation(password, passwordSample)) {
        document.getElementById("errorPassword").innerHTML = "";
        document.getElementById("password").style.borderColor = "gray";

    }
    else
    {
        document.getElementById("errorPassword").innerHTML = "Invaid password";
        successfulValidation = false;
        document.getElementById("password").style.borderColor = "red";
    }
    if(password.localeCompare(repeatPassword) === 0)
    {
      document.getElementById("errorRepeatPassword").innerHTML = "";
      document.getElementById("repeatPassword").style.borderColor = "gray";
    }
    else
    {
      document.getElementById("errorRepeatPassword").innerHTML = "Passwords do not match";
      successfulValidation = false;
      document.getElementById("repeatPassword").style.borderColor = "red";
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

      xhr.open("POST", "../controllers/register.php", true);
      xhr.send();
    }
}

function fieldValidation(str, sample) {
    var res = str.match(sample);
    return (res != null);
}
