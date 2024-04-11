<!DOCTYPE html>
<html>
<head>
    <title>API Caller</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2>API Caller</h2>
    <div class="form-group">
        <label for="urlInput">URL:</label>
        <input type="text" class="form-control" id="urlInput" placeholder="Enter URL">
    </div>
    <div class="form-group">
        <button class="btn btn-primary" id="addHeaderBtn">Add Header</button>
    </div>
    <div class="form-group" id="headerInputs">
        <label>Headers:</label>
        <div class="header-input">
            <input type="text" class="form-control header-key" placeholder="Header Key">
            <input type="text" class="form-control header-value" placeholder="Header Value">
        </div>
    </div>
    <div class="form-group">
        <button class="btn btn-primary" id="callApiBtn">Call API</button>
    </div>
    <div id="responseContainer"></div>
</div>

<script>
    $(document).ready(function () {
        // Thêm input header khi click vào nút Add Header
        $('#addHeaderBtn').click(function () {
            var headerInput = '<div class="header-input">' +
                '<input type="text" class="form-control header-key" placeholder="Header Key">' +
                '<input type="text" class="form-control header-value" placeholder="Header Value">' +
                '</div>';
            $('#headerInputs').append(headerInput);
        });

        // Gọi API khi click vào nút Call API
        $('#callApiBtn').click(function () {
            var url = $('#urlInput').val();
            var headers = {};

            // Lấy thông tin các input header
            $('.header-input').each(function () {
                var key = $(this).find('.header-key').val();
                var value = $(this).find('.header-value').val();
                if (key && value) {
                    headers[key] = value;
                }
            });

            // Gọi API sử dụng AJAX
            $.ajax({
                url: url,
                headers: headers,
                success: function (response) {
                    // Hiển thị dữ liệu trả về dưới dạng JSON pretty
                    $('#responseContainer').html(JSON.stringify(response, null, 2));
                },
                error: function (xhr, status, error) {
                    // Xử lý lỗi nếu có
                    $('#responseContainer').html('Error: ' + error);
                }
            });
        });
    });
</script>

</body>
</html>
