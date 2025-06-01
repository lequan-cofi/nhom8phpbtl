<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng nhập/Đăng ký - iStore</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<style> 
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

* {
    box-sizing: border-box;
}

body {
    background: #f6f5f7;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    font-family: 'Montserrat', sans-serif;
    height: 100vh;
    margin: -20px 0 50px;
}

h1 {
    font-weight: bold;
    margin: 0;
}

h2 {
    text-align: center;
}

p {
    font-size: 14px;
    font-weight: 100;
    line-height: 20px;
    letter-spacing: 0.5px;
    margin: 20px 0 30px;
}

span {
    font-size: 12px;
}

a {
    color: #333;
    font-size: 14px;
    text-decoration: none;
    margin: 15px 0;
}

button {
    border-radius: 20px;
    border: 1px solid #FF4B2B;
    background-color: #FF4B2B;
    color: #FFFFFF;
    font-size: 12px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: transform 80ms ease-in;
}

button:active {
    transform: scale(0.95);
}

button:focus {
    outline: none;
}

button.ghost {
    background-color: transparent;
    border-color: #FFFFFF;
}

form {
    background-color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 50px;
    height: 100%;
    text-align: center;
}

input {
    background-color: #eee;
    border: none;
    padding: 12px 15px;
    margin: 8px 0;
    width: 100%;
}

.container {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25),
        0 10px 10px rgba(0, 0, 0, 0.22);
    position: relative;
    overflow: hidden;
    width: 850px;
    max-width: 100%;
    min-height: 780px;
}

.form-container {
    position: absolute;
    top: 0;
    height: 100%;
    transition: all 0.6s ease-in-out;
}

.sign-in-container {
    left: 0;
    width: 50%;
    z-index: 2;
}

.container.right-panel-active .sign-in-container {
    transform: translateX(100%);
}

.sign-up-container {
    left: 0;
    width: 50%;
    opacity: 0;
    z-index: 1;
}

.container.right-panel-active .sign-up-container {
    transform: translateX(100%);
    opacity: 1;
    z-index: 5;
    animation: show 0.6s;
}

@keyframes show {
    0%, 49.99% {
        opacity: 0;
        z-index: 1;
    }
    50%, 100% {
        opacity: 1;
        z-index: 5;
    }
}

.overlay-container {
    position: absolute;
    top: 0;
    left: 50%;
    width: 50%;
    height: 100%;
    overflow: hidden;
    transition: transform 0.6s ease-in-out;
    z-index: 100;
}

.container.right-panel-active .overlay-container {
    transform: translateX(-100%);
}

.overlay {
    background: #FF416C;
    background: -webkit-linear-gradient(to right, #FF4B2B, #FF416C);
    background: linear-gradient(to right, #FF4B2B, #FF416C);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: 0 0;
    color: #FFFFFF;
    position: relative;
    left: -100%;
    height: 100%;
    width: 200%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
}

.container.right-panel-active .overlay {
    transform: translateX(50%);
}

.overlay-panel {
    position: absolute;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 40px;
    text-align: center;
    top: 0;
    height: 100%;
    width: 50%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
}

.overlay-left {
    transform: translateX(-20%);
}

.container.right-panel-active .overlay-left {
    transform: translateX(0);
}

.overlay-right {
    right: 0;
    transform: translateX(0);
}

.container.right-panel-active .overlay-right {
    transform: translateX(20%);
}

.social-container {
    margin: 20px 0;
}

.social-container a {
    border: 1px solid #DDDDDD;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    margin: 0 5px;
    height: 40px;
    width: 40px;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
    width: 100%;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.gender-container {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin: 20px 0;
}

.gender-container label {
    display: flex;
    align-items: center;
    font-size: 14px;
    font-weight: 500;
    color: #333;
    cursor: pointer;
}

.gender-container input[type="radio"] {
    margin-right: 8px;
    transform: scale(1.1);
    accent-color: #FF4B2B;
}

.form-group {
    width: 100%;
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-size: 14px;
    color: #333;
    text-align: left;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.form-group input:focus {
    border-color: #FF4B2B;
    outline: none;
}

.password-requirements {
    font-size: 12px;
    color: #666;
    margin-top: 5px;
    text-align: left;
}
</style>
<body>
    <h2>Đăng nhập/Đăng ký</h2>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="<?php echo BASE_URL; ?>/index.php?page=login_signup&action=signup" method="POST">
                <h1>Tạo tài khoản</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>hoặc sử dụng email để đăng ký</span>
                
                <div class="form-group">
                    <input type="text" name="name" placeholder="Họ và tên" required 
                           pattern="[A-Za-zÀ-ỹ\s]+" title="Vui lòng chỉ nhập chữ cái và khoảng trắng"/>
                </div>
                
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required />
                </div>
                
                <div class="form-group">
                    <input type="password" name="password" placeholder="Mật khẩu" required 
                           minlength="8" title="Mật khẩu phải có ít nhất 8 ký tự"/>
                    <div class="password-requirements">
                        Mật khẩu phải có ít nhất 8 ký tự
                    </div>
                </div>
                
                <div class="form-group">
                    <input type="password" name="password_confirm" placeholder="Xác nhận mật khẩu" required />
                </div>
                
                <div class="form-group">
                    <input type="tel" name="phone" placeholder="Số điện thoại" required 
                           pattern="[0-9]{10,11}" title="Vui lòng nhập số điện thoại hợp lệ (10-11 số)"/>
                </div>
                
                <div class="form-group">
                    <input type="text" name="address" placeholder="Địa chỉ" required />
                </div>
                
                <div class="gender-container">
                    <label>
                        <input type="radio" name="gender" value="Nam" required>
                        Nam
                    </label>
                    <label>
                        <input type="radio" name="gender" value="Nữ" required>
                        Nữ
                    </label>
                </div>

                <button type="submit">Đăng ký</button>
            </form>
        </div>

        <div class="form-container sign-in-container">
            <form action="<?php echo BASE_URL; ?>/index.php?page=login_signup&action=signin" method="POST">
                <h1>Đăng nhập</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>hoặc sử dụng email để đăng nhập</span>
                
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required />
                </div>
                
                <div class="form-group">
                    <input type="password" name="password" placeholder="Mật khẩu" required />
                </div>
                
                <a href="#">Quên mật khẩu?</a>
                <button type="submit">Đăng nhập</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Chào bạn!</h1>
                    <p>Nhập thông tin cá nhân của bạn và bắt đầu hành trình với chúng tôi   </p>
                    <button class="ghost" id="signIn" type="button">Đăng nhập</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Chào mừng trở lại!</h1>
                    <p>Để tiếp tục, vui lòng đăng nhập với thông tin cá nhân của bạn</p>
                    <button class="ghost" id="signUp" type="button">Đăng ký</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add('right-panel-active');
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove('right-panel-active');
        });

        // Xử lý hiển thị thông báo lỗi
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.display = 'none';
            }, 5000);
        });
    </script>
</body>
</html>