// Mock data for bonus list
// var bonusList = [
//     { month: 'January', amount: 100 },
//     { month: 'February', amount: 150 },
//     { month: 'March', amount: 200 },
//     { month: 'April', amount: 180 },
//     { month: 'May', amount: 220 }
// ];

// Function to display bonus list
// function displayBonusList() {
//     $('.bonus-list').empty(); // Clear existing bonus list items
//     bonusList.forEach(function(bonus, index) {
//         var bonusItem = '<div class="bonus mb-3 rounded">' +
//                             '<div class="row justify-content-between">' +
//                                 '<p>' + bonus.month + '</p>' +
//                                 '<p>' + bonus.amount + '</p>' +
//                             '</div>'; // Close row here
//         if (index === bonusList.length - 1) {
//             bonusItem += '<div>'+
//                         '<button class="btn btn-primary d-block objection-btn m-auto rounded-0">Objection</button>' +
//                         '</div>';
//         }
//         bonusItem += '</div>'; // Close bonus div here
//         $('.bonus-list').append(bonusItem);
//     });
// }

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
