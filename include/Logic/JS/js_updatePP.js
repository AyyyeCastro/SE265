document.getElementById("userProfilePicture").onchange = function () {
  var src = URL.createObjectURL(this.files[0]);
  document.getElementById("newUserPP").src = src;
  document.getElementById("newUserPP").style="background-color: #F1F1F1;"

  // Add an indicator to let the user know that the photo is ready to be submitted
  document.getElementById("photoIndicator").innerHTML =
    "Check to apply updated picture.";
  document.getElementById("btnUpdatePPBox").innerHTML =
    "<button type='submit' class='btnUpdatePP'><i class='fa-solid fa-square-check fa-xl'></i></button>";
};
