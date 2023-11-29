-- create and select the database
DROP DATABASE IF EXISTS clothing_ecommerce;
CREATE DATABASE clothing_ecommerce;
USE clothing_ecommerce;  -- MySQL command

-- Create the products table
CREATE TABLE products 
(
  product_id INT NOT NULL AUTO_INCREMENT,
  product_name VARCHAR(255) NOT NULL, 
  product_description VARCHAR (255) NOT NULL,
  product_price DECIMAL(10,2) NOT NULL, 
  product_inventory INT,
  product_sku VARCHAR(255) UNIQUE,
  product_gender VARCHAR(255),
  product_category VARCHAR(255),
  product_brand VARCHAR(255),
  product_image VARCHAR(255) UNIQUE,
  PRIMARY KEY (product_id)
);

-- create the users
CREATE USER IF NOT EXISTS mgs_user
IDENTIFIED BY 'pa$$word';

-- grant privleges to the users
GRANT SELECT, INSERT, DELETE, UPDATE
ON clothing_ecommerce.* 
TO mgs_user;