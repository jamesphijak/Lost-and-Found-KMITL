<?php

// require_once APPPATH.'/vendor/autoload.php';

class Auth extends CI_Controller
{
public function __construct()
{
    parent::__construct();
    //$this->load->library('facebook');
}

// สมัครสมาชิก
public function register()
{
    $input = $this->input->post();
    // if(isset($_POST['register'])){
    if(!empty($input)){
        if($this->form_validation->run('auth/register')){
            // $verification_key = md5(rand()); // Email verification key
            // $encrypted_password = $this->encrypt->encode($this->input->post('password'));
            // $decrypted_password = $this->encrypt->decode(encrypted_password);
            $encrypted_password = $this->tb_user->hash($this->input->post('password'));
            $value = array(
                'user_email' => $this->input->post('email'),
                'user_password' => $encrypted_password,
                'user_mobile' => $this->input->post('mobile')
            );

            $result = $this->tb_user->user_register($value);
            if($result){   
                $this->session->set_flashdata('success','สมัครสมาชิกสำเร็จ');
                redirect(base_url('auth/register'),'refresh');
            }else{
                $this->session->set_flashdata('error','สมัครสมาชิกไม่สำเร็จ');
            }
        }
    }

    $this->tb_user->already_login();
    $this->template->setTemplate('สมัครสมาชิก', 'auth/register');
    $this->template->loadTemplate();
}

public function login()
{
    $input = $this->input->post();
    if(!empty($input)){
        if($this->form_validation->run('auth/login')){

            $encrypted_password = $this->tb_user->hash($this->input->post('password'));
            $value = array(
                'user_email' => $this->input->post('email'),
                'user_password' => $encrypted_password
            );
            $user = $this->tb_user->user_login($value);

                if($user){
                    if($user->user_status == 'Active') {
                        $this->session->set_flashdata('success', 'เข้าสู่ระบบสำเร็จ');
                        $this->tb_user->user_session_set($user->user_id, $user->user_email, $user->user_type, $user->user_mobile,$user->user_status);
                        redirect(base_url('main'), 'refresh');
                    }else{
                        $this->session->set_flashdata('error','สมาชิกนี้ถูกระงับการใช้งานอยู่');
                    }

                }else{
                    $this->session->set_flashdata('error','เข้าสู่ระบบไม่สำเร็จ กรุณาลองใหม่อีกครั้ง');
                }
        }
    }
    $this->tb_user->already_login();

    $this->template->setTemplate('เข้าสู่ระบบ', 'auth/login');
    $this->template->loadTemplate();
}

// ออกจากระบบ
public function logout(){
    $this->tb_user->user_session_destroy(); // ทำลาย session
    redirect(base_url('auth/login'),'refresh');
}

// เข้าสู่ระบบผ่าน Facebook
public function facebook(){
    $fb = new Facebook\Facebook([
        'app_id' => "2359331964290771", // Replace {app-id} with your app id
        'app_secret' => '05ac8b57974c0bacb71eff2de42caf74',
        'default_graph_version' => 'v2.2',
        ]);

    if (isset($_SESSION['fb_access_token'])) {
        $token = $_SESSION['fb_access_token'];
        try {
          // Returns a `Facebook\FacebookResponse` object
          $response = $fb->get('/me?fields=id,name,email', $token);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }
        // Store data in database
        $facebook = $response->getGraphUser();
        // echo 'ID: ' . $facebook['id'] .'<br>';
        // echo 'Name: ' . $facebook['name'] .'<br>';
        // echo 'E-mail: ' . $facebook['email'] .'<br>';

        $user = $this->tb_user->get_user_by_email($facebook['email']);

        //var_dump($user);
        //var_dump($_SESSION);
        if($user){ // ถ้าเจอ Email ในระบบ
            // เก็บ Facebook id
            if(empty($user->user_facebook_id)){
                // Facebook id ว่าง
                // เก็บค่า facebook id เข้าฐานข้อมูล
                $value = array('user_facebook_id' => $facebook['id']);
                $result = $this->tb_user->update_user($user->user_id, $value); // อัพเดทเข้าฐานข้อมูล
                if($result){
                    // ทำการ Login
                    if($user->user_status == 'Active') {
                        $this->session->set_flashdata('success', 'เข้าสู่ระบบด้วย Facebook สำเร็จ / ทำการรวมเข้ากับบัญชีเดิมเรียบร้อยแล้ว');
                        $this->tb_user->user_session_set($user->user_id, $user->user_email, $user->user_type, $user->user_mobile,$user->user_status);
                        // Redirect ไปหน้าแรก
                        $this->tb_user->check_password();
                    }else{
                        $this->session->set_flashdata('error','สมาชิกนี้ถูกระงับการใช้งานอยู่');
                        redirect(base_url('auth/login'));
                    }
                    // เสร็จกระบวนการ...
                }else{
                    $this->session->set_flashdata('error','เข้าสู่ระบบด้วย Facebook ไม่สำเร็จ');
                }
            }else{
                // Facebook มี id อยู่แล้ว
                // Login ได้เลย
                if($user->user_status == 'Active') {
                    $this->tb_user->user_session_set($user->user_id, $user->user_email, $user->user_type, $user->user_mobile,$user->user_status);
                    $this->tb_user->check_password();
                }else{
                    $this->session->set_flashdata('error','สมาชิกนี้ถูกระงับการใช้งานอยู่');
                    redirect(base_url('auth/login'));
                }
            }
        }else{
            // ไม่เจอ user
            // สร้าง Account ใหม่
            $value = array(
                'user_email' => $facebook['email'],
                'user_facebook_id' => $facebook['id']
            );
            $created_user_id = $this->tb_user->user_register_id($value); // สร้าง Account พร้อม return id
            if($created_user_id > 0){ // สร้าง Account สำเร็จ
                $this->session->set_flashdata('success','เข้าสู่ระบบด้วย Facebook สำเร็จ / สร้าง Account ใหม่เรียบร้อยแล้ว');
                // ทำการดึงข้อมูลมาสร้าง session
                $user = $this->tb_user->get_user_by_id($created_user_id); // ดึงข้อมูลมา
                $this->tb_user->user_session_set($user->user_id, $user->user_email, $user->user_type, $user->user_mobile,$user->user_status);
                $this->tb_user->check_password();
            }else{
                $this->session->set_flashdata('error','เข้าสู่ระบบด้วย Facebook ไม่สำเร็จ');
            }
        }

      }
      else {
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl(base_url('auth/fbcallback'), $permissions);
        redirect($loginUrl);
        //echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
      }

}

function fbcallback(){
    ob_start();
      $appid = "2359331964290771";
      $fb = new Facebook\Facebook([
        'app_id' => "2359331964290771", // Replace {app-id} with your app id
        'app_secret' => '05ac8b57974c0bacb71eff2de42caf74',
        'default_graph_version' => 'v2.2',
    ]);

    $helper = $fb->getRedirectLoginHelper();
    if (isset($_GET['state'])) { $helper->getPersistentDataHandler()->set('state', $_GET['state']); }
    try {
    $accessToken = $helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
    }
    if (! isset($accessToken)) {
    if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
    }
    exit;
    }
    // Logged in
    echo '<h3>Access Token</h3>';
    var_dump($accessToken->getValue());
    // The OAuth 2.0 client handler helps us manage access tokens
    $oAuth2Client = $fb->getOAuth2Client();
    // Get the access token metadata from /debug_token
    $tokenMetadata = $oAuth2Client->debugToken($accessToken);
    echo '<h3>Metadata</h3>';
    var_dump($tokenMetadata);
    // Validation (these will throw FacebookSDKException's when they fail)
    $tokenMetadata->validateAppId($appid); // Replace {app-id} with your app id
    // If you know the user ID this access token belongs to, you can validate it here
    //$tokenMetadata->validateUserId('123');
    $tokenMetadata->validateExpiration();
    if (! $accessToken->isLongLived()) {
    // Exchanges a short-lived access token for a long-lived one
    try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
        exit;
    }
    echo '<h3>Long-lived</h3>';
    var_dump($accessToken->getValue());
    }
    $_SESSION['fb_access_token'] = (string) $accessToken;
    // User is logged in with a long-lived access token.
    // You can redirect them to a members-only page.
    header('Location: '.base_url('auth/facebook'));
    ob_end_flush();
}
}

?>