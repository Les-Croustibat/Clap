/**
 * Autocomplementation
 */

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

/**
 * Mise en place d'étiquette
 */

$(function() {
  // Assign values to variables
  var $peopleList, $newItemForm;
  $peopleList = $('#people_list');
  $newItemForm = $('#newItemForm');
  
  // Listen to the event submit the form (always put preventDefault)
  $newItemForm.on('submit', function(e) {
      e.preventDefault();
      // Get the value of the imput with val()
      var text = $('#film_actor_director').val();
      // Add the retrieved value in the end of the list
      $peopleList.append('<li title="Cliquer pour enlever">' + text + '</li>');
      $('#film_actor_director').val('');
  });

  // Listen to the event click to remove items
  $peopleList.on('click', 'li', function() {
      var $this = $(this);
      $this.remove();
  });

});