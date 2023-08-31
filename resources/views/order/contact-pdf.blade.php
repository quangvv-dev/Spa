<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu bảo hành</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
        body{
            padding:0 20px;
            width: 100%;
            max-width: 100%;
            font-size: 17px;
        }
        /* .content{
            background-image: url('logo.jpg');
            background-repeat: no-repeat;
            background-position: center;
        } */
        div{
            line-height: 1.5;
        }
        input{
            width: 100%;
            border: none;
            border-bottom: 1px dotted;
            /* position: absolute; */
            top: -4px;
            margin-left: 5px;
            outline: none;
        }
        .header{
            display: flex;
        }
        .header .logo{
            width: 50px;
            height: 50px;
            padding-right: 15px;
        }
        .header .title{
            font-size: 18px;
            font-weight: 600;
        }
        .line{
            display: flex;
            width: 50%;
            justify-content: center;
            height: 2px;
            background-color: #000;
            margin: 20px auto;
        }
        .flex{
            display: flex;
        }
        .flex div{
            width: 100%;
        }
        ul{
            padding-left: 20px;
            margin: 0;
        }
        .bold{
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="left">
        <img src="{{!empty(setting('logo_website')) ? setting('logo_website'):'/assets/images/brand/logo.png'}}" alt="" class="logo">
    </div>
    <div class="right">
        <div class="title">VIỆN THẨM MỸ QUỐC TẾ ROYAL</div>
        <div class="">Hotline: <span>1900.299.268</span></div>
        <div class="">Website: <span>vienthammyroyal.vn</span></div>
    </div>
</div>
<div class="line"></div>
<div class="title" style="text-align: center;font-size: 38px;font-weight: 600;">
    HỒ SƠ KHÁCH HÀNG <br>
    PHIẾU CAM KẾT VÀ BẢO HÀNH
</div>
<div class="content">
    <div class="flex">
        <label for="" style="width: 120px;">Hồ sơ mã số: </label>
        <div><input type="text" value="{{$contact->code}}"></div>

    </div>
    <div class="flex">
        <div class="flex" style="width: 60%;">
            <label for="" style="width: 205px;">Họ tên khách hàng:</label>
            <div><input type="text" value="{{$contact->full_name}}"></div>
        </div>
        <div class="flex" style="width: 40%;margin-left: 20px;">
            <label for="" style="width: 155px;">Số điện thoại:</label>
            <div><input type="text" value="{{$contact->phone}}"></div>
        </div>
    </div>
    <div class="flex">
        <div class="flex" style="width: 60%;">
            <label for="" style="width: 85px;">Địa chỉ:</label>
            <div><input type="text" value="{{$contact->address}}"></div>
        </div>
        <div class="flex" style="width: 40%;margin-left: 20px;">
            <label for="" style="width: 120px;">Số CCCD:</label>
            <div><input type="text" value="{{$contact->cccd}}"></div>
        </div>
    </div>
    <div class="flex">
        <div class="flex" style="width: 60%;">
            <label for="" style="width: 180px;">Dịch vụ áp dụng:</label>
            <div><input type="text" value="{{$contact->service}}"></div>
        </div>
        <div class="flex" style="width: 40%;margin-left: 20px;position: relative;">
            <label for="" style="width: 250px;">Thời gian áp dụng:</label>
            <div><input type="text" value="{{$contact->warranty_number}}" style="width: 55%;"></div>
            <span style="position: absolute;right: 10%;">
                    Tháng
                </span>
        </div>

    </div>
    <div class="flex">
        <label for="" style="width: 203px;">Ngày bắt đầu điều trị:</label>
        <div><input type="text" value="{{date('d/m/Y',strtotime($contact->date))}}"></div>
    </div>
    <div class="flex">
        <label for="" style="width: 180px;">Tình trạng ban đầu:</label>
        <div><input type="text" value="{{$contact->before}}"></div>
    </div>
    <div class="flex">
        <label for="" style="width: 212px;">Tình trạng sau điều trị:</label>
        <div><input type="text" value="{{$contact->after}}"></div>
    </div>
    <div class="flex">
        <label for="" style="width: 145px;">Chi phí điều trị:</label>
        <div><input type="text" value="{{number_format($contact->price)}}"></div>
    </div>
    <div class="flex">
        <label for="" style="width: 100px;">- Hiệu quả:</label>
        <div><input type="text" value="{{$contact->result}}"></div>
    </div>
    <div>
        <label for="">- Thời gian tái khám: theo lời dặn của Điều trị viên</label>
    </div>
    <div class="flex">
        <label for="" style="width: 200px;">- Thời gian bảo hành:</label>
        <div><input type="text" value="{{$contact->warranty_time}}"></div>
    </div>
    <div style="font-size: 20px;font-weight: bold;margin-top: 15px;">YÊU CẦU</div>

    <div>
        Khách hàng thực hiện đúng, đủ liệu trình. Sử dụng sản phẩm theo đúng hướng dẫn của Điều trị viên trong <br> và sau quá trình điều trị
    </div>
    <ul>
        <li>Tái khám định kỳ</li>
        <li>Không tự ý thay đổi hoặc dùng bất kể sản phẩm hay liệu trình điều trị nào khác mà không có ý kiến của <br> Điều trị viên</li>
        <li class="bold">Trường hợp không cam kết</li>
    </ul>
    <div>
        <label for="">- Không thực hiện đúng quy trình, dặn dò của Điều trị viên</label>
    </div>
    <div>
        <label for="">- Mất hoặc tẩy xoá phiếu</label>
    </div>
    <div>
        * Ghi chú: Đang trong quá trình điều trị nếu khách hàng không đi đúng liệu trình hoặc tự ý bỏ dở thì Viện <br> thẩm mỹ Royal sẽ không chịu trách nhiệm
    </div>
    <div>
        Nếu khách hàng muốn điều trị tiếp thì phải bắt đầu liệu trình mới hoàn toàn với chi phí phù hợp với tình <br> trạng bệnh lý của khách hàng
    </div>

</div>
<div class="footer flex" style="text-align: center;">
    <div class="left" style="width: 40%;">
        KHÁCH HÀNG <br>
        <span class="small-tip">(Ký và ghi rõ họ tên)</span>
    </div>
    <div class="right" style="width: 60%;">
        ĐẠI DIỆN VIỆN THẨM MỸ QUỐC TẾ ROYAL <br>
        <span class="small-tip">(Ký và ghi rõ họ tên)</span>
    </div>
</div>
<div class="" style="position: absolute;bottom: 0;text-align: center;left: 10%;">
    <i>CẢM ƠN QUÝ KHÁCH ĐÃ TIN TƯỞNG LỰA CHỌN VIỆN THẨM MỸ QUỐC TẾ ROYAL</i>
</div>
</body>
<script>
    window.print();
</script>
</html>
