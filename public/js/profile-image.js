const input = document.getElementById("profileImageInput");
const preview = document.getElementById("profileImagePreview");

input.addEventListener("change", function () {
    if (this.files && this.files[0]) {
        const file = this.files[0];
        if (!file.type.startsWith("image/")) return;
        if (file.size > 5 * 1024 * 1024) {
            // 5MB
            alert("الملف أكبر من 5 ميجابايت!");
            this.value = "";
            return;
        }
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Profile Image">`;
        };
        reader.readAsDataURL(file);
    }
});
