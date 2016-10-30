<?php
/**
 * HTML for fallback menu.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 4.0.0
 */

namespace ICaspar\Arras\Views;
?>

<nav id="menu-<?php echo esc_attr( $this->location ); ?>-container"
     class="<?php echo $class; ?>">
	<ul id="menu-<?php echo esc_attr( $this->location ); ?>" class="menu-<?php echo esc_attr( $this->location ); ?>">
		<li>
			<i class="fa fa-home" aria-hidden="true"></i>&nbsp;<a href="<?php echo home_url(); ?>">Home</a>
		</li>
	</ul>
</nav>