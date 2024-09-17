var system = require('system');
var url = system.args[1];
var destination = system.args[2];
var fileType = system.args[3];
var fileToRender = destination + '/index.' + fileType;
console.log(fileToRender);

var page = require('webpage').create();
  //viewportSize being the actual size of the headless browser
  //page.viewportSize = { width: 1024, height: 768 };
  // //the clipRect is the portion of the page you are taking a screenshot of
  //page.clipRect = { top: 0, left: 0, width: 1024, height: 768 };
  //the rest of the code is the same as the previous example
  window.setTimeout(function(){

    page.open(url, function() {
      page.render(fileToRender);
      phantom.exit();
    });
  }, 1000);
