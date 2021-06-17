$(document).ready(function(){
$("#filter").keyup(function(){
  var filter = $(this).val(), count = 0;
  $(".slist tr").each(function(){
      if ($(this).text().search(new RegExp(filter, "i")) < 0) {
          $(this).fadeOut();
      } else {
          $(this).show();
          count++;
      }
    });
    // Update the count
    var numberItems = count;
    $("#filter-count").text("");
  });
});
