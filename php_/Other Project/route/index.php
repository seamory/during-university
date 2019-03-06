<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>route登陆页</title>
</head>

<body>
<form action="./usr/verifyuser.php"enctype="multipart/form-data" method="post">
<input type="text" name="username" />
<input type="password" name="password" />
<input type="text" name="verify" />
<img src="./usr/verifyimage.php">
<input type="submit" value="LOGIN" />
</form>
</body>
</html>