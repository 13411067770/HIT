<?php
	//1903010226检验登录凭证
	session_start();
	if ($_SESSION["uName"] == null){
		//1903010226无凭证
		echo<<<END
		<script>
			alert("请登录后再访问该功能");
			location = "$loginPath";
		</script>
END;
	}
?>