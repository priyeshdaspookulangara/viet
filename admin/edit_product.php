<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: index.php");
  exit();
}
include '../includes/db_connect.php';
include 'includes/header.php';

$product_id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);
?>

<div class="d-flex" id="wrapper">
  <?php include 'includes/sidebar.php'; ?>
  <div id="page-content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
      <div class="container-fluid">
        <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>
      </div>
    </nav>
    <div class="container-fluid">
      <h1 class="mt-4">Edit Product</h1>

      <div class="card my-4">
        <div class="card-header">Edit Product Details</div>
        <div class="card-body">
          <form action="products.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="edit_product" value="<?php echo $product['id']; ?>">

            <div class="mb-3">
              <label for="name" class="form-label">Product Name</label>
              <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>

            <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" value="<?php echo htmlspecialchars($product['slug']); ?>" required>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>

            <div class="mb-3">
              <label for="variety" class="form-label">Variety</label>
              <input type="text" class="form-control" id="variety" name="variety" value="<?php echo htmlspecialchars($product['variety']); ?>">
            </div>

            <div class="mb-3">
              <label for="size" class="form-label">Size</label>
              <input type="text" class="form-control" id="size" name="size" value="<?php echo htmlspecialchars($product['size']); ?>">
            </div>

            <div class="mb-3">
              <label for="packaging" class="form-label">Packaging</label>
              <input type="text" class="form-control" id="packaging" name="packaging" value="<?php echo htmlspecialchars($product['packaging']); ?>">
            </div>

            <div class="mb-3">
              <label for="season" class="form-label">Season</label>
              <input type="text" class="form-control" id="season" name="season" value="<?php echo htmlspecialchars($product['season']); ?>">
            </div>

            <div class="mb-3">
              <label for="category_id" class="form-label">Category</label>
              <select class="form-control" id="category_id" name="category_id">
                <?php
                $cat_sql = "SELECT * FROM categories";
                $cat_result = mysqli_query($conn, $cat_sql);
                while ($cat_row = mysqli_fetch_assoc($cat_result)) {
                  $selected = ($cat_row['id'] == $product['category_id']) ? 'selected' : '';
                  echo "<option value='" . $cat_row['id'] . "' " . $selected . ">" . htmlspecialchars($cat_row['name']) . "</option>";
                }
                ?>
              </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>