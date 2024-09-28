<?php

namespace auth;

use database\Database;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Auth
{

    protected function redirect($url)
    {

        header("Location:" . trim(CURRENT_DOMAIN, "/ ") . "/" . trim($url, "/ "));
        exit();
    }

    protected function redirectBack()
    {

        header("Location:" . $_SERVER["HTTP_REFERER"]);
        exit();
    }

    private function hash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private function createRandomToken(){
        return bin2hex(openssl_random_pseudo_bytes(32));
    }

    public function activationMessage($username, $verifyToken){

        return '
            <h1>فعال سازی حساب کاربری</h1>>
            <p>'.$username.' عزیز برای فعالسازی حساب کاربری خود روی لینک زیر کلیک نمایید</p>
            <a href="'.url('activation/'.$verifyToken).'">فعالسازی</a>
        ';
    }

    private function sendMail($email, $subject, $body)
    {

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->CharSet = "UTF-8";                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = MAIL_HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth = SMTP_AUTH;                                   //Enable SMTP authentication
            $mail->Username = MAIL_USERNAME;                     //SMTP username
            $mail->Password = MAIL_PASSWORD;                               //SMTP password
            $mail->SMTPSecure = "tls";            //Enable implicit TLS encryption (PHPMailer::ENCRYPTION_SMTPS)
            $mail->Port = MAIL_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(SENDER_MAIL, SENDER_NAME);
            $mail->addAddress($email);     //Add a recipient

            /*$mail->addAddress('ellen@example.com', 'Joe User');               //Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');*/

            //Attachments
            /*$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name*/

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            //echo 'Message has been sent'. "<br/>" . $result;
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }

    }

    //$auth = new \auth\Auth();
    //$auth->sendMail("sadeghjfr97@gmail.com", "Test", "Hello world");

    public function register(){
        require_once (BASE_PATH . '/template/auth/register.php');
    }

    public function registerStore($request){

        if (empty($request['username']) || empty($request['email']) || empty($request['password'])) {
            flash('register_error', 'تمامی فیلد ها اجباری هستند');
            $this->redirectBack();
        }

        else if (strlen($request['password']) < 6){
            flash('register_error', 'کلمه عبور حداقل باید 6 کاراکتر باشد');
            $this->redirectBack();
        }

        else if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)){
            flash('register_error', 'ایمیل وارد شده نامعتبر می باشد');
            $this->redirectBack();
        }

        else{

            $db = new Database();
            $user = $db->select("SELECT * FROM users WHERE email = ?;", [$request['email']])->fetch();

            if ($user != null){
                flash('register_error', 'کاربر از قبل در سیستم وجود دارد');
                $this->redirectBack();
            }

            else{

                $randomToken =$this->createRandomToken();
                $activationMessage = $this->activationMessage($request['username'], $randomToken);
                $result = $this->sendMail($request['email'], "فعالسازی حساب کاربری", $activationMessage);

                if ($result){
                    $request['verify_token'] = $randomToken;
                    $request['password'] = $this->hash($request['password']);
                    $db->insert('users', array_keys($request), $request);
                    $this->redirect('login');
                }

                else{
                    flash('register_error', 'ارسال ایمیل با خطا مواجه شد');
                    $this->redirectBack();
                }
            }
        }

    }

    public function activation($verify_token){

        $db =  new Database();
        $sql = "SELECT * FROM users WHERE verify_token = ? AND is_active = 0;";
        $user = $db->select($sql, [$verify_token])->fetch();

        if ($user != null)
            $db->update('users', $user['id'], ['is_active'], [1]);

        $this->redirect('login');
    }

    public function login(){
        require_once (BASE_PATH . '/template/auth/login.php');
    }

    public function checkLogin($request){

        if (empty($request['email']) || empty($request['password'])) {
            flash('login_error', 'تمامی فیلد ها اجباری هستند');
            $this->redirectBack();
        }

        else{

            $db = new Database();
            $user = $db->select("SELECT * FROM users WHERE email = ?;", [$request['email']])->fetch();

            if ($user == null){
                flash('login_error', 'کاربر وجود ندارد');
                $this->redirectBack();
            }

            else{

                if ($request['email'] != $user['email'] || !password_verify($request['password'], $user['password'])){

                    flash('login_error', 'نام کاربری یا رمز عبور اشتباه است');
                    $this->redirectBack();
                }

                else{

                    if ($user['is_active'] == 0){

                        flash('login_error', 'حساب شما غیر فعال است');
                        $this->redirectBack();
                    }

                    else{

                        $_SESSION['user'] = $user['id'];
                        $this->redirect('admin');
                    }

                }

            }
        }
    }

    public function checkAdmin(){

        if (isset($_SESSION['user'])){

            $db = new Database();
            $user = $db->select("SELECT * FROM users WHERE id = ?;", [$_SESSION['user']])->fetch();

            if ($user != null){

                if ($user['permission'] != 'admin')
                    $this->redirect('home');

            }

            else
                $this->redirect('home');

        }

        else
            $this->redirect('home');
    }

    public function logout(){

        if (isset($_SESSION['user'])){
            unset($_SESSION['user']);
            session_destroy();
        }

        $this->redirect('home');
    }

    public function forgot(){
        require_once (BASE_PATH . '/template/auth/forgot-password.php');
    }

    public function forgotRequest($request){

        if (empty($request['email'])){
            flash('forgot_error', 'ورود ایمیل الزامی است');
            $this->redirectBack();
        }

        else{

            if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)){
                flash('forgot_error', 'ایمیل نا معتبر است');
                $this->redirectBack();
            }

            else{
                $db = new Database();
                $user = $db->select("SELECT * FROM users WHERE email = ?;", [$request['email']])->fetch();

                if ($user == null){
                    flash('forgot_error', 'کاربری یافت نشد');
                    $this->redirectBack();
                }

                else{

                    $randomToken =$this->createRandomToken();
                    $forgotMessage = $this->forgotMessage($user['username'], $randomToken);
                    $result = $this->sendMail($request['email'], "بازیابی رمز عبور", $forgotMessage);

                    if ($result){

                        date_default_timezone_set('Iran');
                        $db->update(
                            'users', $user['id'], ['forgot_token', 'forgot_token_expire'],
                            [$randomToken, date('Y-m-d H:i:s', strtotime('+15 minutes'))]
                        );

                        $this->redirect('login');
                    }

                    else{

                        flash('forgot_error', 'ارسال ایمیل انجام نشد');
                        $this->redirectBack();
                    }
                }
            }

        }
    }

    public function forgotMessage($username, $forgotToken){

        return '
            <h1>فراموشی رمز عبور</h1>>
            <p>'.$username.' عزیز برای تغییر رمز عبور حساب کاربری خود روی لینک زیر کلیک نمایید</p>
            <a href="'.url('reset-password-form/'.$forgotToken).'">بازیابی رمز عبور</a>
        ';
    }

    public function resetPasswordView($forgot_token){
        require_once (BASE_PATH . '/template/auth/reset-password.php');
    }

    public function resetPassword($request, $forgot_token){

        if (!isset($request['password']) || strlen($request['password'])<6){

            flash('reset_error', 'رمز عبور حداقل باید 6 کاراکتر باشد');
            $this->redirectBack();
        }

        else{

            $db = new Database();
            $user = $db->select("SELECT * FROM users WHERE forgot_token = ?;", [$forgot_token])->fetch();

            if ($user == null){
                flash('reset_error', 'کاربر یافت نشد');
                $this->redirectBack();
            }

            else{

                date_default_timezone_set('Iran');

                if ($user['forgot_token_expire']<date('Y-m-d H:i:s')){
                   flash('reset_error', 'انقضای توکن به پایان رسیده است');
                   $this->redirectBack();
               }

               else{

                   $db->update('users', $user['id'], ['password'], [$this->hash($request['password'])]);
                   $this->redirect('login');
               }
            }
        }
    }



















}