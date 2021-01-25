<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\This;
use App\Site;

class SitesHostSSHController extends Controller{

	// SSH Connection Handler
	protected $ch;

	protected $sites_server_host;
	protected $sites_server_user;
	protected $sites_pub_key_path;
	protected $sites_priv_key_path;

	public $auto_sites_path = '/var/www/dealer_sites_auto';
	public $redis_pass      = 'r0CO7ki98903m4I';
	public $redis_host      = '54.188.129.59';
	public $redis_port      = 6379;

	// should be exists in the user's home directory
	public    $vhost_path              = 'auto-sites-enabled';
	protected $temp_file_name          = 'auto_sites';
	protected $vhost_template_file     = 'vhost-template.conf';
	protected $vhost_template_file_ssl = 'vhost-template-le-ssl.conf';
	public    $wpconfig_template_file  = 'wp-config-template.php';
	public    $wpconfig_filename       = 'wp-config.php';
	public    $wpconfig_storage        = 'wpconfigs';

	// templates
	protected $tmpl_site_path = '/var/www/dealer_sites_auto/tmpl.idweb.io';

	protected $login_res;

	public $code_to_disable_autoupdates;
	public $code_to_enable_autoupdates;

    public $dis_updates_filepath;
    public $enab_updates_filepath;

	public function __construct(){
		$this->sites_server_host = '54.188.129.59';
		$this->sites_server_user = 'dg_auto'; // 4LzJp91PPnQREIe

        // ENABLE
        ob_start(); ?>// {{{ AUTOUPDATES_START }}}
if( class_exists( 'Puc_v4_Factory' ) ){
    $slug                   = basename( PARENT_THEME_PATH );
    $update_server_url      = 'https://api.datgate.com/wp-update-server';
    $example_update_checker = new ThemeUpdateChecker( $slug, "{$update_server_url}/temp/{$slug}_info.json" );

    $example_update_checker->addQueryArgFilter( 'wsh_filter_update_theme_checks' );
    function wsh_filter_update_theme_checks( $queryArgs ){
    $queryArgs['license_key'] = get_option( 'dealer-tower_license_key' );
            return $queryArgs;
        }
    }
// {{{ AUTOUPDATES END }}}<?php
        $this->code_to_enable_autoupdates = ob_get_clean();

        // DISABLE
        ob_start(); ?>// {{{ AUTOUPDATES START }}}
// disable updates checker
add_filter( 'pre_site_transient_update_core', '__return_null' );
wp_clear_scheduled_hook( 'wp_version_check' );

// disable plugin updates
remove_action( 'load-update-core.php', 'wp_update_plugins' );
add_filter( 'pre_site_transient_update_plugins', '__return_null' );
wp_clear_scheduled_hook( 'wp_update_plugins' );

// disable themes update
remove_action( 'load-update-core.php', 'wp_update_themes' );
add_filter( 'pre_site_transient_update_themes', '__return_null' );
wp_clear_scheduled_hook( 'wp_update_themes' );
// {{{ AUTOUPDATES END }}}<?php
        $this->code_to_disable_autoupdates = ob_get_clean();


		$this->dis_updates_filepath  = storage_path( $this->wpconfig_storage ) . '/autoupdates_dis.phpt';
		$this->enab_updates_filepath = storage_path( $this->wpconfig_storage ) . '/autoupdates_enab.phpt';

		if( ! file_exists( $this->dis_updates_filepath ) ){
			file_put_contents( $this->dis_updates_filepath, "<?php\n {$this->code_to_disable_autoupdates}" );
		}

		if( ! file_exists( $this->enab_updates_filepath ) ){
			file_put_contents( $this->enab_updates_filepath, "<?php\n {$this->code_to_enable_autoupdates}" );
		}
	}

	/**
	 * @return void
	 */
	public function __ssh_connect(){
		// this function will set `$sites_pub_key_path` and `$sites_priv_key_path` vars
		$this->set_keys_path();

		$this->ch        = ssh2_connect( $this->sites_server_host, 22, [ 'hostkey' => 'ssh-rsa' ] );
		$this->login_res = ssh2_auth_pubkey_file( $this->ch, $this->sites_server_user, $this->sites_pub_key_path, $this->sites_priv_key_path );
	}

