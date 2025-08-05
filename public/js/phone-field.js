const countryBtn = document.getElementById("countryBtn");
const countryDropdown = document.getElementById("countryDropdown");
const countryCode = document.getElementById("countryCode");
const flagSpan = countryBtn.querySelector(".flag");

// Toggle dropdown
countryBtn.addEventListener("click", function (e) {
    e.stopPropagation();
    countryDropdown.style.display =
        countryDropdown.style.display === "block" ? "none" : "block";
});

// Select country
countryDropdown.querySelectorAll(".country-option").forEach((option) => {
    option.addEventListener("click", function () {
        countryCode.textContent = this.dataset.code;
        flagSpan.textContent = this.dataset.flag;
        countryDropdown.style.display = "none";
    });
});

// Hide dropdown on outside click
document.addEventListener("click", function (e) {
    countryDropdown.style.display = "none";
});
