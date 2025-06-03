<?php require_once 'partials/header.php'; ?>
<style>
   /* Card mặc định */
.card {
    border: none;
    border-radius: 16px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    background:rgb(189, 213, 238);
}

/* Hiệu ứng hover */
.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

/* Icon trong card */
.card i {
    color: #0d6efd; /* Màu xanh Bootstrap */
}

/* Tiêu đề card */
.card-title {
    font-size: 1.1rem;
    color: #333;
}

/* Tùy chỉnh container nếu muốn giới hạn max width */
.container {
    max-width: 1200px;
}

.card i {
    background:rgb(189, 213, 238);
    padding: 10px;
    border-radius: 50%;
}
/* Responsive fix nếu nhiều icon */
@media (max-width: 768px) {
    .card-title {
        font-size: 1rem;
    }
    .card i {
        font-size: 1.5rem;
    }
}
   /* Khuyến mãi */

</style>
<div class="container py-5">
    <h2 class="mb-4">Bảng điều khiển Admin</h2>
    <div class="row g-4">
        
        <div class="col-md-4">
            <a href="admin_phanhoi.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-comments fa-2x mb-2"></i>
                        <h5 class="card-title">Quản lý Phản hồi</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="admin_donhang.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                        <h5 class="card-title">Quản lý Đơn hàng</h5>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-4">
            <a href="admin_blog.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-blog fa-2x mb-2"></i>
                        <h5 class="card-title">Quản lý Blog</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="admin_cuahang.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-store fa-2x mb-2"></i>
                        <h5 class="card-title">Quản lý Cửa hàng</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="admin_thietbi.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-mobile-alt fa-2x mb-2"></i>
                        <h5 class="card-title">Quản lý Thiết bị</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="admin_LoaiThietBi.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-list fa-2x mb-2"></i>
                        <h5 class="card-title">Quản lý Loại Thiết bị</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="admin_hinhanhthietbi.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-image fa-2x mb-2"></i>
                        <h5 class="card-title">Quản lý Hình ảnh Thiết bị</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="admin_sales.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-tags fa-2x mb-2"></i>
                        <h5 class="card-title">Quản lý Sản phẩm Khuyến mãi</h5>
                    </div>
                </div>
            </a>
        </div>
      
        <div class="col-md-4">
            <a href="admin_poster.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-images fa-2x mb-2"></i>
                        <h5 class="card-title">Quản lý Poster</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="admin_nguoidung.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <h5 class="card-title">Quản lý Người dùng</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="admin_khuyenmai.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-tags fa-2x mb-2"></i>
                        <h5 class="card-title">Quản lý Khuyến mãi</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="addmin_phantich.php" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-chart-line fa-2x mb-2"></i>
                        <h5 class="card-title">Phân tích</h5>
                    </div>
                </div>
            </a>
        </div>
        
    </div>
</div>
<?php require_once 'partials/footer.php'; ?> 