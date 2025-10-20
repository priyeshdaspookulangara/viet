CREATE DATABASE fruit_export;
USE fruit_export;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  slug VARCHAR(255)
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  slug VARCHAR(255),
  description TEXT,
  variety VARCHAR(255),
  size VARCHAR(50),
  packaging VARCHAR(255),
  season VARCHAR(255),
  image_main VARCHAR(255),
  image_secondary VARCHAR(255),
  category_id INT,
  status TINYINT DEFAULT 1,
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE certificates (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  image VARCHAR(255)
);

CREATE TABLE related_products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT,
  related_id INT
);

CREATE TABLE requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  company VARCHAR(255),
  phone VARCHAR(50),
  email VARCHAR(255),
  message TEXT,
  product_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories
INSERT INTO categories (name, slug) VALUES
('Fresh Fruit', 'fresh-fruit'),
('Dried Fruit', 'dried-fruit');

-- Products
INSERT INTO products (name, slug, description, variety, size, packaging, season, image_main, image_secondary, category_id)
VALUES
('Pomelo', 'pomelo', 'Pomelo contains high levels of antioxidants, including vitamin C, naringenin, naringin, and lycopene, which may offer various health benefits.', 'Honey Pomelo', '800g–1kg', 'Carton box 5kg–12kg', 'Whole year', 'uploads/products/pomelo1.jpg', 'uploads/products/pomelo2.jpg', 1),

('Mango', 'mango', 'Our Mangoes are rich in vitamin A and fiber, sourced from the best tropical farms.', 'Nam Dok Mai', '250g–400g', 'Carton 10kg', 'March–July', 'uploads/products/mango1.jpg', 'uploads/products/mango2.jpg', 1),

('Dragon Fruit', 'dragon-fruit', 'Dragon fruit offers unique flavor and high antioxidant properties.', 'Red Flesh', '300g–500g', 'Carton 5kg', 'June–October', 'uploads/products/dragon1.jpg', 'uploads/products/dragon2.jpg', 1),

('Durian', 'durian', 'Durian is known as the king of fruits, with high nutrition and distinctive flavor.', 'Monthong', '1.5kg–3kg', 'Carton 10kg', 'May–August', 'uploads/products/durian1.jpg', 'uploads/products/durian2.jpg', 1);

-- Related products (for Pomelo)
INSERT INTO related_products (product_id, related_id) VALUES
(1, 2),
(1, 3),
(1, 4);

-- Certificates
INSERT INTO certificates (name, image) VALUES
('ISO 22000:2018', 'uploads/certificates/iso22000.jpg'),
('GMP Codex Alimentarius', 'uploads/certificates/gmp.jpg'),
('Certificate of Registration', 'uploads/certificates/registration.jpg');