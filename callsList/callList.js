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

// Function to handle form submission
// $('#newCallForm').submit(function(e) {
//     e.preventDefault(); // Prevent default form submission
//     // Get form values
//     var customerName = $('#customerName').val();
//     var callSubject = $('#callSubject').val();
//     var callDate = $('#callDate').val();
//     var startTime = $('#startTime').val();
//     var endTime = $('#endTime').val();
//     var callStatus = $('#callStatus').val();
//     // Construct call item HTML
//     var callItem = '<div class="call rounded">' +
//                     '<div class="row justify-content-between">' +
//                     '<p>Full Name: ' + customerName + '</p>' +
//                     '<p>Call Subject: ' + callSubject + '</p>' +
//                     '<p>Date: ' + callDate + '</p>' +
//                     '</div>' +
//                     '<div class="row m-0 justify-content-between">' +
//                     '<p>Start Time: ' + startTime + '</p>' +
//                     '<p>End Time: ' + endTime + '</p>' +
//                     '<p>Status: ' + callStatus + '</p>' +
//                     '</div>' +
//                     '</div>';
//     // Prepend the new call item to the calls list
//     $('.calls').prepend(callItem);
//     // Reset form fields
//     $('#newCallForm')[0].reset();
//     // Hide the pop-up form
//     $('#callForm').hide();
//     $('#overlay').hide();
// });