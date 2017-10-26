$(function() {
    $('input:text').keyup(function() {
        this.value = this.value.toLocaleUpperCase()
    });
});

var inputElement = document.getElementById("anexo_comprovante");
var cancelButton = document.getElementById("pseudoCancel");
var numFiles = 0;

inputElement.onclick = function(event) {
  var target = event.target || event.srcElement;
  console.log(target, "clicked.");
  console.log(event);
  if (target.value.length == 0) {
    console.log("Suspect Cancel was hit, no files selected.");
    cancelButton.onclick();
  } else {
    console.log("File selected: ", target.value);
    numFiles = target.files.length;
  }
}

inputElement.onchange = function(event) {
  var target = event.target || event.srcElement;
  console.log(target, "changed.");
  console.log(event);
  if (target.value.length == 0) {
    console.log("Suspect Cancel was hit, no files selected.");
    if (numFiles == target.files.length) {
      cancelButton.onclick();
    }
  } else {
    console.log("File selected: ", target.value);
    numFiles = target.files.length;
  }
}

inputElement.onblur = function(event) {
  var target = event.target || event.srcElement;
  console.log(target, "changed.");
  console.log(event);
  if (target.value.length == 0) {
    console.log("Suspect Cancel was hit, no files selected.");
    if (numFiles == target.files.length) {
      cancelButton.onclick();
    }
  } else {
    console.log("File selected: ", target.value);
    numFiles = target.files.length;
  }
}


cancelButton.onclick = function(event) {
  console.log("Pseudo Cancel button clicked.");
}
