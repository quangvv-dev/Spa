@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col"><a class="right btn btn-primary btn-flat" href="{{route('category-product.create') }}"><i
                            class="fa fa-plus-circle"></i>Thêm mới</a></div>
            </div>
            <div class="card-header">
                <input class="form-control name col-md-2" name="search" placeholder="Tìm kiếm" tabindex="1"
                       type="search" value="{{@$input['name']}}">
                <div class="col-md-2" style="font-size: 16px;">
                    {!! Form::select('type', $category_pluck, @$input['type_category'], array('class' => 'form-control type','placeholder'=>'Danh mục cha')) !!}
                </div>
                <button class="connect-button">Kết nối ví</button>
            </div>
            <div id="registration-form">
                <div class="card-heade">
                    <label for="">BNB donate: </label>
                    <input type="text" id="donate" class="form-control">
                    <button class="pay-button">Pay</button>
                    <div id="status"></div>
                </div>
                {{--@include('category-product.ajax')--}}
            </div>
            <!-- table-responsive -->
        </div>
    </div>

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}

@endsection
@section('_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/web3/3.0.0-rc.5/web3.min.js"
            integrity="sha512-jRzb6jM5wynT5UHyMW2+SD+yLsYPEU5uftImpzOcVTdu1J7VsynVmiuFTsitsoL5PJVQi+OtWbrpWq/I+kkF4Q=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script type="text/javascript">

        window.addEventListener('load', async () => {
        if (window.web3) {
                        window.web3 = new Web3(web3.currentProvider)
                        let account = web3.currentProvider.selectedAddress;
                        account = 'Địa chỉ ví : ' + account;

                        $('#status').html(account);
                    } else {
                        $('#status').html('No Metamask (or other Web3 Provider) installed')
                    }
        })
        $('.connect-button').click(async function () {
            if (window.ethereum) {
                window.web3 = new Web3(ethereum);
                try {
                    await ethereum.enable();
                    let account = web3.currentProvider.selectedAddress;
                    account = 'Địa chỉ ví : ' + account;

                    $('#status').html(account);
                    // initPayButton()
                } catch (err) {
                    $('#status').html('User denied account access', err)
                }
            } else if (window.web3) {
                window.web3 = new Web3(web3.currentProvider)
                let account = web3.currentProvider.selectedAddress;
                account = 'Địa chỉ ví : ' + account;

                $('#status').html(account);
            } else {
                $('#status').html('No Metamask (or other Web3 Provider) installed')
            }
        })

        // const initPayButton = () => {
        $('.pay-button').click(() => {
            // paymentAddress is where funds will be send to
            const paymentAddress = '0x4E5cf8C3B35c977D5BDf4C7447e740907B30B139';
            let sendAddress = web3.currentProvider.selectedAddress;
            const amountEth = $('#donate').val();
            console.log(amountEth,'amountEth');
            web3.utils.randomHex(4);

            web3.eth.sendTransaction({
                from: sendAddress,
                to: paymentAddress,
                value: web3.utils.toWei(amountEth, 'ether')
            }, (err, transactionId) => {
                if (err) {
                    console.log('Payment failed', err)
                    $('#status').html('Payment failed')
                } else {
                    console.log('Payment successful', transactionId)
                    $('#status').html('Payment successful')
                }
            })
        })
        // }
    </script>
@endsection
