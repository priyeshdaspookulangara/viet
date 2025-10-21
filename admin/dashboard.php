<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: index.php");
  exit();
}
include '../includes/db_connect.php';
include 'includes/header.php';

// Fetch KPIs
$total_products_sql = "SELECT COUNT(*) as total FROM products";
$total_products_result = mysqli_query($conn, $total_products_sql);
$total_products = mysqli_fetch_assoc($total_products_result)['total'];

$total_categories_sql = "SELECT COUNT(*) as total FROM categories";
$total_categories_result = mysqli_query($conn, $total_categories_sql);
$total_categories = mysqli_fetch_assoc($total_categories_result)['total'];

$total_requests_sql = "SELECT COUNT(*) as total FROM requests";
$total_requests_result = mysqli_query($conn, $total_requests_sql);
$total_requests = mysqli_fetch_assoc($total_requests_result)['total'];

// Fetch data for chart
$products_per_category_sql = "SELECT c.name, COUNT(p.id) as count FROM categories c LEFT JOIN products p ON c.id = p.category_id GROUP BY c.name";
$products_per_category_result = mysqli_query($conn, $products_per_category_sql);
$chart_labels = [];
$chart_data = [];
while ($row = mysqli_fetch_assoc($products_per_category_result)) {
  $chart_labels[] = $row['name'];
  $chart_data[] = $row['count'];
}
?>

<div class="d-flex" id="wrapper">
  <!-- Sidebar -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- Page Content -->
  <div id="page-content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
      <div class="container-fluid">
        <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>
      </div>
    </nav>

    <div class="container-fluid">
      <h1 class="mt-4">Dashboard</h1>

      <div class="row">
        <div class="col-md-4">
          <div class="card text-white bg-primary mb-3">
            <div class="card-header">Total Products</div>
            <div class="card-body">
              <h5 class="card-title"><?php echo $total_products; ?></h5>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-white bg-success mb-3">
            <div class="card-header">Total Categories</div>
            <div class="card-body">
              <h5 class="card-title"><?php echo $total_categories; ?></h5>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-white bg-info mb-3">
            <div class="card-header">Total Requests</div>
            <div class="card-body">
              <h5 class="card-title"><?php echo $total_requests; ?></h5>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">Products per Category</div>
            <div class="card-body">
              <canvas id="productsPerCategoryChart"></canvas>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?php
include 'includes/footer.php';
?>

<script>
  const ctx = document.getElementById('productsPerCategoryChart');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($chart_labels); ?>,
      datasets: [{
        label: '# of Products',
        data: <?php echo json_encode($chart_data); ?>,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>