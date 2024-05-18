// Function to hide the pop-up form and overlay when overlay is clicked
$('#overlay').click(function() {
    $('#objectionForm').hide();
    $('#overlay').hide();
});

// Function to open the objection pop-up form
$(document).on('click', '.objection-btn', function() {
    $('#overlay').show();
    $('#objectionForm').show();
});

// Function to handle objection form submission
$('#objectionSubmitForm').submit(function(e) {
    e.preventDefault(); // Prevent default form submission
    var objectionExplanation = $('#objectionExplanation').val();
    // Here you can handle the objection submission, e.g., saving to the system and sending email
    console.log('Objection Explanation:', objectionExplanation);
    // Reset form fields
    $('#objectionExplanation').val('');
    // Hide the pop-up form
    $('#objectionForm').hide();
    $('#overlay').hide();
});

// Display the bonus list when the page loads
$(document).ready(function() {
    displayBonusList();
});
