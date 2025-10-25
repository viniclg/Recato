<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moda Feminina - Black Friday</title>
    <link rel="stylesheet" href="style.css?v=5">
</head>
<body>
    <!-- Header com menu de navegação -->
    <header class="header">
        <nav class="nav">
            <div class="logo">ModaFem</div>
            <ul class="nav-links">
                <li><a href="#home">Início</a></li>
                <li><a href="#products">Produtos</a></li>
                <li><a href="#offers">Ofertas</a></li>
                <li><a href="#about">Sobre</a></li>
                <li><a href="#contact">Contato</a></li>
            </ul>
            <a href="carrinho.html" class="cart-icon">🛒 Carrinho</a>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>

    <!-- Banner principal -->
    <section class="hero" id="home">
        <h1 class="fade-in">Black Friday Exclusiva</h1>
        <p class="fade-in delay-1">Descontos incríveis de até 70% em toda a coleção de moda feminina</p>
        <button class="btn fade-in delay-2">Ver Ofertas</button>
    </section>

    <!-- Seção de produtos -->
<section class="products" id="products">
    <h2 class="section-title">Produtos em Destaque</h2>
    <div class="products-grid">
        <?php
        require_once 'produtos/config.php';
        try {
            $pdo->beginTransaction();
            // Usar LEFT JOIN para pegar o primeiro produto e sua variação
            $stmt = $pdo->prepare("SELECT p.*, pv.tamanho, pv.cor, pv.estoque, pv.imagem 
                                   FROM produtos p 
                                   LEFT JOIN produtos_variacoes pv ON p.id = pv.id_produto 
                                   WHERE p.ativo = 1 
                                   GROUP BY p.id 
                                   LIMIT 8");
            $stmt->execute();
            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();

            foreach ($produtos as $produto) {
                echo '<div class="product-card fade-in" data-product-id="' . htmlspecialchars($produto['id']) . '">
                        <a href="produto.php?id=' . htmlspecialchars($produto['id']) . '">
                            <img src="' . htmlspecialchars($produto['imagem']) . '" alt="' . htmlspecialchars($produto['nome']) . '" class="product-image">
                        </a>
                        <div class="product-info">
                            <h3 class="product-title">' . htmlspecialchars($produto['nome']) . '</h3>
                            <div class="product-price">
                                <span class="new-price">R$ ' . number_format($produto['preco'], 2, ',', '.') . '</span>
                            </div>
                            <a href="produto.php?id=' . htmlspecialchars($produto['id']) . '" class="btn">Ver Detalhes</a>
                        </div>
                    </div>';
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            $pdo->rollBack();
        }
        ?>
    </div>
</section>

    <!-- Seção de ofertas -->
    <section class="offers" id="offers">
        <h2 class="section-title">Ofertas da Black Friday</h2>
        <p>Faltam apenas alguns dias para a Black Friday! Aproveite nossas promoções relâmpago com descontos ainda maiores!</p>
        
        <div class="countdown">
            <div class="countdown-item">
                <div class="countdown-number" id="days">00</div>
                <div class="countdown-label">Dias</div>
            </div>
            <div class="countdown-item">
                <div class="countdown-number" id="hours">00</div>
                <div class="countdown-label">Horas</div>
            </div>
            <div class="countdown-item">
                <div class="countdown-number" id="minutes">00</div>
                <div class="countdown-label">Minutos</div>
            </div>
            <div class="countdown-item">
                <div class="countdown-number" id="seconds">00</div>
                <div class="countdown-label">Segundos</div>
            </div>
        </div>
        
        <button class="btn">Ver Todas as Ofertas</button>
    </section>

    <!-- Newsletter -->
    <section class="newsletter">
        <h2>Receba Nossas Ofertas</h2>
        <p>Cadastre-se em nossa newsletter e seja o primeiro a saber sobre nossas promoções exclusivas!</p>
        <form class="newsletter-form">
            <input type="email" class="newsletter-input" placeholder="Seu melhor e-mail" required>
            <button type="submit" class="newsletter-btn">Cadastrar</button>
        </form>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-column">
                <h3>ModaFem</h3>
                <p>Loja especializada em moda feminina com as últimas tendências e qualidade garantida.</p>
                <div class="social-icons">
                    <a href="#" class="social-icon">FB</a>
                    <a href="#" class="social-icon">IG</a>
                    <a href="#" class="social-icon">TT</a>
                </div>
            </div>
            <div class="footer-column">
                <h3>Links Rápidos</h3>
                <ul class="footer-links">
                    <li><a href="#home">Início</a></li>
                    <li><a href="#products">Produtos</a></li>
                    <li><a href="#offers">Ofertas</a></li>
                    <li><a href="#about">Sobre Nós</a></li>
                    <li><a href="#contact">Contato</a></li>
                    <li><a href="carrinho.html">🛒 Carrinho</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Categorias</h3>
                <ul class="footer-links">
                    <li><a href="#">Vestidos</a></li>
                    <li><a href="#">Blusas</a></li>
                    <li><a href="#">Calças</a></li>
                    <li><a href="#">Saias</a></li>
                    <li><a href="#">Acessórios</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Contato</h3>
                <ul class="footer-links">
                    <li>Email: contato@modafem.com</li>
                    <li>Telefone: (11) 9999-9999</li>
                    <li>Endereço: Rua da Moda, 123 - São Paulo, SP</li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2023 ModaFem. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="script.js?v=5"></script>
    <script src="cart.js?v=5"></script>
</body>
</html>