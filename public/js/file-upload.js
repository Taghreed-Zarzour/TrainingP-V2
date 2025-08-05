document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.file-upload-wrapper').forEach(function (wrapper) {
        const btn = wrapper.querySelector('.file-upload-btn');
        const input = wrapper.querySelector('.file-upload-input');
        const preview = wrapper.querySelector('.file-upload-preview');
        const multiple = wrapper.dataset.multiple === 'true';

        if (!btn || !input || !preview) return;

        btn.addEventListener('click', function () {
            input.click();
        });

        input.addEventListener('change', function () {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.innerHTML = `<img src="${e.target.result}" style="max-width:120px;max-height:120px;border-radius:8px;" />`;
                    };
                    reader.readAsDataURL(file);
                } else {
                    if (multiple) {
                        for (let i = 0; i < input.files.length; i++) {
                            const file = input.files[i];
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                const existingContent = preview.innerHTML;
                                const newFilePreview = `
                                        <div style="display: flex; align-items: center; gap: 8px; padding: 8px; background: #f5f5f5; border-radius: 6px; max-width: 300px; margin-bottom: 8px;">
                                            <span style="flex: 1; font-size: 14px; color: #333; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${file.name}</span>
                                            <button type="button" style="background: none; border: none; color: #e00; cursor: pointer; font-size: 16px; padding: 2px 6px;" onclick="this.parentElement.remove();">×</button>
                                        </div>
                                    `;
                                preview.innerHTML = existingContent + newFilePreview;
                            };
                            reader.readAsDataURL(file);
                        }
                    }
                }
            } else {
                preview.innerHTML = '';
            }
        });
    });
});