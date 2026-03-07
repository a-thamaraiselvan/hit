<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    
    try {
        $stmt = $conn->prepare("SELECT * FROM admin_users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            header("Location: ../dashboard/index.php");
            exit();
        } else {
            $error = "Invalid email or password!";
        }
    } catch(PDOException $e) {
        $error = "Login failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="../../assets/css/aos.css">
        <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../assets/css/boxicons.min.css">
        <link rel="stylesheet" href="../../assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="../../assets/css/flaticon.css">
        <link rel="stylesheet" href="../../assets/css/magnific-popup.min.css">
        <link rel="stylesheet" href="../../assets/css/style.css">
        <link rel="stylesheet" href="../../assets/css/header.css">
        <!-- <link rel="stylesheet" href="assets/css/responsive.css"> -->
        <link rel="stylesheet" href="../../assets/css/responsive.css">

</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Admin Hindusthan Login</h3>
                    </div>
                    <div class="card-body">
                        <?php if($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" style="margin-top:20px !important;">Login</button>
                        </form>
                        <p class="text-center mt-3">
                            Don't have an account? <a href="register.php" style="color:#ed6f26">Register here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>