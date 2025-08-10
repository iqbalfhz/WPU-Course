document.addEventListener("DOMContentLoaded", function () {
    const toast = document.getElementById("toast-success-wrapper");
    if (toast) {
        setTimeout(() => {
            toast.classList.add("opacity-0", "transition", "duration-500");
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }
});
