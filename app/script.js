
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

    $(document).ready(function () {

        $('#deleteButton').click(function (event) {

            event.preventDefault();

            // Have to do a check to see if the form is filled in, otherwise the confirmation will show up even without data.
            if ($('#deleteForm')[0].checkValidity()) {
                $('#deleteAccountConfirmation').show();
            } else {
                $('#deleteForm')[0].reportValidity();
            }

        });

        $('#negative').click(function (event) {

            // Gotta make sure the form ain't submitting when you click the #negative button.
            event.preventDefault();
            event.stopPropagation();
            $('#deleteAccountConfirmation').hide();

        });

    });

});