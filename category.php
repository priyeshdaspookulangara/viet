<?php
include 'includes/db_connect.php';
include 'includes/header.php';

if (isset($_GET['slug'])) {
  $slug = mysqli_real_escape_string($conn, $_GET['slug']);
  $sql = "SELECT c.name as category_name, p.* FROM products p JOIN categories c ON p.category_id = c.id WHERE c.slug = '$slug'";
  $result = mysqli_query($conn, $sql);

  $category_name_sql = "SELECT name FROM categories WHERE slug = '$slug'";
  $category_name_result = mysqli_query($conn, $category_name_sql);
  $category = mysqli_fetch_assoc($category_name_result);
?>

<div class="container mt-5">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($category['name']); ?></li>
    </ol>
  </nav>

  <h2 class="text-center mb-4">Products in <?php echo htmlspecialchars($category['name']); ?></h2>
  <div class="row">
    <?php
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="col-md-4 col-lg-3 mb-4">';
        echo '<div class="card">';
        echo '<img src="' . htmlspecialchars($row['image_main']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
        echo '<a href="product.php?slug=' . htmlspecialchars($row['slug']) . '" class="btn btn-primary">View Details</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
    } else {
      echo '<p class="text-center">No products found in this category.</p>';
    }
    ?>
  </div>
</div>

<?php
} else {
  echo '<p class="text-center">Invalid category request.</p>';
}

include 'includes/footer.php';
?>