<!-- Loader Container -->
<div id="page-loader" style="
       position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    display: flex;
    align-items: center;
    z-index: 100001;
    justify-content: center;
    backface-visibility: hidden;
    background: #c8c8c87c;
">
    <div id="lottie-loader" style="width: 180px; height: 180px;"></div>
</div>

<!-- Lottie Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.10.2/lottie.min.js"></script>
<script>
    // تشغيل اللودر
    const loader = lottie.loadAnimation({
        container: document.getElementById('lottie-loader'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: "{{ asset('assets/loader.json') }}" // مسار اللودر
    });
window.addEventListener('beforeunload', () => {
    document.getElementById('page-loader').style.opacity = '1';
});

    // تأخير بسيط + إخفاء تدريجي
    window.addEventListener('load', function() {
        setTimeout(() => {
            const pageLoader = document.getElementById('page-loader');
            pageLoader.style.opacity = '0';
            setTimeout(() => pageLoader.style.display = 'none', 400);
        }, 1000); // تأخير ثانية واحدة (يمكن تعديلها)
    });
</script>
