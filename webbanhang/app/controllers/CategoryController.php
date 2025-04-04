<?php

require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');

class CategoryController{
    private $categoryModel;
    private $db;

    public function __construct(){
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    public function index(){
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    public function show($id){
        $category = $this->categoryModel->getCategoryById($id);
        if ($category){
            include 'app/views/category/show.php';
        }else {
            echo "Không thấy danh mục";
        }
    }

    public function add(){
        include_once 'app/views/category/add.php';
    }

    public function save(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            $result = $this->categoryModel->addCategory($name, $description);

            if (is_array($result)){
                $errors = $result;
                include 'app/views/category/add.php';
            }else{
                header('Location: /Category');
            }
        }
    }


    public function edit($id){
        $category = $this->categoryModel->getCategoryById($id);

        if ($category){
            include 'app/views/category/edit.php';
        }else{
            echo "Không tìm thấy danh mục";
        }
    }

    public function update(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];

            $edit = $this->categoryModel->updateCategory($id, $name, $description);

            if ($edit){
                header('Location: /Category');
            }else{
                echo "Đã xảy ra lỗi khi xóa danh mục";
            }
        }
    }

    public function delete($id){
        if($this->categoryModel->deleteCategory($id)){
            header('Location: /Category');
        }else{
            echo "Đã xảy ra lỗi khi xoá sản phẩm.";
        }
    }
}

?>