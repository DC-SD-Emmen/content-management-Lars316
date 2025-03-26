
// This small piece of Javascript makes it so the gameform isn't visible unless you click the 'Add New Game' button

// This code selects the 'Add New Game' button and adds a click function to it.

let addButton = document.getElementById('addGame');
let gameForm = document.getElementById('gameForm');

addButton.addEventListener('click', function () {

    // This code checks if this display is set to none. If it is, it sets it to block. If not, it sets it back to none.
    if (gameForm.style.display == 'none') {
        gameForm.style.display = 'block';
    } else {
        gameForm.style.display = 'none';
    }

})

// Boy this code did just not wanna work at first, guess the program really wanted to delete accounts.
$(document).ready(function () { // for some reason the $ is causing an error in the console, but I have no idea what it's problem is.

    // $('#deleteButton').click(function (event) {
    //     let confirmation = confirm('Are you absolutely sure you want to delete your account? This action cannot be undone!');
    //     if (!confirmation) { // if the user decides to not delete their account, these two will prevent the form from submitting.
    //         event.preventDefault();
    //         event.stopPropagation();
    //     } else {
    //         // otherwise it will submit the form.
    //         $('#deleteForm').submit();
    //     }

    // });

    $(document).ready(function () {

        $('#deleteButton').click(function (event) {

            event.preventDefault();

            // Check if the form is valid
            if ($('#deleteForm')[0].checkValidity()) {
                $('#deleteAccountConfirmation').show();
            } else {
                // If the form is not valid, show the browser's validation messages
                $('#deleteForm')[0].reportValidity();
            }

        });

        // $('#affirmative').click(function (event) {

        //     event.preventDefault(); // Prevent default form submission
        //     $('#deleteAccountConfirmation').hide();
        //     $('#deleteForm')[0].submit(); // Submit the form programmatically

        // });

        $('#negative').click(function (event) {

            event.preventDefault(); // Prevent default form submission
            event.stopPropagation();
            $('#deleteAccountConfirmation').hide();

        });

    });

    // $('#deleteButton').click(function (event) {
    //     event.preventDefault();

    //     // Check if the form is valid
    //     if ($('#deleteForm')[0].checkValidity()) {
    //         $('#deleteAccountConfirmation').show();
    //     } else {
    //         // If the form is not valid, show the browser's validation messages
    //         $('#deleteForm')[0].reportValidity();
    //     }
    // });

    // $('#affirmative').click(function () {
    //     $('#deleteAccountConfirmation').hide();
    //     $('#deleteForm')[0].submit();
    // });

    // $('#negative').click(function () {
    //     // event.preventDefault();
    //     // event.stopPropagation();
    //     $('#deleteAccountConfirmation').hide();
    // });

    // $('#deleteButton').click(function (event) {
    //     event.preventDefault();
    //     $('#deleteAccountConfirmation').show();
    // });

    // $('#affirmative').click(function () {
    //     $('#deleteAccountConfirmation').hide();
    //     $('#deleteForm').submit();
    // });

    // $('#negative').click(function () {
    //     $('#deleteAccountConfirmation').hide();
    // });

});