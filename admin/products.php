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
    $category_id = (int)$_POST['category_id'];
    $information = mysqli_real_escape_string($conn, $_POST['information']);
    $packaging_info = mysqli_real_escape_string($conn, $_POST['packaging_info']);
    $storage_conditions = mysqli_real_escape_string($conn, $_POST['storage_conditions']);
    $shelf_life = mysqli_real_escape_string($conn, $_POST['shelf_life']);
    $spec_colour = mysqli_real_escape_string($conn, $_POST['spec_colour']);
    $spec_odor_flavor = mysqli_real_escape_string($conn, $_POST['spec_odor_flavor']);
    $spec_ingredients = mysqli_real_escape_string($conn, $_POST['spec_ingredients']);
    $spec_brix = mysqli_real_escape_string($conn, $_POST['spec_brix']);
    $spec_acidity = mysqli_real_escape_string($conn, $_POST['spec_acidity']);
    $spec_ph = mysqli_real_escape_string($conn, $_POST['spec_ph']);
    $spec_pulp = mysqli_real_escape_string($conn, $_POST['spec_pulp']);
    $spec_additives = mysqli_real_escape_string($conn, $_POST['spec_additives']);

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

    $sql = "INSERT INTO products (name, slug, description, variety, size, packaging, season, image_main, image_secondary, category_id, information, packaging_info, storage_conditions, shelf_life, spec_colour, spec_odor_flavor, spec_ingredients, spec_brix, spec_acidity, spec_ph, spec_pulp, spec_additives) VALUES ('$name', '$slug', '$description', '$variety', '$size', '$packaging', '$season', '$image_main', '$image_secondary', $category_id, '$information', '$packaging_info', '$storage_conditions', '$shelf_life', '$spec_colour', '$spec_odor_flavor', '$spec_ingredients', '$spec_brix', '$spec_acidity', '$spec_ph', '$spec_pulp', '$spec_additives')";
    mysqli_query($conn, $sql);
    header("Location: products.php");
    exit();
  } elseif (isset($_POST['edit_product'])) {
    $id = (int)$_POST['edit_product'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $variety = mysqli_real_escape_string($conn, $_POST['variety']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $packaging = mysqli_real_escape_string($conn, $_POST['packaging']);
    $season = mysqli_real_escape_string($conn, $_POST['season']);
    $category_id = (int)$_POST['category_id'];
    $information = mysqli_real_escape_string($conn, $_POST['information']);
    $packaging_info = mysqli_real_escape_string($conn, $_POST['packaging_info']);
    $storage_conditions = mysqli_real_escape_string($conn, $_POST['storage_conditions']);
    $shelf_life = mysqli_real_escape_string($conn, $_POST['shelf_life']);
    $spec_colour = mysqli_real_escape_string($conn, $_POST['spec_colour']);
    $spec_odor_flavor = mysqli_real_escape_string($conn, $_POST['spec_odor_flavor']);
    $spec_ingredients = mysqli_real_escape_string($conn, $_POST['spec_ingredients']);
    $spec_brix = mysqli_real_escape_string($conn, $_POST['spec_brix']);
    $spec_acidity = mysqli_real_escape_string($conn, $_POST['spec_acidity']);
    $spec_ph = mysqli_real_escape_string($conn, $_POST['spec_ph']);
    $spec_pulp = mysqli_real_escape_string($conn, $_POST['spec_pulp']);
    $spec_additives = mysqli_real_escape_string($conn, $_POST['spec_additives']);

    $sql = "UPDATE products SET name = '$name', slug = '$slug', description = '$description', variety = '$variety', size = '$size', packaging = '$packaging', season = '$season', category_id = $category_id, information = '$information', packaging_info = '$packaging_info', storage_conditions = '$storage_conditions', shelf_life = '$shelf_life', spec_colour = '$spec_colour', spec_odor_flavor = '$spec_odor_flavor', spec_ingredients = '$spec_ingredients', spec_brix = '$spec_brix', spec_acidity = '$spec_acidity', spec_ph = '$spec_ph', spec_pulp = '$spec_pulp', spec_additives = '$spec_additives' WHERE id = $id";
    mysqli_query($conn, $sql);
    header("Location: products.php");
    exit();
  } elseif (isset($_POST['delete_product'])) {
    $id = (int)$_POST['delete_product'];
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
            <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" required onkeyup="document.getElementById('slug').value = generateSlug(this.value)"></div>
            <div class="mb-3"><label class="form-label">Slug</label><input type="text" name="slug" id="slug" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control"></textarea></div>
            <div class="mb-3"><label class="form-label">Variety</label><input type="text" name="variety" class="form-control"></div>
            <div class="mb-3"><label class="form-label">Size</label><input type="text" name="size" class="form-control"></div>
            <div class="mb-3"><label class="form-label">Packaging</label><input type="text" name="packaging" class="form-control"></div>
            <div class="mb-3"><label class="form-label">Season</label><input type="text" name="season" class="form-control"></div>
            <div class="mb-3"><label class="form-label">Category</label><select name="category_id" class="form-control"><option value="">Select Category</option><?php $cat_sql = "SELECT * FROM categories"; $cat_result = mysqli_query($conn, $cat_sql); while($cat_row = mysqli_fetch_assoc($cat_result)) { echo "<option value='" . $cat_row['id'] . "'>" . htmlspecialchars($cat_row['name']) . "</option>"; } ?></select></div>
            <div class="mb-3"><label class="form-label">Main Image</label><input type="file" name="image_main" class="form-control"></div>
            <div class="mb-3"><label class="form-label">Secondary Image</label><input type="file" name="image_secondary" class="form-control"></div>
            <hr>
            <h5>Additional Information</h5>
            <div class="mb-3"><label class="form-label">Information</label><textarea name="information" class="form-control"></textarea></div>
            <div class="mb-3"><label class="form-label">Packaging Info</label><textarea name="packaging_info" class="form-control"></textarea></div>
            <div class="mb-3"><label class="form-label">Storage Conditions</label><input type="text" name="storage_conditions" class="form-control"></div>
            <div class="mb-3"><label class="form-label">Shelf Life</label><input type="text" name="shelf_life" class="form-control"></div>
            <hr>
            <h5>Technical Specifications</h5>
            <div class="mb-3"><label class="form-label">Colour</label><input type="text" name="spec_colour" class="form-control"></div>
            <div class="mb-3"><label class="form-label">Odor and Flavor</label><input type="text" name="spec_odor_flavor" class="form-control"></div>
            <div class="mb-3"><label class="form-label">Ingredients</label><textarea name="spec_ingredients" class="form-control"></textarea></div>
            <div class="mb-3"><label class="form-label">Brix</label><input type="text" name="spec_brix" class="form-control"></div>
            <div class="mb-3"><label class="form-label">Acidity</label><input type="text" name="spec_acidity" class="form-control"></div>
            <div class="mb-3"><label class="form-label">pH</label><input type="text" name="spec_ph" class="form-control"></div>
            <div class="mb-3"><label class="form-label">Pulp</label><input type="text" name="spec_pulp" class="form-control"></div>
            <div class="mb-3"><label class="form-label">Additives</label><input type="text" name="spec_additives" class="form-control"></div>
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
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['category_name']) . "</td>";
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