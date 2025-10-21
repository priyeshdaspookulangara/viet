<?php
include 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $company = mysqli_real_escape_string($conn, $_POST['company']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $message = mysqli_real_escape_string($conn, $_POST['message']);
  $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

  $sql = "INSERT INTO requests (name, company, phone, email, message, product_id) VALUES ('$name', '$company', '$phone', '$email', '$message', '$product_id')";

  if (mysqli_query($conn, $sql)) {
    // Get the slug of the product to redirect back to the product page
    $product_sql = "SELECT slug FROM products WHERE id = $product_id";
    $product_result = mysqli_query($conn, $product_sql);
    $product = mysqli_fetch_assoc($product_result);
    header("Location: product.php?slug=" . $product['slug'] . "&success=1");
    exit();
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}
?>