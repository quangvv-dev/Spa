<style>
    * {
        box-sizing: border-box;
    }

    .container .gallery a img {
        float: left;
        width: 25%;
        height: auto;
        border: 2px solid #fff;
        -webkit-transition: -webkit-transform .15s ease;
        -moz-transition: -moz-transform .15s ease;
        -o-transition: -o-transform .15s ease;
        -ms-transition: -ms-transform .15s ease;
        transition: transform .15s ease;
        position: relative;
    }

    .clear {
        clear: both;
    }

    a {
        text-decoration: none;
    }

    a:hover {
        color: #01695f;
        text-decoration: none;
    }
</style>

    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header" style="background-color: #131313">
                <h3 class="card-title linear-text">ALBUMS</h3></br>
            </div>

            <div id="registration-form">
                <div class="table-responsive tableFixHead" id="parent">
                    <div class="gallery">
                        @if(isset($albums) && count($albums))
                            @foreach($albums as $item)
                        <a href="{{'/images/album/'.$item->fileName}}"
                           class="big">
                            <img
                                src="{{'/images/album/thumb/'.$item->fileName}}"
                                alt="" title="{{$item->date}}"/></a>
                            @endforeach
                        @endif
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    (function () {
        var $gallery = new SimpleLightbox('.gallery a', {});
    })();
</script>
