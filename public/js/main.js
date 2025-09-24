
// تشغيل سلايدر شهادات مبكرة 
      
            document.addEventListener("DOMContentLoaded", function () {
                const wrapper = document.querySelector(".swiper-content");
                const slides = document.querySelectorAll(".swiper-slide");
                const bulletsContainer =
                    document.querySelector(".swiper-bullets");
                const nextBtn = document.querySelector(".next");
                const prevBtn = document.querySelector(".prev");

                let currentIndex = 0;

                function getSlidesPerView() {
                    return window.innerWidth > 800 ? 2 : 1;
                }

                function getTotalGroups() {
                    return Math.ceil(slides.length / getSlidesPerView());
                }

                function renderBullets() {
                    bulletsContainer.innerHTML = ""; // Clear old
                    const total = getTotalGroups();

                    for (let i = 0; i < total; i++) {
                        const bullet = document.createElement("div");
                        bullet.classList.add("bullet");
                        if (i === currentIndex) bullet.classList.add("active");
                        bullet.addEventListener("click", () => {
                            currentIndex = i;
                            updateSlider();
                        });
                        bulletsContainer.appendChild(bullet);
                    }
                }

                function updateSlider() {
                    const slidesPerView = getSlidesPerView();
                    const offset = (100 / slidesPerView) * currentIndex;
                    wrapper.style.transform = `translateX(${offset}%)`;

                    const bullets =
                        bulletsContainer.querySelectorAll(".bullet");
                    bullets.forEach((b, i) =>
                        b.classList.toggle("active", i === currentIndex)
                    );
                }

                function goNext() {
                    const maxIndex = getTotalGroups() - 1;
                    currentIndex =
                        currentIndex >= maxIndex ? 0 : currentIndex + 1;
                    updateSlider();
                }

                function goPrev() {
                    const maxIndex = getTotalGroups() - 1;
                    currentIndex =
                        (currentIndex - 1 + maxIndex + 1) % (maxIndex + 1);
                    updateSlider();
                }

                nextBtn?.addEventListener("click", goNext);
                prevBtn?.addEventListener("click", goPrev);

                window.addEventListener("resize", () => {
                    currentIndex = 0;
                    renderBullets();
                    updateSlider();
                });

                // Initial setup
                renderBullets();
                updateSlider();
            });
  