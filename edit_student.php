<?php
require_once('config.php');

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST['id']) && !empty($_POST['Stname']) && !empty($_POST['Email']) && !empty($_POST['Class']) && isset($_POST['Code'])) {
        $id = $_POST['id'];
        $name = $_POST['Stname'];
        $email = $_POST['Email'];
        $class = $_POST['Class'];
        $code = $_POST['Code'];

        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $name) || 
            preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $id) || 
            preg_match('/[\'^£$%&*()}{#~?><>,|=_+¬-]/', $email) || 
            preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $class) || 
            preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $code)) {
            $message = "Dữ liệu nhập vào không hợp lệ!";
        } else {

            if (empty($id) || empty($name) || empty($email) || empty($class)) {
                $message = "Không được để trống thông tin!";
            } else {

                $conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);

                if ($conn->connect_error) {
                    die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
                }

                $sql = "UPDATE student SET Stname='$name', Email='$email', Class='$class', Code='$code' WHERE ID='$id'";

                if ($conn->query($sql) === TRUE) {
                    $message = "Student information updated successfully. You will be redirected to the homepage in 5 seconds.";

                    header("refresh:5;url=home_page.php");
                } else {
                    $message = "Error updating student information: " . $conn->error;
                }

                // Đóng kết nối
                $conn->close();
            }
        }
    } else {
        $message = "Dữ liệu không hợp lệ!";
    }
} else {
    if (!isset($_GET['id'])) {
        die('Không có ID sinh viên được cung cấp');
    }
    $id = $_GET['id'];
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
    $sql = "SELECT * FROM student WHERE ID='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        $name = $student['Stname'];
        $email = $student['Email'];
        $class = $student['Class'];
        $code = isset($student['Code']) ? $student['Code'] : '';
    } else {
        die('Không tìm thấy sinh viên có ID này trong cơ sở dữ liệu');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Edit Student</title>
</head>

<body class="bg-gray-300">
    <div class="container mx-auto p-8 ">
        <h2 class="text-2xl font-bold mb-4">Edit Student</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
            <input type="text" name="Stname" placeholder="Name student" class="py-2 px-4 border-b mb-4" value="<?php echo $name; ?>" required>
            <input type="email" name="Email" placeholder="Email" class="py-2 px-4 border-b mb-4" value="<?php echo $email; ?>" required>
            <input type="text" name="Class" placeholder="Class" class="py-2 px-4 border-b mb-4" value="<?php echo $class; ?>" required>
            <input type="text" name="Code" placeholder="Code" class="py-2 px-4 border-b mb-4" value="<?php echo $code; ?>">
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Update</button>
        </form>
        <?php echo $message; ?> <!-- Hiển thị thông điệp -->
    </div>
</body>

</html>
