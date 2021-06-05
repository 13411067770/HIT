<?php
//验证身份
$loginPath = "login.html";
include "./inc/data/session.php";
//清除session
session_destroy();

echo <<<END
	<script>
		alert("注销成功！");
		location = "$loginPath";
	</script>
END;
?>