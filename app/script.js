
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

let openDeleteConfirmation = document.getElementById('deleteAccount');
let closeDeleteConfirmation = document.getElementById('no');
let deleteConfirmation = document.getElementById('deleteAccountConfirmation');

openDeleteConfirmation.addEventListener('click', function () {
    deleteConfirmation.style.display = 'block';
});

closeDeleteConfirmation.addEventListener('click', function () {
    deleteConfirmation.style.display = 'none';
});