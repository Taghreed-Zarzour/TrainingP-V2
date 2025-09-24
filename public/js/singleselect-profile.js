document.addEventListener("DOMContentLoaded", function () {
    document
        .querySelectorAll("select.custom-singleselect-profile")
        .forEach(function (select) {
            // Build wrapper
            const wrapper = document.createElement("div");
            wrapper.className = "custom-singleselect-wrapper";
            wrapper.tabIndex = 0;

            // Input for searching/selection
            const input = document.createElement("input");
            input.type = "text";
            input.className = "custom-singleselect-input";
            input.placeholder = select.getAttribute('data-placeholder') || "ابحث أو اختر...";
            input.autocomplete = "off";

            // Options list
            const optionsList = document.createElement("div");
            optionsList.className = "options-list";

            // Arrow
            const arrow = document.createElement("span");
            arrow.className = "dropdown-arrow";
            arrow.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#000000" viewBox="0 0 256 256"><path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path></svg>`; // ▼

            // Get options from select
            const options = Array.from(select.options).map((opt) => ({
                value: opt.value,
                name: opt.getAttribute("data-name") || opt.text,
                email: opt.getAttribute("data-email") || "",
                image: opt.getAttribute("data-image") || "",
                id: opt.getAttribute("data-id") || "",
                selected: opt.selected,
            }));

            let selected = select.value;

            function renderOptions(filter = "") {
                optionsList.innerHTML = "";
                const filtered = options.filter((opt) =>
                    opt.name.includes(filter) || opt.email.includes(filter)
                );
                if (filtered.length === 0) {
                    optionsList.innerHTML = `<div class="option-item" style="color:#aaa;cursor:default;">لا توجد نتائج</div>`;
                    return;
                }
                filtered.forEach((opt) => {
                    const div = document.createElement("div");
                    div.className = "option-item user-option";
                    div.innerHTML = `
                        <img class="user-img" src="${opt.image}" alt="${opt.name}" />
                        <div class="user-info">
                            <div class="user-name">${opt.name}</div>
                            <div class="user-email">${opt.email}</div>
                        </div>
                    `;
                    if (opt.value === selected) div.classList.add("active");
                    div.onclick = () => {
                        selected = opt.value;
                        updateSelect();
                        renderSelected();
                        optionsList.style.display = "none";
                        wrapper.classList.remove("open");
                    };
                    optionsList.appendChild(div);
                });
            }

            function renderSelected() {
                const opt = options.find((o) => o.value === selected);
                if (opt) {
                    input.value = `${opt.name}`;
                    input.setAttribute("data-image", opt.image);
                    input.setAttribute("data-id", opt.id);
                } else {
                    input.value = "";
                    input.removeAttribute("data-image");
                    input.removeAttribute("data-id");
                }
            }

            function updateSelect() {
                select.value = selected;
                select.dispatchEvent(new Event("change"));
            }

            // Show options on input focus/click
            input.addEventListener("focus", () => {
                input.value = "";
                renderOptions("");
                optionsList.style.display = "block";
                wrapper.classList.add("open");
            });

            input.addEventListener("input", () => {
                renderOptions(input.value);
                optionsList.style.display = "block";
            });

            input.addEventListener("click", () => {
                input.value = "";
                renderOptions("");
                optionsList.style.display = "block";
                wrapper.classList.add("open");
            });

            // Hide options on outside click
            document.addEventListener("click", (e) => {
                if (!wrapper.contains(e.target)) {
                    optionsList.style.display = "none";
                    wrapper.classList.remove("open");
                    renderSelected();
                }
            });

            // Initial render
            renderSelected();

            // Build DOM
            wrapper.appendChild(input);
            wrapper.appendChild(optionsList);
            wrapper.appendChild(arrow);
            select.parentNode.insertBefore(wrapper, select.nextSibling);

            // Hide original select
            select.style.display = "none";
        });

    




        
}); 