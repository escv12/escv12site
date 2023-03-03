function showConfirmModal() {
    // Get the modal element
    var modal = document.getElementById("confirm-modal");

    // Get the confirm and cancel buttons
    var confirmBtn = document.getElementById("confirm-btn");
    var cancelBtn = document.getElementById("cancel-btn");

    // Show the modal
    modal.style.display = "block";

    // Set the button actions
    confirmBtn.onclick = function () {
        location.replace('./delete_account.php');
        modal.style.display = "none";
    };

    cancelBtn.onclick = function () {
        modal.style.display = "none";
    };
}