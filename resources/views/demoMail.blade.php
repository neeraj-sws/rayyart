<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="font-family: 'Helvetica', sans-serif;">

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Forgot Password</h4>
                    </div>
                    <div class="card-body">
                        <p>Hello {{ $maildata['user']->name }} </p>
                        <p>We received a request to reset your password. If you did not make this request, please ignore this email.</p>
                        <p>Your One-Time Password (OTP) is: <strong>{{ $maildata['otp'] }}</strong></p>
                        <p>Please use this OTP to reset your password.</p>
                        <!-- <p>This OTP will expire in [Time Duration].</p> -->
                        <p>Thank you,</p>
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and Popper.js links (optional, if needed) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>