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
  if (isset($_POST['add_category'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug']);
    $sql = "INSERT INTO categories (name, slug) VALUES ('$name', '$slug')";
    mysqli_query($conn, $sql);
    header("Location: categories.php");
    exit();
  } elseif (isset($_POST['edit_category'])) {
    $id = mysqli_real_escape_string($conn, $_POST['edit_category']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug']);
    $sql = "UPDATE categories SET name = '$name', slug = '$slug' WHERE id = $id";
    mysqli_query($conn, $sql);
    header("Location: categories.php");
    exit();
  } elseif (isset($_POST['delete_category'])) {
    $id = mysqli_real_escape_string($conn, $_POST['delete_category']);
    $sql = "DELETE FROM categories WHERE id = $id";
    mysqli_query($conn, $sql);
    header("Location: categories.php");
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
      <h1 class="mt-4">Manage Categories</h1>

      <div class="card my-4">
        <div class="card-header">Add New Category</div>
        <div class="card-body">
          <form action="categories.php" method="POST">
            <input type="hidden" name="add_category">
            <div class="mb-3">
              <label for="name" class="form-label">Category Name</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Category</button>
          </form>
        </div>
      </div>

      <div class="card">
        <div class="card-header">All Categories</div>
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT * FROM categories";
              $result = mysqli_query($conn, $sql);
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['slug']) . "</td>";
                echo "<td>";
                echo "<a href='edit_category.php?id=" . $row['id'] . "' class='btn btn-sm btn-warning'>Edit</a>";
                echo "<form action='categories.php' method='POST' style='display:inline-block;'><input type='hidden' name='delete_category' value='" . $row['id'] . "'><button type='submit' class='btn btn-sm btn-danger'>Delete</button></form>";
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