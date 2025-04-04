<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h1 class="mb-3 text-primary">📂 Danh sách danh mục</h1>
    <a href="/Category/add" class="btn btn-success mb-3">
        ➕ Thêm danh mục mới
    </a>

    <div class="row">
        <?php foreach ($categories as $category): ?>
            <div class="col-md-4">
                <div class="card border-primary shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="/Category/show/<?php echo $category->id; ?>" class="text-decoration-none text-dark fw-bold">
                                <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </h5>
                        <p class="card-text text-muted">
                            <?php echo htmlspecialchars($category->description, ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                        <div class="d-flex justify-content-between">
                            <a href="/Category/edit/<?php echo $category->id; ?>" class="btn btn-warning">
                                ✏️ Sửa
                            </a>
                            <a href="/Category/delete/<?php echo $category->id; ?>" class="btn btn-danger"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                🗑 Xóa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>