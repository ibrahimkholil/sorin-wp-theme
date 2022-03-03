<?php
/**
 * The footer file
 * @package WordPress
 * @subpackage Sorin
 * @since 1.0.0
 * @version 1.0.0
 */
global $themeOptions;
?>
<footer class="sr-footer">
	<div class="sr-secondary-bg">
		<div class="sr-top-footer py-3 py-md-5 ">
			<div class="container">
				<div class="row">
					<?php if (is_active_sidebar('sorin-footer-widget')) {
						?>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="sr-widget">
	                            <?php  dynamic_sidebar('sorin-footer-widget') ; ?>
                            </div>
                        </div>
					<?php } ?>

					<?php if (is_active_sidebar('sorin-footer-widget-2')) {
						?>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="sr-widget">
	                            <?php  dynamic_sidebar('sorin-footer-widget-2') ; ?>
                            </div>
                        </div>
					<?php } ?>

					<?php if (is_active_sidebar('sorin-footer-widget-3')) {
						?>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="sr-widget">
	                            <?php  dynamic_sidebar('sorin-footer-widget-3') ; ?>
                            </div>
                        </div>
					<?php } ?>

					<?php if (is_active_sidebar('sorin-footer-widget-4')) {
						?>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="sr-widget">
	                            <?php  dynamic_sidebar('sorin-footer-widget-4') ; ?>
                            </div>
                        </div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="sr-middle-footer py-3">
			<div class="container">
				<div class="row">
					<div class="col-12 col-md-6">
						<div class="sr-middle-content text-center text-md-left mb-3 mb-md-0">
							<ul class="list-unstyled list-inline-items mb-0">
								<li class="list-inline-item"><a href="#">Home</a></li>
								<li class="list-inline-item"><a href="#">About Us</a></li>
								<li class="list-inline-item"><a href="#">Services</a></li>
								<li class="list-inline-item"><a href="#">Term and Policy</a></li>
							</ul>
						</div>
					</div>
					<div class="col-12 col-md-6 d-flex justify-content-center justify-content-md-end">
						<div class="sr-middle-content text-center text-md-left">
							<ul class="list-unstyled list-inline-items mb-0">
								<li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i>Facebook</a></li>
								<li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i>Twitter</a></li>
								<li class="list-inline-item"><a href="#"><i class="fab fa-linkedin-in"></i>Linkedin</a></li>
								<li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="sr-copyright-footer py-2">
		<div class="container">
			<div class="row align-items-center">
				<div class="col">
					<div class="sr-copyright text-center text-white">
                        <?php if(!empty($themeOptions->copyRiteText)):?>
						<p class="mb-0"><?php echo esc_attr($themeOptions->copyRiteText);?></p>
                        <?php endif;?>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>