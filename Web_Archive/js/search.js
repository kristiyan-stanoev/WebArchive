var successfulValidation = true;


function searchValidation()
{

  successfulValidation = true;

  var searchBox = document.getElementById('searchBox').value;

  if (searchBox.localeCompare("") == 0) {
      successfulValidation = false;
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

    xhr.open("POST", "../controllers/search.php", true);
    xhr.send();
  }
}
