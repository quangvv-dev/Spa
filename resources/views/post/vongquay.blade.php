<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vòng quay lì xì 2021 by Adamtech</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Francois+One&amp;display=swap'>
    <link href="{{asset('assets/plugins/bootstrap-sweetalert/sweet-alert.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/plugins/vong-quay/custom.css')}}" rel="stylesheet"/>
    <script type="text/javascript" src="{{asset('assets/plugins/vong-quay/Winwheel.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/plugins/vong-quay/TweenMax.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap-sweetalert/sweet-alert.min.js')}}"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            background: url("{{asset('assets/plugins/vong-quay/img/background.jpg')}}") no-repeat fixed center;
            background-position: center center;
            background-size: cover;
            font-size: 30px;
            color: white;
        }

        .nutbatdau {
            background-image: url('{{asset('assets/plugins/vong-quay/img/contro.png')}}');
            position: absolute;
            width: 180px;
            height: 180px;
            z-index: 99;
        }

        .nutcaidat {
            background-image: url('{{asset('assets/plugins/vong-quay/img/caidat.png')}}');
            cursor: pointer;
            width: 120px;
            height: 40px;
            z-index: 999;
            align-items: center;
        }

        .nutcaidat:hover {
            background-image: url('{{asset('assets/plugins/vong-quay/img/caidathover.png')}}');
        }
    </style>
</head>
<div class="pyro">
    <div class="before" style="z-index: 9999"></div>
    <div class="after"></div>
</div>
<body onload="loadNew()">
<div class="topheader">
    <img class="responsive" style="z-index:99;top:50px;" src="{{asset('assets/plugins/vong-quay/img/2022_1.png')}}"/>
    <!-- <img class="responsive" style="z-index:99;top:50px;" src="img/hea2.png"/> -->
</div>
<div id="caidat">
    <img id="popup" src="{{asset('assets/plugins/vong-quay/img/popup.jpg')}}"/>
    <div class="sotiendalixi" id="sotiendalixi"></div>
    <div class="lichsulixi" id="lichsulixi"></div>
    <div class="buttontatpopup" onClick="tatpopup()"></div>
    <div class="buttonlammoi" id="lammoi" onClick="lammoi()"></div>
    <div class="nenpopup"></div>
</div>
{{--<div id="popupnhantien">--}}
{{--<img id="popuptien" src="img/popupnhantien.png"/>--}}
{{--<div class="lammoipopupnhantien" id="lammoi" onClick="lammoi()"></div>--}}
{{--<div class="nenpopup"></div>--}}
{{--</div>--}}

<div class="vongquay">
    <canvas id="canvas" width="450" height="450" data-responsiveMinWidth="180" data-responsiveScaleHeight="true"
            data-responsiveMargin="50">
    </canvas>
    <div id="batdauquay" class="nutbatdau"></div>
    <div onClick="startSpin();" class="nutquay"></div>
</div>
<!-- </div> -->

<img class="responsive2" style="position:fixed;z-index:99;top:0px;right:0px"
     src="{{asset('assets/plugins/vong-quay/img/hea1.png')}}"/>
<div
    style="position:fixed;z-index:99;bottom:-50px;left:0;width:100%;height:500px;background:url({{asset('assets/plugins/vong-quay/img/bot1.png')}}) repeat-x bottom left;"></div>
<img class="responsive3" style="position:fixed;z-index:99" src="{{asset('assets/plugins/vong-quay/img/bot2.png')}}"/>
<input type="range" id="manhornhe" style="position:fixed;bottom:2px;right:20px;z-index: 999" onchange="laypower()"
       min="5" step="0.01" max="20" value="13">

