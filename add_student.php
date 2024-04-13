<?php
require_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
    if ($conn->connect_error) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
    }

    $sql = "INSERT INTO student (Stname, CODE, Email, Class) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Lỗi chuẩn bị câu lệnh SQL: " . $conn->error;
    } else {
        $stmt->bind_param("ssss", $name, $id, $email, $class);
        $name = $_POST['Stname'];
        $id = $_POST['id'];
        $email = $_POST['email'];
        $class = $_POST['class'];       
        // Kiểm tra dữ liệu nhập vào có chứa ký tự đặc biệt không
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $name) || 
            preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $id) || 
            preg_match('/[\'^£$%&*()}{#~?><>,|=_+¬-]/', $email) || 
            preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $class)) {
            echo "Dữ liệu nhập vào không hợp lệ!";
        } else {
            // Thực thi câu lệnh SQL đã chuẩn bị
            if ($stmt->execute()) {
                echo "Student added successfully. You will be redirected to the homepage in 5 seconds.";
                // Chuyển hướng về trang home_page.php sau 5 giây
                echo '<script>setTimeout(function(){ window.location.href = "home_page.php"; }, 5000);</script>';
            } else {
                echo "Error: " . $conn->error;
            }
        }
        
        // Đóng statement và kết nối
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Add Student</title>
</head>

<body class="bg-gray-300">
    <div class="container mx-auto p-8 ">
        <h2 class="text-2xl font-bold mb-4">Add Student</h2>
        <form action="add_student.php" method="post">
            <input type="text" name="Stname" placeholder="Name student" class="py-2 px-4 border-b mb-4" required>
            <input type="text" name="id" placeholder="CODE" class="py-2 px-4 border-b mb-4" required>
            <input type="email" name="email" placeholder="Email" class="py-2 px-4 border-b mb-4" required>
            <input type="text" name="class" placeholder="Class" class="py-2 px-4 border-b mb-4" required>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Add</button>
        </form>
    </div>
</body>

</html>
