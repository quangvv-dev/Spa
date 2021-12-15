<div class="table-responsive tableFixHead table-bordered table-hover">
    <table class="table table-custom">
        <thead>
        <tr>
            <th class="text-center" style="width: 5%;"></th>
            <th class="text-center" style="width: 20%;">Fanpage</th>
            <th class="text-center" style="width: 15%;">Trạng thái quyền hạn</th>
            <th class="text-center required nowrap" style="width: 5%;">Sử dụng</th>
            <th class="text-center required" style="width: 15%;">Source</th>
            <th class="text-center" style="width: 10%;">Thông tin cập nhật cuối</th>
            {{--<th class="text-center" style="width: 5%;">Đồng bộ</th>--}}
            <th class="text-center" style="width: 10%">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        @foreach($fanpages as $item)
            <tr>
                <td class="text-center"><img src="{{@$item->avatar}}" alt=""></td>
                <td class="text-center">
                    <a href="https://facebook.com/{{$item->page_id}}">{{$item->name}}<br>
                        <span>{{$item->page_id}}</span>
                    </a>
                </td>
                <td class="text-center">{{$item->role_text}}</td>
                <td class="text-center">
                    <input type="checkbox" {{$item->used?'checked':''}} class="used">
                </td>
                <td class="text-center">
                    {!! Form::select('source', $source, @$item->source_id, array('class' => 'form-control select2 square source','placeholder'=>'--Source--')) !!}
                    <p class="small-tip">Source đã cấu hình bởi: {{@$item->user->name}}</p>
                </td>
                <td class="text-center">
                    <p>{{$item->updated_at}}</p>
                </td>
                <td class="text-center">Dữ liệu đồng bộ tự động</td>
                <td class="text-center">
                    <a class="action-control save" href="javascript:void(0)"
                       data-id="{{$item->id}}"
                       data-token="{{$item->access_token}}"
                       data-fanpageId="{{$item->page_id}}"
                       title="Lưu"><i class="fa fa-save fa-2x"></i></a>
                    <a class="action-control"
                       href="{{route('marketing.fanpage-post.index')}}"
                       data-id="1" title="Danh sách bài post"><i
                                class="fa fa-list fa-2x"></i></a>
                    <a class="action-control retweet"
                       data-show="{{$item->used?'true':'false'}}"
                       data-fanpageId="{{$item->page_id}}"
                       data-token="{{$item->access_token}}"
                       href="javascript:void(0)"
                       title="Đồng bộ bài post theo cấu hình"
                    >
                        <i class="fa fa-retweet fa-2x" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        <tr>
            <td class="text-center"><img src="/images/fpage/csn-1635840926.png" alt=""></td>
            <td class="text-center">
                <a href="https://facebook.com/130596252538262">Lavenda - Hàng Chính Hãng Việt Nam<br>
                    <span>130596252538262</span>
                </a>
            </td>
            <td class="text-center">Quản trị viên</td>
            <td class="text-center">
                <input type="checkbox" checked="" class="used">
            </td>
            <td class="text-center">
                <select class="form-control select2 square source select2-hidden-accessible" name="source"
                        data-select2-id="select2-data-1-tmu9" tabindex="-1" aria-hidden="true">
                    <option value="">--Source--</option>
                    <option value="1">Khách hàng cũ từ PUSHSALE</option>
                    <option value="2">ĐỘI IT TEST</option>
                    <option value="7">Conaldo Nhung| Cosima Langdingpage #1</option>
                    <option value="8">Ovancy Chinh hang</option>
                    <option value="10">Conaldo Thiện | Bí quyết</option>
                    <option value="11">Conaldo Thiện | Khỏe Đẹp Plus+</option>
                    <option value="12">Kết nối landing test</option>
                    <option value="13">Khách hàng Xương Khớp Pushsale</option>
                    <option value="14">Lavenda | Thuần Google</option>
                    <option value="15">Sarahee | Thuần Google</option>
                    <option value="16">Lavenda | Hải Google</option>
                    <option value="17">Ovancy - H.Tuấn GG</option>
                    <option value="18">Cosima | Thuần Google</option>
                    <option value="19">sarahee | Huyền GG</option>
                    <option value="20">NGUYỄN VUI</option>
                    <option value="21">Lavenda | Google Shopping</option>
                    <option value="22">Cosima | Huyền Google</option>
                    <option value="23">Lavenda - Huy Tuấn</option>
                    <option value="24">Cosima / Huy Tuấn Google</option>
                    <option value="26">Cosima | Google Shopping</option>
                    <option value="28">Sarahee | Huy Tuấn Google</option>
                    <option value="29">Lavenda | Huyền Google</option>
                    <option value="30">Sarahee Google</option>
                    <option value="31">Sarahee | Google Shopping</option>
                    <option value="32">Cosima Google 02 | Cosimachinhhang.online</option>
                    <option value="33">Cosima Google 03 | Trimunlung-nanglong</option>
                    <option value="34">Cosima Google 01</option>
                    <option value="35">Google Lavenda</option>
                    <option value="36">Google Lavenda #2</option>
                    <option value="37">Lavenda | Nam Cận Google</option>
                    <option value="38">Nam | LAVENDA 2</option>
                    <option value="39">XKNV | MINH GG</option>
                    <option value="40">DD Đinh Hoàng | Huyền Google</option>
                    <option value="41">LAVENDA | MINH GG</option>
                    <option value="42">SARAHEE | MINH GG</option>
                    <option value="44">Kiên lavenda | Google Team</option>
                    <option value="45">Loa Loa Loa VTV1 - Giảm Cân Tại Nhà</option>
                    <option value="46">Kiên Cosima | Google Team</option>
                    <option value="47">Sarahee | Quân Google</option>
                    <option value="48">Sarahee | Tuấn Google</option>
                    <option value="49">Lavenda | Minh Quân Google</option>
                    <option value="51">Kiên ovancy | Google Team</option>
                    <option value="52">Lavenda 2 | X.Tuấn Google</option>
                    <option value="53">Lavenda | XTuấn Google</option>
                    <option value="54">Conaldo Trương Nguyễn Duy | Chính Hãng Chuyên Nấm Ngứa</option>
                    <option value="55">Conaldo Trương Nguyễn Duy | Giải Quyết Nỗi Lo</option>
                    <option value="56">Conaldo Phúc | Sản phẩm Phụ nữ Việt</option>
                    <option value="57">Conaldo Phúc | chính hãng</option>
                    <option value="58">Conaldo Phúc | Sống khoẻ 24h.</option>
                    <option value="59">Conaldo Nhung| Lavenda #1</option>
                    <option value="67">Mkt14 | Conaldo Thương| Lavenda vietnam</option>
                    <option value="69">Mkt14 | Conaldo Thương| Lavenda chuyên khí hư</option>
                    <option value="70">Conaldo Quỳnh | Thảo dược PK</option>
                    <option value="71">Conaldo Quỳnh | Giải Pháp</option>
                    <option value="72">Conaldo Quỳnh | PK Chính Hãng</option>
                    <option value="73">Nhà Thuốc Huệ Vinh - TP. Nguyễn Đức Toàn</option>
                    <option value="74">Phượng conaldo - Chính Hãng Việt Nam</option>
                    <option value="75">Phượng conaldo - Giải Pháp</option>
                    <option value="76">Phượng conaldo - Nhà Phân Phối</option>
                    <option value="77">Conaldo Đặng Đình Hà - Lavenda VN</option>
                    <option value="78">Conaldo Đặng Đình Hà -Lavenda CH GQ</option>
                    <option value="79">Conaldo Yến | Bí Kíp</option>
                    <option value="80">Conaldo Yến | Điều trị</option>
                    <option value="81">Conaldo Yến | UP</option>
                    <option value="82">Conaldo Yến | chính hãng</option>
                    <option value="83">Vinaone - P.Hoang Lavenda | Vì SK CEPNV</option>
                    <option value="84">Vinaone Hiếu - Nhà thuốc Thu Hiền</option>
                    <option value="85">Vinaone|Đức Anh|Nhà Thuốc Thu Hiền|Thường</option>
                    <option value="86">Vinaone - Hoàng Văn Hậu</option>
                    <option value="87">Vinaone - Hoàng Văn Hậu | tặng quà</option>
                    <option value="88">Conaldo Trương Nguyễn Duy | up pushsale</option>
                    <option value="89">Vinaone - Hoàng Văn Hậu | Chữa phụ khoa tại nhà</option>
                    <option value="90">Vinaone Hiếu | Hỗ trợ viêm phụ khoa</option>
                    <option value="91">Conaldo Trí | Sức Khỏe</option>
                    <option value="92">Conaldo Trí | Chính hãng</option>
                    <option value="93">Vinaone Duong Tuyên | Nhà Thuốc Thu Hiền</option>
                    <option value="94">Vinaone Tuyên | Lavenda Chính Hãng</option>
                    <option value="95">Vinaone Biên - Nhà thuốc Thu Hiền</option>
                    <option value="96">Vinaone Biên Huệ Vinh</option>
                    <option value="97">Vinaone - Dương Thị Tuyến</option>
                    <option value="98">Vinaone - Dương Thị Tuyến Lading</option>
                    <option value="99">Giới Thiệu Lavenda</option>
                    <option value="100">Conaldo Phúc | Chính Hãng VN</option>
                    <option value="101">Vinaone - P.Hoàng | Lavenda - Sức Khỏe Gia Đình</option>
                    <option value="102">Conaldo Đặng Đình Hà - Lavenda - CGPK</option>
                    <option value="103">Conaldo ĐẶNG ĐÌNH HÀ -Lavenda VN VSKPD</option>
                    <option value="104">Conaldo Thành| Việt Nam |</option>
                    <option value="105">Conaldo Thành| Hạnh Phúc |</option>
                    <option value="106">Conaldo Thành| thầm kín |</option>
                    <option value="107">Giới thiệu xương khớp nguyễn thuấn</option>
                    <option value="108">Giới thiệu xương khớp nguyễn vui</option>
                    <option value="109">Conaldo Trí | Lavenda chính hãng</option>
                    <option value="110">Conaldo Trí | Lavenda Chính Hãng</option>
                    <option value="111">Lavenda or Ovancy | Thuần Google</option>
                    <option value="112">Conaldo - Huỳnh Chiến Tùng</option>
                    <option value="113">Vinaone Biên - Lavenda VN</option>
                    <option value="114">Lavenda Vì HP GĐ - Vinaone Đức Toàn</option>
                    <option value="115">Conaldo Hải | Đồng Hành</option>
                    <option value="116">Conaldo Hải | Chuyên Gia</option>
                    <option value="117">Conaldo ĐẶNG ĐÌNH HÀ - Lavenda GQMVĐ</option>
                    <option value="119">Hotline Lavenda</option>
                    <option value="120">Conaldo Đặng Quang Linh- Hạnh Phúc của bạn</option>
                    <option value="121">Vinaone|Đức Anh|Nhà Thuốc Thu Hiền 2|Thường</option>
                    <option value="122">GG to FB (Lavenda)</option>
                    <option value="123">Vinaone Biên - lvd chính hãng</option>
                    <option value="124">Vinaone - Nguyễn Đức Toàn - LVD PP Chính hãng</option>
                    <option value="125">VinaOne - Nguyễn Đức Toàn - Giải Pháp</option>
                    <option value="126">Conaldo Linh - Không Còn Nỗi Lo Phụ Khoa V Lộ Tuyến</option>
                    <option value="127">Conaldo Quỳnh | Tinh hoa Thảo dược</option>
                    <option value="128">Conaldo Nhung| Cosima Chính Hãng</option>
                    <option value="129">Conaldo Thành| phụ khoa |</option>
                    <option value="130">Conaldo Thiện - Tâm sự</option>
                    <option value="131">Conaldo - ĐẶNG ĐÌNH HÀ - COSIMA</option>
                    <option value="132">mkt14- thương Chuyên gia</option>
                    <option value="133">Conaldo - Đặng Như Thuần</option>
                    <option value="134">Conaldo Giang - NPP Cosima Chính Hãng</option>
                    <option value="135">Conaldo Nhung| Chăm sóc PK nơi nàng</option>
                    <option value="136">Conaldo - Phước| CSPK Lavenda</option>
                    <option value="137">Hải Conaldo | Chính Hãng_PP Độc Quyền</option>
                    <option value="138">Conaldo Ngọc Vũ | Cosima Trị Viêm Nang lông Chính Hãng</option>
                    <option value="139">Conaldo Trần Hoài Nam | Cosima - Chính Hãng Việt Nam</option>
                    <option value="140">Shoppe Lavenda</option>
                    <option value="141">Lavenda X.Tuấn - Giải Quyết Mọi Vấn Đề Phụ Khoa</option>
                    <option value="142">Nguyễn Hữu Tiến</option>
                    <option value="143">Lavenda - Minh Quân - Lavenda viêm lộ tuyến chính hãng</option>
                    <option value="144">Conaldo thành| Giai phap|</option>
                    <option value="145">Conaldo Yến | 24h Khỏe Đẹp</option>
                    <option value="146">Conaldo - Nguyễn Hữu Tiến</option>
                    <option value="147">Vinaone Dương Tuyên | Nhà Thuốc</option>
                    <option value="148">Conaldo Hải | Chính Hãng</option>
                    <option value="149">Vinaone Hiếu - Nhà thuốc</option>
                    <option value="150">Conaldo Phước- Lavenda- Mang lại tự tin cho phái nữ</option>
                    <option value="151">Conaldo Phước-Lavenda- Sức khỏe gia đình Việt</option>
                    <option value="152">Conaldo - Nguyễn Hữu Tiến</option>
                    <option value="153">Conaldo - Nguyễn Hữu Tiến</option>
                    <option value="154">Conaldo Thuần - COSIMA Da Liễu</option>
                    <option value="155">Lavenda - Minh Quân - Lavenda Chính hãng - Vì sức khỏe Phụ Nữ Việt</option>
                    <option value="156">Nguyễn Hữu Tiến</option>
                    <option value="157">GG to FB (Cosima)</option>
                    <option value="158">Tinh hoa-Trí</option>
                    <option value="159">Nguyễn Hữu Tiến</option>
                    <option value="160">Vinaone Biên - Thảo Dược Lavenda</option>
                    <option value="161">Conaldo - Đánh bay vùng dưới</option>
                    <option value="162">Conaldo Thành - Đắc trị Lavenda</option>
                    <option value="163">X.Tuấn - Lavenda Chính Hãng</option>
                    <option value="164">X.Tuấn - Lavenda Giải Pháp Vàng</option>
                    <option value="165">Conaldo- Hoài| Lavenda Việt Nam- chuyên gia Phụ Khoa</option>
                    <option value="166">Conaldo Hoài| Hội chị em bị PKH0A mong muốn khỏi dứt điểm</option>
                    <option value="167"></option>
                    <option value="168">Conaldo- Phạm Thị Hoài|Lavenda CHÍNH HÃNG- Chuyên gia viêm nhiễm, nấm ngứa, phụ
                        khoa
                    </option>
                    <option value="169">Conaldo Nhung - UPSALE TỪ PUSHSALE</option>
                    <option value="170">Phượng Conaldo _ up chuyển từ pushale</option>
                    <option value="171">Vinaone|Đức Anh|Hỗ Trợ Dứt Pk|Thường</option>
                    <option value="172">Vinaone Mạnh|Chăm sóc phụ khoa|Thường</option>
                    <option value="173">Conaldo Hải | Chinh Hãnq 1</option>
                    <option value="174">Conaldo|Thành| LADI đắc trị</option>
                    <option value="175">Conaldo- Hoài UP</option>
                    <option value="176">Conaldo- Hoài UP2</option>
                    <option value="177">Conaldo- Hoài UP3</option>
                    <option value="178">Conaldo Trí | UPSALE</option>
                    <option value="179">up sang CRM</option>
                    <option value="180">UP HOÀI</option>
                    <option value="181">Vinaone Mạnh|Sức Khỏe,sắc đẹp, phái nữ|thường</option>
                    <option value="182">Conaldo- Hoài upsale5</option>
                    <option value="183">Conaldo-Hoài upsale 6</option>
                    <option value="184">Conaldo- Hoài UP 7</option>
                    <option value="185">Conaldo Nguyễn Văn Tiến</option>
                    <option value="186">Vinaone team</option>
                    <option value="187">CONALDO- THUẦN - COSIMA VIỆT NAM</option>
                    <option value="188">Vinaone - Hoàng Văn Hậu - pk</option>
                    <option value="189">Lavenda.com.vn</option>
                    <option value="190">Vinaone|Đức Anh|Chuyên Up|Thường</option>
                    <option value="191">Conaldo- Hoài upp</option>
                    <option value="192">Nguyễn Hữu Tiến giải pháp</option>
                    <option value="193">Hotline - 614</option>
                    <option value="194">mkt14- thương</option>
                    <option value="195">Vinaone - Dương Thị Tuyến| up</option>
                    <option value="196">Conaldo- Hoài UP 8</option>
                    <option value="197">Conaldo- hoài UP 9</option>
                    <option value="198">hoài up</option>
                    <option value="199">Shopee Lavenda</option>
                    <option value="200">Vinaone - Hoàng Văn Hậu | Lavenda</option>
                    <option value="201">Conaldo Linh - Dứt điểm tình trạng khí hư</option>
                    <option value="202">Conaldo|Thành| chinh hang</option>
                    <option value="203">Conaldo Linh - Lavenda Chính Hãng Việt Nam</option>
                    <option value="204">Conaldo- Hoài| Chăm sóc Phụ Khoa- Lavenda Chính Hãng</option>
                    <option value="205">Vinaone Mạnh|OVANCY Sức Khoẻ Chị Em|Thường</option>
                    <option value="206">Tiki Lavenda</option>
                    <option value="207">Shopee Ovancy</option>
                    <option value="208">Shopee Cosima</option>
                    <option value="209">Ovancy - PP chính hãng - Vinaone TP. Đức Toàn</option>
                    <option value="210">Conaldo - Nguyễn Văn Tiến - Giải Pháp Vàng Cho Viêm Nhiễm Phụ Khoa</option>
                    <option value="211">Conaldo Hải | VN Chính Hãng</option>
                    <option value="212">nguồn test</option>
                    <option value="213">Conaldo Nhung| Cosima #1</option>
                    <option value="214">Conaldo - Nguyễn Tiến - Viêm Phụ Khoa Chính Hãng</option>
                    <option value="215">Conaldo - Nguyễn Tiến - Nhà phân phối</option>
                    <option value="216">Conaldo - Nguyễn Tiến - Vì sức khoẻ Phụ nữ</option>
                    <option value="217">Conaldo Thiện | Phụ Khoa Lavenda</option>
                    <option value="218">Conaldo|Thành| Lavenda</option>
                    <option value="219">Conaldo Tùng | Cosima | Giải quyết</option>
                    <option value="220">Conaldo Tùng | Cosima | khắc phục viêm nang lông</option>
                    <option value="221">Nam | OVANCY</option>
                    <option value="222">Conaldo Nguyễn Văn Tiến - Giải pháp Viêm nhiễm PK</option>
                    <option value="223">Conaldo|Thành| thamkin2</option>
                    <option value="224">Giới thiệu Dạ Dày</option>
                    <option value="225">CONALDO- THUẦN - COSIMA KOREA</option>
                    <option value="226">OVANCY | MINH GG</option>
                    <option value="227">Vinaone|Đức Anh|Nhà Thuốc Thu Hiền 3|Thường</option>
                    <option value="228">Conaldo - Cosima - Huỳnh Chiến Tùng</option>
                    <option value="229">Conaldo Phúc | Vnam</option>
                    <option value="230">Phượng Conaldo _ Hội Chị Em</option>
                    <option value="231">vu nguyen</option>
                    <option value="232" selected="selected" data-select2-id="select2-data-3-pywh">Conaldo Linh- Hàng
                        Chính Hãng
                    </option>
                </select>

                <p class="small-tip">Source đã cấu hình bởi: Conaldo - Đặng Quang Linh</p>
            </td>
            <td class="text-center">
                <p>2021-11-02 15:15:26</p>
            </td>
            {{--<td class="text-center">Dữ liệu đồng bộ tự động</td>--}}
            <td class="text-center">
                <a class="action-control save mr-1" href="javascript:void(0)" data-id="268"
                   data-token="EAAKordZAaiB4BAOiWXPJqZCagcZCooxqQeCpxtVenl81b7hAFzf7YtyZCjtSBjagDNBemVSozsZBYGZBgysSNpoH1U8B07IZBOTlIV7KpDOVcHraMtadrcDQHamuQBg3M7ZA0GRNy6EMuxRWJ3MZBI18cCWcwPGIkAR9zEBik1XUJHpGZCjbjGnGZCt"
                   data-fanpageid="130596252538262" title="Lưu"><i class="fa fa-save"></i></a>
                <a class="action-control mr-1" href="http://test.local/marketing/fanpage-post" data-id="1"
                   title="Danh sách bài post"><i class="fa fa-list"></i></a>
                <a class="action-control retweet" data-show="true" data-fanpageid="130596252538262"
                   data-token="EAAKordZAaiB4BAOiWXPJqZCagcZCooxqQeCpxtVenl81b7hAFzf7YtyZCjtSBjagDNBemVSozsZBYGZBgysSNpoH1U8B07IZBOTlIV7KpDOVcHraMtadrcDQHamuQBg3M7ZA0GRNy6EMuxRWJ3MZBI18cCWcwPGIkAR9zEBik1XUJHpGZCjbjGnGZCt"
                   href="javascript:void(0)" title="Đồng bộ bài post theo cấu hình">
                    <i class="fa fa-retweet" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="float-right">
        {{--{{$fanpages->links()}}--}}
    </div>
</div>
