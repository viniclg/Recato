function addToCart(produtoId, tamanho, cor, name, price, image) {
    console.log('Tentando adicionar:', { produtoId, tamanho, cor, name, price, image });
    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const existingItem = cart.find(item => item.produtoId === produtoId && item.tamanho === tamanho && item.cor === cor);
    if (existingItem) {
        existingItem.qty += 1;
    } else {
        cart.push({ produtoId, tamanho, cor, name, price, image, qty: 1 });
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    console.log('Carrinho atual:', cart);
    alert(`${name} (${tamanho}, ${cor}) adicionado ao carrinho! 🛒`);
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