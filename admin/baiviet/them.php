<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THÊM BÀI VIẾT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/them.css">
    <link rel="stylesheet" href="../css/base.css">
</head>
<body>
<?php
// Kết nối cơ sở dữ liệu
include('../../connect.php');
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Lấy dữ liệu từ form
  $TenBaiViet = $_POST["tenbaiviet"];
  $MaDiemDen = $_POST["madiemden"];
  $MoTa = $_POST["mota"];
  // Xử lý upload hình ảnh
  $hinhanh = $_FILES["hinhanh"]["name"];
  $hinhanh_temp = $_FILES["hinhanh"]["tmp_name"];
  $hinhanh_path = "../../hinhanh/" . $hinhanh; // Thư mục để lưu hình ảnh

  move_uploaded_file($hinhanh_temp, $hinhanh_path);

  // Thêm dữ liệu vào bảng tbldiemden
  $sql = "INSERT INTO tblbaiviet (tenbaiviet, madiemden, hinhanh, chitietbaiviet) VALUES ('$TenBaiViet', '$MaDiemDen', '$hinhanh', '$MoTa')";

  if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Thêm điểm du lịch thành công');</script>";

      // Chuyển hướng về trang danhsach.php sau khi thêm thành công
      echo "<script>window.location = '$port/admin/baiviet/danhsach.php';</script>";
  } else {
      echo "Lỗi: " . $sql . "<br>" . $conn->error;
  }
}
?>
<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <h2 style="text-align:center">THÊM BÀI VIẾT</h2>
            <form aaction="them.php" method="POST" class="was-validated" enctype="multipart/form-data">
              <div class="form-group">
                <label for="ten_monan">Tên bài viết:</label>
                <input type="text" class="form-control" id="tenbaiviet" placeholder="Tên bài viết" name="tenbaiviet" required>
              </div>
              <div class="form-group">
                <label for="ten_monan">Tên điểm du lịch:</label>
                <select class='mien' name="madiemden" id="">
                  <?php
                  // select ra danh sách điểm đến
                  $sql2 = "SELECT * FROM tbldiemden";
                  $conn2 = new mysqli("localhost", "root", "", "db_dulich");
                  $result2 = $conn2->query($sql2);
                  if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                      echo "<option value='" . $row2['madiemden'] . "'>" . $row2['tendiemden'] . "</option>";
                    }
                  } else {
                    echo "Không tìm thấy điểm du lịch.";
                  }
                 
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="hinhanh">Hình ảnh:</label>
                <input type="file" class="form-control" id="hinhanh" placeholder="Hình ảnh minh hoạ" name="hinhanh" required>
            
              </div>
              <div class="form-group">
                <label for="cachnau">Chi tiết :</label>
                <textarea  type="text" class="form-control" id="mota" placeholder="Mô tả" name="mota" required></textarea >
              </div>
              <button type="submit" class="btn btn-success">Thêm bài viết</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>