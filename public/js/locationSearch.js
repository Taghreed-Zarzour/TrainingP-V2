// locationSearch.js
// ملف جافاسكريبت للبحث عن الدول والمدن

class LocationSearch {
    constructor() {
        this.countries = [];
        this.cities = [];
        this.init();
    }

    // تهيئة البحث
    init() {
        this.loadCountries();
        this.setupEventListeners();
    }

    // تحميل بيانات الدول
    async loadCountries() {
        try {
            const response = await fetch('/countries');
            this.countries = await response.json();
            this.populateCountrySelects();
        } catch (error) {
            console.error('Error loading countries:', error);
        }
    }

    // تحميل بيانات المدن
    async loadCities() {
        try {
            const response = await fetch('/cities');
            this.cities = await response.json();
        } catch (error) {
            console.error('Error loading cities:', error);
        }
    }

    // تعبئة قوائم الدول
    populateCountrySelects() {
        const countrySelects = document.querySelectorAll('.country-select');
        
        countrySelects.forEach(select => {
            // حفظ القيمة المحددة حالياً
            const currentValue = select.value;
            
            // مسح الخيارات الحالية
            select.innerHTML = '<option value="" selected disabled>اختر الدولة</option>';
            
            // إضافة خيارات الدول
            this.countries.forEach(country => {
                const option = document.createElement('option');
                option.value = country.id;
                option.textContent = country.name;
                if (country.id == currentValue) {
                    option.selected = true;
                }
                select.appendChild(option);
            });
            
            // تشغيل حدث التغيير إذا كانت هناك قيمة محددة
            if (currentValue) {
                select.dispatchEvent(new Event('change'));
            }
        });
    }

