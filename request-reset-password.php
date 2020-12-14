<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
              integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.9.0/css/all.css">
        <!-- jQuery and JS bundle w/ Popper.js -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
                crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <script src="main.js"></script>
        <link rel="icon" href="images_logo/background/logo_tdtu.png" type="image/icon type">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Reset password</title>
    </head>

    <body>
        <div class="forget_form" style="border-radius: .5rem; padding: 1.5rem">
            <form method="POST" class="forget_input" action="send_mail.php">
                <div class="reset-form-wrap" style="height: 100%!important; display: flex; flex-direction: column; justify-content: space-between">
                <div id="header">
                    <h2>Reset password</h2>
                </div>
                <div class="input_area mt-5">
                    <label for="reset-email" class="font-weight-bold mb-0 mt-auto">Enter your email</label>
                    <small class="mb-2">A confirmation link will be sent to your email</small>
                    <input type="email" id="reset-email" name="reset-email" autocomplete="off" placeholder="Email" onkeyup="enableSendButton()">
                    <div class='error reset-error text-danger' style="display: none">Email doesn't exist</div>
                </div>  

                <div class="buttons_area mt-5">
                        <button type="submit" class="send-btn btn btn-primary" disabled>Send</button>
                        <button type="button" class="btn mr-3" onclick="window.location.href='./sign-in.php'">Cancel</button>
                </div>
                </div>
            </form>
        </div>
    </body>

</html>