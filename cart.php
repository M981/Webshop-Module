<?php
// Include necessary PHP files
@include_once(__DIR__.'/src/Helpers/Auth.php');
@include_once(__DIR__.'/src/Helpers/Message.php');
@include_once(__DIR__.'/src/Database/Database.php');

// Fetch cart items from the database along with product information including the image
Database::query("SELECT ci.*, p.name AS product_name, p.image AS product_image
                FROM cart_items AS ci 
                INNER JOIN products AS p ON ci.product_id = p.id
                WHERE ci.cart_id = (SELECT id FROM cart WHERE customer_id = :customer_id AND ordered = 0)", 
                [':customer_id' => user_id()]);

$cartItems = Database::getAll();


// Calculate total price
$totalPrice = 0;
foreach ($cartItems as $item) {
    // Fetch product price from the products table
    Database::query("SELECT price FROM products WHERE id = :product_id", [':product_id' => $item->product_id]);
    $product = Database::get();
    $totalPrice += $product->price * $item->amount;
}

// Start HTML output
@include_once(__DIR__ . '/template/head.inc.php');
?>

<script>
function updateQuantity() {
    <?php foreach ($cartItems as $item): ?>
        var cartId = <?= $item->cart_id ?>;
        var productId = <?= $item->product_id ?>;
        var amount = document.getElementById('amount_' + productId).value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'src/Formhandlers/change_amount.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                location.reload();
            }
        };
        xhr.send('cart_id=' + cartId + '&product_id=' + productId + '&amount=' + amount);
    <?php endforeach; ?>
}

</script>

<main class="uk-container uk-padding">
    <div class="uk-grid">
        <section class="uk-width-2-3 uk-flex uk-flex-column uk-cart-gap">
            <?php if (!empty($cartItems)): ?>
                <?php foreach ($cartItems as $item): ?>
                    <div class="uk-card-default uk-card-small uk-flex uk-flex-between">
                        <div class="uk-card-media-left uk-width-1-5">
                            <img src="<?= $item->product_image ?>" alt="Product Image" class="product-image uk-align-center">
                        </div>
                        <div class="uk-card-body uk-width-4-5 uk-flex uk-flex-between">
                            <div class="uk-width-3-4 uk-flex uk-flex-column">
                                <!-- Product naam, description -->
                                <h2><?= $item->product_name ?></h2>
                                <p class="uk-margin-remove-top">Beschrijving kort</p>
                            </div>
                            <div class="uk-width-1-4 uk-flex uk-flex-between uk-flex-middle uk-flex-center">
                               <!-- Hoeveelheid input -->
                                <div class="uk-width-3-4 uk-flex uk-flex-column uk-flex-middle">
                                    <input id="amount_<?= $item->product_id ?>" class="uk-form-controls uk-form-width-xsmall uk-text-medium" name="amount" value="<?= $item->amount ?>" type="number" />
                                </div>
                                <!-- Verwijder -->
                                <div class="uk-width-1-4">
                                    <form method="POST" action="src/Formhandlers/delete_product.php">
                                        <input type="hidden" name="cart_id" value="<?= $item->cart_id ?>">
                                        <input type="hidden" name="product_id" value="<?= $item->product_id ?>">
                                        <button type="submit" class="uk-link-cart-trash uk-flex uk-flex-column uk-flex-middle uk-text-danger uk-flex-1">
                                            <span uk-icon="icon: trash"></span>
                                            <span class="uk-text-xsmall">Verwijder</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
        <section class="uk-width-1-3">
            <div class="uk-card uk-card-default uk-card-small">
                <div class="uk-card-header uk-align-center">
                    <h2>Overzicht</h2>
                </div>
                <div class="uk-card-body">
                    <div class="uk-flex uk-flex-between uk-flex-middle">
                        <p class="uk-width-1-2">Artikelen (<?= count($cartItems) ?>)</p>
                        <p class="uk-width-1-2 uk-margin-remove-top uk-text-right">&euro; <?= number_format($totalPrice, 2) ?></p>
                    </div>
                    <div class="uk-width-1-4 ">
                        <button onclick="updateQuantity()" class="uk-button uk-button-primary">
                            Update
                        </button>
                    </div>
                </div>
                <?php if (!empty($cartItems)): ?>
                    <div class="uk-card-footer">
                        <div class="uk-flex uk-flex-between uk-flex-middle">
                            <p class="uk-width-1-2 uk-text-bold">Te betalen</p>
                            <p class="uk-width-1-2 uk-margin-remove-top uk-text-bold uk-text-right">&euro; <?= number_format($totalPrice, 2) ?></p>
                        </div>
                        <div class="uk-flex uk-flex-1 uk-flex-middle uk-flex-center uk-margin-medium-top">
                            <a href="order.php" class="uk-button uk-button-primary">
                                Verder naar bestellen
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>

<?php
// Include necessary footer PHP files
@include_once(__DIR__ . '/template/foot.inc.php');
?>
