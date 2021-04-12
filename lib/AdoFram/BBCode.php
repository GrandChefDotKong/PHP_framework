<?php
namespace AdoFram;

class BBCode {
	/**
	 * Liste de balises BBCode
	 * @var <array>
	 */
	protected static $bbcodeBalises;
	
	/**
	 * Liste de balises HTML
	 * @var <array>
	 */
	protected static $htmlBalises;
	

	/**
	 * Conversion d'un contenu contenant 
	 * des balises BBCode en code HTML
	 *
	 * @param <string> Contenu
	 * @return <string> Contenu converti
	 */
	public static function bbcodeToHtml($content)
	{
		$content = stripslashes(htmlspecialchars(nl2br($content)));
		BBCode::initializeBbcodeToHtml();
		for ($i = 0 ; $i < count(self::$bbcodeBalises) ; $i++) {
			$content = preg_replace(self::$bbcodeBalises[$i], self::$htmlBalises[$i], $content);
		}
		return $content;
	}
	
	/**
	 * Conversion d'un contenu contenant 
	 * du code HTML en balises BBCode
	 *
	 * @param <string> Contenu
	 * @return <string> Contenu converti
	 */
	public static function htmlToBbcode($content)
	{
		$content = stripslashes(htmlspecialchars(nl2br($content)));
		BBCode::initializeHtmlToBbcode();
		for ($i = 0 ; $i < count(self::$htmlBalises) ; $i++) {
			$content = preg_replace(self::$htmlBalises[$i], self::$bbcodeBalises[$i], $content);
		}
		return nl2br($content);
	}
	
	/**
	 * Initialise les valeurs pattern et replacement
	 * pour la conversion du BBCode en HTML
	 */
	protected static function initializeBbcodeToHtml()
	{
		self::$bbcodeBalises = array('#\[sous_titre](.+)\[/sous_titre]#isU',
									 '#\[p](.+)\[/p]#isU',
									 '#\[br]#isU',
									 '#\[i](.+)\[/i]#isU',
									 '#\[b](.+)\[/b]#isU',
									 '#\[liste]#isU',
									 '#\[/liste]#isU',
									 '#\[liste_element]#isU',
									 '#\[/liste_element]#isU',
									 '#\[img=(.+)\ alt=(.+)\]#isU');

		self::$htmlBalises = array('<h3>$1</h3>',
								   '<p>$1</p>',
								   '<br />',
								   '<em>$1</em>',
								   '<strong>$1</strong>',
								   '<ul>',
								   '</ul>',
								   '<li>',		
								   '</li>',
								   '<img src="$1" alt="$2" />');								   
	}
	
	/**
	 * Initialise les valeurs pattern et replacement
	 * pour la conversion du HTML en BBCode
	 */
	protected static function initializeHtmlToBbcode()
	{
		self::$htmlBalises = array('#\<h3>(.+)\</h3>#isU',
								   '#\<p>(.+)\</p>#isU',
								   '#\<em>(.+)\</em>#isU',
								   '#\<strong>(.+)\</strong>#isU',
								   '#\<ul>(.+)\</ul>#isU',
								   '#\<li>(.+)\</li>#isU');
											  
		self::$bbcodeBalises = array('[sous_titre]$1[/sous_titre]',
									 '[p]$1[/p]',
									 '[i]$1[/i]',
									 '[b]$1[/b]',
									 '[ul]$1[/ul]',
									 '[li]$1[/li]');	
	}
}

