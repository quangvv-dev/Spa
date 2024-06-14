<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        .font12 {
            font-size: 10px;
        }

        body {
            font-family: system-ui;
        }

        .bold {
            font-weight: bold;
        }

        strong {
            font-size: 12px;
            font-weight: 600;
        }

        b {
            font-size: 12px;
        }

        h3 {
            margin: 0;
        }

        td {
            padding: 4px !important;
            border: none !important;
        }

        .table-bordered {
            border-top: dotted 1px;
            border-bottom: dotted 1px;
            border-right: none;
            border-left: none;
        }

        .mt0 {
            margin-bottom: 0px;
        }
    </style>

</head>
<div class="invoice">
    <div class="block-header">
        <div class="brand">VIỆN THẨM MỸ QUỐC TẾ GTG</div>
        <div class="address font12">Số 10, Vũ Phạm Hàm, Quận Cầu Giấy, Thành Phố Hà Nội</div>

        <div class="title text-center"><h3>PHIẾU TÁI KHÁM</h3></div>
        {{--            <div class="date-time font12"> </div>--}}
        <div class="customer">
            <div class="lesson bold">I/ THÔNG TIN KHÁCH HÀNG</div>
            <div class="info">
                <div class="row">
                    <div class="col-lg-6">
                        <span class="bold">Khách hàng: </span>
                        <span>Nguyễn Thị Hồng Vân</span>
                    </div>
                    <div class="col-lg-3">
                        <span>Năm sinh: </span> 1992
                    </div>
                    <div class="col-lg-3">
                        <span>Mã KH: </span> KH00183
                    </div>
                    <div class="col-lg-12">
                        <span>Địa chỉ: </span> Số 10, Vũ Phạm Hàm, Quận Cầu Giấy, Thành Phố Hà Nội
                    </div>
                </div>
            </div>
        </div>
        <div class="doctor">
            <div class="lesson bold">II/ THÔNG TIN DỊCH VỤ</div>
            <div class="row">
                <div class="col-lg-7">
                    <span class="bold">EKIP thực hiện: </span>
                    <span>B.sĩ Nguyền Hồng Tiến , Y tá Trần Văn Minh</span>
                </div>
                <div class="col-lg-5">
                    <span>Bác sĩ tư vấn: </span>
                    B.sĩ Nguyền Hồng Tiến
                </div>
            </div>
        </div>
        <table class="table table table-bordered table-info hidden-xs">
            <thead class="bg-primary text-white">
            <tr>
                <th rowspan="2">Ngày tái khám</th>
                <th rowspan="2">Ngày thực hiện</th>
                <th rowspan="2">Dịch vụ</th>
                <th rowspan="2">Kết quả tái khám</th>
                <th colspan="2">Mức đáp ứng KH</th>
                <th rowspan="2">Chỉ định</th>
                <th rowspan="2">Người tái khám</th>
                <th rowspan="2">Khách hàng</th>
            </tr>
            <tr>
                <td>Hài lòng</td>
                <td>Không hài lòng</td>

            </tr>
            </thead>
            <tbody>
            <tr>
                <td>14/06/2024</td>
                <td>18/06/2024</td>
                <td>Tân trang cô bé</td>

            </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    // window.print();
</script>
</html>
