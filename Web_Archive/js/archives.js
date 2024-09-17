var successfulValidation = true;
var sentRequest = false;
var userExistence = false;
var result = false;

function functionValidation() {

    document.getElementById("error").innerHTML = "";

    successfulValidation = true;
    userExistence = false;
    sentRequest = false;
    result = false;

    var select = document.getElementById('archiveRank').value;

    if (select.localeCompare("") != 0) {
        document.getElementById("error").innerHTML = "";
        document.getElementById("archiveRank").style.borderColor = "gray";
    }
    else
    {
        document.getElementById("error").innerHTML = "Please select archive rank";
        successfulValidation = false;
        document.getElementById("archiveRank").style.borderColor = "red";
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

      xhr.open("POST", "../controllers/archives.php", true);
      xhr.send();
    }
  }
