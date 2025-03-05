<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/dwes/includes/header.php');

?>
    <style>
        .login-container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #13547a 0%, #80d0c7 100%);
        }
        .login-form {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-title {
            color: #13547a;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-control:focus {
            border-color: #13547a;
            box-shadow: 0 0 0 0.2rem rgba(19, 84, 122, 0.25);
        }
        .btn-login {
            background: #13547a;
            border: none;
            padding: 0.75rem;
        }
        .btn-login:hover {
            background: #0f4563;
        }
        .register-link {
            text-align: center;
            margin-top: 1rem;
        }
    </style>
    <div class="login-container">
        <div class="login-form">
            <h2 class="login-title">Paradise Hotel</h2>
            <h4 class="text-center text-muted mb-4">Welcome back</h4>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <?php 
                        switch($_GET['error']) {
                            case 'invalid':
                                echo 'Invalid email or password';
                                break;
                            case 'empty':
                                echo 'Please fill in all fields';
                                break;
                            default:
                                echo 'An error occurred';
                        }
                    ?>
                </div>
            <?php endif; ?>
            <form action="auth/authenticate.php" method="post">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-login w-100">Log in</button>
            </form>
            <div class="register-link">
                <p class="mb-0">Don't have an account? <a href="registration.php">Sign up</a></p>
            </div>
        </div>
    </div>

    <?php include($root . '/student062/dwes/includes/footer.php'); ?>