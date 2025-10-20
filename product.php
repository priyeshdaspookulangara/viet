<?php
include 'includes/db_connect.php';
include 'includes/header.php';

if (isset($_GET['slug'])) {
  $slug = mysqli_real_escape_string($conn, $_GET['slug']);
  $sql = "SELECT * FROM products WHERE slug = '$slug'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    $product = mysqli_fetch_assoc($result);
?>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-6">
      <img src="<?php echo htmlspecialchars($product['image_main']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($product['name']); ?>">
    </div>
    <div class="col-md-6">
      <h2><?php echo htmlspecialchars($product['name']); ?></h2>
      <p><?php echo htmlspecialchars($product['description']); ?></p>
      <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong>Variety:</strong> <?php echo htmlspecialchars($product['variety']); ?></li>
        <li class="list-group-item"><strong>Size:</strong> <?php echo htmlspecialchars($product['size']); ?></li>
        <li class="list-group-item"><strong>Packaging:</strong> <?php echo htmlspecialchars($product['packaging']); ?></li>
        <li class="list-group-item"><strong>Season:</strong> <?php echo htmlspecialchars($product['season']); ?></li>
      </ul>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-md-8">
      <h3>Request Quote & COA</h3>
      <form action="submit_request.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
          <label for="company" class="form-label">Company</label>
          <input type="text" class="form-control" id="company" name="company">
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label">Phone</label>
          <input type="tel" class="form-control" id="phone" name="phone">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">Message</label>
          <textarea class="form-control" id="message" name="message" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Request</button>
      </form>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-12">
      <h3 class="text-center">Related Products</h3>
      <div class="row">
        <?php
        $related_sql = "SELECT p.* FROM products p JOIN related_products rp ON p.id = rp.related_id WHERE rp.product_id = " . $product['id'];
        $related_result = mysqli_query($conn, $related_sql);

        if (mysqli_num_rows($related_result) > 0) {
          while ($related_row = mysqli_fetch_assoc($related_result)) {
            echo '<div class="col-md-3 mb-4">';
            echo '<div class="card">';
            echo '<img src="' . htmlspecialchars($related_row['image_main']) . '" class="card-img-top" alt="' . htmlspecialchars($related_row['name']) . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($related_row['name']) . '</h5>';
            echo '<a href="product.php?slug=' . htmlspecialchars($related_row['slug']) . '" class="btn btn-primary">View Details</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
        }
        ?>
      </div>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-12">
      <h3 class="text-center">Certificates</h3>
      <div class="row">
        <?php
        $cert_sql = "SELECT * FROM certificates";
        $cert_result = mysqli_query($conn, $cert_sql);

        if (mysqli_num_rows($cert_result) > 0) {
          while ($cert_row = mysqli_fetch_assoc($cert_result)) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card">';
            echo '<img src="' . htmlspecialchars($cert_row['image']) . '" class="card-img-top" alt="' . htmlspecialchars($cert_row['name']) . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title text-center">' . htmlspecialchars($cert_row['name']) . '</h5>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
        }
        ?>
      </div>
    </div>
  </div>

</div>

<?php
  } else {
    echo '<p class="text-center">Product not found.</p>';
  }
} else {
  echo '<p class="text-center">Invalid product request.</p>';
}

include 'includes/footer.php';
?>