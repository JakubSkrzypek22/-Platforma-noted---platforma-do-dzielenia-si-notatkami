window.onload = function (e) {
    var toastList = document.querySelectorAll('.toast');
    toastList.forEach(toast => {
        // Set transition styles programmatically if not fully declared in utility classes
        toast.style.transition = 'opacity 0.3s ease-in-out';
        toast.style.opacity = '1';
        
        // Find close buttons and add click handler to close manually
        const closeBtn = toast.querySelector('.btn-close, [data-close]');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                toast.style.opacity = '0';
                setTimeout(() => toast.style.display = 'none', 300);
            });
        }
        
        // Auto-close after 5 seconds
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => {
                toast.style.display = 'none';
            }, 300);
        }, 5000);
    });
}