	/**
	 * Send file via SSH/SFTP from `vhosts` storage to `auto_sites_path` by filename
	 *
	 * @param string $filename
	 *
	 * @return bool
	 */
	public function ssh_send_vhost_file( string $filename ):bool{

		if( ! $this->ch ) $this->__ssh_connect();

		$local_filename  = Storage::disk( 'vhosts' )->path( $filename );
		$remote_filename = "{$this->vhost_path}/{$filename}";

		return ssh2_scp_send( $this->ch, $local_filename, $remote_filename, 0644 );
	}

	/**
	 * Send file via SSH/SFTP from `from` to 'destination'
	 *
	 * @param string $from
	 * @param string $to
	 *
	 * @return bool
	 */
	public function ssh_send_file( string $from, string $to ):bool{
		if( ! $this->ch ) $this->__ssh_connect();

		return ssh2_scp_send( $this->ch, $from, $to, 0644 );
	}

	/**
	 * @param string $base_name
	 *
	 * @return string
	 */
	public function create_folder( string $base_name ):string{
		$dir_name      = HelperController::generate_name_from_string( $base_name, $this->get_sites_directories(), false, true );
		$document_root = "{$this->auto_sites_path}/{$dir_name}";

		$this->ssh_cmd( "mkdir {$document_root}" );

		return $document_root;
	}

	/**
	 * Return array of directories in specific folder on remote Server
	 *
	 * @return array
	 */
	public function get_sites_directories():array{

		// create file with listing of directories in specific folder
		$this->ssh_cmd( "ls {$this->auto_sites_path} > {$this->temp_file_name}" );

		// show content of file, created above
		$sites_raw = $this->ssh_cmd( "cat {$this->temp_file_name}" );

		// clean up array of sites
		$sites = explode( "\n", $sites_raw );
		$sites = array_filter( $sites );
		$sites = array_map( 'trim', $sites );

		return $sites;
	}

	/**
	 * @return void
	 */
	public function set_keys_path():void{
		$this->sites_pub_key_path  = storage_path( 'keys' ) . '/dg_auto.pub';
		$this->sites_priv_key_path = storage_path( 'keys' ) . '/dg_auto';
	}

	/**
	 * @param string $cmd
	 *
	 * @return string
	 */
	public function ssh_cmd( string $cmd ):string{

		if( ! $this->ch ) $this->__ssh_connect();

		// create file with listing of directories in specific folder
		$stream = ssh2_exec( $this->ch, $cmd );
		stream_set_blocking( $stream, true );
		$output_raw = stream_get_contents( $stream, 4096 );
		fclose( $stream );

		return $output_raw;
	}

	/**
	 * @param string $document_root
	 *
	 * @return bool
	 */
	public function copy_files_from_tmpl( string $document_root ):bool{

		$dir = last( explode( '/', $document_root ) );
		if( ! in_array( $dir, $this->get_sites_directories() ) ){
			return false;
		}

		$this->ssh_cmd( "cp -R {$this->tmpl_site_path}/. {$document_root}" );
		$this->ssh_cmd( "cp {$this->tmpl_site_path}/.htaccess {$document_root}" );

		// remove /var/www/dealer_sites_auto/{{DOCUMENT_ROOT}}/content/object-cache.php
		$this->ssh_cmd( "rm {$document_root}/content/object-cache.php" );

		// Enable autoupdates for just copied site
		$this->ssh_send_file( $this->enab_updates_filepath, "{$document_root}/content/themes/dh5/autoupdates.php" );

		$tmp_file          = 'site_folder_listing.tmp';
		$check_files_names = [ '.htaccess', 'content', 'core', 'index.php', 'wp-config.php', 'wp-config-extend.php' ];

		// get just copied filenames from the server for check
		$this->ssh_cmd( "ls -a {$document_root} > {$tmp_file}" );
		$res = $this->ssh_cmd( "cat $tmp_file" );
		$res = explode( "\n", $res );
		$res = array_map( 'strtolower', $res );
		$res = array_filter( $res, function( $item ){
			return !in_array( $item, ['.', '..', ''] );
		});

		// check
		return count( array_intersect( $check_files_names, $res ) ) >= count( $check_files_names );
	}

