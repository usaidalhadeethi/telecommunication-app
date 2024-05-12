// Function to handle "Answer" button click
$('.answer-btn').click(function(event) {
    // Prevent click event propagation to the parent (objection item)
    event.stopPropagation();
    // Show the answer pop-up modal
    $('#answerForm').show();
    $('#overlay').show();
});

// Function to hide the pop-up form and overlay when overlay is clicked
$('#overlay').click(function() {
    $('#answerForm').hide();
    $('#overlay').hide();
});

// Function to handle form submission
$('#answerObjectionForm').submit(function(e) {
    e.preventDefault(); // Prevent default form submission
    // Get form values
    var response = $('#response').val();
    // Reset form field
    $('#response').val('');
    // Hide the pop-up form
    $('#answerForm').hide();
    $('#overlay').hide();
});

// Function to toggle modal visibility when objection item is clicked
$('.objection-item').click(function() {
    var modal = $('#objectionDetailsModal');
    modal.addClass('show-modal');
});

// Function to close the modal when the close button is clicked
$('.close').click(function() {
    var modal = $('#objectionDetailsModal');
    modal.removeClass('show-modal');
});
