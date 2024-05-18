// Function to open the pop-up form
$('#newCallBtn').click(function() {
    $('#callForm').show();
    $('#overlay').show();
});

// Function to hide the pop-up form and overlay when overlay is clicked
$('#overlay').click(function() {
    $('#callForm').hide();
    $('#overlay').hide();
});