	/**
	 * Generate file content from template and send `wp-config.php` to the server
	 *
	 * @param $site
	 *
	 * @return bool
	 */
	public function replace_db_credentials( $site ):bool{

		// Generate and save locally wp-config.php file
		$file_content     = $this->get_wpconfig_template_file_content();
		$wpconfig_content = strtr( $file_content, [
			'{{{REMOTE_ADDR}}}'  => $_SERVER['REMOTE_ADDR'],
			'{{{CUR_DATETIME}}}' => date( 'd-m-Y H:i:s' ),
			'{{{TIMEZONE}}}'     => SitesController::$tz,
			'{{{DB_NAME}}}'      => $site->db_name,
			'{{{DB_USER}}}'      => $site->db_user,
			'{{{DB_PASS}}}'      => $site->db_pass,
			'{{{DB_HOST}}}'      => DBHostController::$db_server_host,
			'{{{REDIS_HOST}}}'   => $this->redis_host,
			'{{{REDIS_PASS}}}'   => $this->redis_pass,
			'{{{REDIS_PORT}}}'   => $this->redis_port,
		] );
		// save this file to local storage
		Storage::disk( $this->wpconfig_storage )->put( $this->wpconfig_filename, $wpconfig_content );

		$local_path  = Storage::disk( $this->wpconfig_storage )->path( $this->wpconfig_filename );
		$remote_path = "{$site->document_root}/$this->wpconfig_filename";

		// send file to
		return $this->ssh_send_file( $local_path, $remote_path );
	}

	/**
	 * @param string $domain
	 *
	 * @return bool
	 */
	public function SSL_generate( string $domain ):bool{

		// delete if exists
		if( $this->is_SSL_exists( $domain ) ){
			$certbot_cmd = "sudo certbot -n delete --cert-name {$domain}";
			$this->ssh_cmd( $certbot_cmd );
		}

		$certbot_cmd = "sudo certbot -n --apache -d {$domain}";
		$res         = $this->ssh_cmd( $certbot_cmd );

		return false !== strpos( $res, 'Congratulations' );
	}

	/**
	 * @param string $domain
	 *
	 * @return bool
	 */
	public function is_SSL_exists( string $domain ):bool{
		$certbot_cmd = "sudo certbot certificates -d {$domain}";
		$output      = $this->ssh_cmd( $certbot_cmd );

		return false !== strpos( $output, "Certificate Name: {$domain}" );
	}

	/**
	 * Get template of virtual host configuration file for Apache
	 *
	 * @return string
	 */
	public function get_vhost_template_file_content():string{
		return $this->ssh_cmd( "cat {$this->vhost_template_file}" );
	}

	/**
	 * Get template of wp-config.php
	 *
	 * @return string
	 */
	public function get_wpconfig_template_file_content():string{
		return $this->ssh_cmd( "cat {$this->wpconfig_template_file}" );
	}

	/**
	 * Get template of virtual host configuration for SSL file for Apache
	 *
	 * @return string
	 */
	public function get_vhost_template_file_ssl_content():string{
		return $this->ssh_cmd( "cat {$this->vhost_template_file_ssl}" );
	}

	/**
	 * Need to check if tmpl site is not updating at this moment, if yes, wait 5 sec, if no - disable autoupdates
     *
     * @param bool $enable
     *
	 */
	public function autoupdatesSwitcherForTmpl( $enable = true ):void{
		if( $enable ){
			$this->ssh_send_file( $this->enab_updates_filepath, "{$this->tmpl_site_path}/content/themes/dh5/autoupdates.php" );
        }
		else{
		    $this->ssh_send_file( $this->dis_updates_filepath, "{$this->tmpl_site_path}/content/themes/dh5/autoupdates.php" );
        }
	}

	/**
	 * Disconnect from SSH
	 */
	public function __destruct(){
		if( is_resource( $this->ch ) ) ssh2_disconnect( $this->ch );
	}
}
