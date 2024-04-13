<?php
require_once('config.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Kết nối tới cơ sở dữ liệu
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
    }

    // Xóa sinh viên khỏi cơ sở dữ liệu
    $sql = "DELETE FROM student WHERE ID = $id";
    $result = $conn->query($sql);

    if ($result) {
        // Đóng kết nối cơ sở dữ liệu
        $conn->close();
        
        // Hiển thị thông báo và chuyển hướng về trang home_page.php
        echo '"Xoá sinh viên thành công"';
        exit();
    } else {
        echo 'Xoá sinh viên thất bại';
    }
} else {
    echo 'Yêu cầu không hợp lệ';
}
