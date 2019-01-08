<title>Lumen</title>

<style>

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }
        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }
        .content {
            text-align: center;
            display: inline-block;
        }
        .title {
            font-size: 96px;
            margin-bottom: 40px;
        }
        .quote {
            font-size: 24px;
        }
</style>



    <div class="container">
        <nav>

                Welcome, <?php echo $name; ?> |
                <a href="/logout">Logout</a>

                <a href="/login">Login</a> |
                <a href="/register">Register</a> |
                <a href="/forgotPassword">Forgot Password</a>

        </nav>
        <div class="content">
            <div class="title">Lumen.</div>
        </div>
    </div>