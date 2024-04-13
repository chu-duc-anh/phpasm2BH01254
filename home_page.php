<?php
require_once ('pbhelper.php');

?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Management</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            Quản lý thông tin sinh viên
            <form method="get">
            </form>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ và Tên</th>
                    <th>Email</th>
                    <th>Lớp</th>
                    <th>Code</th>
                    <th width="60px"></th>
                    <th width="60px"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (isset($_GET['s']) && $_GET['s'] != '') {
                    $sql = 'select * from student where fullname like "%'.$_GET['s'].'%"';
                } else {
                    $sql = 'select * from student';
                }

                $studentList = executeResult($sql);

                $index = 1;
                foreach ($studentList as $std) {
                    echo '<tr>
                        <td>'.($index++).'</td>
                        <td>'.$std['Stname'].'</td>
                        <td>'.$std['Email'].'</td>
                        <td>'.$std['Class'].'</td>
                        <td>'.$std['CODE'].'</td>
                        <td><a href="edit_student.php?id='.$std['ID'].'" class="btn btn-warning">Edit</a></td>
                        <td>
                            <a href="#" class="btn btn-danger" onclick="confirmDelete('.$std['ID'].')">Delete</a>
                        </td>
                    </tr>';
                }
                ?>
                </tbody>
            </table>
            <button class="btn btn-success" onclick="window.open('add_student.php', '_self')">Add Student</button>
        </div>
    </div>
</div>

<script type="text/javascript">
    function confirmDelete(id) {
        var result = confirm("Bạn có muốn xoá sinh viên này không?");
        if (result) {
            deleteStudent(id);
        }
    }

    function deleteStudent(id) {
        $.post('delete_student.php', {
            'id': id
        }, function(data) {
            alert(data);
            location.reload();
        });
    }
</script>
</body>
</html>
