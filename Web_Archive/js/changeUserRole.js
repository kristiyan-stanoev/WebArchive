var successfulValidation = true;
var sentRequest = false;
var userExistence = false;
var result = false;

function functionValidation() {

    document.getElementById("errorUsername").innerHTML = "";

    successfulValidation = true;
    userExistence = false;
    sentRequest = false;
    result = false;

    var username = document.getElementById("username").value;
    var userRole = document.getElementById("userRole").value;

    if (username.localeCompare("") != 0) {
        document.getElementById("errorUsername").innerHTML = "";
        document.getElementById("username").style.borderColor = "gray";
    }
    else
    {
        document.getElementById("errorUsername").innerHTML = "Please provide a username";
        successfulValidation = false;
        document.getElementById("username").style.borderColor = "red";
    }
    if (userRole.localeCompare("") != 0) {
        document.getElementById("errorUserRole").innerHTML = "";
        document.getElementById("userRole").style.borderColor = "gray";
    }
    else
    {
        document.getElementById("errorUserRole").innerHTML = "Please provide user role";
        successfulValidation = false;
        document.getElementById("userRole").style.borderColor = "red";
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

      xhr.open("POST", "../controllers/changeUserRole.php", true);
      xhr.send();
    }

}
