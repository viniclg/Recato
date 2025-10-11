function addToCart(id, name, price, image) {
    console.log('Tentando adicionar:', { id, name, price, image });
    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const existingItem = cart.find(item => item.id === id);
    if (existingItem) {
        existingItem.qty += 1;
    } else {
        cart.push({ id, name, price, image, qty: 1 });
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    console.log('Carrinho atual:', cart);
    alert(`${name} adicionado ao carrinho! 🛒`);
    updateCartCounter();
}

function updateCartCounter() {
    const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
    
    // Atualiza o ícone do carrinho no header
    const cartIcon = document.querySelector('.cart-icon');
    if (cartIcon) {
        cartIcon.innerHTML = `🛒 Carrinho ${totalItems > 0 ? `(${totalItems})` : ''}`;
    }
    
    // Atualiza o link do carrinho no footer
    const footerCartLink = document.querySelector('.footer-links a[href="carrinho.html"]');
    if (footerCartLink) {
        footerCartLink.innerHTML = `🛒 Carrinho ${totalItems > 0 ? `(${totalItems})` : ''}`;
    }
}