<img style="position:fixed;z-index:99;top:2px;left:1px" src="{{asset('assets/plugins/vong-quay/img/banglixi.png')}}"/>
<div id="annhantien" style="display: none;">
    <img class="buttonnhantien" style="position:fixed;z-index:99;top:153px;left:1px;cursor: pointer"
         src="{{asset('assets/plugins/vong-quay/img/nhantien.png')}}" onclick="nhantien()"/>
    <img style="position:fixed;z-index:99;top:183px;left:24px;"
         src="{{asset('assets/plugins/vong-quay/img/muiten.gif')}}"/>
</div>

<div style="position:fixed;z-index:999;top:37px;left:40px;text-shadow: 2px 2px 5px #f7ff29;color: #f2f4be;"
     id="xuatluotquay"></div>

<img style="position:fixed;z-index:999;top:105px;left:9px" id="xuatsotien"></img>

<audio id="votay">
    <source src="sound/votay.mp3" type="audio/mpeg">
</audio>
<!-- <audio id="matluot"><source src="sound/matluot.mp3" type="audio/mpeg"></audio>-->
<!-- <audio id="dangquay"><source src="sound/dangquay.mp3" type="audio/mpeg"></audio>  -->

<div class="content-the-le">
    <h3 style="color:#f7ef11;text-align: center;padding-top: 10px;">THỂ LỆ CHƯƠNG TRÌNH</h3>
    <div class="content" style="background:white;color: black;margin: 20px;border-radius: 20px;font-size: 14px;">
        <div class="text-content" style="padding: 20px;">
            Thông tin chương trình
            Chương Trình "Vòng quay may mắn chào mừng ngày Noel - Ngập tràn quà tặng" 100% nhận được quà.


            DS Care xin gửi tới quý khách lời chúc sức khỏe và hạnh phúc trong mùa Giáng Sinh. Những món quà đặc biệt và
            hấp dẫn đang chờ đón chị em trong dịp này.

            Cơ cấu giải thưởng:

            1. Tặng 35% bộ combo Thanh Xuân đẹp theo thời gian trị giá 999k
            2. Tặng 20% viên uống đẹp da trị giá 599k
            3. Tặng 40% bột rửa nám Thanh Xuân trị giá 599k
            4. Tặng 40% kem thảo dược Thanh Xuân trị giá 599k
            5. Tặng 45% serum tinh chất dưỡng nhan trị giá 299k
            6. Tặng 45% bột tắm body Thanh Xuân
            7. Tặng 2 bộ combo mini Thanh Xuân trị giá 138k
            8. Tặng 45% cho tổng bill


            => Quý khách phải nhập đúng thông tin cá nhân.
            DS Care sẽ dựa trên thông tin của Quý khách để trao thưởng.
            + Trong trường hợp thông tin đăng ký không có thật, giải thưởng sẽ bị hủy.
            + Trong trường hợp có phát sinh mâu thuẫn về giải thưởng do lỗi kĩ thuật, quyết định của DS Care là quyết
            định cuối cùng.

            🍓DSCare - Thanh xuân đẹp theo thời gian🍓
            🏠 65 Yersin - P.Phương Sài - TP.Nha Trang
            🏠 5/1 Mạc Đĩnh Chi - P.Phước Tiến - TP.Nha Trang
            ☎️ 1900 966 995 - 0844 797 799
        </div>
    </div>
</div>

<!-- modal -->
<div class="modal" id="myModal" data-backdrop="static" data-keyboard="false" style="color: black;">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header"
                 style="background-image: url({{asset('assets/plugins/vong-quay/img/backlist.png')}});background-size: contain;">
                <div class="row" style="display: flex;justify-content:center;">
                    <p class="modal-title">Chúc mừng phần quà của bạn là:</h4>
                    <p style="font-size: 16px; color: red;" class="modal-title" id="gift">Kẹo bông gòn 45%</span>
                </div>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="padding-top: 0px;">
                <span style="font-size: 13px;">Vui lòng cung cấp thông tin để nhận quà :</span>
                <form method="GET" id="form-url" class="form-group" style="text-align: center;">
                    <input type="text" id="ten" class="form-control" id="ten" placeholder="Họ Tên" name="ten">
                    <input type="text" id="sdt" class="form-control mt-1" placeholder="Số điện thoại" name="sdt">
                    <input type="hidden" id="phan_qua" class="form-control" placeholder="SỐ ĐIỆN THOẠI" name="phan_qua">
                    <button type="button" class="btn btn-primary pushData">
                        Nhận quà
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- end modal -->

