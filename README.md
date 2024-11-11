# Product & Order Management API 📦🛒

An API designed for managing products and orders with comprehensive CRUD functionality. This API supports authentication, pagination, sorting, and search capabilities, making it an ideal foundation for e-commerce applications or inventory management systems.

## Features

- **Product Management**: Create, read, update, delete products
- **Order Management**: Create, read, and delete orders, with automated total price calculation
- **User Authentication**: JWT-based authentication to protect endpoints
- **Search & Filtering**: Search products by name and filter by price range
- **Pagination & Sorting**: Easily paginate and sort lists of products and orders
- **Automated Calculations**: Event-driven calculation for order totals based on product prices

## Models and Database Structure 🗃️

### Product Model

| Field      | Type    | Description                  |
|------------|---------|------------------------------|
| `id`       | Integer | Primary Key                  |
| `name`     | String  | Product name (required)      |
| `price`    | Decimal | Product price (required)     |
| `quantity` | Integer | Available quantity (required)|

### Order Model

| Field         | Type       | Description                                                  |
|---------------|------------|--------------------------------------------------------------|
| `id`          | Integer    | Primary Key                                                  |
| `product_id`  | Integer    | Foreign Key referencing Products                             |
| `quantity`    | Integer    | Quantity of product ordered (required)                       |
| `total_price` | Decimal    | Calculated as `product price * quantity`                     |
| `created_at`  | Timestamp  | Timestamp of order creation                                  |
| `updated_at`  | Timestamp  | Timestamp of last update to order                            |

## API Endpoints 🛠️

### Product Endpoints

- **GET /api/products**: List all products with optional sorting and pagination
- **POST /api/products**: Create a new product
- **GET /api/products/{id}**: Retrieve details of a specific product
- **PUT /api/products/{id}**: Update details of a specific product
- **DELETE /api/products/{id}**: Delete a specific product

### Order Endpoints

- **GET /api/orders**: List all orders with optional sorting and pagination
- **POST /api/orders**: Create a new order (total price auto-calculated)
- **GET /api/orders/{id}**: Retrieve details of a specific order
- **DELETE /api/orders/{id}**: Delete a specific order

> **Note:** `total_price` in orders is automatically calculated as `product price * ordered quantity`.

## Additional Requirements 🎯

### Search & Filter Products

- **Search by Name**: Query products by name
- **Filter by Price Range**: Specify minimum and maximum price to filter products

### Pagination 📄

- Pagination for product and order lists (default: 10 items per page)
- Optional sorting (e.g., by price, date added)

### Authentication 🔒

- **JWT-based Authentication**: Required for all product and order endpoints
- **User Registration**: Register new users
- **Login**: Authenticate users and issue JWT tokens for access

## Installation & Setup ⚙️

1. **Clone the repository**:
   ```bash
   git clone https://github.com/your-username/product-order-api.git
   cd product-order-api
