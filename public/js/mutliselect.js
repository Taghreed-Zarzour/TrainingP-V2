document.addEventListener("DOMContentLoaded", function () {
    document
        .querySelectorAll("select.custom-multiselect")
        .forEach(function (select) {
            // Build wrapper
            const wrapper = document.createElement("div");
            wrapper.className = "custom-multiselect-wrapper";
            wrapper.tabIndex = 0;

            // Selected tags
            const selectedDiv = document.createElement("div");
            selectedDiv.className = "selected-options";

            // Input
            const input = document.createElement("input");
            input.type = "text";
            input.className = "custom-multiselect-input";
            input.placeholder = select.getAttribute('data-placeholder') || "ابحث أو اختر...";
            input.autocomplete = "off";

            // Options list
            const optionsList = document.createElement("div");
            optionsList.className = "options-list";

            // Arrow
            const arrow = document.createElement("span");
            arrow.className = "dropdown-arrow";
            arrow.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#000000" viewBox="0 0 256 256"><path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path></svg>`; // ▼

            // Clear button
            const clearBtn = document.createElement("button");
            clearBtn.type = "button";
            clearBtn.className = "clear-multiselect";
            clearBtn.title = "مسح الكل";
            clearBtn.innerHTML = "&times;";
            clearBtn.onclick = function (e) {
                e.stopPropagation();
                selected = [];
                updateSelect();
                renderSelected();
                renderOptions(input.value);
                wrapper.classList.remove("has-selection");
            };

            // Get options from select
            const options = Array.from(select.options).map((opt) => ({
                value: opt.value,
                text: opt.text,
                selected: opt.selected,
            }));

            let selected = options
                .filter((opt) => opt.selected)
                .map((opt) => opt.value);

            function renderOptions(filter = "") {
                optionsList.innerHTML = "";
                const filtered = options.filter(
                    (opt) =>
                        opt.text.includes(filter) &&
                        !selected.includes(opt.value)
                );
                if (filtered.length === 0) {
                    optionsList.innerHTML = `<div class="option-item" style="color:#aaa;cursor:default;">لا توجد نتائج</div>`;
                    return;
                }
                filtered.forEach((opt) => {
                    const div = document.createElement("div");
                    div.className = "option-item";
                    div.textContent = opt.text;
                    div.onclick = () => {
                        selected.push(opt.value);
                        updateSelect();
                        renderSelected();
                        input.value = "";
                        renderOptions();
                        optionsList.style.display = "none";
                        input.focus();
                    };
                    optionsList.appendChild(div);
                });
            }

            function renderSelected() {
                selectedDiv.innerHTML = "";
                selected.forEach((val) => {
                    const opt = options.find((o) => o.value === val);
                    if (!opt) return;
                    const tag = document.createElement("span");
                    tag.className = "selected-tag";
                    tag.innerHTML = `${opt.text} <span class="remove-tag" title="إزالة">&#10005;</span>`;
                    tag.querySelector(".remove-tag").onclick = (e) => {
                        e.stopPropagation();
                        selected = selected.filter((s) => s !== val);
                        updateSelect();
                        renderSelected();
                        renderOptions(input.value);
                    };
                    selectedDiv.appendChild(tag);
                });
                // Show clear button if any selected
                if (selected.length > 0) {
                    wrapper.classList.add("has-selection");
                } else {
                    wrapper.classList.remove("has-selection");
                }
            }

            function updateSelect() {
                // Update the original select element
                options.forEach((opt) => {
                    select.querySelector(
                        `option[value="${opt.value}"]`
                    ).selected = selected.includes(opt.value);
                });
                // Trigger change event if needed
                select.dispatchEvent(new Event("change"));
            }

            input.addEventListener("focus", () => {
                renderOptions(input.value);
                optionsList.style.display = "block";
                wrapper.classList.add("open");
            });

            input.addEventListener("click", () => {
                renderOptions(input.value);
                optionsList.style.display = "block";
                wrapper.classList.add("open");
            });

            input.addEventListener("input", () => {
                renderOptions(input.value);
                optionsList.style.display = "block";
            });

            wrapper.addEventListener("click", () => {
                input.focus();
            });

            document.addEventListener("click", (e) => {
                if (!wrapper.contains(e.target)) {
                    optionsList.style.display = "none";
                    wrapper.classList.remove("open");
                }
            });

            // Keyboard navigation
            input.addEventListener("keydown", (e) => {
                const items = Array.from(
                    optionsList.querySelectorAll(".option-item")
                );
                let idx = items.findIndex((item) =>
                    item.classList.contains("active")
                );
                if (e.key === "ArrowDown") {
                    e.preventDefault();
                    if (idx < items.length - 1) {
                        if (idx >= 0) items[idx].classList.remove("active");
                        items[++idx].classList.add("active");
                    } else if (items.length > 0) {
                        items.forEach((item) =>
                            item.classList.remove("active")
                        );
                        items[0].classList.add("active");
                    }
                } else if (e.key === "ArrowUp") {
                    e.preventDefault();
                    if (idx > 0) {
                        items[idx].classList.remove("active");
                        items[--idx].classList.add("active");
                    }
                } else if (e.key === "Enter" && idx >= 0) {
                    e.preventDefault();
                    items[idx].click();
                }
            });

            // Initial render
            renderSelected();

            // Build DOM
            wrapper.appendChild(selectedDiv);
            wrapper.appendChild(input);
            wrapper.appendChild(optionsList);
            wrapper.appendChild(clearBtn);
            wrapper.appendChild(arrow);
            select.parentNode.insertBefore(wrapper, select.nextSibling);

            if (select.classList.contains("error")) {
                wrapper.classList.add("error");
            }

            const observer = new MutationObserver(() => {
                if (select.classList.contains("error")) {
                    wrapper.classList.add("error");
                } else {
                    wrapper.classList.remove("error");
                }
            });
            observer.observe(select, {
                attributes: true,
                attributeFilter: ["class"],
            });
        });
});
