<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>文件上传</title>
</head>
<body>
<form action="uploads" enctype="multipart/form-data" type="post">
    <input type="file" name="files">
    <input type="submit" value="提交">
</form>

</body>
</html>