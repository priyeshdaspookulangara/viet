<?php
include 'includes/db_connect.php';
include 'includes/header.php';
?>

<div class="container mt-5">
  <h2 class="text-center mb-4">Our Products</h2>
  <div class="row">
    <?php
    $sql = "SELECT * FROM products WHERE status = 1";
    $result = mysqli_query($conn, $sql);

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
      echo '<p class="text-center">No products found.</p>';
    }
    ?>
  </div>
</div>

<?php
include 'includes/footer.php';
?>