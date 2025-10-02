<h1 align="center">Build an E-commerce Order Management System (backend).</h1>


---

## 🚀 Features

- Authentication with registration and login
- Customer can cart products and Place the Order
- Customer have mock payment (success)
- Admin accept the user order and update  the status 
- Queue worker support for send mail after OrderConfirmation & OrderPlace

---

## ⚙️ How to Set Up Locally

### Step 1: Clone the repository

```bash
git clone https://github.com/developeralamin/automated_api_task
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

- Step:7  Setup the smtp mailtrap for sending testing mail after Orderconfirm and Orderplace 

```bash
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=587
    MAIL_USERNAME=bdc92f522f2248
    MAIL_PASSWORD=bf1df338da0c03
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"
```

- Step:8 Run the application In a separate terminal:
```bash
php artisan serve 
 
```
Step 9: Start the queue  and default queue connection is database .
```bash
php artisan queue:work
```

Step 9: Default queue connection is database send mail with notification
```bash
  QUEUE_CONNECTION=database
```

📦 Requirements
```bash
    "php": "^8.1",
     "laravel" : '^10.10'
```

-
Access the Application








