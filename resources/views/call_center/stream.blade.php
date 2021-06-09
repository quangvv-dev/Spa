<html>
<head>
    <meta name="viewport" content="width=device-width">
</head>
<style>
    body{
        display: flex;
        align-items: center;
        justify-content: center;
        /* align-self: center; */
        overflow: hidden;
        height: 100vh;
    }
</style>
<body>
<audio id="audio" autoplay="autoplay" controls="controls"  name="media">
    <source
        src="{{@$doc->recording_url}}"
        type="audio/x-wav">
</audio>
<script type="text/javascript">
    function autoplay(){
        // var r =confirm("Would You Like To AutoPlay Music?");
        // if (r == true) {
        //     document.getElementById("audio").play();
        // }
    }
</script>
<script>autoplay();</script>
</body>
</html>
