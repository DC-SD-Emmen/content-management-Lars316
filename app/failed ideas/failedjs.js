
// Function to handle the dynamic 'required' attribute based on the first input
function toggleRequired() {
    var firstInput = document.getElementById("storygenre");
    var secondInput = document.getElementById("description");

    // If the first field is filled in, make the second field required
    if (firstInput.value.trim() !== "") {
        secondInput.setAttribute("required", "true");
    } else {
        secondInput.removeAttribute("required");
    }
}