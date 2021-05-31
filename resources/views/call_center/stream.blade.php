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
<video controls="" autoplay  name="media">
    <source
        src="{{@$doc->recording_url}}"
        type="audio/x-wav">
</video>
</body>
</html>
