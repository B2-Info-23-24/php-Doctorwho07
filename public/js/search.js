$(document).ready(function () {
  $("#search").keyup(function () {
    var searchValue = $(this).val();

    $.ajax({
      type: "POST",
      url: "/search_post",
      data: { search: searchValue },
      success: function (response) {
        $("#searchResults").html(response);

        $("#searchResults li").each(function (index) {
          var propertyId = $(this).data("property-id");
          $(this).attr("data-property-id", propertyId);
        });
      },
    });
  });

  $("#searchResults").on("click", "li", function () {
    var propertyId = $(this).data("property-id");
    var selectedValue = $(this).text();
    $("#search").val(selectedValue);
    $("#searchResults").empty();

    window.location.href = "/property/" + propertyId;
  });
});
