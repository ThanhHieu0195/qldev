<?php
require_once '../part/common_start_page.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Đăng nhập</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script type="text/javascript" src="../resources/scripts/keyboard.js"></script>
        <link href="../resources/css/login/960.css" rel="stylesheet" type="text/css" media="all" />
        <link href="../resources/css/login/login.css" rel="stylesheet" type="text/css" media="all" />
        <link href="../resources/css/login/forms.css" rel="stylesheet" type="text/css" />
        <link href="../resources/css/keyboard.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
            img { cursor: pointer; }
        </style>
    </head>
    <body>        
        <div class="container_16">
            <div class="grid_6 prefix_5 suffix_5">
                <h1 style="color: blue;">Hệ thống bán hàng - nhilong©</h1>
                <div id="login">
                    <form action="" method="post">
                        <?php
                            if (isset($_POST["submit"])) {
                                $username = $_POST["username"];
                                $password = md5($_POST["password"]);
                                
                                $nv = new nhanvien();
                                $obj = $nv->detail($username);
                                $ext = $nv->get_ext($username);
                                
                                if ( ! is_object($obj)) 
                                {
                                    $message = "*Mã NV hoặc mật khẩu không đúng";
                                }
                                else 
                                {
                                    if ($obj->password !== $password) 
                                    {
                                        $message = "*Mã NV hoặc mật khẩu không đúng";
                                    }
                                    elseif ($obj->enable == BIT_FALSE)
                                    {
                                        $message = "*Tài khoản của bạn đã bị khóa, vui lòng liên hệ admin để được hỗ trợ";
                                    }
                                    else 
                                    {
                                        // Set account information to session
                                        $account = array(
                                                MANV => $obj->manv,
                                                PASSWORD => $obj->password,
                                                TENNV => $obj->hoten,
                                                UID => $obj->uid,
                                        );
                                        $_SESSION[LOGGED_IN_ACCOUNT] = $account;
                                        $_SESSION["ext"] = $ext;
                                        
                                        if(isset ($_GET['url']))
                                        {
                                            redirect($_GET['url']);
                                        }
                                        else
                                        {
                                            // Redirect to default site
                                            redirect(default_site($username));
                                        }
                                    }
                                }
                            }
                        ?>
                        <?php if (isset($message)): ?>
                        <p class="error">
                            <span id="message"><?php echo $message;?></span>
                        </p>
                        <?php endif; ?>
                        <p>
                            <label>
                                <img src="../resources/images/icon_user.jpg" alt="icon_user"
                                     title="Mã nhân viên" />
                                <strong>Mã nhân viên</strong>
                                <input class="inputText" type="text" 
                                       name="username" id="username" value="<?php if (isset($_POST["username"])) echo $_POST["username"];?>" />

                            </label>
                        </p>
                        <p>
                            <label>
                                <img src="../resources/images/icon_password.jpg" alt="icon_password"
                                     title="Mật khẩu đăng nhập" />
                                <strong>Mật khẩu</strong>
                                <input class="inputText keyboardInputSize3" type="password" 
                                       name="password" id="password" />
                            </label>
                        </p>
                        <div style="float: right">
                            <input id="submit" name="submit" type="submit" class="button button-green" value="Đăng nhập" />
                        </div>
                    </form>
                    <br clear="all" />
                </div>
            </div>
        </div>
        <br clear="all" />
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
