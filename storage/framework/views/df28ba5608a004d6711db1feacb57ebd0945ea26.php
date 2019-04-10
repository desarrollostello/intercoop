<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- If you delete this meta tag, Half Life 3 will never be released. -->
<meta name="viewport" content="width=device-width" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Pheaks</title>
	
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/email.css')); ?>" />

</head>
 
<body bgcolor="#FFFFFF" style="width: 100%;border:thin solid #eee;">

<!-- HEADER -->
<table class="head-wrap" bgcolor="#29b6f6" style="border-bottom: thin solid #eee;">
	<tr>
		<td></td>
		<td class="header container"  style="width: 100%;">
				
				<div class="content">
				<table bgcolor="#29b6f6">
					<tr>
						<td>
                            <a href="<?php echo e(url('/')); ?>">
                                <img src="<?php echo e(url('img/logo-2.png')); ?>" alt="" width="35" style="display: inline-block;vertical-align: middle;"/> <h2 class="collapse" style="color: white;display: inline-block;vertical-align: middle;"><?php echo e(env('APP_NAME')); ?></h2>
                            </a>
                        </td>
					</tr>
				</table>
				</div>
				
		</td>
		<td></td>
	</tr>
</table><!-- /HEADER -->


<!-- BODY -->
<table class="body-wrap" width="100%">
	<tr>
		<td></td>
		<td class="container" bgcolor="#FFFFFF">

			<div class="content">
			<table width="100%">
				<tr>
					<td>
						<h3>Hi, <?php echo e($name); ?></h3>
						<p class="lead">Please activate your accound.</p>
						<p>
                            <a href="<?php echo e(url('/auth/activate?hash='.$hash.'&key='.$key_id)); ?>" style="padding: 2.5px 5px;">Activate!</a>
                        </p>
						<!-- Callout Panel -->

                        <?php /*<!-- social & contact -->
                        <table class="social" width="100%" style="border-top: thin solid #eee;">
                            <tr>
                                <td>

                                    <!-- column 1 -->
                                    <table align="left" class="column">
                                        <tr>
                                            <td>

                                                <h5 class="">Connect with Us:</h5>
                                                <p class=""><a href="#" class="soc-btn fb">Facebook</a> <a href="#" class="soc-btn tw">Twitter</a> <a href="#" class="soc-btn gp">Google+</a></p>


                                            </td>
                                        </tr>
                                    </table><!-- /column 1 -->

                                    <!-- column 2 -->
                                    <table align="left" class="column">
                                        <tr>
                                            <td>

                                                <h5 class="">Contact Info:</h5>
                                                <p>Phone: <strong>408.341.0600</strong><br/>
                Email: <strong><a href="emailto:hseldon@trantor.com">hseldon@trantor.com</a></strong></p>

                                            </td>
                                        </tr>
                                    </table><!-- /column 2 -->

                                    <span class="clear"></span>

                                </td>
                            </tr>
                        </table><!-- /social & contact -->*/ ?>

					</td>
				</tr>
			</table>
			</div><!-- /content -->

		</td>
		<td></td>
	</tr>
</table><!-- /BODY -->

<?php /*<!-- FOOTER -->
<table class="footer-wrap">
	<tr>
		<td></td>
		<td class="container">

				<!-- content -->
				<div class="content">
				<table>
				<tr>
					<td align="center">
						<p>
							<a href="#">Terms</a> |
							<a href="#">Privacy</a> |
							<a href="#"><unsubscribe>Unsubscribe</unsubscribe></a>
						</p>
					</td>
				</tr>
			</table>
				</div><!-- /content -->

		</td>
		<td></td>
	</tr>
</table><!-- /FOOTER -->*/ ?>

</body>
</html>