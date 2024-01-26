{strip}
<!DOCTYPE html>
<header>
<title>Login</title> 
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<link REL="SHORTCUT ICON" HREF="../../layouts/vlayout/modules/crmtogo/resources/images/favicon.ico">	
<script type="text/javascript" src="../../layouts/vlayout/modules/crmtogo/resources/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="../../layouts/vlayout/modules/crmtogo/resources/jquery.mobile-1.4.5.min.js"></script>
<link rel="stylesheet" href="../../layouts/vlayout/modules/crmtogo/resources/css/jquery.mobile.structure-1.4.5.min.css" >
<link rel="stylesheet" href="../../layouts/vlayout/modules/crmtogo/resources/css/theme.css" >
<script type="text/javascript" src="../../layouts/vlayout/modules/crmtogo/resources/crmtogo.js"></script>
</header>
<body>
<div data-role="page" data-theme="b" data-mini="true" id="login_page">
	<div data-role="header"  data-theme="{$COLOR_HEADER_FOOTER}" >
		<h4>CRM</h4>
	</div>
	<div data-role="fieldcontain" class="ui-hide-label">
		<form method="post" data-transition="pop" data-ajax="false" action="index.php?_operation=loginAndFetchModules">
			<label for="username">{$LANGUAGE['LBL_NAME']}:</label>
			<input type="text" name="username" id="username" value="" placeholder="{$LANGUAGE['LBL_NAME']}"/>
			<label for="password">{$LANGUAGE['LBL_PASSWORD']}:</label>
			<input name="checkbox-mini-0" id="showpw" data-mini="true" data-theme=c type="checkbox">
			<label for="showpw">{$LANGUAGE['LBL_SHOW']}</label>
			<input type="password" name="password" id="password" value="" placeholder="{$LANGUAGE['LBL_PASSWORD']}"/>
			<div data-role="button" >
				<input  type="submit" value="Login" >
			</div>
		</form>
	</div>
	<div data-role="footer" data-theme="{$COLOR_HEADER_FOOTER}" data-position="fixed">
		<h1></h1>
	</div>	
</div>
</body>
{/strip}