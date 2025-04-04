<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5">
    <h1 class="mb-4 text-center">Thêm Sản Phẩm Mới</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="/Product/save" enctype="multipart/form-data" onsubmit="return validateForm();">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Tên sản phẩm:</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Nhập tên sản phẩm" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="price" class="form-label">Giá sản phẩm:</label>
                <input type="number" id="price" name="price" class="form-control" placeholder="Nhập giá sản phẩm" step="0.01" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả sản phẩm:</label>
            <textarea id="description" name="description" class="form-control" rows="4" placeholder="Nhập mô tả sản phẩm" required></textarea>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Danh mục sản phẩm:</label>
            <select id="category_id" name="category_id" class="form-select" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->id; ?>"><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Chọn hình ảnh:</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/*">
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
            <a href="/Product/" class="btn btn-secondary">Quay lại danh sách</a>
        </div>
    </form>
</div>

<?php include 'app/views/shares/footer.php'; ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
fetch('/api/category')
.then(response => response.json())
.then(data => {
const categorySelect = document.getElementById('category_id');
data.forEach(category => {
const option = document.createElement('option');
option.value = category.id;
option.textContent = category.name;
categorySelect.appendChild(option);
});
});
document.getElementById('add-product-form').addEventListener('submit', 
function(event) {
event.preventDefault();
const formData = new FormData(this);
const jsonData = {};
formData.forEach((value, key) => {
jsonData[key] = value;
});
fetch('/api/product', {
method: 'POST',
headers: {
'Content-Type': 'application/json'
},
body: JSON.stringify(jsonData)
})
.then(response => response.json())
.then(text => {
console.log('Raw response:', text); // Log the raw response text
try {
const data = text;
if (data.message === 'Product created successfully') {
location.href = '/Product';
} else {
alert('Thêm sản phẩm thất bại');
}
} catch (error) {
console.error('Error parsing JSON:', error);
alert('Lỗi: Không thể phân tích JSON từ phản hồi của máy chủ.');
}
});
});
});
</script>
