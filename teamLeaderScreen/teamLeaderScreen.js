// Function to handle "Answer" button click
$('.answer-btn').click(function(event) {
    event.stopPropagation();
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
    e.preventDefault();
    var response = $('#response').val();
    $('#response').val('');
    $('#answerForm').hide();
    $('#overlay').hide();
});

// Function to toggle modal visibility when objection item is clicked
$('.objection-item').click(function() {
    // Get the objection details
    var employeeId = $(this).find('.employee-id').text();
    var employeeFullName = $(this).find('.employee-fullname').text();
    var objectionDescription = $(this).find('.objection-description').text();
    var objectionMonth = $(this).find('.objection-month').text();

    // Populate the modal content with the objection details
    $('#objectionDetailsModal #employeeId').text(employeeId);
    $('#objectionDetailsModal #employeeFullName').text(employeeFullName);
    $('#objectionDetailsModal #objectionDescription').text(objectionDescription);
    $('#objectionDetailsModal #objectionMonth').text(objectionMonth);

    // Show the modal
    $('#objectionDetailsModal').addClass('show-modal');
});

// Function to close the modal when the close button is clicked
$('.close').click(function() {
    $('#objectionDetailsModal').removeClass('show-modal');
});