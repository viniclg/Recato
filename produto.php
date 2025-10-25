<?php
require_once 'produtos/config.php'; // Inclui a conexão PDO

// Pegar o ID do produto da URL
$produto_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($produto_id <= 0) {
    die("Produto não encontrado.");
}

try {
    // Buscar dados do produto
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id AND ativo = 1");
    $stmt->execute([':id' => $produto_id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produto) {
        die("Produto não encontrado.");
    }

    // Buscar todas as variações do produto
    $stmt_variacoes = $pdo->prepare("SELECT * FROM produtos_variacoes WHERE id_produto = :id_produto");
    $stmt_variacoes->execute([':id_produto' => $produto_id]);
    $variacoes = $stmt_variacoes->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($produto['nome']); ?> | ModaFem</title>
    <link rel="stylesheet" href="style.css?v=6">
</head>
<body>
    <!-- Header (reutilize de index.php) -->
    <?php include 'extra/header.php'; // Crie um arquivo header.php ou copie o header de index.php ?>

    <div class="container product-detail">
        <div class="product-gallery">
            <!-- Exibir a primeira imagem das variações como principal -->
            <img src="<?php echo htmlspecialchars($variacoes[0]['imagem']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="product-main-image">
        </div>
        <div class="product-info">
            <h1><?php echo htmlspecialchars($produto['nome']); ?></h1>
            <p class="product-description"><?php echo htmlspecialchars($produto['descricao']); ?></p>
            <p class="product-price">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>

            <!-- Seleção de variações -->
            <div class="product-variations">
                <label for="tamanho">Tamanho:</label>
                <select id="tamanho" name="tamanho">
                    <?php foreach ($variacoes as $variacao): ?>
                        <option value="<?php echo htmlspecialchars($variacao['tamanho']); ?>">
                            <?php echo htmlspecialchars($variacao['tamanho']); ?> (Estoque: <?php echo $variacao['estoque']; ?>)
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="cor">Cor:</label>
                <select id="cor" name="cor">
                    <?php foreach ($variacoes as $variacao): ?>
                        <option value="<?php echo htmlspecialchars($variacao['cor']); ?>">
                            <?php echo htmlspecialchars($variacao['cor']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Botão de compra -->
            <button class="btn add-to-cart" data-produto-id="<?php echo $produto_id; ?>">
                Adicionar ao Carrinho
            </button>
        </div>
    </div>

    <!-- Footer (reutilize de index.php) -->
    <?php include 'extra/footer.php'; // Crie um arquivo footer.php ou copie o footer de index.php ?>

    <script src="script.js?v=6"></script>
    <script src="cart.js?v=6"></script>
    <script>
        document.querySelector('.add-to-cart').addEventListener('click', function() {
            const produtoId = this.getAttribute('data-produto-id');
            const tamanho = document.getElementById('tamanho').value;
            const cor = document.getElementById('cor').value;
            const name = "<?php echo addslashes($produto['nome']); ?>";
            const price = <?php echo $produto['preco']; ?>;
            const image = "<?php echo addslashes($variacoes[0]['imagem']); ?>";

            // Chamar addToCart com as variações
            addToCart(produtoId, tamanho, cor, name, price, image);
        });
    </script>
</body>
</html>