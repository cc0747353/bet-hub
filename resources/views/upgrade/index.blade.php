<html>
<body>

<form method="POST" action="{{route('upgrade')}}" enctype="multipart/form-data" >
@csrf
<input type="file" name="zip">
<input type="submit">
</form>
</body>
</html>
