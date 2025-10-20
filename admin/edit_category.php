<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: index.php");
  exit();
}
include '../includes/db_connect.php';
include 'includes/header.php';

$category_id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM categories WHERE id = $category_id";
$result = mysqli_query($conn, $sql);
$category = mysqli_fetch_assoc($result);
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
      <h1 class="mt-4">Edit Category</h1>

      <div class="card my-4">
        <div class="card-header">Edit Category Details</div>
        <div class="card-body">
          <form action="categories.php" method="POST">
            <input type="hidden" name="edit_category" value="<?php echo $category['id']; ?>">

            <div class="mb-3">
              <label for="name" class="form-label">Category Name</label>
              <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required onkeyup="document.getElementById('slug').value = generateSlug(this.value)">
            </div>

            <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" value="<?php echo htmlspecialchars($category['slug']); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Category</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>