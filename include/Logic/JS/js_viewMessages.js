// JQuery script not by me. Easy enough now that I see it, but this was Google 101.
$(document).ready(function () {
  $(".thumb-imgs img").click(function () {
    $(".main-img img").attr("src", $(this).attr("src"));
  });
});

document.getElementById("sendPic").onchange = function () {
  var src = URL.createObjectURL(this.files[0]);
  document.getElementById("prevImg").src = src;
  document.getElementById("prevImg").style = "height: 150px; width: 150px;";
  document.getElementById("customFile1").style.display = "none";
  document.getElementById("removeBtn1").style.display = "inline-block";
  document.getElementById("removeBtn1").addEventListener("click", function () {
    removeFile("sendPic");
    document.getElementById("prevImg").src = "";
    document.getElementById("prevImg").style = "";
    document.getElementById("customFile1").style.display = "inline-block";
    document.getElementById("removeBtn1").style.display = "none";
  });
};

document.getElementById("sendPic2").onchange = function () {
  var src = URL.createObjectURL(this.files[0]);
  document.getElementById("prevImg2").src = src;
  document.getElementById("prevImg2").style = "height: 150px; width: 150px;";
  document.getElementById("customFile2").style.display = "none";
  document.getElementById("removeBtn2").style.display = "inline-block";
  document.getElementById("removeBtn2").addEventListener("click", function () {
    removeFile("sendPic2");
    document.getElementById("prevImg2").src = "";
    document.getElementById("prevImg2").style = "";
    document.getElementById("customFile2").style.display = "inline-block";
    document.getElementById("removeBtn2").style.display = "none";
  });
};

document.getElementById("sendPic3").onchange = function () {
  var src = URL.createObjectURL(this.files[0]);
  document.getElementById("prevImg3").src = src;
  document.getElementById("prevImg3").style = "height: 150px; width: 150px;";
  document.getElementById("customFile3").style.display = "none";
  document.getElementById("removeBtn3").style.display = "inline-block";
  document.getElementById("removeBtn3").addEventListener("click", function () {
    removeFile("sendPic3");
    document.getElementById("prevImg3").src = "";
    document.getElementById("prevImg3").style = "";
    document.getElementById("customFile3").style.display = "inline-block";
    document.getElementById("removeBtn3").style.display = "none";
  });
};
document.getElementById("sendPic4").onchange = function () {
  var src = URL.createObjectURL(this.files[0]);
  document.getElementById("prevImg4").src = src;
  document.getElementById("prevImg4").style = "height: 150px; width: 150px;";
  document.getElementById("customFile4").style.display = "none";
  document.getElementById("removeBtn4").style.display = "inline-block";
  document.getElementById("removeBtn4").addEventListener("click", function () {
    removeFile("sendPic4");
    document.getElementById("prevImg4").src = "";
    document.getElementById("prevImg4").style = "";
    document.getElementById("customFile4").style.display = "inline-block";
    document.getElementById("removeBtn4").style.display = "none";
  });
};

function removeFile(inputId) {
  var fileInput = document.getElementById(inputId);
  fileInput.value = "";
}
