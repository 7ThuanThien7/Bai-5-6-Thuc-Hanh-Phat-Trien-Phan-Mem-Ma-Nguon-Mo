<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm - T&T Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .product-image {
            max-width: 100px;
            height: auto;
        }
        .banner {
            background-image: url('https://png.pngtree.com/background/20230416/original/pngtree-website-technology-line-dark-background-picture-image_2443641.jpg');
            background-size: cover;
            background-position: center;
            color: #ffffff;
            text-align: center;
            padding: 80px 0;
        }
        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            color: #007bff !important;
            font-weight: bold;
        }
        .nav-link {
            color: #333333 !important;
        }
        .nav-link:hover {
            color: #007bff !important;
        }
        
    </style>
</head>
<body>
    <marquee style="color: #ffffff; font-style: italic; margin-bottom: 10px; border: 1px solid #007bff; background-color: #007bff; padding: 5px; border-radius: 5px;">
        <i class="fas fa-star"></i> Công nghệ Thông minh, Cuộc sống Thông minh, Chạm vào Tương lai, Chạm vào Công nghệ
    </marquee>

    <!-- Thanh điều hướng -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fas fa-microchip"></i> T&T Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/Product/"><i class="fas fa-list"></i> Danh sách sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="/Product/Cart"><i class="fas fa-shopping-cart"></i>  Giỏ Hàng</a></li>
                    <li class="nav-item" id="nav-admin-panel" style="display: none;">
                        <a class="nav-link" href="/admin/dashboard"><i class="fas fa-cogs"></i> Quản trị</a>
                    </li>
                    <li class="nav-item" id="nav-add-product" style="display: none;">
                        <a class="nav-link" href="/Product/add"><i class="fas fa-plus-circle"></i> Thêm sản phẩm</a>
                    </li>
                    <li class="nav-item" id="nav-login">
                        <a class="nav-link" href="/account/login">😁 Đăng nhập</a>
                    </li>
                    <li class="nav-item" id="nav-logout" style="display: none;">
                        <a class="nav-link" href="#" onclick="logout()">🙂 Đăng xuất</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Banner -->
    <div class="banner">
    <h1 style="color: white;">Chào mừng đến với T&T Shop</h1>
    </div>


    <script>
        function logout() {
            localStorage.removeItem('jwtToken');
            location.href = '/account/login';
        }

        document.addEventListener("DOMContentLoaded", function() {
            const token = localStorage.getItem('jwtToken');
            if (!token) {
                document.getElementById('nav-login').style.display = 'block';
                document.getElementById('nav-logout').style.display = 'none';
                return;
            }

            try {
                const payload = JSON.parse(atob(token.split('.')[1])); // Giải mã payload JWT
                const role = payload.role; // Lấy quyền user

                document.getElementById('nav-login').style.display = 'none';
                document.getElementById('nav-logout').style.display = 'block';

                if (role === 'admin') {
                    document.getElementById('nav-add-product').style.display = 'block'; // Hiện "Thêm sản phẩm"
                    document.getElementById('nav-admin-panel').style.display = 'block'; // Hiện "Quản trị"
                }
            } catch (error) {
                console.error("JWT không hợp lệ:", error);
                localStorage.removeItem('jwtToken'); 
                location.href = '/account/login';
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
