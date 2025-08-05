function openModal(modalId) {
    document.getElementById(modalId).style.display = "block";
    document.getElementById("customModalOverlay").style.display = "block";
    document.body.style.overflow = "hidden";
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
    document.getElementById("customModalOverlay").style.display = "none";
    document.body.style.overflow = "";
}

// Close on X
document.querySelectorAll(".modal-close").forEach(function (btn) {
    btn.onclick = function () {
        closeModal(this.dataset.modal);
    };
});

// Close on overlay click
document.querySelectorAll(".modal-overlay").forEach(function (overlay) {
    overlay.onclick = function () {
        const overlayId = this.id;
        const modalId = overlayId.replace("Overlay", "");
        closeModal(modalId, overlayId);
    };
});

// Optional: Close on ESC key (closes all modals)
document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
        document.querySelectorAll(".custom-modal").forEach(function (modal) {
            modal.style.display = "none";
        });
        document.querySelectorAll(".modal-overlay").forEach(function (overlay) {
            overlay.style.display = "none";
        });
        document.body.style.overflow = "";
    }
});
