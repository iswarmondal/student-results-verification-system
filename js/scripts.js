/*
	Author: S.k.joy
	Author URI: http://skjoy.info
*/

jQuery(document).ready(function ($) {
  $("#result-form").on("submit", function (e) {
    e.preventDefault();
    $(".loader").show();

    $.ajax({
      url: jsrms_object.ajaxUrl,
      type: "POST",
      data: {
        action: "jsrms_student_result_view",
        exam_reg: $("#exam-reg").val(),
      },
      success: function (response) {
        $(".jsrms-result").html(response);
        $(".loader").hide();
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
        $(".loader").hide();
        $(".jsrms-result").html(
          '<div class="result-error"><span>An error occurred. Please try again.</span></div>'
        );
      },
    });
  });
});
