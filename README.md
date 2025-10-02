<h1 align="center">Build an E-commerce Order Management System (backend).</h1>


---

## 🚀 Features

## Authentication
Separate flows for Customer and Admin

## Customer
    Add products to Cart
    Place Order
    Mock Payment
## Admin
    Manage Categories & Products
    Accept & update order status
## Mail Queue Support
Email sent after order confirmation & order placed

## 🔑 Authentication Flow

## Customer Flow:
    -- Register / Login
    -- Add products → Cart
    -- Place Order  → Mock Payment
    -- Confirmation Mail (via Queue)

## Admin Flow:
    -- Login
    -- View All Orders
    -- Update Order Status
    -- Trigger Mail Notification
---

## 💻 API Endpoints (Postman Collection)

To easily test all the backend functionalities, you can import the provided Postman Collection.

### 📥 Import Steps

1.  **Download Postman** if you don't have it installed.
2.  **Download the Collection File** from the root of this repository:
    * `Automate.postman_collection.json`
3.  **Import the Collection:**
    * In Postman, click **File -> Import** and select the downloaded `Automate.postman_collection.json` file.
4.  **Set the Base URL:**
    * The collection is configured to use an environment variable called `{{url}}`. Ensure your Postman environment's `url` variable is set to your local server address: `http://127.0.0.1:8000/api`

### 🔑 Authentication Flow

All authenticated endpoints require an **Authorization Header** with a **Bearer Token**.

1.  Run the **`POST /login`** request.
2.  The response token is automatically saved to the Postman environment variable `{{token}}`.
3.  All subsequent requests will use `Bearer {{token}}` for authorization.

### 🔑 Default Login Credentials
  Admin:
  1. Email: admin2@gmail.com
  2. password: password

  Customer:
   1. Email:  (Dynamically Generated -- Check the database (users table) for an entry with role = customer.)
   2. password: password

  
---


## ⚙️ How to Set Up Locally

### Step 1: Clone the repository

```bash
git clone https://github.com/developeralamin/automated_api_task
```
📦 Requirements
```bash
    "php": "^8.1",
     "laravel" : '^10.10'
```

- Step:2 Install dependencies 
```bash
   composer install
```

- Step:3 Create a copy of your .env file
```
cp .env.example  .env
```

- Step:4 Generate application key
```bash
php artisan key:generate
```

- Step:5  Create Database Name .env file 

```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
```

- Step:6 Run fresh seed and migrations 
```bash
 php artisan migrate:fresh --seed
```

Step 7: Setup the SMTP service (Mailtrap) for testing
S1. Create Mailtrap Account
Go to https://mailtrap.io
Sign up (free plan is enough for testing).
Inside Dashboard → create an Inbox (if not created automatically).

2. Get SMTP Credentials
Inside that inbox, click on SMTP Settings.
Copy these values: HOST, PORT, USERNAME, PASSWORD.

3. Update .env File

```bash
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=587
    MAIL_USERNAME=your_actual_mailtrap_username
    MAIL_PASSWORD=your_actual_mailtrap_password
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"
```
4. Clear and Cache Config

```bash
php artisan config:clear
php artisan cache:clear
```


- Step:8 Run the application In a separate terminal:
```bash
php artisan serve 
 
```
Step 9: Start the queue  and default queue connection is database .
```bash
php artisan queue:listen
```

Step 10: Default queue connection is database send mail with notification
```bash
  QUEUE_CONNECTION=database
```


-








