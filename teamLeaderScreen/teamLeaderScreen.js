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

// Function to close the modal when the overlay (outside the modal content) is clicked
$('#objectionDetailsModal').click(function(event) {
    if ($(event.target).is('#objectionDetailsModal')) {
        $('#objectionDetailsModal').removeClass('show-modal');
    }
});