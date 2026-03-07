/*--------------------------------------------------
  View All Faculty Button Toggle
---------------------------------------------------*/
$(document).ready(function () {
  let isExpanded = false;

  $("#view-all-faculty-btn").click(function () {
    if (!isExpanded) {
      // Show all faculty
      $(".extra-faculty").removeClass("d-none").hide().fadeIn(500);
      $(this).html("Show Less <i class='bx bx-up-arrow-alt'></i>");
      isExpanded = true;
    } else {
      // Hide extra faculty
      $(".extra-faculty").fadeOut(300, function () {
        // Add the classes back after fade out completes
        $(this).addClass("d-none");
      });
      $(this).html("View All Faculty <i class='bx bx-down-arrow-alt'></i>");
      isExpanded = false;

      // Optional: scroll back to the top of the faculty section
      $('html, body').animate({
        scrollTop: $("#faculty-grid").offset().top - 100
      }, 300);
    }
  });
});