</body>
<script>
    var matkhau = "mycode";
    var solanquay = 2;

    function setcookie(name, value) {
        document.cookie = name + "=" + value + ";"; // + and " added
    }
    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function loadNew() {
        let spin = getCookie('spin');
        if (!spin) {
            setcookie('spin',2);
        }
        $('#xuatluotquay').html(spin);
    }

    function mopopup() {
        document.getElementById("caidat").style.display = "block";
    }

    function tatpopup() {
        document.getElementById("caidat").style.display = "none";
    }

    // $(".buttontatpopup").hover(
    //     function () {
    //         $("#popup").attr("src", 'img/popup2.jpg');
    //     }, function () {
    //         $("#popup").attr("src", 'img/popup.jpg');
    //     }
    // );
    // $(".buttonlammoi").hover(
    //     function () {
    //         $("#popup").attr("src", 'img/popup1.png');
    //     }, function () {
    //         $("#popup").attr("src", 'img/popup.jpg');
    //     }
    // );

    // $(".lammoipopupnhantien").hover(
    //     function () {
    //         $("#popuptien").attr("src", 'img/popupnhantienhover.png');
    //     }, function () {
    //         $("#popuptien").attr("src", 'img/popupnhantien.png');
    //     }
    // );
    let theWheel = new Winwheel({
        // 'outerRadius': 220, // Bán kính ngoài
        'innerRadius': 15, // Size lỗ trung tâm
        'textFontSize': 10, // Size chữ
        'textOrientation': 'horizontal', // Chữ nằm ngang
        'textAlignment': 'center', // Căn chỉnh văn bản ra bên ngoài bánh xe.
        'textMargin': 0,
        'numSegments': 6, // Số ô
        'responsive': true,
        'drawText': true,
        // 'imageDirection' : 'S',
        // 'drawMode' : 'segmentImage',
        'lineWidth': 3,
        'strokeStyle': '#f7ef11',

        'segments': [{
            'fillStyle': '#0f514d',
            'text': '1 buổi triệt lông miễn phí (350K)',
            // 'text': 'Ô mất lượt',
            // 'size': winwheelPercentToDegrees(15),
            'textFontSize': 12,
            'textFillStyle': '#ffffff',
            // 'image':'img/2022_1.png',

        }, {
            'fillStyle': '#ffffff',
            'text': 'Combo 1 buổi tắm trắng & \n massage mặt (299K)',
            // 'size': winwheelPercentToDegrees(12),
            'textFontSize': 12,
            'textFillStyle': '#0f514d',
            // 'image':'img/2022_1.png',

        }, {
            'fillStyle': '#0f514d',
            'text': 'Tặng voucher khuyến mại 20% DV trắng da',
            // 'size': winwheelPercentToDegrees(12),
            'textFontSize': 12,
            'textFillStyle': '#ffffff',
            // 'image':'img/2022_1.png',

        }, {
            'fillStyle': '#0f514d',
            'text': 'Tặng voucher khuyến mại \n 20% DV trắng da',
            // 'size': winwheelPercentToDegrees(12),
            'textFontSize': 12,
            'textFillStyle': '#ffffff',
            // 'image':'img/2022_1.png',

        }, {
            'fillStyle': '#0f514d',
            'text': 'Tặng voucher khuyến mại \n 20% DV trắng da',
            // 'size': winwheelPercentToDegrees(12),
            'textFontSize': 12,
            'textFillStyle': '#ffffff',
            // 'image':'img/2022_1.png',

        }, {
            'fillStyle': '#ffffff',
            'text': 'Món quà đặc biệt',
            // 'size': winwheelPercentToDegrees(13),
            'textFontSize': 12,
            'textFillStyle': '#0f514d',
            // 'image':'img/2022_1.png',
        }],
        'animation': // Chỉ định hình động để sử dụng.
            {
                'type': 'spinToStop',
                'duration': 20, // Thời lượng tính bằng giây.
                'spins': 10, // Số vòng quay hoàn chỉnh mặc định.
                'callbackFinished': alertPrize,
                'callbackSound': playSound, // Chức năng gọi khi âm thanh đánh dấu được kích hoạt.
                'soundTrigger': 'pin', // Chỉ định các chân là để kích hoạt âm thanh, tùy chọn khác là 'phân đoạn'.
                'duration': 6.4,
            },
        'pins': {
            'number': 8, // Số lượng chân. Họ không gian đều xung quanh bánh xe.
            'responsive': true,
            'fillStyle': 'white',
            'outerRadius': 4,
        }
    });

    // Vars được sử dụng bởi mã trong trang này để thực hiện các điều khiển nguồn.
    let wheelPower = 13;
    let wheelSpinning = false;
    // ---------------------------------------------------------------------
    // Tải âm thanh đánh dấu và chức năng phát được gọi khi pin đi qua con trỏ.
    let audio = new Audio('http://dougtesting.net//elements/sound/tick.mp3'); // Tạo đối tượng âm thanh và tải tập tin tick.mp3.

    var dem = 0;
    var demnhantien = 0; // Đếm số lần click vào nút nhận tiền
    var lichsulixi = "";
    var tongtienlixi = 0;
    var tiendalixi;
    document.getElementById("xuatluotquay").innerHTML = solanquay;
    // var votay = document.getElementById("votay");
    // var matluot = document.getElementById("matluot");
    // var dangquay = document.getElementById("dangquay");

    function playSound() {
        // Dừng và tua lại âm thanh nếu nó đã phát.
        audio.pause();
        audio.currentTime = 0;

        // Phát âm thanh.
        // audio.play();
    }

    // -------------------------------------------------------
    // Xử lý thanh range
    // -------------------------------------------------------
    function laypower() {
        wheelPower = document.getElementById("manhornhe").value; // Lấy dữ liệu thanh range
    }

    // -------------------------------------------------------
    // Sau khi nhấp vào nút quay
    // -------------------------------------------------------
    function startSpin() {
     {
         let spin = getCookie('spin');

            if (parseInt(spin) > 0) {
                spin = spin - 1;
                setcookie('spin', spin);
            }else {
                swal("Oops!","Hết lượt quay :(( ", "error");
                return false;
            }
        }
        // Nút quay không nhấp được khi đang chạy
        if (wheelSpinning == false) {
            // Dựa trên mức công suất được chọn, hãy điều chỉnh số vòng quay cho bánh xe, càng nhiều lần
            // để xoay với thời lượng của hình ảnh động thì bánh xe quay càng nhanh.
            theWheel.animation.spins = wheelPower;

            // Tắt nút xoay để không thể nhấp lại trong khi bánh xe đang quay.
            $(".nutbatdau").css("background-image", "url({{asset('assets/plugins/vong-quay/img/controtat.png')}})");

            // Bắt đầu quay bằng cách gọi startAnimation.
            theWheel.startAnimation();

            // Đặt thành true để không thể thay đổi nguồn và bật nút quay lại trong khi
            // hình ảnh động hiện tại. Người dùng sẽ phải thiết lập lại trước khi quay lại.
            wheelSpinning = true;
        }
        if (dem < solanquay) {
            // dangquay.play();
        }
    }

    // -------------------------------------------------------
    // Sau khi nhấp vào nút làm mới
    // -------------------------------------------------------
    function lammoi() {
        swal({
                title: "Làm mới vòng quay!",
                text: "Làm mới vòng quay sẽ xoá hết các vòng quay còn lại. \nLịch sử và tổng tiền lì xì vẫn giữ nguyên. \nChú ý nếu tải lại trang sẽ làm mất lịch sử và tổng tiền lì xì\nNhập mật khẩu để tiếp tục:",
                type: "input",
                showCancelButton: true, // Có hiển thị nút cancel không(true = có)
                closeOnConfirm: false, // Có thể tắt popup khi nhấp Ok không (true = có)
                showLoaderOnConfirm: true, // Hiển thị loading khi nhấp vào nút Ok
                animation: "slide-from-top", // Như tên của nó, popup sẽ slide from top
                inputPlaceholder: "Nhập mật khẩu..."
            },
            function (inputValue) {
                if (inputValue === false) return false;

                if (inputValue !== matkhau) {
                    setTimeout(function () {
                        swal.showInputError("Mật khẩu sai, vui lòng nhập lại!");
                    }, 2000);
                    return false
                }
                setTimeout(function () {
                    swal("Làm mới thành công!", "Hãy đưa chiếc điện thoại cho người muốn nhận lì xì nào!", "success");

                    document.getElementById("popupnhantien").style.display = "none"; // Tắt popup nhận tiền

                    theWheel.stopAnimation(false); // Dừng hình động
                    theWheel.rotationAngle = 0; // Đặt lại góc bánh xe về 0 độ.
                    theWheel.draw(); // Gọi draw để hiển thị các thay đổi cho bánh xe.

                    $(".nutbatdau").css("background-image", "url({{asset('assets/plugins/vong-quay/img/contro.png')}})"); // Hiển thị lại nút Quay

                    document.getElementById("xuatluotquay").innerHTML = solanquay;

                    wheelSpinning = false; // Đặt lại thành false thành các nút nguồn và quay có thể được bấm lại.
                    document.getElementById("annhantien").style.display = "none"; // Ẩn nút nhận tiền
                    document.getElementById("xuatsotien").src = ""; // Xoá ảnh tiền

                    dem = 0;
                }, 2000);
            });
    }

    // -------------------------------------------------------
    // Sau khi vòng quay quay xong
    // -------------------------------------------------------
    function alertPrize(indicatedSegment) {
        dem++;
        tiendalixi = indicatedSegment.text.replace(".000 VNĐ", "");

        if (dem < solanquay) { // Check xem đã hết lượt quay chưa
            theWheel.rotationAngle = 0; // Đặt lại góc bánh xe về 0 độ.
            theWheel.draw(); // Gọi draw để hiển thị các thay đổi cho bánh xe.
            wheelSpinning = false; // Đặt lại thành false thành các nút nguồn và quay có thể được bấm lại.

            $(".nutbatdau").css("background-image", "url({{asset('assets/plugins/vong-quay/img/contro.png')}})"); // Hiển thị lại nút Quay
            document.getElementById("xuatluotquay").innerHTML = solanquay - dem; // Xuất kết quả


            if (indicatedSegment.text == 'Ô mất lượt') { // Nếu quay vào 0k
                // matluot.play(); // Bật nhạc fail

                document.getElementById("annhantien").style.display = "none"; // Ẩn nút nhận tiền
                document.getElementById("xuatsotien").src = ""; // Xoá ảnh tiền

                swal("Rất tiếc!", "Bạn không nhận được đồng nào\nNhưng bạn còn lại " + (solanquay - dem) + " lần quay, cố gắng lên nào!", "error");
            } else { // Nếu không quay vào 0k
                // votay.play(); // Bật nhạc vỗ tay

                // document.getElementById("annhantien").style.display = ""; // Hiển thị nút nhận tiền
                // document.getElementById("xuatsotien").src = "img/" + indicatedSegment.text.replace(".000 VNĐ", "") + "k.jpg"; // Xuất ảnh tiền
                $('#gift').html(indicatedSegment.text).change();
                $('#phan_qua').val(indicatedSegment.text);

                $('#myModal').modal('show');
                // swal({
                //   title:"Tết ấm no",
                //   text:"Bạn nhận được " + indicatedSegment.text + "\nBạn còn lại " + (solanquay - dem) + " lần quay\nChú ý: Nếu quay tiếp bạn sẽ mất phần quà trước đó!",
                //   type:"success"
                // },function(){
                //   // $('#myModal').modal('hide');
                // });
            }
        } else { // Nếu hết lượt quay(dem = solanquay)
            document.getElementById("xuatluotquay").innerHTML = "0";
            $(".nutbatdau").css("background-image", "url({{asset('assets/plugins/vong-quay/img/controhetluot.png')}})");

            if (indicatedSegment.text == 'Ô mất lượt') {
                // matluot.play(); // Bật nhạc fail

                document.getElementById("annhantien").style.display = "none"; // Ẩn nút nhận tiền
                document.getElementById("xuatsotien").src = ""; // Xoá ảnh tiền

                swal("Rất tiếc!", "Bạn không nhận được đồng nào và số lượt quay đã hết!", "error");
            } else {
                // votay.play(); // Bật nhạc vỗ tay

                // document.getElementById("annhantien").style.display = ""; // Hiển thị nút nhận tiền
                // document.getElementById("xuatsotien").src = "img/" + indicatedSegment.text.replace(".000 VNĐ", "") + "k.jpg"; // Xuất ảnh tiền
                $('#myModal').modal('show');
                $('#gift').html(indicatedSegment.text).change();
                $('#phan_qua').val(indicatedSegment.text);

                // swal("Tết ấm no!", "Bạn nhận được " + indicatedSegment.text + "\nBạn đã hết lượt quay", "success");
            }
        }
    }

    $('.pushData').click(function (e) {
        var data = $('form#form-url').serialize();
        $('.pushData').prop('disabled', true);
        $('#myModal').modal('hide');
        swal("Nhận quà thành công!", "Chúc mừng " + $('#ten').val() + " nhận được " + $('#phan_qua').val(), "success");
        $.ajax({
            type: 'GET',
            url: 'https://script.google.com/macros/s/AKfycbw-QjVVqDRaMwA8TQYu3jnRXxKX-0tKnA5yXIZJqsVUkF1uQXM/exec',
            dataType: 'json',
            crossDomain: true,
            data: data,
            success: function (data) {
                //   if(data == 'false') {
                // $('.pushData').prop('disabled', false);
                //   alert('Thêm không thành công, bạn cũng có thể sử dụng để hiển thị Popup hoặc điều hướng');
                // swal("Oops!","Có lỗi gì đó sảy ra :(( ", "error");
                //     }else{
                // $('#myModal').modal('hide');
                // swal("Nhận quà thành công!","Chúc mừng "+$('#ten').val() +" nhận được " + $('#phan_qua').val(), "success");
                //     }
            }
        })
    });
    // -------------------------------------------------------
    // Sau khi nhấp vào nút nhận tiền
    // -------------------------------------------------------
    function nhantien() {
        document.getElementById("annhantien").style.display = "none"; // Ẩn nút nhận tiền
        document.getElementById("popupnhantien").style.display = "block"; // Mở popup
        document.getElementById("xuatsotienpopup").src = "img/" + tiendalixi + "kk.jpg";
        demnhantien++;
        tongtienlixi += Number(tiendalixi);
        document.getElementById("sotiendalixi").innerHTML = tongtienlixi + ".000 VNĐ";
        lichsulixi += "Người " + demnhantien + " : " + tiendalixi + ".000 VNĐ<br/>";
        document.getElementById("lichsulixi").innerHTML = lichsulixi;
    }

</script>
</html>
