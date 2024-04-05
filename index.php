<?php

@include_once(__DIR__.'/src/Helpers/Auth.php');
@include_once(__DIR__.'/src/Helpers/Message.php');
@include_once(__DIR__.'/src/Database/Database.php');
@include_once(__DIR__ . '/template/head.inc.php');

setLastVisitedPage();
// Get all the categories
Database::query("SELECT * FROM `categories`");
$categories = Database::getAll();

// Check if any category is selected
$categoryFilter = '';
if (isset($_GET['category_id'])) {
    $categoryId = intval($_GET['category_id']);
    $categoryFilter = "WHERE `category_id` = $categoryId";
}

// Fetch products based on category filter
$query = "SELECT * FROM `products` $categoryFilter";
Database::query($query);
$products = Database::getAll();

?>
      <?php if (hasMessage('success')): ?>
         <div class="uk-alert-success" uk-alert>
            <a href class="uk-alert-close" uk-close></a>
            <p><?= getMessage('success') ?></p>
         </div>
      <?php endif; ?>

      <?php if (hasError('failed')) : ?>
         <div class="uk-alert-danger" uk-alert>
            <a href class="uk-alert-close" uk-close></a>
            <p><?= getError('failed') ?></p>
         </div>
      <?php endif; ?>

      <div class="uk-grid">
         <section class="uk-width-1-5">
            <h4>Categoriën</h4>
            <hr class="uk-divider" />
            <?php foreach ($categories as $category) : ?>
               <div>
                    <input class="category-checkbox" id="category_<?= $category->id ?>" type="checkbox" value="<?= $category->id ?>" name="category" onchange="filterProducts(<?= $category->id ?>)" />
                    <label for="category_<?= $category->id ?>"><?= $category->name ?></label>
               </div>
            <?php endforeach; ?>
         </section>
         <section class="uk-width-4-5">
            <h4 class="uk-text-muted uk-text-small">Gekozen categorieën: <span class="uk-text-small uk-text-primary">
               <?php
                  if(isset($_GET['category_id'])) {
                     $selectedCategory = $_GET['category_id'];
                     $selectedCategoryName = $categories[$selectedCategory - 1]->name;
                     echo $selectedCategoryName;
                  } else {
                     echo "Alle";
                  }
               ?>
            </span></h4>
            <div class="uk-flex uk-flex-home uk-flex-wrap">
               <?php foreach ($products as $product) : ?>
                  <a class="product-card uk-card uk-card-home uk-card-default uk-card-small uk-card-hover" href="product.php?product_id=<?= $product->id ?>">
                     <div class="uk-card-media-top uk-align-center">
                        <img src="<?= $product->image ?>" alt="Witte kip" class="product-image uk-align-center">
                     </div>
                     <div class="uk-card-body uk-card-body-home">
                        <p class="product-card-p uk-text-bold uk-margin-remove-bottom"><?= substr($product->name, 0, 89) ?></p>
                        <p class="product-card-p uk-margin-remove-top uk-margin-remove-bottom"><?= substr($product->description, 0, 89) ?></p>
                        <p class="product-card-p uk-margin-remove-top uk-margin-remove-bottom uk-text-large uk-text-bold uk-text-danger uk-text-right">&euro; <?= $product->price ?></p>
                     </div>
                  </a>
               <?php endforeach; ?>
            </div>
         </section>
      </div>
      <script src="js/index.js"></script>
<?php

include_once(__DIR__ . '/template/foot.inc.php');
?>

