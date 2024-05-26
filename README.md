# Hotel Booking Management System

The Hotel Booking Management System is a web application designed to streamline the process of booking and managing hotel reservations. It provides an intuitive interface for users to create accounts, make reservations, and manage their bookings. Administrators can manage room prices, view all reservations, respond to user inquiries, and oversee user accounts. The system includes essential features such as password recovery, contact forms, and secure payment processing to ensure a seamless experience for both guests and hotel administrators.

## File Descriptions

- **config.php**: Configure the database settings.
- **register.php**: Allows users to create an account.
- **login.php**: Allows users to log in.
- **logout.php**: Allows users to log out.
- **accountInfo.php**: Users can view their account information and all their reservations.
- **forgotPassword.php**: Allows users to reset their account password.
- **contact.php**: Contact form for logged-in users to send inquiries.
- **home.php**: Users can select check-in dates and rooms for reservations.
- **payment.php**: Payment page for completing reservations.
- **rooms.php**: Admin can modify room prices or add discounted prices.
- **dashboard.php**: Admin can view all reservations made by users, contact form responses, and a list of all admins and clients.
- **update.php**: Update details such as check-in status, responses to contact form inquiries, and manage admin privileges.
- **delete.php**: Cancel bookings.

## Admin Credentials

- **Username:** admin
- **Password:** admin@123

## Getting Started

### Step 1: Download & Install XAMPP

1. Download XAMPP from [Apache Friends](https://www.apachefriends.org/).
2. Install XAMPP in the default directory: `C:\xampp`.

### Step 2: Clone the Repository

1. Clone the project repository to the `C:\xampp\htdocs\`:
    ```sh
    git clone https://github.com/pratham-jaiswal/HotelBookingManagement.git
    ```

### Step 3: Start XAMPP

1. Open XAMPP.
2. Start the **Apache** and **MySQL** services by clicking the respective "Start" buttons.

### Step 4: Setup the Database

1. Open your web browser and go to:
    ```
    localhost/phpmyadmin/
    ```
2. In the sidebar, click on "New" to create a new database.
3. Name the database **hotelbookingmanagement**.
4. After creating the database, click on the database name to open it.
5. Go to the "Import" tab and import the `hotelbookingmanagement.sql` file.

### Step 5: Launch the Application

1. Open your web browser and go to:
    ```
    localhost/HotelBookingManagement/
    ```
2. Register a new account and log in to start using the Hotel Booking Management System.

## License

This project is licensed under the MIT License - see the [LICENSE.md](https://github.com/pratham-jaiswal/HotelBookingManagement/blob/main/LICENSE) file for details.
