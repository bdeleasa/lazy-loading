<?php
class Lazy_Loading_Settings_Page
{
  /**
   * Holds the values to be used in the fields callbacks
   */
  private $options;

  /**
   * Holds the page slug
   */
  private $options_page_slug = 'lazy-loading-settings';

  /**
   * Holds the options slug value
   */
  private $options_slug = 'lazy_loading_options';

  /**
   * Holds the options group value
   */
  private $options_group_slug = 'lazy_loading_settings_group';


  /**
   * Start up
   */
  public function __construct() {

    add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
    add_action( 'admin_init', array( $this, 'page_init' ) );
    add_action( 'wp_print_scripts', array( $this, 'output_settings_as_js' ) );

  }


  /**
   * Add options page
   */
  public function add_plugin_page() {

    add_options_page(
      'Lazy Loading Settings',
      'Lazy Loading Settings',
      'manage_options',
      $this->options_page_slug,
      array( $this, 'create_admin_page' )
    );

  }

  /**
   * Options page callback
   */
  public function create_admin_page()
  {

    $this->options = get_option( $this->options_slug );
    ?>
    <div class="wrap">
      <h2>Lazy Loading Settings</h2>
      <form method="post" action="options.php">
        <?php
        // This prints out all hidden setting fields
        settings_fields( $this->options_group_slug );
        do_settings_sections( $this->options_page_slug );
        submit_button();
        ?>
      </form>
    </div>
  <?php
  }

  /**
   * Register and add settings
   */
  public function page_init()
  {
    register_setting(
      $this->options_group_slug, // Option group
      $this->options_slug, // Option name
      array( $this, 'sanitize' ) // Sanitize
    );

    add_settings_section(
      'lazy_loading_settings_section', // ID
      'Settings', // Title
      array( $this, 'print_section_info' ), // Callback
      $this->options_page_slug // Page
    );

    add_settings_field(
      'threshold', // ID
      'Threshold', // Title
      array( $this, 'threshold_callback' ), // Callback
      $this->options_page_slug, // Page
      'lazy_loading_settings_section' // Section
    );
  }

  /**
   * Sanitize each setting field as needed
   *
   * @param array $input Contains all settings fields as array keys
   */
  public function sanitize( $input )
  {
    $new_input = array();

    if( isset( $input['threshold'] ) )
      $new_input['threshold'] = absint( $input['threshold'] );

    return $new_input;
  }

  /**
   * Print the Section text
   */
  public function print_section_info()
  {
    print 'Customize the lazy loading settings below:';
  }

  /**
   * Get the settings option array and print one of its values
   */
  public function threshold_callback()
  {
    printf(
      '<input type="text" id="threshold" name="'.$this->options_slug .'[threshold]" value="%s" />px',
      isset( $this->options['threshold'] ) ? esc_attr( $this->options['threshold']) : '200'
    );

    echo '<p class="description">By default images are loaded when they appear on the screen. Ex: setting threshold to 200 causes image to load 200 pixels before it appears on viewport.</p>';
  }


  function output_settings_as_js() {
    ?>
    <script type="text/javascript">
      var <?php echo $this->options_slug; ?> = <?php echo json_encode( get_option( $this->options_slug ) ); ?>;
    </script>
  <?php
  }

}
  