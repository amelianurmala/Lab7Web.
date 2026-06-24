<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="<?= base_url('/style.css');?>">
    <style>
        body {
            background-color: var(--bg);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        #login-wrapper {
            max-width: 1100px;
            margin: 30px auto;
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            overflow: hidden;
            width: 100%;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 32px 40px;
            position: relative;
            overflow: hidden;
        }

        .login-header::after {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 180px;
            height: 180px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%;
        }

        .login-body {
            padding: 40px;
            max-width: 480px;
            margin: 0 auto;
        }

        .login-body h2 {
            font-size: 20px;
            color: var(--dark);
            margin-bottom: 24px;
            font-weight: 700;
        }

        .alert-danger {
            background: #fee2e2;
            color: #dc2626;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 16px;
            border: 1px solid #fecaca;
        }

        .mb-3 {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            background: var(--bg);
            transition: border-color 0.2s;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--primary);
            background: var(--white);
        }

        .btn-primary {
            background: var(--primary);
            color: var(--white);
            border: none;
            padding: 11px 28px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        footer {
            background: var(--dark);
            padding: 18px 40px;
            text-align: center;
            margin-top: auto;
        }

        footer p {
            color: #64748b;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div id="login-wrapper">
    <div class="login-header"></div>

    <div class="login-body">
        <h2>Sign In</h2>

        <?php if(session()->getFlashdata('flash_msg')):?>
            <div class="alert-danger"><?= session()->getFlashdata('flash_msg') ?></div>
        <?php endif;?>

        <form action="" method="post">
            <div class="mb-3">
                <label for="InputForEmail" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control"
                    id="InputForEmail" value="<?= set_value('email') ?>">
            </div>
            <div class="mb-3">
                <label for="InputForPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control"
                    id="InputForPassword">
            </div>
            <button type="submit" class="btn-primary">Login</button>
        </form>
    </div>
</div>

<footer>
    <p>&copy; <?= date('Y') ?> Universitas Pelita Bangsa</p>
</footer>

</body>
</html>