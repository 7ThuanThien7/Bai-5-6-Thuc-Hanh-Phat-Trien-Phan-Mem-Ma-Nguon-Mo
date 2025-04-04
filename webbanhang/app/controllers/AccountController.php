<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');
require_once('app/utils/JWTHandler.php');

class AccountController {
    private $accountModel;
    private $db;
    private $jwtHandler;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
        $this->jwtHandler = new JWTHandler();
    }

    // Hiển thị trang đăng ký
    public function register() {
        include_once 'app/views/account/register.php';
    }

    // Hiển thị trang đăng nhập
    public function login() {
        include_once 'app/views/account/login.php';
    }

    // Xử lý đăng ký tài khoản
    public function save() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $role = $_POST['role'] ?? 'user';

            $errors = [];

            if (empty($username)) $errors['username'] = "Vui lòng nhập username!";
            if (empty($fullName)) $errors['fullname'] = "Vui lòng nhập fullname!";
            if (empty($password)) $errors['password'] = "Vui lòng nhập password!";
            if ($password != $confirmPassword) $errors['confirmPass'] = "Mật khẩu và xác nhận chưa khớp!";
            if (!in_array($role, ['admin', 'user'])) $role = 'user';

            // Kiểm tra username đã tồn tại chưa
            if ($this->accountModel->getAccountByUsername($username)) {
                $errors['account'] = "Tài khoản này đã được đăng ký!";
            }

            if (count($errors) > 0) {
                include_once 'app/views/account/register.php';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                $result = $this->accountModel->save($username, $fullName, $hashedPassword, $role);
                
                if ($result) {
                    header('Location: /account/login');
                    exit;
                }
            }
        }
    }

    // Xử lý đăng nhập và tạo JWT Token
    public function checkLogin() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        $user = $this->accountModel->getAccountByUsername($username);

        if ($user && password_verify($password, $user->password)) {
            // Tạo JWT token
            $token = $this->jwtHandler->encode([
                'id' => $user->id,
                'username' => $user->username,
                'role' => $user->role
            ]);

            echo json_encode(['token' => $token]);
        } else {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid credentials']);
        }
    }

    // Xử lý đăng xuất
    public function logout() {
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['role']);

        header('Location: /product');
        exit;
    }
}
?>
