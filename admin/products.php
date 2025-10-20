<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: index.php");
  exit();
}
include '../includes/db_connect.php';
include 'includes/header.php';

// Handle Add/Edit/Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $variety = mysqli_real_escape_string($conn, $_POST['variety']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $packaging = mysqli_real_escape_string($conn, $_POST['packaging']);
    $season = mysqli_real_escape_string($conn, $_POST['season']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);

    $image_main = '';
    if (isset($_FILES['image_main']) && $_FILES['image_main']['error'] == 0) {
      $image_main = 'uploads/products/' . basename($_FILES['image_main']['name']);
      move_uploaded_file($_FILES['image_main']['tmp_name'], '../' . $image_main);
    }

    $image_secondary = '';
    if (isset($_FILES['image_secondary']) && $_FILES['image_secondary']['error'] == 0) {
      $image_secondary = 'uploads/products/' . basename($_FILES['image_secondary']['name']);
      move_uploaded_file($_FILES['image_secondary']['tmp_name'], '../' . $image_secondary);
    }

    $sql = "INSERT INTO products (name, slug, description, variety, size, packaging, season, image_main, image_secondary, category_id) VALUES ('$name', '$slug', '$description', '$variety', '$size', '$packaging', '$season', '$image_main', '$image_secondary', '$category_id')";
    mysqli_query($conn, $sql);
    header("Location: products.php");
    exit();
  } elseif (isset($_POST['edit_product'])) {
    $id = mysqli_real_escape_string($conn, $_POST['edit_product']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    // ... (rest of the fields)
    $sql = "UPDATE products SET name = '$name' WHERE id = $id"; // Simplified for brevity
    mysqli_query($conn, $sql);
    header("Location: products.php");
    exit();
  } elseif (isset($_POST['delete_product'])) {
    $id = mysqli_real_escape_string($conn, $_POST['delete_product']);
    $sql = "DELETE FROM products WHERE id = $id";
    mysqli_query($conn, $sql);
    header("Location: products.php");
    exit();
  }
}
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
      <h1 class="mt-4">Manage Products</h1>

      <!-- Add Product Form -->
      <div class="card my-4">
        <div class="card-header">Add New Product</div>
        <div class="card-body">
          <form action="products.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="add_product">
            <!-- Form fields for product details -->
            <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Slug</label><input type="text" name="slug" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control"></textarea></div>
            <div class="mb-3"><label class="form-label">Variety</label><input type="text" name="variety" class="form-control"></div>
            <div class="mb-3"><label class="form-label">Size</label><input type="text" name="size" class="form-control"></div>
            <div class="mb-3"><label class="form-label">Packaging</label><input type="text" name="packaging" class="form-control"></div>
            <div class="mb-3"><label class="form-label">Season</label><input type="text" name="season" class="form-control"></div>
            <div class="mb-3"><label class="form-label">Category</label><select name="category_id" class="form-control"><option value="">Select Category</option><?php $cat_sql = "SELECT * FROM categories"; $cat_result = mysqli_query($conn, $cat_sql); while($cat_row = mysqli_fetch_assoc($cat_result)) { echo "<option value='" . $cat_row['id'] . "'>" . $cat_row['name'] . "</option>"; } ?></select></div>
            <div class="mb-3"><label class="form-label">Main Image</label><input type="file" name="image_main" class="form-control"></div>
            <div class="mb-3"><label class="form-label">Secondary Image</label><input type="file" name="image_secondary" class="form-control"></div>
            <button type="submit" class="btn btn-primary">Add Product</button>
          </form>
        </div>
      </div>

      <!-- Products Table -->
      <div class="card">
        <div class="card-header">All Products</div>
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id";
              $result = mysqli_query($conn, $sql);
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['category_name'] . "</td>";
                echo "<td>";
                echo "<a href='edit_product.php?id=" . $row['id'] . "' class='btn btn-sm btn-warning'>Edit</a>";
                echo "<form action='products.php' method='POST' style='display:inline-block;'><input type='hidden' name='delete_product' value='" . $row['id'] . "'><button type='submit' class='btn btn-sm btn-danger'>Delete</button></form>";
                echo "</td>";
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>