const burgerButton = document.getElementById("burger-btn");
const closeButton = document.getElementById("mobile-menu-close-btn");
const mobileMenu = document.getElementById("mobile-menu");
burgerButton.addEventListener("click", () => {
    const isOpened = mobileMenu.classList.contains("opened");
    if (isOpened) {
        mobileMenu.classList.remove("opened");
    } else {
        mobileMenu.classList.add("opened");
    }
});

mobileMenu.addEventListener("click", () => {
    const isOpened = mobileMenu.classList.contains("opened");
    if (isOpened) {
        mobileMenu.classList.remove("opened");
    }
});