    // إعداد مستمعي الأحداث
    setupEventListeners() {
        // مستمع لتغييرات اختيار الدولة
        document.addEventListener('change', async (e) => {
            if (e.target.classList.contains('country-select')) {
                const countryId = e.target.value;
                const citySelectId = e.target.dataset.citySelect;
                
                if (citySelectId) {
                    const citySelect = document.getElementById(citySelectId);
                    if (citySelect) {
                        await this.updateCities(citySelect, countryId);
                    }
                }
            }
            
            // مستمع لتغييرات اختيار الدولة في الفروع
            if (e.target.classList.contains('branch-country')) {
                const branchId = e.target.dataset.branch;
                const countryId = e.target.value;
                const citySelect = document.getElementById(`branch_city_${branchId}`);
                
                if (citySelect) {
                    await this.updateCities(citySelect, countryId);
                }
            }
        });

        // مستمع لفتح قائمة الدول
        document.addEventListener('click', (e) => {
            if (e.target.closest('.country-dropdown')) {
                const dropdown = e.target.closest('.country-dropdown');
                const flagOptions = dropdown.querySelector('.flag-options');
                
                if (flagOptions) {
                    flagOptions.style.display = flagOptions.style.display === 'flex' ? 'none' : 'flex';
                    e.stopPropagation();
                }
            }
        });

        // مستمع لإغلاق القوائم عند النقر خارجها
        document.addEventListener('click', (e) => {
            document.querySelectorAll('.flag-options').forEach(options => {
                if (!options.contains(e.target) && !e.target.closest('.country-dropdown')) {
                    options.style.display = 'none';
                }
            });
        });

        // مستمع للبحث في قائمة الدول
        document.addEventListener('input', (e) => {
            if (e.target.classList.contains('country-search')) {
                const searchTerm = e.target.value.toLowerCase();
                const flagItems = e.target.closest('.flag-options').querySelectorAll('.flag-item');
                
                flagItems.forEach(item => {
                    const countryName = item.querySelector('.country-name').textContent.toLowerCase();
                    const countryCode = item.getAttribute('data-code');
                    
                    if (countryName.includes(searchTerm) || countryCode.includes(searchTerm)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }
        });

        // مستمع لاختيار دولة من القائمة
        document.addEventListener('click', (e) => {
            if (e.target.closest('.flag-item')) {
                const item = e.target.closest('.flag-item');
                const dropdown = item.closest('.country-dropdown');
                const iso = item.getAttribute('data-iso');
                const code = item.getAttribute('data-code');
                const name = item.querySelector('.country-name').textContent;
                
                const selectedFlag = dropdown.querySelector('.selected-flag img');
                const phoneCode = dropdown.querySelector('.phone-code');
                const countryCodeInput = dropdown.querySelector('.country-code-input');
                
                if (selectedFlag) selectedFlag.src = `/flags/${iso}.svg`;
                if (phoneCode) phoneCode.textContent = code;
                if (countryCodeInput) countryCodeInput.value = code;
                
                const flagOptions = dropdown.querySelector('.flag-options');
                if (flagOptions) flagOptions.style.display = 'none';
                
                // تشغيل حدث التغيير
                dropdown.dispatchEvent(new CustomEvent('countryChanged', {
                    detail: { iso, code, name }
                }));
            }
        });
    }

    // تحديث قائمة المدن بناءً على الدولة المحددة
    async updateCities(citySelect, countryId) {
        // حفظ القيمة المحددة حالياً
        const currentValue = citySelect.value;
        
        // إذا لم يتم تحميل المدن بعد، قم بتحميلها
        if (this.cities.length === 0) {
            await this.loadCities();
        }
        
        // مسح الخيارات الحالية
        citySelect.innerHTML = '<option value="" selected disabled>اختر المدينة</option>';
        
        // فلترة المدن حسب الدولة
        const filteredCities = this.cities.filter(city => city.country_id == countryId);
        
        // إضافة خيارات المدن
        filteredCities.forEach(city => {
            const option = document.createElement('option');
            option.value = city.name;
            option.textContent = city.name;
            if (city.name == currentValue) {
                option.selected = true;
            }
            citySelect.appendChild(option);
        });
        
        // تحديث Select2 إذا كان مستخدماً
        if (typeof $ !== 'undefined' && $.fn.select2) {
            $(citySelect).trigger('change');
        }
    }

    // إضافة فرع جديد
    addBranch(branchesContainer, countries) {
        const branchCount = Date.now(); // استخدام الطابع الزمني كمعرّف فريد
        
        let countryOptions = `<option value="" disabled selected>اختر الدولة</option>`;
        countries.forEach(country => {
            countryOptions += `<option value="${country.id}">${country.name}</option>`;
        });
        
        const branchHtml = `
            <div class="row g-3 border p-3 rounded mb-3 position-relative branch-item m-3" id="branch_${branchCount}">
                <div class="col-md-6">
                    <label class="form-label">الدولة (فرع)</label>
                    <select class="form-select branch-country country-select" name="branch_country_id[]" data-branch="${branchCount}">
                        ${countryOptions}
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">المدينة (فرع)</label>
                    <select class="form-select city-select" name="branch_city[]" id="branch_city_${branchCount}">
                        <option value="" selected disabled>اختر المدينة</option>
                    </select>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2" onclick="this.parentElement.remove()" title="حذف الفرع"></button>
            </div>`;
        
        branchesContainer.insertAdjacentHTML('beforeend', branchHtml);
        
        // تحديث Select2 إذا كان مستخدماً
        if (typeof $ !== 'undefined' && $.fn.select2) {
            $(`#branch_${branchCount} .select2`).select2({
                width: '100%',
                language: {
                    noResults: function() {
                        return "لا توجد نتائج";
                    }
                }
            });
        }
        
        return branchCount;
    }

    // تهيئة البحث في قائمة الدول
    initCountrySearch() {
        const searchBoxes = document.querySelectorAll('.country-search');
        
        searchBoxes.forEach(searchBox => {
            searchBox.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const flagItems = this.closest('.flag-options').querySelectorAll('.flag-item');
                
                flagItems.forEach(item => {
                    const countryName = item.querySelector('.country-name').textContent.toLowerCase();
                    const countryCode = item.getAttribute('data-code');
                    
                    if (countryName.includes(searchTerm) || countryCode.includes(searchTerm)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }
}

// إنشاء نسخة من الفئة عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', () => {
    window.locationSearch = new LocationSearch();
});