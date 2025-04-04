<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Giỏ Hàng</h1>

    <?php if (!empty($cart)): ?>
        <ul class="list-group">
            <?php foreach ($cart as $id => $item): ?>
                <li class="list-group-item d-flex align-items-center justify-content-between" id="cart-item-<?php echo $id; ?>">
                    <div class="d-flex align-items-center">
                        <?php if ($item['image']): ?>
                            <img src="/<?php echo $item['image']; ?>" alt="Product Image" style="max-width: 100px; max-height: 100px; margin-right: 20px;">
                        <?php endif; ?>
                        <div>
                            <h4 class="mb-2"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h4>
                            <p class="mb-2">Giá: <?php echo number_format($item['price']); ?> VND</p>
                            <p class="mb-2">Số lượng: <span id="quantity-<?php echo $id; ?>"><?php echo $item['quantity']; ?></span></p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <button class="btn btn-success btn-sm mx-1" onclick="updateQuantity(<?php echo $id; ?>, 'increase')">+</button>
                        <button class="btn btn-danger btn-sm mx-1" onclick="updateQuantity(<?php echo $id; ?>, 'decrease')">-</button>

                        <p class="ms-3" id="totalPrice-<?php echo $id; ?>" data-price="<?php echo $item['price']; ?>">
                            Tổng: <?php echo number_format($item['price'] * $item['quantity']); ?> VND
                        </p>

                        <button class="btn btn-outline-danger btn-sm mx-2" onclick="removeFromCart(<?php echo $id; ?>)">🗑 Xóa</button>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-center">Giỏ hàng của bạn đang trống.</p>
    <?php endif; ?>

    <!-- Tổng tiền giỏ hàng -->
    <div class="mt-4 text-end">
        <h4>Tổng tiền giỏ hàng: <span id="grandTotal"><?php echo number_format(array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart))); ?> VND</span></h4>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="/Product" class="btn btn-secondary">Tiếp tục mua sắm</a>
        <a href="/Product/checkout" class="btn btn-primary">Thanh Toán</a>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<script>
// Cập nhật số lượng sản phẩm
function updateQuantity(productId, action) {
    let url = action === 'increase' ? `/Cart/increaseQuantity/${productId}` : `/Cart/decreaseQuantity/${productId}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let quantity = document.getElementById('quantity-' + productId);
                let totalPrice = document.getElementById('totalPrice-' + productId);
                let grandTotal = document.getElementById('grandTotal');

                let newQuantity = parseInt(quantity.textContent) + (action === 'increase' ? 1 : -1);
                if (newQuantity < 1) newQuantity = 1;

                quantity.textContent = newQuantity;

                let price = parseInt(totalPrice.getAttribute('data-price'));
                let newTotalPrice = price * newQuantity;
                totalPrice.textContent = 'Tổng: ' + newTotalPrice.toLocaleString() + ' VND';

                updateGrandTotal();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Lỗi:', error));
}

// Xóa sản phẩm khỏi giỏ hàng
function removeFromCart(productId) {
    fetch(`/Cart/remove/${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('cart-item-' + productId).remove();
                updateGrandTotal();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Lỗi:', error));
}

// Cập nhật tổng tiền giỏ hàng
function updateGrandTotal() {
    let allTotalPrices = document.querySelectorAll('[id^="totalPrice-"]');
    let grandTotalValue = Array.from(allTotalPrices).reduce((sum, item) => {
        return sum + parseInt(item.textContent.replace(/\D/g, ''));
    }, 0);

    document.getElementById('grandTotal').textContent = grandTotalValue.toLocaleString() + ' VND';
}
</script>
