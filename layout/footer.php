</div> </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const el = document.getElementById("wrapper");
    const toggleButton = document.getElementById("menu-toggle");

    if (el && toggleButton) {
        if (window.matchMedia("(max-width: 992px)").matches) {
            el.classList.add("toggled");
        }

        toggleButton.addEventListener("click", function () {
            el.classList.toggle("toggled");
        });
    }
</script>

</body>
</html>
