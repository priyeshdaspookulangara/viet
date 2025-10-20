<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: index.php");
  exit();
}
include '../includes/db_connect.php';
include 'includes/header.php';

// Handle Add/Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['add_certificate'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
      $image = 'uploads/certificates/' . basename($_FILES['image']['name']);
      move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image);
    }
    $sql = "INSERT INTO certificates (name, image) VALUES ('$name', '$image')";
    mysqli_query($conn, $sql);
    header("Location: certificates.php");
    exit();
  } elseif (isset($_POST['delete_certificate'])) {
    $id = mysqli_real_escape_string($conn, $_POST['delete_certificate']);
    $sql = "DELETE FROM certificates WHERE id = $id";
    mysqli_query($conn, $sql);
    header("Location: certificates.php");
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
      <h1 class="mt-4">Manage Certificates</h1>

      <div class="card my-4">
        <div class="card-header">Add New Certificate</div>
        <div class="card-body">
          <form action="certificates.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="add_certificate">
            <div class="mb-3">
              <label for="name" class="form-label">Certificate Name</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
              <label for="image" class="form-label">Image</label>
              <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Certificate</button>
          </form>
        </div>
      </div>

      <div class="card">
        <div class="card-header">All Certificates</div>
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT * FROM certificates";
              $result = mysqli_query($conn, $sql);
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td><img src='../" . $row['image'] . "' width='100'></td>";
                echo "<td>";
                echo "<form action='certificates.php' method='POST' style='display:inline-block;'><input type='hidden' name='delete_certificate' value='" . $row['id'] . "'><button type='submit' class='btn btn-sm btn-danger'>Delete</button></form>";
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