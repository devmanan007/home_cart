document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function showToast(message, type = 'success') {
        const existing = document.getElementById('toast-container');
        let container = existing;
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:10px;';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
        toast.className = `alert ${bgColor} alert-dismissible fade show shadow`;
        toast.style.cssText = 'min-width:280px;animation:slideIn 0.3s ease;';
        toast.innerHTML = `
            <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'} me-1"></i>${message}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        `;
        container.appendChild(toast);

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    function updateCartBadge(count) {
        document.querySelectorAll('.cart-badge').forEach(badge => {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'inline-block' : 'none';
        });
    }

    document.querySelectorAll('[data-ajax-form]').forEach(form => {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const btn = form.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Loading...';

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                });

                const data = await response.json();

                if (data.success) {
                    showToast(data.message, 'success');
                    if (data.cart_count !== undefined) {
                        updateCartBadge(data.cart_count);
                    }

                    // Handle cart item removal
                    if (form.hasAttribute('data-cart-remove')) {
                        const row = form.closest('.cart-item') || form.closest('tr') || form.closest('[id^="wishlist-item"]');
                        if (row) {
                            row.style.transition = 'opacity 0.3s, transform 0.3s';
                            row.style.opacity = '0';
                            row.style.transform = 'translateX(20px)';
                            setTimeout(() => {
                                row.remove();
                                // Update totals if available
                                if (data.subtotal !== undefined) {
                                    const el = (id) => document.getElementById(id);
                                    if (el('cart-subtotal')) el('cart-subtotal').textContent = '₹' + parseFloat(data.subtotal).toFixed(2);
                                    if (el('cart-shipping')) el('cart-shipping').textContent = data.shipping > 0 ? '₹' + parseFloat(data.shipping).toFixed(2) : 'Free';
                                    if (el('cart-tax')) el('cart-tax').textContent = '₹' + parseFloat(data.tax).toFixed(2);
                                    if (el('cart-total')) el('cart-total').textContent = '₹' + parseFloat(data.total).toFixed(2);
                                }
                            }, 300);
                        }
                    }

                    // Handle wishlist item removal
                    if (form.hasAttribute('data-wishlist-remove')) {
                        const card = form.closest('[id^="wishlist-item"]');
                        if (card) {
                            card.style.transition = 'opacity 0.3s';
                            card.style.opacity = '0';
                            setTimeout(() => card.remove(), 300);
                        }
                    }
                } else {
                    showToast(data.message || 'Something went wrong.', 'error');
                }
            } catch (error) {
                // Fallback to normal form submit
                form.submit();
                return;
            }

            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    });

    // Auto-submit cart quantity updates
    document.querySelectorAll('[data-cart-update] input[name="quantity"]').forEach(input => {
        let timeout;
        input.addEventListener('change', function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                input.closest('form').dispatchEvent(new Event('submit', { bubbles: true }));
            }, 300);
        });
    });
});
