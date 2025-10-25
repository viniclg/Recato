<?php include 'extra/header.php'; ?>
<link rel="stylesheet" href="style.css">
<div class="container">
    <h1>Sua Sacola</h1>
    <div id="cart-items"></div>
    <div class="summary" id="cart-summary"></div>
    <div style="margin-top: 24px;">
        <a href="index.php">&larr; Continuar comprando</a>
    </div>
</div>

<?php include 'extra/footer.php'; ?>

<script src="cart.js?v=6"></script>
<script>
    function getCart() {
        return JSON.parse(localStorage.getItem('cart') || '[]');
    }
    function setCart(cart) {
        localStorage.setItem('cart', JSON.stringify(cart));
    }
    function renderCart() {
        const cart = getCart();
        const cartItemsDiv = document.getElementById('cart-items');
        const summaryDiv = document.getElementById('cart-summary');
        if (cart.length === 0) {
            cartItemsDiv.innerHTML = '<div class="empty-cart">Sua sacola está vazia.</div>';
            summaryDiv.innerHTML = '';
            return;
        }
        let total = 0;
        cartItemsDiv.innerHTML = cart.map((item, idx) => `
            <div class="cart-item">
                <img src="${item.image}" alt="${item.name}">
                <div class="cart-details">
                    <div><strong>${item.name}</strong> (Tamanho: ${item.tamanho}, Cor: ${item.cor})</div>
                    <div>R$ ${item.price.toFixed(2)}</div>
                </div>
                <div class="cart-actions">
                    <button class="qty-btn qty-minus" onclick="updateQty(${idx}, -1)">-</button>
                    <input type="text" class="qty-input" value="${item.qty}" readonly>
                    <button class="qty-btn qty-plus" onclick="updateQty(${idx}, 1)">+</button>
                    <button class="remove-btn" onclick="removeItem(${idx})">Remover</button>
                </div>
            </div>
        `).join('');
        total = cart.reduce((sum, item) => sum + item.price * item.qty, 0);
        summaryDiv.innerHTML = `
            <div><strong>Total:</strong> R$ ${total.toFixed(2)}</div>
            <button class="checkout-btn" onclick="checkout()">Finalizar Compra</button>
        `;
    }
    function updateQty(idx, delta) {
        const cart = getCart();
        cart[idx].qty += delta;
        if (cart[idx].qty < 1) cart[idx].qty = 1;
        setCart(cart);
        renderCart();
        updateCartCounter();
    }
    function removeItem(idx) {
        const cart = getCart();
        cart.splice(idx, 1);
        setCart(cart);
        renderCart();
        updateCartCounter();
    }
    function checkout() {
        alert('Compra finalizada! Obrigada por comprar na ModaFem.');
        setCart([]);
        renderCart();
        updateCartCounter();
    }
    renderCart();
</script>