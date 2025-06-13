// resources/js/app.js

document.addEventListener('DOMContentLoaded', function () {
    // --- JavaScript untuk Mobile Menu ---
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const closeMobileMenuButton = document.getElementById('close-mobile-menu');
    const mobileMenuContainer = document.getElementById('mobile-menu');
    const mobileOverlayBg = document.getElementById('mobile-overlay-bg');
    const mobileMenuPanel = document.getElementById('mobile-menu-panel');

    // Fungsionalitas Buka Menu
    if (mobileMenuButton && mobileMenuContainer && mobileOverlayBg && mobileMenuPanel) {
        mobileMenuButton.addEventListener('click', function () {
            mobileMenuContainer.classList.remove('hidden'); // Tampilkan container utama

            requestAnimationFrame(() => {
                mobileOverlayBg.classList.remove('opacity-0');
                mobileOverlayBg.classList.add('opacity-75');

                mobileMenuPanel.classList.remove('translate-x-full');
            });
        });
    }

    // Fungsionalitas Tutup Menu
    const closeMenu = () => {
        mobileMenuPanel.classList.add('translate-x-full');
        mobileOverlayBg.classList.remove('opacity-75');
        mobileOverlayBg.classList.add('opacity-0');

        setTimeout(() => {
            mobileMenuContainer.classList.add('hidden');
        }, 300); 
    };

    if (closeMobileMenuButton && mobileMenuContainer && mobileOverlayBg && mobileMenuPanel) {
        closeMobileMenuButton.addEventListener('click', closeMenu);
    }

    // Fungsionalitas Tutup Menu (Klik di luar area menu putih - pada overlay)
    if (mobileMenuContainer && mobileOverlayBg && mobileMenuPanel) {
        mobileMenuContainer.addEventListener('click', function(event) {
            if (event.target === mobileOverlayBg) {
                closeMenu();
            }
        });
    }

    // --- JavaScript untuk Modal "Tambah ke Keranjang" ---
    const openModalButton = document.getElementById('openAddToCartModal');
    const addToCartModal = document.getElementById('addToCartModal');
    const closeModalButtonModal = document.getElementById('closeModalButton');
    const modalProductImage = document.getElementById('modalProductImage');
    const modalProductName = document.getElementById('modalProductName');
    const modalProductPrice = document.getElementById('modalProductPrice');
    const modalProductStock = document.getElementById('modalProductStock');
    const modalProductIdInput = document.getElementById('modalProductId');
    const modalAddToCartForm = document.getElementById('modalAddToCartForm');
    const modalQuantityInput = document.getElementById('modalQuantity');
    const displayQuantitySpan = document.getElementById('displayQuantity');
    const decrementButton = document.getElementById('decrementQuantity');
    const incrementButton = document.getElementById('incrementQuantity');

    let currentStock = 0; 

    if (openModalButton && addToCartModal && closeModalButtonModal && modalProductName && modalProductPrice && modalProductIdInput && modalAddToCartForm && modalQuantityInput && displayQuantitySpan && decrementButton && incrementButton && modalProductImage && modalProductStock) {
        openModalButton.addEventListener('click', function () {
            const productId = this.dataset.productId;
            const productName = this.dataset.productName;
            const productPrice = parseFloat(this.dataset.productPrice);
            const productImage = this.dataset.productImage;
            currentStock = parseInt(this.dataset.productStock); 

            modalProductImage.src = productImage;
            modalProductName.textContent = productName;
            modalProductPrice.textContent = `Rp ${productPrice.toLocaleString('id-ID')}`;
            modalProductStock.textContent = currentStock;
            modalProductIdInput.value = productId;

            modalQuantityInput.value = 1; 
            displayQuantitySpan.textContent = 1;
            modalQuantityInput.min = 1;
            modalQuantityInput.max = currentStock; 

            modalAddToCartForm.action = `/cart/add/${productId}`;

            addToCartModal.classList.remove('hidden');
            setTimeout(() => { 
                addToCartModal.classList.remove('opacity-0');
                addToCartModal.querySelector('div.bg-white').classList.remove('scale-95');
                addToCartModal.querySelector('div.bg-white').classList.add('scale-100', 'opacity-100');
            }, 10);
        });

        decrementButton.addEventListener('click', function () {
            let currentValue = parseInt(modalQuantityInput.value);
            if (currentValue > 1) { 
                modalQuantityInput.value = currentValue - 1;
                displayQuantitySpan.textContent = modalQuantityInput.value;
            }
        });

        incrementButton.addEventListener('click', function () {
            let currentValue = parseInt(modalQuantityInput.value);
            if (currentValue < currentStock) { 
                modalQuantityInput.value = currentValue + 1;
                displayQuantitySpan.textContent = modalQuantityInput.value;
            }
        });

        const closeAddToCartModal = () => {
            addToCartModal.querySelector('div.bg-white').classList.remove('scale-100', 'opacity-100');
            addToCartModal.querySelector('div.bg-white').classList.add('scale-95');
            
            setTimeout(() => { 
                addToCartModal.classList.add('opacity-0');
                addToCartModal.classList.add('hidden');
            }, 300); 
        };

        closeModalButton.addEventListener('click', closeAddToCartModal);

        addToCartModal.addEventListener('click', function(event) {
            if (event.target === addToCartModal) {
                closeAddToCartModal();
            }
        });
    }
});