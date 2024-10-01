
# Real-Time Chat Application

This project is a real-time chat application that allows users to create accounts, join chat rooms, or start private conversations. The application uses WebSocket technology to enable instant messaging between users. It also stores all messages in a MySQL database for future reference.

## Features
- Create accounts and log in.
- Join chat rooms or initiate private conversations.
- Real-time messaging using WebSocket and the Ratchet library.
- Fully responsive design.
- All messages stored in a MySQL database.

## Tech Stack
- **Frontend**: HTML, CSS, Tailwind, JavaScript
- **Backend**: PHP, MySQL
- **Real-Time Technology**: WebSocket, Ratchet library

## Installation

### 1. Clone the Repository
```bash
git clone https://github.com/hashirmeraj/real-time-chat-application.git
cd real-time-chat-application
```

### 2. Set Up the Database
- Import the `chat_application.php` file located in `/database` into your MySQL database.
- You can download the SQL file directly by [clicking here](./database/chat_application.php).

### 3. Configure the Database Connection
- Open the `config.php` file and set your database credentials.

```php
$host = 'localhost';
$db_name = 'chat_application';
$username = 'root';
$password = '';
```

### 4. Start the WebSocket Server
Run the following command to start the WebSocket server using the Ratchet library:

```bash
php path/to/your/server.php
```

### 5. Launch the Application
- Open your browser and navigate to `http://localhost/your_project_folder/` to access the application.

## License
This project is licensed under the MIT License.
