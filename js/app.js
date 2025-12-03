(function () {
  function showToast(message, type) {
    if (!message) return;

    var container = document.getElementById("toast-container");
    if (!container) return;

    var toast = document.createElement("div");
    toast.className = "toast toast-" + type;
    toast.textContent = message;

    container.appendChild(toast);

    setTimeout(function () {
      toast.classList.add("show");
    }, 50);

    setTimeout(function () {
      toast.classList.remove("show");
      setTimeout(function () {
        toast.remove();
      }, 300);
    }, 3000);
  }

  if (window.APP_FLASH) {
    if (APP_FLASH.success) {
      showToast(APP_FLASH.success, "success");
    }
    if (APP_FLASH.error) {
      showToast(APP_FLASH.error, "error");
    }
  }
})();

// Hide loader after page fully loads
window.addEventListener('load', () => {
  const loader = document.getElementById('loader');
  loader.classList.add('fade-out');
  setTimeout(() => loader.style.display = 'none', 500); // match CSS transition
});