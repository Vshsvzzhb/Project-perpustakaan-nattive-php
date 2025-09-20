<?php
include 'db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password_hash')";
    if ($conn->query($sql)) {
        $success = "User  berhasil didaftarkan!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Register User</title>
    <style>
        body {
            background-color: #121212;
            color: #f0f0f0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background-color: #1e1e1e;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
            width: 350px;
            text-align: center;
        }

        h2 {
            margin-bottom: 25px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            margin: 12px 0;
            border: 1.5px solid #565353ff;
            border-radius: 8px;
            background-color: #121212;
            color: #f0f0f0;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #484545ff;
            box-shadow: 0 0 8px #ffffff;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background-color: #000000;
            color: #ffffff;
            border: 2px solid #595252ff;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        button:hover {
            background-color: #312f2fff;
            color: #000000;
        }

        a {
            color: #ffffff;
            text-decoration: underline;
            font-weight: 600;
        }

        a:hover {
            color: #ecdbdbff;
        }

        .alert {
            max-width: 350px;
            margin: 0 auto 20px auto;
            padding: 15px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
        }

        .success-alert {
            background-color: #28a745;
            color: white;
        }

        .error-alert {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>

<body>
    <?php if ($success): ?>
        <div class="register-container">
            <div class="alert success-alert"><?php echo $success; ?></div>
            <h2>Register User Baru</h2>
            <form method="POST" action="">
                <input type="text" name="username" placeholder="Username" required autocomplete="off" />
                <input type="password" name="password" placeholder="Password" required autocomplete="off" />
                <button type="submit">Daftar</button>
            </form>
            <p style="margin-top: 15px;">Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    <?php elseif ($error): ?>
        <div class="register-container">
            <div class="alert error-alert"><?php echo $error; ?></div>
            <h2>Register User Baru</h2>
            <form method="POST" action="">
                <input type="text" name="username" placeholder="Username" required autocomplete="off" />
                <input type="password" name="password" placeholder="Password" required autocomplete="off" />
                <button type="submit">Daftar</button>
            </form>
            <p style="margin-top: 15px;">Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    <?php else: ?>
        <div class="register-container">
            <h2>Register User Baru</h2>
            <form method="POST" action="">
                <input type="text" name="username" placeholder="Username" required autocomplete="off" />
                <input type="password" name="password" placeholder="Password" required autocomplete="off" />
                <button type="submit">Daftar</button>
            </form>
            <p style="margin-top: 15px;">Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    <?php endif; ?>
</body>

</html>