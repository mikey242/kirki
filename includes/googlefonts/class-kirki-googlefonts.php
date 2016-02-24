<?php

class Kirki_GoogleFonts {

	public static $mode = 'link';

	public static $google_fonts = null;

	public function __construct() {
		$this->set_google_fonts();
	}

	/**
	 * Compile font options from different sources.
	 *
	 * @return array    All available fonts.
	 */
	public static function get_all_fonts() {
		$standard_fonts = Kirki_GoogleFonts::get_standard_fonts();
		$google_fonts   = Kirki_GoogleFonts::get_google_fonts();

		return apply_filters( 'kirki/fonts/all', array_merge( $standard_fonts, $google_fonts ) );
	}

	/**
	 * Return an array of standard websafe fonts.
	 *
	 * @return array    Standard websafe fonts.
	 */
	public static function get_standard_fonts() {

		$i18n = Kirki_Toolkit::i18n();

		return apply_filters( 'kirki/fonts/standard_fonts', array(
			'serif'     => array(
				'label' => $i18n['serif'],
				'stack' => 'Georgia,Times,"Times New Roman",serif',
			),
			'sans-serif' => array(
				'label'  => $i18n['sans-serif'],
				'stack'  => 'Helvetica,Arial,sans-serif',
			),
			'monospace' => array(
				'label' => $i18n['monospace'],
				'stack' => 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace',
			),
		) );

	}

	/**
	 * Return an array of backup fonts based on the font-category
	 *
	 * @return array
	 */
	public static function get_backup_fonts() {
		$backup_fonts = array(
			'sans-serif'  => 'Helvetica, Arial, sans-serif',
			'serif'       => 'Georgia, serif',
			'display'     => '"Comic Sans MS", cursive, sans-serif',
			'handwriting' => '"Comic Sans MS", cursive, sans-serif',
			'monospace'   => '"Lucida Console", Monaco, monospace',
		);
		return apply_filters( 'kirki/fonts/backup_fonts', $backup_fonts );
	}

	/**
	 * Return an array of all available Google Fonts.
	 *
	 * @return array    All Google Fonts.
	 */
	public static function get_google_fonts() {
		return self::$google_fonts;
	}

	/**
	 * Sets the $google_fonts property
	 */
	private function set_google_fonts() {

		global $wp_filesystem;
		// Initialize the WP filesystem, no more using 'file-put-contents' function
		if ( empty( $wp_filesystem ) ) {
			require_once ( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		if ( null == self::$google_fonts ) {

			$json_path = wp_normalize_path( dirname( dirname( dirname( __FILE__ ) ) ) . '/assets/json/webfonts.json' );
			$json      = $wp_filesystem->get_contents( $json_path );
			// Get the list of fonts from our json file and convert to an array
			$fonts = json_decode( $json, true );

			$google_fonts = array();
			if ( is_array( $fonts ) ) {
				foreach ( $fonts['items'] as $font ) {
					$google_fonts[ $font['family'] ] = array(
						'label'    => $font['family'],
						'variants' => $font['variants'],
						'subsets'  => $font['subsets'],
						'category' => $font['category'],
					);
				}
			}

		}

		self::$google_fonts = apply_filters( 'kirki/fonts/google_fonts', $google_fonts );

	}

	public static function get_all_subsets() {
		$i18n = Kirki_Toolkit::i18n();
		return array(
			'all'          => $i18n['all'],
			'cyrillic'     => $i18n['cyrillic'],
			'cyrillic-ext' => $i18n['cyrillic-ext'],
			'devanagari'   => $i18n['devanagari'],
			'greek'        => $i18n['greek'],
			'greek-ext'    => $i18n['greek-ext'],
			'khmer'        => $i18n['khmer'],
			'latin'        => $i18n['latin'],
			'latin-ext'    => $i18n['latin-ext'],
			'vietnamese'   => $i18n['vietnamese'],
			'hebrew'       => $i18n['hebrew'],
			'arabic'       => $i18n['arabic'],
			'bengali'      => $i18n['bengali'],
			'gujarati'     => $i18n['gujarati'],
			'tamil'        => $i18n['tamil'],
			'telugu'       => $i18n['telugu'],
			'thai'         => $i18n['thai'],
		);
	}

	public static function is_google_font( $fontname ) {
		if ( array_key_exists( $fontname, self::$google_fonts ) ) {
			return true;
		}
		return false;
	}

}
