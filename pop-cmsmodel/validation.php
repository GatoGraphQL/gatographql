<?php
namespace PoP\CMSModel;

define('POP_CMSMODEL_POP_ENGINE_MIN_VERSION', 0.1);

class Validation {

	function get_provider_validation_class() {
		
		return apply_filters(
			'PoP_CMSModel_Validation:provider-validation-class',
			null
		);
	}

	function validate() {
		
		$success = true;

		$provider_validation_class = $this->get_provider_validation_class();
		if (is_null($provider_validation_class)) {

			add_action('admin_notices',array($this, 'providerinstall_warning'));
			add_action('network_admin_notices',array($this, 'providerinstall_warning'));
			$success = false;
		}
		elseif (!(new $provider_validation_class())->validate()) {

			add_action('admin_notices',array($this, 'providerinitialize_warning'));
			add_action('network_admin_notices',array($this, 'providerinitialize_warning'));
			$success = false;
		}
		
		if (!defined('POP_ENGINE_VERSION')) {

			add_action('admin_notices', array($this, 'install_warning'));
			add_action('network_admin_notices', array($this, 'install_warning'));
			$success = false;
		}
		elseif (!defined('POP_ENGINE_INITIALIZED')) {

			add_action('admin_notices', array($this, 'initialize_warning'));
			add_action('network_admin_notices', array($this, 'initialize_warning'));
			$success = false;
		}
		elseif (POP_CMSMODEL_POP_ENGINE_MIN_VERSION > POP_ENGINE_VERSION) {
			
			add_action('admin_notices', array($this, 'version_warning'));
			add_action('network_admin_notices', array($this, 'version_warning'));
		}

		return $success;	
	}
	function providerinstall_warning() {
		
		$this->providerinstall_warning_notice(
			__('PoP CMS Model', 'pop-cmsmodel')
		);
	}
	function providerinitialize_warning() {
		
		$this->providerinitialize_warning_notice(
			__('PoP CMS Model', 'pop-cmsmodel')
		);
	}
	function initialize_warning() {
		
		$this->dependency_initialization_warning(
			__('PoP CMS Model', 'pop-cmsmodel'),
			__('PoP Engine', 'pop-cmsmodel')
		);
	}
	function install_warning() {
		
		$this->dependency_installation_warning(
			__('PoP CMS Model', 'pop-cmsmodel'),
			__('PoP Engine', 'pop-cmsmodel'),
			'https://github.com/leoloso/PoP'
		);
	}
	function version_warning() {
		
		$this->dependency_version_warning(
			__('PoP CMS Model', 'pop-cmsmodel'),
			__('PoP Engine', 'pop-cmsmodel'),
			'https://github.com/leoloso/PoP',
			POP_CMSMODEL_POP_ENGINE_MIN_VERSION
		);
	}
	protected function providerinstall_warning_notice($plugin){
		
		$this->admin_notice(
			sprintf(
				__('Error: %s','pop-engine-frontend'),
				sprintf(
					__('There is no provider (underlying implementation) for <strong>%s</strong>.','pop-engine-frontend'),
					$plugin
				)
			)
		);
	}
	protected function dependency_installation_warning($plugin, $dependency, $dependency_url){
		
		$this->admin_notice(
			sprintf(
				__('Error: %s','pop-engine-frontend'),
				sprintf(
					__('<strong>%s</strong> is not installed/activated. Without it, <strong>%s</strong> will not work. Please install this plugin from your plugin installer or download it <a href="%s" target="_blank">from here</a>.','pop-engine-frontend'),
					$dependency,
					$plugin,
					$dependency_url
				)
			)
		);
	}
	protected function dependency_initialization_warning($plugin, $dependency){
		
		$this->admin_notice(
			sprintf(
				__('Error: %s','pop-engine-frontend'),
				sprintf(
					__('<strong>%s</strong> is not initialized properly. As a consequence, <strong>%s</strong> has not been loaded.','pop-engine-frontend'),
					$dependency,
					$plugin
				)
			)
		);
	}
	protected function dependency_version_warning($plugin, $dependency, $dependency_url, $dependency_min_version){
		
		$this->admin_notice(
			sprintf(
				__('Error: %s','pop-engine-frontend'),
				sprintf(
					__('<strong>%s</strong> requires version %s or bigger of <strong>%s</strong>. Please update this plugin from your plugin installer or download it <a href="%s" target="_blank">from here</a>.','pop-engine-frontend'),
					$plugin,
					$dependency_min_version,
					$dependency,
					$dependency_url
				)
			)
		);
	}
	protected function admin_notice($message) {
		?>
		<div class="error">
			<p>
				<?php echo $message ?><br/>
				<em>
					<?php _e('Only admins see this message.', 'pop-engine-frontend'); ?>
				</em>
			</p>
		</div>
		<?php
	}
}
