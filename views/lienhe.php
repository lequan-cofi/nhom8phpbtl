<?php
// Set page title
$data['pageTitle'] = 'Liên hệ - iStore';
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h2>Liên hệ với chúng tôi</h2>
            <p class="mb-4">Nếu bạn có bất kỳ câu hỏi hoặc thắc mắc nào, vui lòng điền vào form bên dưới và chúng tôi sẽ liên hệ lại với bạn trong thời gian sớm nhất.</p>
            
            <form id="contactForm" onsubmit="submitContact(event)">
                <div class="form-group">
                    <label for="HoTen">Họ và tên *</label>
                    <input type="text" class="form-control" id="HoTen" name="HoTen" required>
                </div>
                
                <div class="form-group">
                    <label for="Email">Email *</label>
                    <input type="email" class="form-control" id="Email" name="Email" required>
                </div>
                
                <div class="form-group">
                    <label for="ChuDe">Chủ đề *</label>
                    <input type="text" class="form-control" id="ChuDe" name="ChuDe" required>
                </div>
                
                <div class="form-group">
                    <label for="NoiDung">Nội dung *</label>
                    <textarea class="form-control" id="NoiDung" name="NoiDung" rows="5" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Gửi</button>
            </form>
        </div>
        
        <div class="col-md-6">
            <h2>Thông tin liên hệ</h2>
            <div class="contact-info">
                <div class="info-item mb-4">
                    <h5><i class="fas fa-map-marker-alt"></i> Địa chỉ</h5>
                    <p>123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</p>
                </div>
                
                <div class="info-item mb-4">
                    <h5><i class="fas fa-phone"></i> Điện thoại</h5>
                    <p>0123.456.789</p>
                </div>
                
                <div class="info-item mb-4">
                    <h5><i class="fas fa-envelope"></i> Email</h5>
                    <p>contact@istore.com</p>
                </div>
                
                <div class="info-item">
                    <h5><i class="fas fa-clock"></i> Giờ làm việc</h5>
                    <p>Thứ 2 - Thứ 6: 8:00 - 17:30</p>
                    <p>Thứ 7: 8:00 - 12:00</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function submitContact(event) {
    event.preventDefault();
    
    const formData = new FormData(document.getElementById('contactForm'));
    formData.append('submit_contact', '1');
    
    fetch('<?php echo BASE_URL; ?>/index.php?page=lienhe&action=submitContact', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi sớm nhất có thể.');
            document.getElementById('contactForm').reset();
        } else {
            alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
    });
}
</script>

<style>
.contact-info {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 5px;
}

.info-item h5 {
    color: #2761e7;
    margin-bottom: 10px;
}

.info-item i {
    margin-right: 10px;
}

.form-control {
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 10px;
}

.btn-primary {
    background-color: #2761e7;
    border-color: #2761e7;
    padding: 10px 30px;
}

.btn-primary:hover {
    background-color: #1c4bb3;
    border-color: #1c4bb3;
}
</style> 