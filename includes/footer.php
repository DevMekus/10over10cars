<!-- Toasts -->
<div class="toast-wrap" id="toastWrap" style="z-index:9999"></div>
<div id="toastContainer" aria-live="polite" style="position:fixed;right:20px;top:20px;z-index:9999"></div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.12/typed.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jwt-decode/build/jwt-decode.min.js"></script>






<script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/App.js"></script>

<script>
    AOS.init({
        duration: 800,
        once: true
    });
    feather.replace({
        width: 28,
        height: 28
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d"
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.select-tags').forEach((el) => {
            new TomSelect(el, {
                dropdownParent: "body", // append dropdown to body
                placeholder: "Select...",
                allowEmptyOption: true
            });

        });
    });
</script>