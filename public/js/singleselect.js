document.addEventListener("DOMContentLoaded", function () {
    document
        .querySelectorAll("select.custom-singleselect")
        .forEach(function (select) {
            window.initCustomSelect(select);
        });
});

window.initCustomSelect = function (select) {
    // إزالة المكون السابق إن وُجد
    const next = select.nextElementSibling;
    if (next && next.classList.contains("custom-singleselect-wrapper")) {
        next.remove();
    }

    const wrapper = document.createElement("div");
    wrapper.className = "custom-singleselect-wrapper";
    wrapper.tabIndex = 0;

    const input = document.createElement("input");
    input.type = "text";
    input.className = "custom-singleselect-input";
    input.placeholder = select.getAttribute('data-placeholder') || "ابحث أو اختر...";
    input.autocomplete = "off";

    const optionsList = document.createElement("div");
    optionsList.className = "options-list";

    const arrow = document.createElement("span");
    arrow.className = "dropdown-arrow";
    arrow.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#000000" viewBox="0 0 256 256"><path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path></svg>`;

    const options = Array.from(select.options).map((opt) => ({
        value: opt.value,
        text: opt.text,
        selected: opt.selected,
    }));

    let selected = select.value || "";

    function renderOptions(filter = "") {
        optionsList.innerHTML = "";
        const filtered = options.filter((opt) =>
            opt.text.includes(filter)
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
        input.value = opt ? opt.text : "";
    }

    function updateSelect() {
        select.value = selected;
        select.dispatchEvent(new Event("change"));
    }

    input.addEventListener("focus", () => {
        renderOptions("");
        optionsList.style.display = "block";
        wrapper.classList.add("open");
    });

    input.addEventListener("input", () => {
        renderOptions(input.value);
        optionsList.style.display = "block";
    });

    input.addEventListener("keydown", (e) => {
        const items = Array.from(optionsList.querySelectorAll(".option-item"));
        let idx = items.findIndex((item) =>
            item.classList.contains("active")
        );
        if (e.key === "ArrowDown") {
            e.preventDefault();
            if (idx < items.length - 1) {
                if (idx >= 0) items[idx].classList.remove("active");
                items[++idx].classList.add("active");
            } else if (items.length > 0) {
                items.forEach((item) => item.classList.remove("active"));
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

    document.addEventListener("click", (e) => {
        if (!wrapper.contains(e.target)) {
            optionsList.style.display = "none";
            wrapper.classList.remove("open");
        }
    });

    renderSelected();

    wrapper.appendChild(input);
    wrapper.appendChild(optionsList);
    wrapper.appendChild(arrow);
    select.parentNode.insertBefore(wrapper, select.nextSibling);

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
};
