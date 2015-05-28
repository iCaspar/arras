<?php

function arras_addmenu() {
	$options_page = add_theme_page( __( 'Arras Info', 'arras' ), __( 'Arras Info', 'arras' ), 'edit_theme_options', 'arras-info', 'render_arras_info_page' );
}

function render_arras_info_page() {
?>
<div class="wrap">
	<h2>Arras Information</h2>
	<h3>Looking for Theme Options?</h3>
	<p>As of Arras 3.0, all options are accessed <a href="<?php echo admin_url( 'customize.php?return=/wp-admin/themes.php?page=arras-info' );?>">in the customizer</a>.</p>

	<h3>New In this Version</h3>
	<p>(<strong>Please note:</strong> This is a beta version. Some things may not work as expected.<br />
		Please help make Arras better by reporting issues on <a href="http://github.com/iCaspar/arras">Github</a>.)</p>
	<ul>
		<li><strong>Responsive!</strong> Column widths and image sizes adjust to fit smaller screens.</li>
		<li><strong>Color Scheme Update.</strong> Same base color options as in 1.x versions, but simplified.
		And you can change background colors for the header and page to whatever you like.</li>
		<li>All Theme Options are now in the customizer.</li>
	</ul>

	<h3>Support</h3>
	<ul>
		<li>Please report <strong>bugs</strong> on the project's development site at <a href="http://github.com/iCaspar/arras">Github</a>.</li>
		<li>For <strong>Latest Theme News and Downloads</strong> check the <a href="http://arrastheme.net">theme website</a>.</li>
		<li>For <strong>Questions and Discussion</strong> check the <a href="http://forum.arrastheme.net">theme forum</a>.</li>
	</ul>

	<h3>Credits</h3>
	<p>Thanks to Arras's original developer, <strong><a href="http://www.zy.sg/" title="Melvin Lee">Melvin Lee</a></strong>.</p>
	<p>Thanks to everyone who checked out the Alpha versions and suggested improvements.</p>

	<p>Thanks to <a href="http://wenzhixin.net.cn/p/multiple-select/">Zhixin Wen</a> for the dropdown multi-check script in the customizer.</p>


</div>
<?php
}