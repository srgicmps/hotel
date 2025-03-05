<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/dwes/includes/header.php');

if (isset($_SESSION['user_role'])) {
    $redirect = $_SESSION['user_role'] === 'admin' ? 'admin/index.php' : 'customer/dashboard.php';
    header("Location: $redirect");
    exit();
}

?>
    <style>
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #13547a 0%, #80d0c7 100%);
            padding: 2rem 0;
        }
        .register-form {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
        .register-title {
            color: #13547a;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-control:focus {
            border-color: #13547a;
            box-shadow: 0 0 0 0.2rem rgba(19, 84, 122, 0.25);
        }
        .btn-register {
            background: #13547a;
            border: none;
            padding: 0.75rem;
        }
        .btn-register:hover {
            background: #0f4563;
        }
        .login-link {
            text-align: center;
            margin-top: 1rem;
        }
    </style>
    <div class="register-container">
        <div class="register-form">
            <h2 class="register-title">Paradise Hotel</h2>
            <h4 class="text-center text-muted mb-4">Create your account</h4>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <?php 
                        switch($_GET['error']) {
                            case 'passwords':
                                echo 'Passwords do not match';
                                break;
                            case 'email':
                                echo 'Email already exists';
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

            <form action="auth/register.php" method="post">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" 
                           pattern=".{6,}" title="Minimum 6 characters" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary btn-register w-100">Sign up</button>
            </form>

            <div class="login-link">
                <p class="mb-0">Already have an account? <a href="login.php">Log in</a></p>
            </div>
        </div>
    </div>
    <?php include($root . '/student062/dwes/includes/footer.php'); ?>