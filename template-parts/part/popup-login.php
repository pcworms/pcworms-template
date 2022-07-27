<?php
if(get_theme_mod('display_login_link')){
	$login_link_texts = Free_Template::login_link_texts();
	?>
		<div class="mainbox modal fade" id="myModal" role="dialog">
			<div class="modal-dialog" role="document" style="width: 400px;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="<?php esc_html_e('Close', 'pcworms'); ?>"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel"><?php echo $login_link_texts[ get_theme_mod('login_link_text') ]; // xss ok ?></h4>
					</div>
					<div class="modal-body">
						<form id="loginform" data-toggle="validator" method="post" action="<?php echo esc_url( get_site_url() . '/wp-login.php' ); ?>">
							<div class="form-group has-feedback">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-at fa-lg"></i></span>
									<input id="login-username" style="direction: ltr;" type="email" class="form-control" name="log"
										placeholder="<?php esc_attr_e('Email Address', 'pcworms'); ?>" required="required" data-error="<?php esc_attr_e('Please enter your valid email address!', 'pcworms'); ?>" />
								</div>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group has-feedback">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-key fa-lg"></i></span>
									<input id="login-password" style="direction: ltr;" type="password" class="form-control" name="pwd"
										placeholder="<?php esc_attr_e('Password', 'pcworms'); ?>"  required="required" data-error="<?php esc_attr_e('Please enter your password!', 'pcworms'); ?>" />
								</div>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
								<div class="help-block with-errors"></div>
							</div>
							<div class="text-center form-group">
									<input type="submit" class="btn btn-primary" value="<?php esc_attr_e('Login', 'pcworms'); ?>" />&nbsp;
									<?php if ( get_option( 'users_can_register' ) ) { ?>
									<a class="btn btn-success" href="<?php echo esc_url( get_site_url() . '/wp-login.php?action=register' ); ?>" rel="nofollow"><?php esc_html_e('Register!', 'pcworms'); ?></a>&nbsp;	
									<?php } ?>
									<a class="btn btn-warning"  rel="nofollow" href="<?php echo esc_url( get_site_url() . '/wp-login.php?action=lostpassword' ); ?>"><?php esc_html_e('Forgot Password?', 'pcworms'); ?></a>&nbsp;
							</div>
						</form>     	  
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?php esc_html_e('Close', 'pcworms'); ?></button>
					</div>
				</div>
			</div>
		</div>
<?php } ?>