$(function() {
    var availableTags = [
      "Albert",
      "Aurore",
      "Abib",
      "Bebert",
      "Bart",
    ];
    $("#tags").autocomplete({
      source: availableTags
    });
});