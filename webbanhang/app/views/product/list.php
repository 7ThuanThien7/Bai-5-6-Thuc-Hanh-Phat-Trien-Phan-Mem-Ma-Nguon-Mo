<?php include 'app/views/shares/header.php'; ?>

<style>
    body {
        background-image: url('https://cdn.photoroom.com/v2/image-cache?path=gs://background-7ef44.appspot.com/backgrounds_v3/white/01_-_white.jpg');
        background-size: cover;
        background-position: center;
        color: #34495e;
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        line-height: 1.6;
    }

    h1 {
        text-align: center;
        color: #2c3e50;
        font-size: 2.8rem;
        margin-bottom: 50px;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .container {
        width: 90%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 50px 0;
    }

    .btn-success {
        background-color: #1abc9c;
        border: none;
        border-radius: 50px;
        padding: 14px 30px;
        color: black;
        font-size: 1.1rem;
        font-weight: 600;
        text-transform: uppercase;
        transition: background-color 0.3s ease, transform 0.3s ease;
        display: block;
        margin: 10px auto;
    }

    .btn-success:hover {
        background-color: #16a085;
        transform: translateY(-3px);
    }

    .product-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
    }

    .product-item {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        padding: 25px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .product-image {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        object-fit: cover;
    }
</style>

<div class="container">
    <h1>Danh sách sản phẩm</h1>
    <a href="/Product/add" class="btn btn-success mb-3">Thêm sản phẩm mới</a>
    <div class="product-list" id="product-list">
        <!-- Sản phẩm sẽ được tải từ API -->
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const token = localStorage.getItem('jwtToken');
    if (!token) {
        alert('Vui lòng đăng nhập');
        location.href = '/account/login';
        return;
    }
    
    fetch('/api/product', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        }
    })
    .then(response => response.json())
    .then(data => {
        const productList = document.getElementById('product-list');
        data.forEach(product => {
            const productItem = document.createElement('div');
            productItem.className = 'product-item';
            productItem.innerHTML = `
                <h2><a href="/Product/show/${product.id}">${product.name}</a></h2>
                <img src="/${product.image}" alt="Product Image" class="product-image">
                <p>Giá: ${product.price} VND</p>
                <p>Danh mục: ${product.category_name}</p>
                <a href="/Product/edit/${product.id}" class="btn btn-warning">Sửa</a>
                <button class="btn btn-danger" onclick="deleteProduct(${product.id})">Xóa</button>
            `;
            productList.appendChild(productItem);
        });
    });
});

function deleteProduct(id) {
    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
        fetch(`/api/product/${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Product deleted successfully') {
                location.reload();
            } else {
                alert('Xóa sản phẩm thất bại');
            }
        });
    }
}
</script>