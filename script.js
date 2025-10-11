// script.js
document.addEventListener('DOMContentLoaded', function() {
    updateCartCounter();
    
    // Adiciona event listeners aos botões "Comprar"
    document.querySelectorAll('.product-card .btn').forEach(button => {
        button.addEventListener('click', function() {
            console.log('Botão clicado!');
            const productCard = this.closest('.product-card');
            console.log('Product card encontrado:', productCard);
            
            // Pega os dados do produto
            const id = productCard.dataset.productId;
            const name = productCard.querySelector('.product-title').textContent;
            const priceText = productCard.querySelector('.new-price').textContent;
            const cleanPriceText = priceText.replace(/[^\d,.]/g, ''); // Remove tudo exceto números, vírgula e ponto
            const price = parseFloat(cleanPriceText.replace(',', '.')); // Converte para número
            const image = productCard.querySelector('.product-image').src;
            
            console.log('Dados do produto:', { id, name, price, image });
            
            // Verifica se todos os dados estão corretos
            if (!id || !name || isNaN(price) || !image) {
                console.error('Dados do produto incompletos:', { id, name, price, image });
                alert('Erro ao adicionar produto ao carrinho!');
                return;
            }
            
            addToCart(id, name, price, image);
        });
    });
    
    // Menu mobile toggle
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');
    if (hamburger && navLinks) {
        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            const spans = hamburger.querySelectorAll('span');
            if (navLinks.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });

        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
                const spans = hamburger.querySelectorAll('span');
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            });
        });
    }

    // Função para calcular a data da Black Friday (sexta após a quarta quinta de novembro)
    function getBlackFridayDate(year) {
        const nov1 = new Date(year, 10, 1); // Novembro é mês 10
        const nov1Weekday = nov1.getDay(); // 0=Dom, 1=Seg, ..., 6=Sáb
        // Offset para a primeira quinta: quinta é 4
        const firstThursdayOffset = (4 - nov1Weekday + 7) % 7;
        const firstThursday = 1 + firstThursdayOffset;
        const fourthThursday = firstThursday + 21; // Thanksgiving
        const blackFridayDay = fourthThursday + 1; // Sexta-feira seguinte
        return new Date(year, 10, blackFridayDay);
    }

    // Contador regressivo
    function updateCountdown() {
        const now = new Date();
        const currentYear = now.getFullYear();
        let blackFriday = getBlackFridayDate(currentYear);
        if (now > blackFriday) {
            blackFriday = getBlackFridayDate(currentYear + 1);
        }
        const timeDiff = blackFriday - now;
        if (timeDiff > 0) {
            const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);
            document.getElementById('days').textContent = days.toString().padStart(2, '0');
            document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
            document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
        }
    }
    setInterval(updateCountdown, 1000);
    updateCountdown();

    // Scroll suave
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Animação fade-in
    const fadeElements = document.querySelectorAll('.fade-in');
    const fadeInOnScroll = () => {
        fadeElements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;
            if (elementTop < window.innerHeight - elementVisible) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        });
    };
    window.addEventListener('scroll', fadeInOnScroll);
    window.addEventListener('load', fadeInOnScroll);
});