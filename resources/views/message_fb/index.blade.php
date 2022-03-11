<style>
    .chatApplication .card-bordered {
        border: 1px solid #ebebeb
    }

    .chatApplication .card {
        border: 0;
        border-radius: 0px;
        margin-bottom: 30px;
        -webkit-box-shadow: 0 2px 3px rgba(0, 0, 0, 0.03);
        box-shadow: 0 2px 3px rgba(0, 0, 0, 0.03);
        -webkit-transition: .5s;
        transition: .5s
    }

    .ps-container {
        position: relative
    }

    .ps-container {
        -ms-touch-action: auto;
        touch-action: auto;
        overflow: hidden !important;
        -ms-overflow-style: none
    }

    .media-chat {
        padding-right: 64px;
        margin-bottom: 0
    }

    .media {
        padding: 16px 12px;
        -webkit-transition: background-color .2s linear;
        transition: background-color .2s linear
    }

    .media .avatar {
        flex-shrink: 0
    }

    .chatApplication .avatar {
        position: relative;
        display: inline-block;
        width: 36px;
        height: 36px;
        line-height: 36px;
        text-align: center;
        border-radius: 100%;
        background-color: #f5f6f7;
        color: #8b95a5;
        text-transform: uppercase
    }

    .media-chat .media-body {
        -webkit-box-flex: initial;
        flex: initial;
        display: table
    }

    .media-body {
        min-width: 0
    }

    .media-chat .media-body p {
        position: relative;
        padding: 6px 8px;
        margin: 4px 0;
        background-color: #f5f6f7;
        border-radius: 3px;
        font-weight: 100;
        color: #000
    }

    .media > * {
        margin: 0 8px
    }

    .media-chat .media-body p.meta {
        background-color: transparent !important;
        padding: 0;
        opacity: .8
    }

    .media {
        padding: 16px 12px;
        -webkit-transition: background-color .2s linear;
        transition: background-color .2s linear
    }


    .media-chat.media-chat-reverse {
        padding-right: 12px;
        padding-left: 64px;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: reverse;
        flex-direction: row-reverse
    }

    .media-chat {
        padding-right: 64px;
        margin-bottom: 0
    }

    .media {
        padding: 16px 12px;
        -webkit-transition: background-color .2s linear;
        transition: background-color .2s linear
    }

    .media-chat.media-chat-reverse .media-body p {
        float: right;
        clear: right;
        background-color: #48b0f7;
        color: #fff
    }

    .media-chat .media-body p {
        position: relative;
        padding: 6px 8px;
        margin: 4px 0;
        background-color: #f5f6f7;
        border-radius: 3px
    }
    .publisher > *:first-child {
        margin-left: 0
    }

    .chatApplication .publisher > * {
        margin: 0 8px
    }

    button,
    input,
    optgroup,
    select,
    textarea {
        font-family: Roboto, sans-serif;
        font-weight: 300
    }
    .chatApplication .file-group input[type="file"] {
        position: absolute;
        opacity: 0;
        z-index: -1;
        width: 20px
    }

</style>

<div class="page-content page-container chatApplication" id="page-content">
    <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="card card-bordered chatContent">
                    {{--<div class="ps-container ps-theme-default ps-active-y"--}}
                    {{--style="overflow-y: scroll !important; height:400px !important;">--}}

                    {{--<div class="media media-chat">--}}
                    {{--<img class="avatar" src="https://img.icons8.com/color/36/000000/administrator-male.png"--}}
                    {{--alt="...">--}}
                    {{--<div class="media-body">--}}
                    {{--<p>What are you doing tomorrow?<br> Can we come up a bar?</p>--}}
                    {{--<p class="meta">--}}
                    {{--<time datetime="2018">23:58</time>--}}
                    {{--</p>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="media media-chat media-chat-reverse">--}}
                    {{--<div class="media-body">--}}
                    {{--<p>Long time no see! Tomorrow office. will be free on sunday.11</p>--}}
                    {{--<p class="meta">--}}
                    {{--<time datetime="2018">00:06</time>--}}
                    {{--</p>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    {{--</div>--}}
                </div>
            </div>
        </div>
</div>
