<?php
include 'db.php';

$error = '';  

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Login Perpustakaan</title>
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

        .login-container {
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
            border: 1.5px solid #f0f0f0;
            border-radius: 8px;
            background-color: #121212;
            color: #f0f0f0;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #ffffff;
            box-shadow: 0 0 8px #ffffff;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background-color: #000000;
            color: #ffffff;
            border: 2px solid #ffffff;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        button:hover {
            background-color: #ffffff;
            color: #000000;
        }

        .error {
            color: #ff4c4c;
            margin-bottom: 15px;
            font-weight: 600;
        }

        a {
            color: #ffffff;
            text-decoration: underline;
            font-weight: 600;
        }

        a:hover {
            color: #bbbbbb;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login Perpustakaan</h2>
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required autofocus autocomplete="off" />
            <input type="password" name="password" placeholder="Password" required autocomplete="off" />
            <button type="submit">Login</button>
        </form>
        <p style="margin-top: 15px;">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>
</body>


</html>
