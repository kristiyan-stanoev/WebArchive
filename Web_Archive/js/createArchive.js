var successfulValidation = true;
var sentRequest = false;
var userExistence = false;
var result = false;

function functionValidation() {

    document.getElementById("errorUrl").innerHTML = "";

    successfulValidation = true;
    userExistence = false;
    sentRequest = false;
    result = false;

    var url = document.getElementById("url").value;
    var archiveRank = document.getElementById("archiveRank").value;
    var downloadType = document.getElementById('downloadType').value;

    var urlSample = /^(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)$/gi;

    if (archiveRank.localeCompare("") != 0) {
        document.getElementById("errorRank").innerHTML = "";
        document.getElementById("archiveRank").style.borderColor = "gray";
    }
    else
    {
        document.getElementById("errorRank").innerHTML = "Please select archive rank";
        successfulValidation = false;
        document.getElementById("archiveRank").style.borderColor = "red";
    }
    if (downloadType.localeCompare("") != 0) {
        document.getElementById("errorDownload").innerHTML = "";
        document.getElementById("downloadType").style.borderColor = "gray";
    }
    else
    {
        document.getElementById("errorDownload").innerHTML = "Please select download type";
        successfulValidation = false;
        document.getElementById("downloadType").style.borderColor = "red";
    }
    if (fieldValidation(url, urlSample)) {
        document.getElementById("errorUrl").innerHTML = "";
        document.getElementById("url").style.borderColor = "gray";
    }
    else
    {
        document.getElementById("errorUrl").innerHTML = "Invaid URL";
        successfulValidation = false;
        document.getElementById("url").style.borderColor = "red";
    }

    if(successfulValidation)
    {
      document.getElementById("success").innerHTML = "";
      var xhr = new XMLHttpRequest();
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

      xhr.onload = function () {
        if (xhr.status == 200) {
          settings.success(xhr.response);
        } else {
          console.log(xhr);
        }
      };

      xhr.open("POST", "../controllers/createArchive.php", true);
      xhr.send();
    }

}

function fieldValidation(str, sample) {
    var res = str.match(sample);
    return (res != null);
}
