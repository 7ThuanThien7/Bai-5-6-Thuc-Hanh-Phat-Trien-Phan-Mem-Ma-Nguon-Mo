<?php
class CartController
{
    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($productId)
    {
        $productModel = new ProductMode1();
        $product = $productModel->getProductById($productId);

        if (!$product) {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
            return;
        }

        // Kiểm tra và khởi tạo giỏ hàng nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        if (isset($_SESSION['cart'][$productId])) {
            // Nếu có, tăng số lượng và tính lại tổng giá
            $_SESSION['cart'][$productId]['quantity']++;
            $_SESSION['cart'][$productId]['totalPrice'] = $_SESSION['cart'][$productId]['quantity'] * $_SESSION['cart'][$productId]['price'];
        } else {
            // Nếu chưa có, thêm sản phẩm vào giỏ và khởi tạo giá trị
            $_SESSION['cart'][$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'totalPrice' => $product->price,  // Khởi tạo totalPrice
                'image' => $product->image
            ];
        }

        // Cập nhật lại tổng tiền giỏ hàng
        $this->updateCartTotal();

        echo json_encode(['success' => true, 'message' => 'Sản phẩm đã được thêm vào giỏ hàng.']);
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function update($productId)
    {
        if (!isset($_SESSION['cart'][$productId])) {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không có trong giỏ hàng.']);
            return;
        }

        $quantity = $_GET['quantity'];

        if ($quantity <= 0) {
            echo json_encode(['success' => false, 'message' => 'Số lượng phải lớn hơn 0.']);
            return;
        }

        $_SESSION['cart'][$productId]['quantity'] = $quantity;
        $_SESSION['cart'][$productId]['totalPrice'] = $quantity * $_SESSION['cart'][$productId]['price'];

        // Cập nhật lại tổng tiền giỏ hàng
        $this->updateCartTotal();

        echo json_encode(['success' => true, 'message' => 'Giỏ hàng đã được cập nhật.']);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($productId)
    {
        if (!isset($_SESSION['cart'][$productId])) {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.']);
            return;
        }
    
        // Xóa sản phẩm khỏi giỏ hàng
        unset($_SESSION['cart'][$productId]);
    
        // Cập nhật lại tổng tiền giỏ hàng
        $this->updateCartTotal();
    
        echo json_encode([
            'success' => true,
            'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng.',
            'cartTotal' => $_SESSION['cartTotal']
        ]);
    }

    // Cập nhật tổng tiền giỏ hàng
    private function updateCartTotal()
    {
        $_SESSION['cartTotal'] = 0;
        foreach ($_SESSION['cart'] as $item) {
            $_SESSION['cartTotal'] += $item['totalPrice'];
        }
    }

    // Tăng số lượng sản phẩm trong giỏ hàng
    public function increaseQuantity($productId)
    {
        if (!isset($_SESSION['cart'][$productId])) {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không có trong giỏ hàng.']);
            return;
        }

        $_SESSION['cart'][$productId]['quantity']++;
        $_SESSION['cart'][$productId]['totalPrice'] = $_SESSION['cart'][$productId]['quantity'] * $_SESSION['cart'][$productId]['price'];

        $this->updateCartTotal();

        echo json_encode(['success' => true, 'message' => 'Số lượng sản phẩm đã được tăng.']);
    }

    // Giảm số lượng sản phẩm trong giỏ hàng
    public function decreaseQuantity($productId)
    {
        if (!isset($_SESSION['cart'][$productId])) {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không có trong giỏ hàng.']);
            return;
        }

        if ($_SESSION['cart'][$productId]['quantity'] > 1) {
            $_SESSION['cart'][$productId]['quantity']--;
            $_SESSION['cart'][$productId]['totalPrice'] = $_SESSION['cart'][$productId]['quantity'] * $_SESSION['cart'][$productId]['price'];
        } else {
            echo json_encode(['success' => false, 'message' => 'Số lượng không thể giảm thêm']);
            return;
        }

        $this->updateCartTotal();

        echo json_encode(['success' => true, 'message' => 'Số lượng sản phẩm đã được giảm.']);
    }
}