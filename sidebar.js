var navIcon = document.getElementById("navIcon");
sideBarAHR = document.getElementById("sideBar");
navIcon.addEventListener("click", function () {
  if (sideBarAHR.classList.contains("active")) {
    sideBarAHR.classList.remove("active");
  } else {
    sideBarAHR.classList.add("active");
  }
});