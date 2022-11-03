<?php
//============================================================+
// File name   : tcpdf.php
// Version     : 6.0.023
// Begin       : 2002-08-03
// Last Update : 2013-08-05
// Author      : Nicola Asuni - Tecnick.com LTD - www.tecnick.com - info@tecnick.com
// License     : GNU-LGPL v3 (http://www.gnu.org/copyleft/lesser.html)
// -------------------------------------------------------------------
// Copyright (C) 2002-2013 Nicola Asuni - Tecnick.com LTD
//
// This file is part of TCPDF software library.
//
// TCPDF is free software: you can ioredistribute it and/or modify it
// under the terms of the GNU Lesser General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// TCPDF is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// See the GNU Lesser General Public License for more details.
//
// You should have received a copy of the License
// along with TCPDF. If not, see
// <http://www.tecnick.com/pagefiles/tcpdf/LICENSE.TXT>.
//
// See LICENSE.TXT file for more information.
// -------------------------------------------------------------------
//
// Description :
//   This is a PHP class for generating PDF documents without requiring external extensions.
//
// NOTE:
//   This class was originally derived in 2002 from the Public
//   Domain FPDF class by Olivier Plathey (http://www.fpdf.org),
//   but now is almost entirely rewritten and contains thousands of
//   new lines of code and hundreds new features.
//
// Main features:
//  * no external libraries are required for the basic functions;
//  * all standard page formats, custom page formats, custom margins and units of measure;
//  * UTF-8 Unicode and Right-To-Left languages;
//  * TrueTypeUnicode, TrueType, Type1 and CID-0 fonts;
//  * font subsetting;
//  * methods to publish some XHTML + CSS code, Javascript and Forms;
//  * images, graphic (geometric figures) and transformation methods;
//  * supports JPEG, PNG and SVG images natively, all images supported by GD (GD, GD2, GD2PART, GIF, JPEG, PNG, BMP, XBM, XPM) and all images supported via ImagMagick (http://www.imagemagick.org/www/formats.html)
//  * 1D and 2D barcodes: CODE 39, ANSI MH10.8M-1983, USD-3, 3 of 9, CODE 93, USS-93, Standard 2 of 5, Interleaved 2 of 5, CODE 128 A/B/C, 2 and 5 Digits UPC-Based Extention, EAN 8, EAN 13, UPC-A, UPC-E, MSI, POSTNET, PLANET, RMS4CC (Royal Mail 4-state Customer Code), CBC (Customer Bar Code), KIX (Klant index - Customer index), Intelligent Mail Barcode, Onecode, USPS-B-3200, CODABAR, CODE 11, PHARMACODE, PHARMACODE TWO-TRACKS, Datamatrix, QR-Code, PDF417;
//  * JPEG and PNG ICC profiles, Grayscale, RGB, CMYK, Spot Colors and Transparencies;
//  * automatic page header and footer management;
//  * document encryption up to 256 bit and digital signature certifications;
//  * transactions to UNDO commands;
//  * PDF annotations, including links, text and file attachments;
//  * text rendering modes (fill, stroke and clipping);
//  * multiple columns mode;
//  * no-write page regions;
//  * bookmarks, named destinations and table of content;
//  * text hyphenation;
//  * text stretching and spacing (tracking);
//  * automatic page break, line break and text alignments including justification;
//  * automatic page numbering and page groups;
//  * move and delete pages;
//  * page compression (requires php-zlib extension);
//  * XOBject Templates;
//  * Layers and object visibility.
//	* PDF/A-1b support.
//
// -----------------------------------------------------------
// THANKS TO:
//
// Olivier Plathey (http://www.fpdf.org) for original FPDF.
// Efthimios Mavrogeorgiadis (emavro@yahoo.com) for suggestions on RTL language support.
// Klemen Vodopivec (http://www.fpdf.de/downloads/addons/37/) for Encryption algorithm.
// Warren Sherliker (wsherliker@gmail.com) for better image handling.
// dullus for text Justification.
// Bob Vincent (pillarsdotnet@users.sourceforge.net) for <li> value attribute.
// Patrick Benny for text stretch suggestion on Cell().
// Johannes Güntert for JavaScript support.
// Denis Van Nuffelen for Dynamic Form.
// Jacek Czekaj for multibyte justification
// Anthony Ferrara for the reintroduction of legacy image methods.
// Sourceforge user 1707880 (hucste) for line-through mode.
// Larry Stanbery for page groups.
// Martin Hall-May for transparency.
// Aaron C. Spike for Polycurve method.
// Mohamad Ali Golkar, Saleh AlMatrafe, Charles Abbott for Arabic and Persian support.
// Moritz Wagner and Andreas Wurmser for graphic functions.
// Andrew Whitehead for core fonts support.
// Esteban Joël Marín for OpenType font conversion.
// Teus Hagen for several suggestions and fixes.
// Yukihiro Nakadaira for CID-0 CJK fonts fixes.
// Kosmas Papachristos for some CSS improvements.
// Marcel Partap for some fixes.
// Won Kyu Park for several suggestions, fixes and patches.
// Dominik Dzienia for QR-code support.
// Laurent Minguet for some suggestions.
// Christian Deligant for some suggestions and fixes.
// Travis Harris for crop mark suggestion.
// Aleksey Kuznetsov for some suggestions and text shadows.
// Jim Hanlon for several suggestions and patches.
// Anyone else that has reported a bug or sent a suggestion.
//============================================================+

/**
 * @file
 * This is a PHP class for generating PDF documents without requiring external extensions.<br>
 * TCPDF project (http://www.tcpdf.org) was originally derived in 2002 from the Public Domain FPDF class by Olivier Plathey (http://www.fpdf.org), but now is almost entirely rewritten.<br>
 * <h3>TCPDF main features are:</h3>
 * <ul>
 * <li>no external libraries are required for the basic functions;</li>
 * <li>all standard page formats, custom page formats, custom margins and units of measure;</li>
 * <li>UTF-8 Unicode and Right-To-Left languages;</li>
 * <li>TrueTypeUnicode, TrueType, Type1 and CID-0 fonts;</li>
 * <li>font subsetting;</li>
 * <li>methods to publish some XHTML + CSS code, Javascript and Forms;</li>
 * <li>images, graphic (geometric figures) and transformation methods;
 * <li>supports JPEG, PNG and SVG images natively, all images supported by GD (GD, GD2, GD2PART, GIF, JPEG, PNG, BMP, XBM, XPM) and all images supported via ImagMagick (http://www.imagemagick.org/www/formats.html)</li>
 * <li>1D and 2D barcodes: CODE 39, ANSI MH10.8M-1983, USD-3, 3 of 9, CODE 93, USS-93, Standard 2 of 5, Interleaved 2 of 5, CODE 128 A/B/C, 2 and 5 Digits UPC-Based Extention, EAN 8, EAN 13, UPC-A, UPC-E, MSI, POSTNET, PLANET, RMS4CC (Royal Mail 4-state Customer Code), CBC (Customer Bar Code), KIX (Klant index - Customer index), Intelligent Mail Barcode, Onecode, USPS-B-3200, CODABAR, CODE 11, PHARMACODE, PHARMACODE TWO-TRACKS, Datamatrix, QR-Code, PDF417;</li>
 * <li>JPEG and PNG ICC profiles, Grayscale, RGB, CMYK, Spot Colors and Transparencies;</li>
 * <li>automatic page header and footer management;</li>
 * <li>document encryption up to 256 bit and digital signature certifications;</li>
 * <li>transactions to UNDO commands;</li>
 * <li>PDF annotations, including links, text and file attachments;</li>
 * <li>text rendering modes (fill, stroke and clipping);</li>
 * <li>multiple columns mode;</li>
 * <li>no-write page regions;</li>
 * <li>bookmarks, named destinations and table of content;</li>
 * <li>text hyphenation;</li>
 * <li>text stretching and spacing (tracking);</li>
 * <li>automatic page break, line break and text alignments including justification;</li>
 * <li>automatic page numbering and page groups;</li>
 * <li>move and delete pages;</li>
 * <li>page compression (requires php-zlib extension);</li>
 * <li>XOBject Templates;</li>
 * <li>Layers and object visibility;</li>
 * <li>PDF/A-1b support.</li>
 * </ul>
 * Tools to encode your unicode fonts are on fonts/utils directory.</p>
 * @package com.tecnick.tcpdf
 * @author Nicola Asuni
 * @version 6.0.023
 */

// TCPDF configuration
require_once(dirname(__FILE__).'/tcpdf_autoconfig.php');
// TCPDF static font methods and data
require_once(dirname(__FILE__).'/include/tcpdf_font_data.php');
// TCPDF static font methods and data
require_once(dirname(__FILE__).'/include/tcpdf_fonts.php');
// TCPDF static color methods and data
require_once(dirname(__FILE__).'/include/tcpdf_colors.php');
// TCPDF static image methods and data
require_once(dirname(__FILE__).'/include/tcpdf_images.php');
// TCPDF static methods and data
require_once(dirname(__FILE__).'/include/tcpdf_static.php');

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * @class TCPDF
 * PHP class for generating PDF documents without requiring external extensions.
 * TCPDF project (http://www.tcpdf.org) has been originally derived in 2002 from the Public Domain FPDF class by Olivier Plathey (http://www.fpdf.org), but now is almost entirely rewritten.<br>
 * @package com.tecnick.tcpdf
 * @brief PHP class for generating PDF documents without requiring external extensions.
 * @version 6.0.023
 * @author Nicola Asuni - info@tecnick.com
 */
class TCPDF {

	// Protected properties

	/**
	 * Current page number.
	 * @protected
	 */
	protected $page;

	/**
	 * Current object number.
	 * @protected
	 */
	protected $n;

	/**
	 * Array of object offsets.
	 * @protected
	 */
	protected $offsets = array();

	/**
	 * Array of object IDs for each page.
	 * @protected
	 */
	protected $pageobjects = array();

	/**
	 * Buffer holding in-memory PDF.
	 * @protected
	 */
	protected $buffer;

	/**
	 * Array containing pages.
	 * @protected
	 */
	protected $pages = array();

	/**
	 * Current document state.
	 * @protected
	 */
	protected $state;

	/**
	 * Compression flag.
	 * @protected
	 */
	protected $compress;

	/**
	 * Current page orientation (P = Portrait, L = Landscape).
	 * @protected
	 */
	protected $CurOrientation;

	/**
	 * Page dimensions.
	 * @protected
	 */
	protected $pagedim = array();

	/**
	 * Scale factor (number of points in user unit).
	 * @protected
	 */
	protected $k;

	/**
	 * Width of page format in points.
	 * @protected
	 */
	protected $fwPt;

	/**
	 * Height of page format in points.
	 * @protected
	 */
	protected $fhPt;

	/**
	 * Current width of page in points.
	 * @protected
	 */
	protected $wPt;

	/**
	 * Current height of page in points.
	 * @protected
	 */
	protected $hPt;

	/**
	 * Current width of page in user unit.
	 * @protected
	 */
	protected $w;

	/**
	 * Current height of page in user unit.
	 * @protected
	 */
	protected $h;

	/**
	 * Left margin.
	 * @protected
	 */
	protected $lMargin;

	/**
	 * Right margin.
	 * @protected
	 */
	protected $rMargin;

	/**
	 * Cell left margin (used by regions).
	 * @protected
	 */
	protected $clMargin;

	/**
	 * Cell right margin (used by regions).
	 * @protected
	 */
	protected $crMargin;

	/**
	 * Top margin.
	 * @protected
	 */
	protected $tMargin;

	/**
	 * Page break margin.
	 * @protected
	 */
	protected $bMargin;

	/**
	 * Array of cell internal paddings ('T' => top, 'R' => right, 'B' => bottom, 'L' => left).
	 * @since 5.9.000 (2010-10-03)
	 * @protected
	 */
	protected $cell_padding = array('T' => 0, 'R' => 0, 'B' => 0, 'L' => 0);

	/**
	 * Array of cell margins ('T' => top, 'R' => right, 'B' => bottom, 'L' => left).
	 * @since 5.9.000 (2010-10-04)
	 * @protected
	 */
	protected $cell_margin = array('T' => 0, 'R' => 0, 'B' => 0, 'L' => 0);

	/**
	 * Current horizontal position in user unit for cell positioning.
	 * @protected
	 */
	protected $x;

	/**
	 * Current vertical position in user unit for cell positioning.
	 * @protected
	 */
	protected $y;

	/**
	 * Height of last cell printed.
	 * @protected
	 */
	protected $lasth;

	/**
	 * Line width in user unit.
	 * @protected
	 */
	protected $LineWidth;

	/**
	 * Array of standard font names.
	 * @protected
	 */
	protected $CoreFonts;

	/**
	 * Array of used fonts.
	 * @protected
	 */
	protected $fonts = array();

	/**
	 * Array of font files.
	 * @protected
	 */
	protected $FontFiles = array();

	/**
	 * Array of encoding differences.
	 * @protected
	 */
	protected $diffs = array();

	/**
	 * Array of used images.
	 * @protected
	 */
	protected $images = array();

	/**
	 * Array of cached files.
	 * @protected
	 */
	protected $cached_files = array();

	/**
	 * Array of Annotations in pages.
	 * @protected
	 */
	protected $PageAnnots = array();

	/**
	 * Array of internal links.
	 * @protected
	 */
	protected $links = array();

	/**
	 * Current font family.
	 * @protected
	 */
	protected $FontFamily;

	/**
	 * Current font style.
	 * @protected
	 */
	protected $FontStyle;

	/**
	 * Current font ascent (distance between font top and baseline).
	 * @protected
	 * @since 2.8.000 (2007-03-29)
	 */
	protected $FontAscent;

	/**
	 * Current font descent (distance between font bottom and baseline).
	 * @protected
	 * @since 2.8.000 (2007-03-29)
	 */
	protected $FontDescent;

	/**
	 * Underlining flag.
	 * @protected
	 */
	protected $underline;

	/**
	 * Overlining flag.
	 * @protected
	 */
	protected $overline;

	/**
	 * Current font info.
	 * @protected
	 */
	protected $CurrentFont;

	/**
	 * Current font size in points.
	 * @protected
	 */
	protected $FontSizePt;

	/**
	 * Current font size in user unit.
	 * @protected
	 */
	protected $FontSize;

	/**
	 * Commands for drawing color.
	 * @protected
	 */
	protected $DrawColor;

	/**
	 * Commands for filling color.
	 * @protected
	 */
	protected $FillColor;

	/**
	 * Commands for text color.
	 * @protected
	 */
	protected $TextColor;

	/**
	 * Indicates whether fill and text colors are different.
	 * @protected
	 */
	protected $ColorFlag;

	/**
	 * Automatic page breaking.
	 * @protected
	 */
	protected $AutoPageBreak;

	/**
	 * Threshold used to trigger page breaks.
	 * @protected
	 */
	protected $PageBreakTrigger;

	/**
	 * Flag set when processing page header.
	 * @protected
	 */
	protected $InHeader = false;

	/**
	 * Flag set when processing page footer.
	 * @protected
	 */
	protected $InFooter = false;

	/**
	 * Zoom display mode.
	 * @protected
	 */
	protected $ZoomMode;

	/**
	 * Layout display mode.
	 * @protected
	 */
	protected $LayoutMode;

	/**
	 * If true set the document information dictionary in Unicode.
	 * @protected
	 */
	protected $docinfounicode = true;

	/**
	 * Document title.
	 * @protected
	 */
	protected $title = '';

	/**
	 * Document subject.
	 * @protected
	 */
	protected $subject = '';

	/**
	 * Document author.
	 * @protected
	 */
	protected $author = '';

	/**
	 * Document keywords.
	 * @protected
	 */
	protected $keywords = '';

	/**
	 * Document creator.
	 * @protected
	 */
	protected $creator = '';

	/**
	 * Starting page number.
	 * @protected
	 */
	protected $starting_page_number = 1;

	/**
	 * The right-bottom (or left-bottom for RTL) corner X coordinate of last inserted image.
	 * @since 2002-07-31
	 * @author Nicola Asuni
	 * @protected
	 */
	protected $img_rb_x;

	/**
	 * The right-bottom corner Y coordinate of last inserted image.
	 * @since 2002-07-31
	 * @author Nicola Asuni
	 * @protected
	 */
	protected $img_rb_y;

	/**
	 * Adjusting factor to convert pixels to user units.
	 * @since 2004-06-14
	 * @author Nicola Asuni
	 * @protected
	 */
	protected $imgscale = 1;

	/**
	 * Boolean flag set to true when the input text is unicode (require unicode fonts).
	 * @since 2005-01-02
	 * @author Nicola Asuni
	 * @protected
	 */
	protected $isunicode = false;

	/**
	 * PDF version.
	 * @since 1.5.3
	 * @protected
	 */
	protected $PDFVersion = '1.7';

	/**
	 * ID of the stored default header template (-1 = not set).
	 * @protected
	 */
	protected $header_xobjid = -1;

	/**
	 * If true reset the Header Xobject template at each page
	 * @protected
	 */
	protected $header_xobj_autoreset = false;

	/**
	 * Minimum distance between header and top page margin.
	 * @protected
	 */
	protected $header_margin;

	/**
	 * Minimum distance between footer and bottom page margin.
	 * @protected
	 */
	protected $footer_margin;

	/**
	 * Original left margin value.
	 * @protected
	 * @since 1.53.0.TC013
	 */
	protected $original_lMargin;

	/**
	 * Original right margin value.
	 * @protected
	 * @since 1.53.0.TC013
	 */
	protected $original_rMargin;

	/**
	 * Default font used on page header.
	 * @protected
	 */
	protected $header_font;

	/**
	 * Default font used on page footer.
	 * @protected
	 */
	protected $footer_font;

	/**
	 * Language templates.
	 * @protected
	 */
	protected $l;

	/**
	 * Barcode to print on page footer (only if set).
	 * @protected
	 */
	protected $barcode = false;

	/**
	 * Boolean flag to print/hide page header.
	 * @protected
	 */
	protected $print_header = true;

	/**
	 * Boolean flag to print/hide page footer.
	 * @protected
	 */
	protected $print_footer = true;

	/**
	 * Header image logo.
	 * @protected
	 */
	protected $header_logo = '';

	/**
	 * Width of header image logo in user units.
	 * @protected
	 */
	protected $header_logo_width = 30;

	/**
	 * Title to be printed on default page header.
	 * @protected
	 */
	protected $header_title = '';

	/**
	 * String to pring on page header after title.
	 * @protected
	 */
	protected $header_string = '';

	/**
	 * Color for header text (RGB array).
	 * @since 5.9.174 (2012-07-25)
	 * @protected
	 */
	protected $header_text_color = array(0,0,0);

	/**
	 * Color for header line (RGB array).
	 * @since 5.9.174 (2012-07-25)
	 * @protected
	 */
	protected $header_line_color = array(0,0,0);

	/**
	 * Color for footer text (RGB array).
	 * @since 5.9.174 (2012-07-25)
	 * @protected
	 */
	protected $footer_text_color = array(0,0,0);

	/**
	 * Color for footer line (RGB array).
	 * @since 5.9.174 (2012-07-25)
	 * @protected
	 */
	protected $footer_line_color = array(0,0,0);

	/**
	 * Text shadow data array.
	 * @since 5.9.174 (2012-07-25)
	 * @protected
	 */
	protected $txtshadow = array('enabled'=>false, 'depth_w'=>0, 'depth_h'=>0, 'color'=>false, 'opacity'=>1, 'blend_mode'=>'Normal');

	/**
	 * Default number of columns for html table.
	 * @protected
	 */
	protected $default_table_columns = 4;

	// variables for html parser

	/**
	 * HTML PARSER: array to store current link and rendering styles.
	 * @protected
	 */
	protected $HREF = array();

	/**
	 * List of available fonts on filesystem.
	 * @protected
	 */
	protected $fontlist = array();

	/**
	 * Current foreground color.
	 * @protected
	 */
	protected $fgcolor;

	/**
	 * HTML PARSER: array of boolean values, true in case of ordered list (OL), false otherwise.
	 * @protected
	 */
	protected $listordered = array();

	/**
	 * HTML PARSER: array count list items on nested lists.
	 * @protected
	 */
	protected $listcount = array();

	/**
	 * HTML PARSER: current list nesting level.
	 * @protected
	 */
	protected $listnum = 0;

	/**
	 * HTML PARSER: indent amount for lists.
	 * @protected
	 */
	protected $listindent = 0;

	/**
	 * HTML PARSER: current list indententation level.
	 * @protected
	 */
	protected $listindentlevel = 0;

	/**
	 * Current background color.
	 * @protected
	 */
	protected $bgcolor;

	/**
	 * Temporary font size in points.
	 * @protected
	 */
	protected $tempfontsize = 10;

	/**
	 * Spacer string for LI tags.
	 * @protected
	 */
	protected $lispacer = '';

	/**
	 * Default encoding.
	 * @protected
	 * @since 1.53.0.TC010
	 */
	protected $encoding = 'UTF-8';

	/**
	 * PHP internal encoding.
	 * @protected
	 * @since 1.53.0.TC016
	 */
	protected $internal_encoding;

	/**
	 * Boolean flag to indicate if the document language is Right-To-Left.
	 * @protected
	 * @since 2.0.000
	 */
	protected $rtl = false;

	/**
	 * Boolean flag used to force RTL or LTR string direction.
	 * @protected
	 * @since 2.0.000
	 */
	protected $tmprtl = false;

	// --- Variables used for document encryption:

	/**
	 * IBoolean flag indicating whether document is protected.
	 * @protected
	 * @since 2.0.000 (2008-01-02)
	 */
	protected $encrypted;

	/**
	 * Array containing encryption settings.
	 * @protected
	 * @since 5.0.005 (2010-05-11)
	 */
	protected $encryptdata = array();

	/**
	 * Last RC4 key encrypted (cached for optimisation).
	 * @protected
	 * @since 2.0.000 (2008-01-02)
	 */
	protected $last_enc_key;

	/**
	 * Last RC4 computed key.
	 * @protected
	 * @since 2.0.000 (2008-01-02)
	 */
	protected $last_enc_key_c;

	/**
	 * File ID (used on document trailer).
	 * @protected
	 * @since 5.0.005 (2010-05-12)
	 */
	protected $file_id;

	// --- bookmark ---

	/**
	 * Outlines for bookmark.
	 * @protected
	 * @since 2.1.002 (2008-02-12)
	 */
	protected $outlines = array();

	/**
	 * Outline root for bookmark.
	 * @protected
	 * @since 2.1.002 (2008-02-12)
	 */
	protected $OutlineRoot;

	// --- javascript and form ---

	/**
	 * Javascript code.
	 * @protected
	 * @since 2.1.002 (2008-02-12)
	 */
	protected $javascript = '';

	/**
	 * Javascript counter.
	 * @protected
	 * @since 2.1.002 (2008-02-12)
	 */
	protected $n_js;

	/**
	 * line through state
	 * @protected
	 * @since 2.8.000 (2008-03-19)
	 */
	protected $linethrough;

	/**
	 * Array with additional document-wide usage rights for the document.
	 * @protected
	 * @since 5.8.014 (2010-08-23)
	 */
	protected $ur = array();

	/**
	 * DPI (Dot Per Inch) Document Resolution (do not change).
	 * @protected
	 * @since 3.0.000 (2008-03-27)
	 */
	protected $dpi = 72;

	/**
	 * Array of page numbers were a new page group was started (the page numbers are the keys of the array).
	 * @protected
	 * @since 3.0.000 (2008-03-27)
	 */
	protected $newpagegroup = array();

	/**
	 * Array that contains the number of pages in each page group.
	 * @protected
	 * @since 3.0.000 (2008-03-27)
	 */
	protected $pagegroups = array();

	/**
	 * Current page group number.
	 * @protected
	 * @since 3.0.000 (2008-03-27)
	 */
	protected $currpagegroup = 0;

	/**
	 * Array of transparency objects and parameters.
	 * @protected
	 * @since 3.0.000 (2008-03-27)
	 */
	protected $extgstates;

	/**
	 * Set the default JPEG compression quality (1-100).
	 * @protected
	 * @since 3.0.000 (2008-03-27)
	 */
	protected $jpeg_quality;

	/**
	 * Default cell height ratio.
	 * @protected
	 * @since 3.0.014 (2008-05-23)
	 */
	protected $cell_height_ratio = K_CELL_HEIGHT_RATIO;

	/**
	 * PDF viewer preferences.
	 * @protected
	 * @since 3.1.000 (2008-06-09)
	 */
	protected $viewer_preferences;

	/**
	 * A name object specifying how the document should be displayed when opened.
	 * @protected
	 * @since 3.1.000 (2008-06-09)
	 */
	protected $PageMode;

	/**
	 * Array for storing gradient information.
	 * @protected
	 * @since 3.1.000 (2008-06-09)
	 */
	protected $gradients = array();

	/**
	 * Array used to store positions inside the pages buffer (keys are the page numbers).
	 * @protected
	 * @since 3.2.000 (2008-06-26)
	 */
	protected $intmrk = array();

	/**
	 * Array used to store positions inside the pages buffer (keys are the page numbers).
	 * @protected
	 * @since 5.7.000 (2010-08-03)
	 */
	protected $bordermrk = array();

	/**
	 * Array used to store page positions to track empty pages (keys are the page numbers).
	 * @protected
	 * @since 5.8.007 (2010-08-18)
	 */
	protected $emptypagemrk = array();

	/**
	 * Array used to store content positions inside the pages buffer (keys are the page numbers).
	 * @protected
	 * @since 4.6.021 (2009-07-20)
	 */
	protected $cntmrk = array();

	/**
	 * Array used to store footer positions of each page.
	 * @protected
	 * @since 3.2.000 (2008-07-01)
	 */
	protected $footerpos = array();

	/**
	 * Array used to store footer length of each page.
	 * @protected
	 * @since 4.0.014 (2008-07-29)
	 */
	protected $footerlen = array();

	/**
	 * Boolean flag to indicate if a new line is created.
	 * @protected
	 * @since 3.2.000 (2008-07-01)
	 */
	protected $newline = true;

	/**
	 * End position of the latest inserted line.
	 * @protected
	 * @since 3.2.000 (2008-07-01)
	 */
	protected $endlinex = 0;

	/**
	 * PDF string for width value of the last line.
	 * @protected
	 * @since 4.0.006 (2008-07-16)
	 */
	protected $linestyleWidth = '';

	/**
	 * PDF string for CAP value of the last line.
	 * @protected
	 * @since 4.0.006 (2008-07-16)
	 */
	protected $linestyleCap = '0 J';

	/**
	 * PDF string for join value of the last line.
	 * @protected
	 * @since 4.0.006 (2008-07-16)
	 */
	protected $linestyleJoin = '0 j';

	/**
	 * PDF string for dash value of the last line.
	 * @protected
	 * @since 4.0.006 (2008-07-16)
	 */
	protected $linestyleDash = '[] 0 d';

	/**
	 * Boolean flag to indicate if marked-content sequence is open.
	 * @protected
	 * @since 4.0.013 (2008-07-28)
	 */
	protected $openMarkedContent = false;

	/**
	 * Count the latest inserted vertical spaces on HTML.
	 * @protected
	 * @since 4.0.021 (2008-08-24)
	 */
	protected $htmlvspace = 0;

	/**
	 * Array of Spot colors.
	 * @protected
	 * @since 4.0.024 (2008-09-12)
	 */
	protected $spot_colors = array();

	/**
	 * Symbol used for HTML unordered list items.
	 * @protected
	 * @since 4.0.028 (2008-09-26)
	 */
	protected $lisymbol = '';

	/**
	 * String used to mark the beginning and end of EPS image blocks.
	 * @protected
	 * @since 4.1.000 (2008-10-18)
	 */
	protected $epsmarker = 'x#!#EPS#!#x';

	/**
	 * Array of transformation matrix.
	 * @protected
	 * @since 4.2.000 (2008-10-29)
	 */
	protected $transfmatrix = array();

	/**
	 * Current key for transformation matrix.
	 * @protected
	 * @since 4.8.005 (2009-09-17)
	 */
	protected $transfmatrix_key = 0;

	/**
	 * Booklet mode for double-sided pages.
	 * @protected
	 * @since 4.2.000 (2008-10-29)
	 */
	protected $booklet = false;

	/**
	 * Epsilon value used for float calculations.
	 * @protected
	 * @since 4.2.000 (2008-10-29)
	 */
	protected $feps = 0.005;

	/**
	 * Array used for custom vertical spaces for HTML tags.
	 * @protected
	 * @since 4.2.001 (2008-10-30)
	 */
	protected $tagvspaces = array();

	/**
	 * HTML PARSER: custom indent amount for lists. Negative value means disabled.
	 * @protected
	 * @since 4.2.007 (2008-11-12)
	 */
	protected $customlistindent = -1;

	/**
	 * Boolean flag to indicate if the border of the cell sides that cross the page should be removed.
	 * @protected
	 * @since 4.2.010 (2008-11-14)
	 */
	protected $opencell = true;

	/**
	 * Array of files to embedd.
	 * @protected
	 * @since 4.4.000 (2008-12-07)
	 */
	protected $embeddedfiles = array();

	/**
	 * Boolean flag to indicate if we are inside a PRE tag.
	 * @protected
	 * @since 4.4.001 (2008-12-08)
	 */
	protected $premode = false;

	/**
	 * Array used to store positions of graphics transformation blocks inside the page buffer.
	 * keys are the page numbers
	 * @protected
	 * @since 4.4.002 (2008-12-09)
	 */
	protected $transfmrk = array();

	/**
	 * Default color for html links.
	 * @protected
	 * @since 4.4.003 (2008-12-09)
	 */
	protected $htmlLinkColorArray = array(0, 0, 255);

	/**
	 * Default font style to add to html links.
	 * @protected
	 * @since 4.4.003 (2008-12-09)
	 */
	protected $htmlLinkFontStyle = 'U';

	/**
	 * Counts the number of pages.
	 * @protected
	 * @since 4.5.000 (2008-12-31)
	 */
	protected $numpages = 0;

	/**
	 * Array containing page lengths in bytes.
	 * @protected
	 * @since 4.5.000 (2008-12-31)
	 */
	protected $pagelen = array();

	/**
	 * Counts the number of pages.
	 * @protected
	 * @since 4.5.000 (2008-12-31)
	 */
	protected $numimages = 0;

	/**
	 * Store the image keys.
	 * @protected
	 * @since 4.5.000 (2008-12-31)
	 */
	protected $imagekeys = array();

	/**
	 * Length of the buffer in bytes.
	 * @protected
	 * @since 4.5.000 (2008-12-31)
	 */
	protected $bufferlen = 0;

	/**
	 * If true enables disk caching.
	 * @protected
	 * @since 4.5.000 (2008-12-31)
	 */
	protected $diskcache = false;

	/**
	 * Counts the number of fonts.
	 * @protected
	 * @since 4.5.000 (2009-01-02)
	 */
	protected $numfonts = 0;

	/**
	 * Store the font keys.
	 * @protected
	 * @since 4.5.000 (2009-01-02)
	 */
	protected $fontkeys = array();

	/**
	 * Store the font object IDs.
	 * @protected
	 * @since 4.8.001 (2009-09-09)
	 */
	protected $font_obj_ids = array();

	/**
	 * Store the fage status (true when opened, false when closed).
	 * @protected
	 * @since 4.5.000 (2009-01-02)
	 */
	protected $pageopen = array();

	/**
	 * Default monospace font.
	 * @protected
	 * @since 4.5.025 (2009-03-10)
	 */
	protected $default_monospaced_font = 'courier';

	/**
	 * Cloned copy of the current class object.
	 * @protected
	 * @since 4.5.029 (2009-03-19)
	 */
	protected $objcopy;

	/**
	 * Array used to store the lengths of cache files.
	 * @protected
	 * @since 4.5.029 (2009-03-19)
	 */
	protected $cache_file_length = array();

	/**
	 * Table header content to be repeated on each new page.
	 * @protected
	 * @since 4.5.030 (2009-03-20)
	 */
	protected $thead = '';

	/**
	 * Margins used for table header.
	 * @protected
	 * @since 4.5.030 (2009-03-20)
	 */
	protected $theadMargins = array();

	/**
	 * Boolean flag to enable document digital signature.
	 * @protected
	 * @since 4.6.005 (2009-04-24)
	 */
	protected $sign = false;

	/**
	 * Digital signature data.
	 * @protected
	 * @since 4.6.005 (2009-04-24)
	 */
	protected $signature_data = array();

	/**
	 * Digital signature max length.
	 * @protected
	 * @since 4.6.005 (2009-04-24)
	 */
	protected $signature_max_length = 11742;

	/**
	 * Data for digital signature appearance.
	 * @protected
	 * @since 5.3.011 (2010-06-16)
	 */
	protected $signature_appearance = array('page' => 1, 'rect' => '0 0 0 0');

	/**
	 * Array of empty digital signature appearances.
	 * @protected
	 * @since 5.9.101 (2011-07-06)
	 */
	protected $empty_signature_appearance = array();

	/**
	 * Regular expression used to find blank characters (required for word-wrapping).
	 * @protected
	 * @since 4.6.006 (2009-04-28)
	 */
	protected $re_spaces = '/[^\S\xa0]/';

	/**
	 * Array of $re_spaces parts.
	 * @protected
	 * @since 5.5.011 (2010-07-09)
	 */
	protected $re_space = array('p' => '[^\S\xa0]', 'm' => '');

	/**
	 * Digital signature object ID.
	 * @protected
	 * @since 4.6.022 (2009-06-23)
	 */
	protected $sig_obj_id = 0;

	/**
	 * ID of page objects.
	 * @protected
	 * @since 4.7.000 (2009-08-29)
	 */
	protected $page_obj_id = array();

	/**
	 * List of form annotations IDs.
	 * @protected
	 * @since 4.8.000 (2009-09-07)
	 */
	protected $form_obj_id = array();

	/**
	 * Deafult Javascript field properties. Possible values are described on official Javascript for Acrobat API reference. Annotation options can be directly specified using the 'aopt' entry.
	 * @protected
	 * @since 4.8.000 (2009-09-07)
	 */
	protected $default_form_prop = array('lineWidth'=>1, 'borderStyle'=>'solid', 'fillColor'=>array(255, 255, 255), 'strokeColor'=>array(128, 128, 128));

	/**
	 * Javascript objects array.
	 * @protected
	 * @since 4.8.000 (2009-09-07)
	 */
	protected $js_objects = array();

	/**
	 * Current form action (used during XHTML rendering).
	 * @protected
	 * @since 4.8.000 (2009-09-07)
	 */
	protected $form_action = '';

	/**
	 * Current form encryption type (used during XHTML rendering).
	 * @protected
	 * @since 4.8.000 (2009-09-07)
	 */
	protected $form_enctype = 'application/x-www-form-urlencoded';

	/**
	 * Current method to submit forms.
	 * @protected
	 * @since 4.8.000 (2009-09-07)
	 */
	protected $form_mode = 'post';

	/**
	 * List of fonts used on form fields (fontname => fontkey).
	 * @protected
	 * @since 4.8.001 (2009-09-09)
	 */
	protected $annotation_fonts = array();

	/**
	 * List of radio buttons parent objects.
	 * @protected
	 * @since 4.8.001 (2009-09-09)
	 */
	protected $radiobutton_groups = array();

	/**
	 * List of radio group objects IDs.
	 * @protected
	 * @since 4.8.001 (2009-09-09)
	 */
	protected $radio_groups = array();

	/**
	 * Text indentation value (used for text-indent CSS attribute).
	 * @protected
	 * @since 4.8.006 (2009-09-23)
	 */
	protected $textindent = 0;

	/**
	 * Store page number when startTransaction() is called.
	 * @protected
	 * @since 4.8.006 (2009-09-23)
	 */
	protected $start_transaction_page = 0;

	/**
	 * Store Y position when startTransaction() is called.
	 * @protected
	 * @since 4.9.001 (2010-03-28)
	 */
	protected $start_transaction_y = 0;

	/**
	 * True when we are printing the thead section on a new page.
	 * @protected
	 * @since 4.8.027 (2010-01-25)
	 */
	protected $inthead = false;

	/**
	 * Array of column measures (width, space, starting Y position).
	 * @protected
	 * @since 4.9.001 (2010-03-28)
	 */
	protected $columns = array();

	/**
	 * Number of colums.
	 * @protected
	 * @since 4.9.001 (2010-03-28)
	 */
	protected $num_columns = 1;

	/**
	 * Current column number.
	 * @protected
	 * @since 4.9.001 (2010-03-28)
	 */
	protected $current_column = 0;

	/**
	 * Starting page for columns.
	 * @protected
	 * @since 4.9.001 (2010-03-28)
	 */
	protected $column_start_page = 0;

	/**
	 * Maximum page and column selected.
	 * @protected
	 * @since 5.8.000 (2010-08-11)
	 */
	protected $maxselcol = array('page' => 0, 'column' => 0);

	/**
	 * Array of: X difference between table cell x start and starting page margin, cellspacing, cellpadding.
	 * @protected
	 * @since 5.8.000 (2010-08-11)
	 */
	protected $colxshift = array('x' => 0, 's' => array('H' => 0, 'V' => 0), 'p' => array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));

	/**
	 * Text rendering mode: 0 = Fill text; 1 = Stroke text; 2 = Fill, then stroke text; 3 = Neither fill nor stroke text (invisible); 4 = Fill text and add to path for clipping; 5 = Stroke text and add to path for clipping; 6 = Fill, then stroke text and add to path for clipping; 7 = Add text to path for clipping.
	 * @protected
	 * @since 4.9.008 (2010-04-03)
	 */
	protected $textrendermode = 0;

	/**
	 * Text stroke width in doc units.
	 * @protected
	 * @since 4.9.008 (2010-04-03)
	 */
	protected $textstrokewidth = 0;

	/**
	 * Current stroke color.
	 * @protected
	 * @since 4.9.008 (2010-04-03)
	 */
	protected $strokecolor;

	/**
	 * Default unit of measure for document.
	 * @protected
	 * @since 5.0.000 (2010-04-22)
	 */
	protected $pdfunit = 'mm';

	/**
	 * Boolean flag true when we are on TOC (Table Of Content) page.
	 * @protected
	 */
	protected $tocpage = false;

	/**
	 * Boolean flag: if true convert vector images (SVG, EPS) to raster image using GD or ImageMagick library.
	 * @protected
	 * @since 5.0.000 (2010-04-26)
	 */
	protected $rasterize_vector_images = false;

	/**
	 * Boolean flag: if true enables font subsetting by default.
	 * @protected
	 * @since 5.3.002 (2010-06-07)
	 */
	protected $font_subsetting = true;

	/**
	 * Array of default graphic settings.
	 * @protected
	 * @since 5.5.008 (2010-07-02)
	 */
	protected $default_graphic_vars = array();

	/**
	 * Array of XObjects.
	 * @protected
	 * @since 5.8.014 (2010-08-23)
	 */
	protected $xobjects = array();

	/**
	 * Boolean value true when we are inside an XObject.
	 * @protected
	 * @since 5.8.017 (2010-08-24)
	 */
	protected $inxobj = false;

	/**
	 * Current XObject ID.
	 * @protected
	 * @since 5.8.017 (2010-08-24)
	 */
	protected $xobjid = '';

	/**
	 * Percentage of character stretching.
	 * @protected
	 * @since 5.9.000 (2010-09-29)
	 */
	protected $font_stretching = 100;

	/**
	 * Increases or decreases the space between characters in a text by the specified amount (tracking).
	 * @protected
	 * @since 5.9.000 (2010-09-29)
	 */
	protected $font_spacing = 0;

	/**
	 * Array of no-write regions.
	 * ('page' => page number or empy for current page, 'xt' => X top, 'yt' => Y top, 'xb' => X bottom, 'yb' => Y bottom, 'side' => page side 'L' = left or 'R' = right)
	 * @protected
	 * @since 5.9.003 (2010-10-14)
	 */
	protected $page_regions = array();

	/**
	 * Boolean value true when page region check is active.
	 * @protected
	 */
	protected $check_page_regions = true;

	/**
	 * Array of PDF layers data.
	 * @protected
	 * @since 5.9.102 (2011-07-13)
	 */
	protected $pdflayers = array();

	/**
	 * A dictionary of names and corresponding destinations (Dests key on document Catalog).
	 * @protected
	 * @since 5.9.097 (2011-06-23)
	 */
	protected $dests = array();

	/**
	 * Object ID for Named Destinations
	 * @protected
	 * @since 5.9.097 (2011-06-23)
	 */
	protected $n_dests;

	/**
	 * Embedded Files Names
	 * @protected
	 * @since 5.9.204 (2013-01-23)
	 */
	protected $efnames = array();

	/**
	 * Directory used for the last SVG image.
	 * @protected
	 * @since 5.0.000 (2010-05-05)
	 */
	protected $svgdir = '';

	/**
	 *  Deafult unit of measure for SVG.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svgunit = 'px';

	/**
	 * Array of SVG gradients.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svggradients = array();

	/**
	 * ID of last SVG gradient.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svggradientid = 0;

	/**
	 * Boolean value true when in SVG defs group.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svgdefsmode = false;

	/**
	 * Array of SVG defs.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svgdefs = array();

	/**
	 * Boolean value true when in SVG clipPath tag.
	 * @protected
	 * @since 5.0.000 (2010-04-26)
	 */
	protected $svgclipmode = false;

	/**
	 * Array of SVG clipPath commands.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svgclippaths = array();

	/**
	 * Array of SVG clipPath tranformation matrix.
	 * @protected
	 * @since 5.8.022 (2010-08-31)
	 */
	protected $svgcliptm = array();

	/**
	 * ID of last SVG clipPath.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svgclipid = 0;

	/**
	 * SVG text.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svgtext = '';

	/**
	 * SVG text properties.
	 * @protected
	 * @since 5.8.013 (2010-08-23)
	 */
	protected $svgtextmode = array();

	/**
	 * Array of SVG properties.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svgstyles = array(array(
		'alignment-baseline' => 'auto',
		'baseline-shift' => 'baseline',
		'clip' => 'auto',
		'clip-path' => 'none',
		'clip-rule' => 'nonzero',
		'color' => 'black',
		'color-interpolation' => 'sRGB',
		'color-interpolation-filters' => 'linearRGB',
		'color-profile' => 'auto',
		'color-rendering' => 'auto',
		'cursor' => 'auto',
		'direction' => 'ltr',
		'display' => 'inline',
		'dominant-baseline' => 'auto',
		'enable-background' => 'accumulate',
		'fill' => 'black',
		'fill-opacity' => 1,
		'fill-rule' => 'nonzero',
		'filter' => 'none',
		'flood-color' => 'black',
		'flood-opacity' => 1,
		'font' => '',
		'font-family' => 'helvetica',
		'font-size' => 'medium',
		'font-size-adjust' => 'none',
		'font-stretch' => 'normal',
		'font-style' => 'normal',
		'font-variant' => 'normal',
		'font-weight' => 'normal',
		'glyph-orientation-horizontal' => '0deg',
		'glyph-orientation-vertical' => 'auto',
		'image-rendering' => 'auto',
		'kerning' => 'auto',
		'letter-spacing' => 'normal',
		'lighting-color' => 'white',
		'marker' => '',
		'marker-end' => 'none',
		'marker-mid' => 'none',
		'marker-start' => 'none',
		'mask' => 'none',
		'opacity' => 1,
		'overflow' => 'auto',
		'pointer-events' => 'visiblePainted',
		'shape-rendering' => 'auto',
		'stop-color' => 'black',
		'stop-opacity' => 1,
		'stroke' => 'none',
		'stroke-dasharray' => 'none',
		'stroke-dashoffset' => 0,
		'stroke-linecap' => 'butt',
		'stroke-linejoin' => 'miter',
		'stroke-miterlimit' => 4,
		'stroke-opacity' => 1,
		'stroke-width' => 1,
		'text-anchor' => 'start',
		'text-decoration' => 'none',
		'text-rendering' => 'auto',
		'unicode-bidi' => 'normal',
		'visibility' => 'visible',
		'word-spacing' => 'normal',
		'writing-mode' => 'lr-tb',
		'text-color' => 'black',
		'transfmatrix' => array(1, 0, 0, 1, 0, 0)
		));

	/**
	 * If true force sRGB color profile for all document.
	 * @protected
	 * @since 5.9.121 (2011-09-28)
	 */
	protected $force_srgb = false;

	/**
	 * If true set the document to PDF/A mode.
	 * @protected
	 * @since 5.9.121 (2011-09-27)
	 */
	protected $pdfa_mode = false;

	/**
	 * Document creation date-time
	 * @protected
	 * @since 5.9.152 (2012-03-22)
	 */
	protected $doc_creation_timestamp;

	/**
	 * Document modification date-time
	 * @protected
	 * @since 5.9.152 (2012-03-22)
	 */
	protected $doc_modification_timestamp;

	/**
	 * Custom XMP data.
	 * @protected
	 * @since 5.9.128 (2011-10-06)
	 */
	protected $custom_xmp = '';

	/**
	 * Overprint mode array.
	 * (Check the "Entries in a Graphics State Parameter Dictionary" on PDF 32000-1:2008).
	 * @protected
	 * @since 5.9.152 (2012-03-23)
	 */
	protected $overprint = array('OP' => false, 'op' => false, 'OPM' => 0);

	/**
	 * Alpha mode array.
	 * (Check the "Entries in a Graphics State Parameter Dictionary" on PDF 32000-1:2008).
	 * @protected
	 * @since 5.9.152 (2012-03-23)
	 */
	protected $alpha = array('CA' => 1, 'ca' => 1, 'BM' => '/Normal', 'AIS' => false);

	/**
	 * Define the page boundaries boxes to be set on document.
	 * @protected
	 * @since 5.9.152 (2012-03-23)
	 */
	protected $page_boxes = array('MediaBox', 'CropBox', 'BleedBox', 'TrimBox', 'ArtBox');

	/**
	 * If true print TCPDF meta link.
	 * @protected
	 * @since 5.9.152 (2012-03-23)
	 */
	protected $tcpdflink = true;

	/**
	 * Cache array for computed GD gamma values.
	 * @protected
	 * @since 5.9.1632 (2012-06-05)
	 */
	protected $gdgammacache = array();

	//------------------------------------------------------------
	// METHODS
	//------------------------------------------------------------

	/**
	 * This is the class constructor.
	 * It allows to set up the page format, the orientation and the measure unit used in all the methods (except for the font sizes).
	 * 
	 * IMPORTANT: Please note that this method sets the mb_internal_encoding to ASCII, so if you are using the mbstring module functions with TCPDF you need to correctly set/unset the mb_internal_encoding when needed.
	 * 
	 * @param $orientation (string) page orientation. Possible values are (case insensitive):<ul><li>P or Portrait (default)</li><li>L or Landscape</li><li>'' (empty string) for automatic orientation</li></ul>
	 * @param $unit (string) User measure unit. Possible values are:<ul><li>pt: point</li><li>mm: millimeter (default)</li><li>cm: centimeter</li><li>in: inch</li></ul><br />A point equals 1/72 of inch, that is to say about 0.35 mm (an inch being 2.54 cm). This is a very common unit in typography; font sizes are expressed in that unit.
	 * @param $format (mixed) The format used for pages. It can be either: one of the string values specified at getPageSizeFromFormat() or an array of parameters specified at setPageFormat().
	 * @param $unicode (boolean) TRUE means that the input text is unicode (default = true)
	 * @param $encoding (string) Charset encoding (used only when converting back html entities); default is UTF-8.
	 * @param $diskcache (boolean) If TRUE reduce the RAM memory usage by caching temporary data on filesystem (slower).
	 * @param $pdfa (boolean) If TRUE set the document to PDF/A mode.
	 * @public
	 * @see getPageSizeFromFormat(), setPageFormat()
	 */
	public function __construct($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false) {
		/* Set internal character encoding to ASCII */
		if (function_exists('mb_internal_encoding') AND mb_internal_encoding()) {
			$this->internal_encoding = mb_internal_encoding();
			mb_internal_encoding('ASCII');
		}
		$this->font_obj_ids = array();
		$this->page_obj_id = array();
		$this->form_obj_id = array();
		// set pdf/a mode
		$this->pdfa_mode = $pdfa;
		$this->force_srgb = false;
		// set disk caching
		$this->diskcache = $diskcache ? true : false;
		// set language direction
		$this->rtl = false;
		$this->tmprtl = false;
		// some checks
		$this->_dochecks();
		// initialization of properties
		$this->isunicode = $unicode;
		$this->page = 0;
		$this->transfmrk[0] = array();
		$this->pagedim = array();
		$this->n = 2;
		$this->buffer = '';
		$this->pages = array();
		$this->state = 0;
		$this->fonts = array();
		$this->FontFiles = array();
		$this->diffs = array();
		$this->images = array();
		$this->links = array();
		$this->gradients = array();
		$this->InFooter = false;
		$this->lasth = 0;
		$this->FontFamily = defined('PDF_FONT_NAME_MAIN')?PDF_FONT_NAME_MAIN:'helvetica';
		$this->FontStyle = '';
		$this->FontSizePt = 12;
		$this->underline = false;
		$this->overline = false;
		$this->linethrough = false;
		$this->DrawColor = '0 G';
		$this->FillColor = '0 g';
		$this->TextColor = '0 g';
		$this->ColorFlag = false;
		$this->pdflayers = array();
		// encryption values
		$this->encrypted = false;
		$this->last_enc_key = '';
		// standard Unicode fonts
		$this->CoreFonts = array(
			'courier'=>'Courier',
			'courierB'=>'Courier-Bold',
			'courierI'=>'Courier-Oblique',
			'courierBI'=>'Courier-BoldOblique',
			'helvetica'=>'Helvetica',
			'helveticaB'=>'Helvetica-Bold',
			'helveticaI'=>'Helvetica-Oblique',
			'helveticaBI'=>'Helvetica-BoldOblique',
			'times'=>'Times-Roman',
			'timesB'=>'Times-Bold',
			'timesI'=>'Times-Italic',
			'timesBI'=>'Times-BoldItalic',
			'symbol'=>'Symbol',
			'zapfdingbats'=>'ZapfDingbats'
		);
		// set scale factor
		$this->setPageUnit($unit);
		// set page format and orientation
		$this->setPageFormat($format, $orientation);
		// page margins (1 cm)
		$margin = 28.35 / $this->k;
		$this->SetMargins($margin, $margin);
		$this->clMargin = $this->lMargin;
		$this->crMargin = $this->rMargin;
		// internal cell padding
		$cpadding = $margin / 10;
		$this->setCellPaddings($cpadding, 0, $cpadding, 0);
		// cell margins
		$this->setCellMargins(0, 0, 0, 0);
		// line width (0.2 mm)
		$this->LineWidth = 0.57 / $this->k;
		$this->linestyleWidth = sprintf('%F w', ($this->LineWidth * $this->k));
		$this->linestyleCap = '0 J';
		$this->linestyleJoin = '0 j';
		$this->linestyleDash = '[] 0 d';
		// automatic page break
		$this->SetAutoPageBreak(true, (2 * $margin));
		// full width display mode
		$this->SetDisplayMode('fullwidth');
		// compression
		$this->SetCompression();
		// set default PDF version number
		$this->setPDFVersion();
		$this->tcpdflink = true;
		$this->encoding = $encoding;
		$this->HREF = array();
		$this->getFontsList();
		$this->fgcolor = array('R' => 0, 'G' => 0, 'B' => 0);
		$this->strokecolor = array('R' => 0, 'G' => 0, 'B' => 0);
		$this->bgcolor = array('R' => 255, 'G' => 255, 'B' => 255);
		$this->extgstates = array();
		$this->setTextShadow();
		// user's rights
		$this->sign = false;
		$this->ur['enabled'] = false;
		$this->ur['document'] = '/FullSave';
		$this->ur['annots'] = '/Create/Delete/Modify/Copy/Import/Export';
		$this->ur['form'] = '/Add/Delete/FillIn/Import/Export/SubmitStandalone/SpawnTemplate';
		$this->ur['signature'] = '/Modify';
		$this->ur['ef'] = '/Create/Delete/Modify/Import';
		$this->ur['formex'] = '';
		$this->signature_appearance = array('page' => 1, 'rect' => '0 0 0 0', 'name' => 'Signature');
		$this->empty_signature_appearance = array();
		// set default JPEG quality
		$this->jpeg_quality = 75;
		// initialize some settings
		TCPDF_FONTS::utf8Bidi(array(''), '', false, $this->isunicode, $this->CurrentFont);
		// set default font
		$this->SetFont($this->FontFamily, $this->FontStyle, $this->FontSizePt);
		// check if PCRE Unicode support is enabled
		if ($this->isunicode AND (@preg_match('/\pL/u', 'a') == 1)) {
			// PCRE unicode support is turned ON
			// \p{Z} or \p{Separator}: any kind of Unicode whitespace or invisible separator.
			// \p{Lo} or \p{Other_Letter}: a Unicode letter or ideograph that does not have lowercase and uppercase variants.
			// \p{Lo} is needed because Chinese characters are packed next to each other without spaces in between.
			//$this->setSpacesRE('/[^\S\P{Z}\P{Lo}\xa0]/u');
			$this->setSpacesRE('/[^\S\P{Z}\xa0]/u');
		} else {
			// PCRE unicode support is turned OFF
			$this->setSpacesRE('/[^\S\xa0]/');
		}
		$this->default_form_prop = array('lineWidth'=>1, 'borderStyle'=>'solid', 'fillColor'=>array(255, 255, 255), 'strokeColor'=>array(128, 128, 128));
		// set file ID for trailer
		$serformat = (is_array($format) ? serialize($format) : $format);
		$this->file_id = md5(TCPDF_STATIC::getRandomSeed('TCPDF'.$orientation.$unit.$serformat.$encoding));
		// set document creation and modification timestamp
		$this->doc_creation_timestamp = time();
		$this->doc_modification_timestamp = $this->doc_creation_timestamp;
		// get default graphic vars
		$this->default_graphic_vars = $this->getGraphicVars();
		$this->header_xobj_autoreset = false;
		$this->custom_xmp = '';
	}

	/**
	 * Default destructor.
	 * @public
	 * @since 1.53.0.TC016
	 */
	public function __destruct() {
		// restore internal encoding
		if (isset($this->internal_encoding) AND !empty($this->internal_encoding)) {
			mb_internal_encoding($this->internal_encoding);
		}
		// unset all class variables
		$this->_destroy(true);
	}

	/**
	 * Set the units of measure for the document.
	 * @param $unit (string) User measure unit. Possible values are:<ul><li>pt: point</li><li>mm: millimeter (default)</li><li>cm: centimeter</li><li>in: inch</li></ul><br />A point equals 1/72 of inch, that is to say about 0.35 mm (an inch being 2.54 cm). This is a very common unit in typography; font sizes are expressed in that unit.
	 * @public
	 * @since 3.0.015 (2008-06-06)
	 */
	public function setPageUnit($unit) {
		$unit = strtolower($unit);
		//Set scale factor
		switch ($unit) {
			// points
			case 'px':
			case 'pt': {
				$this->k = 1;
				break;
			}
			// millimeters
			case 'mm': {
				$this->k = $this->dpi / 25.4;
				break;
			}
			// centimeters
			case 'cm': {
				$this->k = $this->dpi / 2.54;
				break;
			}
			// inches
			case 'in': {
				$this->k = $this->dpi;
				break;
			}
			// unsupported unit
			default : {
				$this->Error('Incorrect unit: '.$unit);
				break;
			}
		}
		$this->pdfunit = $unit;
		if (isset($this->CurOrientation)) {
			$this->setPageOrientation($this->CurOrientation);
		}
	}

	/**
	 * Change the format of the current page
	 * @param $format (mixed) The format used for pages. It can be either: one of the string values specified at getPageSizeFromFormat() documentation or an array of two numners (width, height) or an array containing the following measures and options:<ul>
	 * <li>['format'] = page format name (one of the above);</li>
	 * <li>['Rotate'] : The number of degrees by which the page shall be rotated clockwise when displayed or printed. The value shall be a multiple of 90.</li>
	 * <li>['PZ'] : The page's preferred zoom (magnification) factor.</li>
	 * <li>['MediaBox'] : the boundaries of the physical medium on which the page shall be displayed or printed:</li>
	 * <li>['MediaBox']['llx'] : lower-left x coordinate in points</li>
	 * <li>['MediaBox']['lly'] : lower-left y coordinate in points</li>
	 * <li>['MediaBox']['urx'] : upper-right x coordinate in points</li>
	 * <li>['MediaBox']['ury'] : upper-right y coordinate in points</li>
	 * <li>['CropBox'] : the visible region of default user space:</li>
	 * <li>['CropBox']['llx'] : lower-left x coordinate in points</li>
	 * <li>['CropBox']['lly'] : lower-left y coordinate in points</li>
	 * <li>['CropBox']['urx'] : upper-right x coordinate in points</li>
	 * <li>['CropBox']['ury'] : upper-right y coordinate in points</li>
	 * <li>['BleedBox'] : the region to which the contents of the page shall be clipped when output in a production environment:</li>
	 * <li>['BleedBox']['llx'] : lower-left x coordinate in points</li>
	 * <li>['BleedBox']['lly'] : lower-left y coordinate in points</li>
	 * <li>['BleedBox']['urx'] : upper-right x coordinate in points</li>
	 * <li>['BleedBox']['ury'] : upper-right y coordinate in points</li>
	 * <li>['TrimBox'] : the intended dimensions of the finished page after trimming:</li>
	 * <li>['TrimBox']['llx'] : lower-left x coordinate in points</li>
	 * <li>['TrimBox']['lly'] : lower-left y coordinate in points</li>
	 * <li>['TrimBox']['urx'] : upper-right x coordinate in points</li>
	 * <li>['TrimBox']['ury'] : upper-right y coordinate in points</li>
	 * <li>['ArtBox'] : the extent of the page's meaningful content:</li>
	 * <li>['ArtBox']['llx'] : lower-left x coordinate in points</li>
	 * <li>['ArtBox']['lly'] : lower-left y coordinate in points</li>
	 * <li>['ArtBox']['urx'] : upper-right x coordinate in points</li>
	 * <li>['ArtBox']['ury'] : upper-right y coordinate in points</li>
	 * <li>['BoxColorInfo'] :specify the colours and other visual characteristics that should be used in displaying guidelines on the screen for each of the possible page boundaries other than the MediaBox:</li>
	 * <li>['BoxColorInfo'][BOXTYPE]['C'] : an array of three numbers in the range 0-255, representing the components in the DeviceRGB colour space.</li>
	 * <li>['BoxColorInfo'][BOXTYPE]['W'] : the guideline width in default user units</li>
	 * <li>['BoxColorInfo'][BOXTYPE]['S'] : the guideline style: S = Solid; D = Dashed</li>
	 * <li>['BoxColorInfo'][BOXTYPE]['D'] : dash array defining a pattern of dashes and gaps to be used in drawing dashed guidelines</li>
	 * <li>['trans'] : the style and duration of the visual transition to use when moving from another page to the given page during a presentation</li>
	 * <li>['trans']['Dur'] : The page's display duration (also called its advance timing): the maximum length of time, in seconds, that the page shall be displayed during presentations before the viewer application shall automatically advance to the next page.</li>
	 * <li>['trans']['S'] : transition style : Split, Blinds, Box, Wipe, Dissolve, Glitter, R, Fly, Push, Cover, Uncover, Fade</li>
	 * <li>['trans']['D'] : The duration of the transition effect, in seconds.</li>
	 * <li>['trans']['Dm'] : (Split and Blinds transition styles only) The dimension in which the specified transition effect shall occur: H = Horizontal, V = Vertical. Default value: H.</li>
	 * <li>['trans']['M'] : (Split, Box and Fly transition styles only) The direction of motion for the specified transition effect: I = Inward from the edges of the page, O = Outward from the center of the pageDefault value: I.</li>
	 * <li>['trans']['Di'] : (Wipe, Glitter, Fly, Cover, Uncover and Push transition styles only) The direction in which the specified transition effect shall moves, expressed in degrees counterclockwise starting from a left-to-right direction. If the value is a number, it shall be one of: 0 = Left to right, 90 = Bottom to top (Wipe only), 180 = Right to left (Wipe only), 270 = Top to bottom, 315 = Top-left to bottom-right (Glitter only). If the value is a name, it shall be None, which is relevant only for the Fly transition when the value of SS is not 1.0. Default value: 0.</li>
	 * <li>['trans']['SS'] : (Fly transition style only) The starting or ending scale at which the changes shall be drawn. If M specifies an inward transition, the scale of the changes drawn shall progress from SS to 1.0 over the course of the transition. If M specifies an outward transition, the scale of the changes drawn shall progress from 1.0 to SS over the course of the transition. Default: 1.0.</li>
	 * <li>['trans']['B'] : (Fly transition style only) If true, the area that shall be flown in is rectangular and opaque. Default: false.</li>
	 * </ul>
	 * @param $orientation (string) page orientation. Possible values are (case insensitive):<ul>
	 * <li>P or Portrait (default)</li>
	 * <li>L or Landscape</li>
	 * <li>'' (empty string) for automatic orientation</li>
	 * </ul>
	 * @protected
	 * @since 3.0.015 (2008-06-06)
	 * @see getPageSizeFromFormat()
	 */
	protected function setPageFormat($format, $orientation='P') {
		if (!empty($format) AND isset($this->pagedim[$this->page])) {
			// remove inherited values
			unset($this->pagedim[$this->page]);
		}
		if (is_string($format)) {
			// get page measures from format name
			$pf = TCPDF_STATIC::getPageSizeFromFormat($format);
			$this->fwPt = $pf[0];
			$this->fhPt = $pf[1];
		} else {
			// the boundaries of the physical medium on which the page shall be displayed or printed
			if (isset($format['MediaBox'])) {
				$this->pagedim = TCPDF_STATIC::setPageBoxes($this->page, 'MediaBox', $format['MediaBox']['llx'], $format['MediaBox']['lly'], $format['MediaBox']['urx'], $format['MediaBox']['ury'], false, $this->k, $this->pagedim);
				$this->fwPt = (($format['MediaBox']['urx'] - $format['MediaBox']['llx']) * $this->k);
				$this->fhPt = (($format['MediaBox']['ury'] - $format['MediaBox']['lly']) * $this->k);
			} else {
				if (isset($format[0]) AND is_numeric($format[0]) AND isset($format[1]) AND is_numeric($format[1])) {
					$pf = array(($format[0] * $this->k), ($format[1] * $this->k));
				} else {
					if (!isset($format['format'])) {
						// default value
						$format['format'] = 'A4';
					}
					$pf = TCPDF_STATIC::getPageSizeFromFormat($format['format']);
				}
				$this->fwPt = $pf[0];
				$this->fhPt = $pf[1];
				$this->pagedim = TCPDF_STATIC::setPageBoxes($this->page, 'MediaBox', 0, 0, $this->fwPt, $this->fhPt, true, $this->k, $this->pagedim);
			}
			// the visible region of default user space
			if (isset($format['CropBox'])) {
				$this->pagedim = TCPDF_STATIC::setPageBoxes($this->page, 'CropBox', $format['CropBox']['llx'], $format['CropBox']['lly'], $format['CropBox']['urx'], $format['CropBox']['ury'], false, $this->k, $this->pagedim);
			}
			// the region to which the contents of the page shall be clipped when output in a production environment
			if (isset($format['BleedBox'])) {
				$this->pagedim = TCPDF_STATIC::setPageBoxes($this->page, 'BleedBox', $format['BleedBox']['llx'], $format['BleedBox']['lly'], $format['BleedBox']['urx'], $format['BleedBox']['ury'], false, $this->k, $this->pagedim);
			}
			// the intended dimensions of the finished page after trimming
			if (isset($format['TrimBox'])) {
				$this->pagedim = TCPDF_STATIC::setPageBoxes($this->page, 'TrimBox', $format['TrimBox']['llx'], $format['TrimBox']['lly'], $format['TrimBox']['urx'], $format['TrimBox']['ury'], false, $this->k, $this->pagedim);
			}
			// the page's meaningful content (including potential white space)
			if (isset($format['ArtBox'])) {
				$this->pagedim = TCPDF_STATIC::setPageBoxes($this->page, 'ArtBox', $format['ArtBox']['llx'], $format['ArtBox']['lly'], $format['ArtBox']['urx'], $format['ArtBox']['ury'], false, $this->k, $this->pagedim);
			}
			// specify the colours and other visual characteristics that should be used in displaying guidelines on the screen for the various page boundaries
			if (isset($format['BoxColorInfo'])) {
				$this->pagedim[$this->page]['BoxColorInfo'] = $format['BoxColorInfo'];
			}
			if (isset($format['Rotate']) AND (($format['Rotate'] % 90) == 0)) {
				// The number of degrees by which the page shall be rotated clockwise when displayed or printed. The value shall be a multiple of 90.
				$this->pagedim[$this->page]['Rotate'] = intval($format['Rotate']);
			}
			if (isset($format['PZ'])) {
				// The page's preferred zoom (magnification) factor
				$this->pagedim[$this->page]['PZ'] = floatval($format['PZ']);
			}
			if (isset($format['trans'])) {
				// The style and duration of the visual transition to use when moving from another page to the given page during a presentation
				if (isset($format['trans']['Dur'])) {
					// The page's display duration
					$this->pagedim[$this->page]['trans']['Dur'] = floatval($format['trans']['Dur']);
				}
				$stansition_styles = array('Split', 'Blinds', 'Box', 'Wipe', 'Dissolve', 'Glitter', 'R', 'Fly', 'Push', 'Cover', 'Uncover', 'Fade');
				if (isset($format['trans']['S']) AND in_array($format['trans']['S'], $stansition_styles)) {
					// The transition style that shall be used when moving to this page from another during a presentation
					$this->pagedim[$this->page]['trans']['S'] = $format['trans']['S'];
					$valid_effect = array('Split', 'Blinds');
					$valid_vals = array('H', 'V');
					if (isset($format['trans']['Dm']) AND in_array($format['trans']['S'], $valid_effect) AND in_array($format['trans']['Dm'], $valid_vals)) {
						$this->pagedim[$this->page]['trans']['Dm'] = $format['trans']['Dm'];
					}
					$valid_effect = array('Split', 'Box', 'Fly');
					$valid_vals = array('I', 'O');
					if (isset($format['trans']['M']) AND in_array($format['trans']['S'], $valid_effect) AND in_array($format['trans']['M'], $valid_vals)) {
						$this->pagedim[$this->page]['trans']['M'] = $format['trans']['M'];
					}
					$valid_effect = array('Wipe', 'Glitter', 'Fly', 'Cover', 'Uncover', 'Push');
					if (isset($format['trans']['Di']) AND in_array($format['trans']['S'], $valid_effect)) {
						if (((($format['trans']['Di'] == 90) OR ($format['trans']['Di'] == 180)) AND ($format['trans']['S'] == 'Wipe'))
							OR (($format['trans']['Di'] == 315) AND ($format['trans']['S'] == 'Glitter'))
							OR (($format['trans']['Di'] == 0) OR ($format['trans']['Di'] == 270))) {
							$this->pagedim[$this->page]['trans']['Di'] = intval($format['trans']['Di']);
						}
					}
					if (isset($format['trans']['SS']) AND ($format['trans']['S'] == 'Fly')) {
						$this->pagedim[$this->page]['trans']['SS'] = floatval($format['trans']['SS']);
					}
					if (isset($format['trans']['B']) AND ($format['trans']['B'] === true) AND ($format['trans']['S'] == 'Fly')) {
						$this->pagedim[$this->page]['trans']['B'] = 'true';
					}
				} else {
					$this->pagedim[$this->page]['trans']['S'] = 'R';
				}
				if (isset($format['trans']['D'])) {
					// The duration of the transition effect, in seconds
					$this->pagedim[$this->page]['trans']['D'] = floatval($format['trans']['D']);
				} else {
					$this->pagedim[$this->page]['trans']['D'] = 1;
				}
			}
		}
		$this->setPageOrientation($orientation);
	}

	/**
	 * Set page orientation.
	 * @param $orientation (string) page orientation. Possible values are (case insensitive):<ul><li>P or Portrait (default)</li><li>L or Landscape</li><li>'' (empty string) for automatic orientation</li></ul>
	 * @param $autopagebreak (boolean) Boolean indicating if auto-page-break mode should be on or off.
	 * @param $bottommargin (float) bottom margin of the page.
	 * @public
	 * @since 3.0.015 (2008-06-06)
	 */
	public function setPageOrientation($orientation, $autopagebreak='', $bottommargin='') {
		if (!isset($this->pagedim[$this->page]['MediaBox'])) {
			// the boundaries of the physical medium on which the page shall be displayed or printed
			$this->pagedim = TCPDF_STATIC::setPageBoxes($this->page, 'MediaBox', 0, 0, $this->fwPt, $this->fhPt, true, $this->k, $this->pagedim);
		}
		if (!isset($this->pagedim[$this->page]['CropBox'])) {
			// the visible region of default user space
			$this->pagedim = TCPDF_STATIC::setPageBoxes($this->page, 'CropBox', $this->pagedim[$this->page]['MediaBox']['llx'], $this->pagedim[$this->page]['MediaBox']['lly'], $this->pagedim[$this->page]['MediaBox']['urx'], $this->pagedim[$this->page]['MediaBox']['ury'], true, $this->k, $this->pagedim);
		}
		if (!isset($this->pagedim[$this->page]['BleedBox'])) {
			// the region to which the contents of the page shall be clipped when output in a production environment
			$this->pagedim = TCPDF_STATIC::setPageBoxes($this->page, 'BleedBox', $this->pagedim[$this->page]['CropBox']['llx'], $this->pagedim[$this->page]['CropBox']['lly'], $this->pagedim[$this->page]['CropBox']['urx'], $this->pagedim[$this->page]['CropBox']['ury'], true, $this->k, $this->pagedim);
		}
		if (!isset($this->pagedim[$this->page]['TrimBox'])) {
			// the intended dimensions of the finished page after trimming
			$this->pagedim = TCPDF_STATIC::setPageBoxes($this->page, 'TrimBox', $this->pagedim[$this->page]['CropBox']['llx'], $this->pagedim[$this->page]['CropBox']['lly'], $this->pagedim[$this->page]['CropBox']['urx'], $this->pagedim[$this->page]['CropBox']['ury'], true, $this->k, $this->pagedim);
		}
		if (!isset($this->pagedim[$this->page]['ArtBox'])) {
			// the page's meaningful content (including potential white space)
			$this->pagedim = TCPDF_STATIC::setPageBoxes($this->page, 'ArtBox', $this->pagedim[$this->page]['CropBox']['llx'], $this->pagedim[$this->page]['CropBox']['lly'], $this->pagedim[$this->page]['CropBox']['urx'], $this->pagedim[$this->page]['CropBox']['ury'], true, $this->k, $this->pagedim);
		}
		if (!isset($this->pagedim[$this->page]['Rotate'])) {
			// The number of degrees by which the page shall be rotated clockwise when displayed or printed. The value shall be a multiple of 90.
			$this->pagedim[$this->page]['Rotate'] = 0;
		}
		if (!isset($this->pagedim[$this->page]['PZ'])) {
			// The page's preferred zoom (magnification) factor
			$this->pagedim[$this->page]['PZ'] = 1;
		}
		if ($this->fwPt > $this->fhPt) {
			// landscape
			$default_orientation = 'L';
		} else {
			// portrait
			$default_orientation = 'P';
		}
		$valid_orientations = array('P', 'L');
		if (empty($orientation)) {
			$orientation = $default_orientation;
		} else {
			$orientation = strtoupper($orientation{0});
		}
		if (in_array($orientation, $valid_orientations) AND ($orientation != $default_orientation)) {
			$this->CurOrientation = $orientation;
			$this->wPt = $this->fhPt;
			$this->hPt = $this->fwPt;
		} else {
			$this->CurOrientation = $default_orientation;
			$this->wPt = $this->fwPt;
			$this->hPt = $this->fhPt;
		}
		if ((abs($this->pagedim[$this->page]['MediaBox']['urx'] - $this->hPt) < $this->feps) AND (abs($this->pagedim[$this->page]['MediaBox']['ury'] - $this->wPt) < $this->feps)){
			// swap X and Y coordinates (change page orientation)
			$this->pagedim = TCPDF_STATIC::swapPageBoxCoordinates($this->page, $this->pagedim);
		}
		$this->w = ($this->wPt / $this->k);
		$this->h = ($this->hPt / $this->k);
		if (TCPDF_STATIC::empty_string($autopagebreak)) {
			if (isset($this->AutoPageBreak)) {
				$autopagebreak = $this->AutoPageBreak;
			} else {
				$autopagebreak = true;
			}
		}
		if (TCPDF_STATIC::empty_string($bottommargin)) {
			if (isset($this->bMargin)) {
				$bottommargin = $this->bMargin;
			} else {
				// default value = 2 cm
				$bottommargin = 2 * 28.35 / $this->k;
			}
		}
		$this->SetAutoPageBreak($autopagebreak, $bottommargin);
		// store page dimensions
		$this->pagedim[$this->page]['w'] = $this->wPt;
		$this->pagedim[$this->page]['h'] = $this->hPt;
		$this->pagedim[$this->page]['wk'] = $this->w;
		$this->pagedim[$this->page]['hk'] = $this->h;
		$this->pagedim[$this->page]['tm'] = $this->tMargin;
		$this->pagedim[$this->page]['bm'] = $bottommargin;
		$this->pagedim[$this->page]['lm'] = $this->lMargin;
		$this->pagedim[$this->page]['rm'] = $this->rMargin;
		$this->pagedim[$this->page]['pb'] = $autopagebreak;
		$this->pagedim[$this->page]['or'] = $this->CurOrientation;
		$this->pagedim[$this->page]['olm'] = $this->original_lMargin;
		$this->pagedim[$this->page]['orm'] = $this->original_rMargin;
	}

	/**
	 * Set regular expression to detect withespaces or word separators.
	 * The pattern delimiter must be the forward-slash character "/".
	 * Some example patterns are:
	 * <pre>
	 * Non-Unicode or missing PCRE unicode support: "/[^\S\xa0]/"
	 * Unicode and PCRE unicode support: "/[^\S\P{Z}\xa0]/u"
	 * Unicode and PCRE unicode support in Chinese mode: "/[^\S\P{Z}\P{Lo}\xa0]/u"
	 * if PCRE unicode support is turned ON ("\P" is the negate class of "\p"):
	 * "\p{Z}" or "\p{Separator}": any kind of Unicode whitespace or invisible separator.
	 * "\p{Lo}" or "\p{Other_Letter}": a Unicode letter or ideograph that does not have lowercase and uppercase variants.
	 * "\p{Lo}" is needed for Chinese characters because are packed next to each other without spaces in between.
	 * </pre>
	 * @param $re (string) regular expression (leave empty for default).
	 * @public
	 * @since 4.6.016 (2009-06-15)
	 */
	public function setSpacesRE($re='/[^\S\xa0]/') {
		$this->re_spaces = $re;
		$re_parts = explode('/', $re);
		// get pattern parts
		$this->re_space = array();
		if (isset($re_parts[1]) AND !empty($re_parts[1])) {
			$this->re_space['p'] = $re_parts[1];
		} else {
			$this->re_space['p'] = '[\s]';
		}
		// set pattern modifiers
		if (isset($re_parts[2]) AND !empty($re_parts[2])) {
			$this->re_space['m'] = $re_parts[2];
		} else {
			$this->re_space['m'] = '';
		}
	}

	/**
	 * Enable or disable Right-To-Left language mode
	 * @param $enable (Boolean) if true enable Right-To-Left language mode.
	 * @param $resetx (Boolean) if true reset the X position on direction change.
	 * @public
	 * @since 2.0.000 (2008-01-03)
	 */
	public function setRTL($enable, $resetx=true) {
		$enable = $enable ? true : false;
		$resetx = ($resetx AND ($enable != $this->rtl));
		$this->rtl = $enable;
		$this->tmprtl = false;
		if ($resetx) {
			$this->Ln(0);
		}
	}

	/**
	 * Return the RTL status
	 * @return boolean
	 * @public
	 * @since 4.0.012 (2008-07-24)
	 */
	public function getRTL() {
		return $this->rtl;
	}

	/**
	 * Force temporary RTL language direction
	 * @param $mode (mixed) can be false, 'L' for LTR or 'R' for RTL
	 * @public
	 * @since 2.1.000 (2008-01-09)
	 */
	public function setTempRTL($mode) {
		$newmode = false;
		switch (strtoupper($mode)) {
			case 'LTR':
			case 'L': {
				if ($this->rtl) {
					$newmode = 'L';
				}
				break;
			}
			case 'RTL':
			case 'R': {
				if (!$this->rtl) {
					$newmode = 'R';
				}
				break;
			}
			case false:
			default: {
				$newmode = false;
				break;
			}
		}
		$this->tmprtl = $newmode;
	}

	/**
	 * Return the current temporary RTL status
	 * @return boolean
	 * @public
	 * @since 4.8.014 (2009-11-04)
	 */
	public function isRTLTextDir() {
		return ($this->rtl OR ($this->tmprtl == 'R'));
	}

	/**
	 * Set the last cell height.
	 * @param $h (float) cell height.
	 * @author Nicola Asuni
	 * @public
	 * @since 1.53.0.TC034
	 */
	public function setLastH($h) {
		$this->lasth = $h;
	}

	/**
	 * Reset the last cell height.
	 * @public
	 * @since 5.9.000 (2010-10-03)
	 */
	public function resetLastH() {
		$this->lasth = ($this->FontSize * $this->cell_height_ratio) + $this->cell_padding['T'] + $this->cell_padding['B'];
	}

	/**
	 * Get the last cell height.
	 * @return last cell height
	 * @public
	 * @since 4.0.017 (2008-08-05)
	 */
	public function getLastH() {
		return $this->lasth;
	}

	/**
	 * Set the adjusting factor to convert pixels to user units.
	 * @param $scale (float) adjusting factor to convert pixels to user units.
	 * @author Nicola Asuni
	 * @public
	 * @since 1.5.2
	 */
	public function setImageScale($scale) {
		$this->imgscale = $scale;
	}

	/**
	 * Returns the adjusting factor to convert pixels to user units.
	 * @return float adjusting factor to convert pixels to user units.
	 * @author Nicola Asuni
	 * @public
	 * @since 1.5.2
	 */
	public function getImageScale() {
		return $this->imgscale;
	}

	/**
	 * Returns an array of page dimensions:
	 * <ul><li>$this->pagedim[$this->page]['w'] = page width in points</li><li>$this->pagedim[$this->page]['h'] = height in points</li><li>$this->pagedim[$this->page]['wk'] = page width in user units</li><li>$this->pagedim[$this->page]['hk'] = page height in user units</li><li>$this->pagedim[$this->page]['tm'] = top margin</li><li>$this->pagedim[$this->page]['bm'] = bottom margin</li><li>$this->pagedim[$this->page]['lm'] = left margin</li><li>$this->pagedim[$this->page]['rm'] = right margin</li><li>$this->pagedim[$this->page]['pb'] = auto page break</li><li>$this->pagedim[$this->page]['or'] = page orientation</li><li>$this->pagedim[$this->page]['olm'] = original left margin</li><li>$this->pagedim[$this->page]['orm'] = original right margin</li><li>$this->pagedim[$this->page]['Rotate'] = The number of degrees by which the page shall be rotated clockwise when displayed or printed. The value shall be a multiple of 90.</li><li>$this->pagedim[$this->page]['PZ'] = The page's preferred zoom (magnification) factor.</li><li>$this->pagedim[$this->page]['trans'] : the style and duration of the visual transition to use when moving from another page to the given page during a presentation<ul><li>$this->pagedim[$this->page]['trans']['Dur'] = The page's display duration (also called its advance timing): the maximum length of time, in seconds, that the page shall be displayed during presentations before the viewer application shall automatically advance to the next page.</li><li>$this->pagedim[$this->page]['trans']['S'] = transition style : Split, Blinds, Box, Wipe, Dissolve, Glitter, R, Fly, Push, Cover, Uncover, Fade</li><li>$this->pagedim[$this->page]['trans']['D'] = The duration of the transition effect, in seconds.</li><li>$this->pagedim[$this->page]['trans']['Dm'] = (Split and Blinds transition styles only) The dimension in which the specified transition effect shall occur: H = Horizontal, V = Vertical. Default value: H.</li><li>$this->pagedim[$this->page]['trans']['M'] = (Split, Box and Fly transition styles only) The direction of motion for the specified transition effect: I = Inward from the edges of the page, O = Outward from the center of the pageDefault value: I.</li><li>$this->pagedim[$this->page]['trans']['Di'] = (Wipe, Glitter, Fly, Cover, Uncover and Push transition styles only) The direction in which the specified transition effect shall moves, expressed in degrees counterclockwise starting from a left-to-right direction. If the value is a number, it shall be one of: 0 = Left to right, 90 = Bottom to top (Wipe only), 180 = Right to left (Wipe only), 270 = Top to bottom, 315 = Top-left to bottom-right (Glitter only). If the value is a name, it shall be None, which is relevant only for the Fly transition when the value of SS is not 1.0. Default value: 0.</li><li>$this->pagedim[$this->page]['trans']['SS'] = (Fly transition style only) The starting or ending scale at which the changes shall be drawn. If M specifies an inward transition, the scale of the changes drawn shall progress from SS to 1.0 over the course of the transition. If M specifies an outward transition, the scale of the changes drawn shall progress from 1.0 to SS over the course of the transition. Default: 1.0. </li><li>$this->pagedim[$this->page]['trans']['B'] = (Fly transition style only) If true, the area that shall be flown in is rectangular and opaque. Default: false.</li></ul></li><li>$this->pagedim[$this->page]['MediaBox'] : the boundaries of the physical medium on which the page shall be displayed or printed<ul><li>$this->pagedim[$this->page]['MediaBox']['llx'] = lower-left x coordinate in points</li><li>$this->pagedim[$this->page]['MediaBox']['lly'] = lower-left y coordinate in points</li><li>$this->pagedim[$this->page]['MediaBox']['urx'] = upper-right x coordinate in points</li><li>$this->pagedim[$this->page]['MediaBox']['ury'] = upper-right y coordinate in points</li></ul></li><li>$this->pagedim[$this->page]['CropBox'] : the visible region of default user space<ul><li>$this->pagedim[$this->page]['CropBox']['llx'] = lower-left x coordinate in points</li><li>$this->pagedim[$this->page]['CropBox']['lly'] = lower-left y coordinate in points</li><li>$this->pagedim[$this->page]['CropBox']['urx'] = upper-right x coordinate in points</li><li>$this->pagedim[$this->page]['CropBox']['ury'] = upper-right y coordinate in points</li></ul></li><li>$this->pagedim[$this->page]['BleedBox'] : the region to which the contents of the page shall be clipped when output in a production environment<ul><li>$this->pagedim[$this->page]['BleedBox']['llx'] = lower-left x coordinate in points</li><li>$this->pagedim[$this->page]['BleedBox']['lly'] = lower-left y coordinate in points</li><li>$this->pagedim[$this->page]['BleedBox']['urx'] = upper-right x coordinate in points</li><li>$this->pagedim[$this->page]['BleedBox']['ury'] = upper-right y coordinate in points</li></ul></li><li>$this->pagedim[$this->page]['TrimBox'] : the intended dimensions of the finished page after trimming<ul><li>$this->pagedim[$this->page]['TrimBox']['llx'] = lower-left x coordinate in points</li><li>$this->pagedim[$this->page]['TrimBox']['lly'] = lower-left y coordinate in points</li><li>$this->pagedim[$this->page]['TrimBox']['urx'] = upper-right x coordinate in points</li><li>$this->pagedim[$this->page]['TrimBox']['ury'] = upper-right y coordinate in points</li></ul></li><li>$this->pagedim[$this->page]['ArtBox'] : the extent of the page's meaningful content<ul><li>$this->pagedim[$this->page]['ArtBox']['llx'] = lower-left x coordinate in points</li><li>$this->pagedim[$this->page]['ArtBox']['lly'] = lower-left y coordinate in points</li><li>$this->pagedim[$this->page]['ArtBox']['urx'] = upper-right x coordinate in points</li><li>$this->pagedim[$this->page]['ArtBox']['ury'] = upper-right y coordinate in points</li></ul></li></ul>
	 * @param $pagenum (int) page number (empty = current page)
	 * @return array of page dimensions.
	 * @author Nicola Asuni
	 * @public
	 * @since 4.5.027 (2009-03-16)
	 */
	public function getPageDimensions($pagenum='') {
		if (empty($pagenum)) {
			$pagenum = $this->page;
		}
		return $this->pagedim[$pagenum];
	}

	/**
	 * Returns the page width in units.
	 * @param $pagenum (int) page number (empty = current page)
	 * @return int page width.
	 * @author Nicola Asuni
	 * @public
	 * @since 1.5.2
	 * @see getPageDimensions()
	 */
	public function getPageWidth($pagenum='') {
		if (empty($pagenum)) {
			return $this->w;
		}
		return $this->pagedim[$pagenum]['w'];
	}

	/**
	 * Returns the page height in units.
	 * @param $pagenum (int) page number (empty = current page)
	 * @return int page height.
	 * @author Nicola Asuni
	 * @public
	 * @since 1.5.2
	 * @see getPageDimensions()
	 */
	public function getPageHeight($pagenum='') {
		if (empty($pagenum)) {
			return $this->h;
		}
		return $this->pagedim[$pagenum]['h'];
	}

	/**
	 * Returns the page break margin.
	 * @param $pagenum (int) page number (empty = current page)
	 * @return int page break margin.
	 * @author Nicola Asuni
	 * @public
	 * @since 1.5.2
	 * @see getPageDimensions()
	 */
	public function getBreakMargin($pagenum='') {
		if (empty($pagenum)) {
			return $this->bMargin;
		}
		return $this->pagedim[$pagenum]['bm'];
	}

	/**
	 * Returns the scale factor (number of points in user unit).
	 * @return int scale factor.
	 * @author Nicola Asuni
	 * @public
	 * @since 1.5.2
	 */
	public function getScaleFactor() {
		return $this->k;
	}

	/**
	 * Defines the left, top and right margins.
	 * @param $left (float) Left margin.
	 * @param $top (float) Top margin.
	 * @param $right (float) Right margin. Default value is the left one.
	 * @param $keepmargins (boolean) if true overwrites the default page margins
	 * @public
	 * @since 1.0
	 * @see SetLeftMargin(), SetTopMargin(), SetRightMargin(), SetAutoPageBreak()
	 */
	public function SetMargins($left, $top, $right=-1, $keepmargins=false) {
		//Set left, top and right margins
		$this->lMargin = $left;
		$this->tMargin = $top;
		if ($right == -1) {
			$right = $left;
		}
		$this->rMargin = $right;
		if ($keepmargins) {
			// overwrite original values
			$this->original_lMargin = $this->lMargin;
			$this->original_rMargin = $this->rMargin;
		}
	}

	/**
	 * Defines the left margin. The method can be called before creating the first page. If the current abscissa gets out of page, it is brought back to the margin.
	 * @param $margin (float) The margin.
	 * @public
	 * @since 1.4
	 * @see SetTopMargin(), SetRightMargin(), SetAutoPageBreak(), SetMargins()
	 */
	public function SetLeftMargin($margin) {
		//Set left margin
		$this->lMargin = $margin;
		if (($this->page > 0) AND ($this->x < $margin)) {
			$this->x = $margin;
		}
	}

	/**
	 * Defines the top margin. The method can be called before creating the first page.
	 * @param $margin (float) The margin.
	 * @public
	 * @since 1.5
	 * @see SetLeftMargin(), SetRightMargin(), SetAutoPageBreak(), SetMargins()
	 */
	public function SetTopMargin($margin) {
		//Set top margin
		$this->tMargin = $margin;
		if (($this->page > 0) AND ($this->y < $margin)) {
			$this->y = $margin;
		}
	}

	/**
	 * Defines the right margin. The method can be called before creating the first page.
	 * @param $margin (float) The margin.
	 * @public
	 * @since 1.5
	 * @see SetLeftMargin(), SetTopMargin(), SetAutoPageBreak(), SetMargins()
	 */
	public function SetRightMargin($margin) {
		$this->rMargin = $margin;
		if (($this->page > 0) AND ($this->x > ($this->w - $margin))) {
			$this->x = $this->w - $margin;
		}
	}

	/**
	 * Set the same internal Cell padding for top, right, bottom, left-
	 * @param $pad (float) internal padding.
	 * @public
	 * @since 2.1.000 (2008-01-09)
	 * @see getCellPaddings(), setCellPaddings()
	 */
	public function SetCellPadding($pad) {
		if ($pad >= 0) {
			$this->cell_padding['L'] = $pad;
			$this->cell_padding['T'] = $pad;
			$this->cell_padding['R'] = $pad;
			$this->cell_padding['B'] = $pad;
		}
	}

	/**
	 * Set the internal Cell paddings.
	 * @param $left (float) left padding
	 * @param $top (float) top padding
	 * @param $right (float) right padding
	 * @param $bottom (float) bottom padding
	 * @public
	 * @since 5.9.000 (2010-10-03)
	 * @see getCellPaddings(), SetCellPadding()
	 */
	public function setCellPaddings($left='', $top='', $right='', $bottom='') {
		if (($left !== '') AND ($left >= 0)) {
			$this->cell_padding['L'] = $left;
		}
		if (($top !== '') AND ($top >= 0)) {
			$this->cell_padding['T'] = $top;
		}
		if (($right !== '') AND ($right >= 0)) {
			$this->cell_padding['R'] = $right;
		}
		if (($bottom !== '') AND ($bottom >= 0)) {
			$this->cell_padding['B'] = $bottom;
		}
	}

	/**
	 * Get the internal Cell padding array.
	 * @return array of padding values
	 * @public
	 * @since 5.9.000 (2010-10-03)
	 * @see setCellPaddings(), SetCellPadding()
	 */
	public function getCellPaddings() {
		return $this->cell_padding;
	}

	/**
	 * Set the internal Cell margins.
	 * @param $left (float) left margin
	 * @param $top (float) top margin
	 * @param $right (float) right margin
	 * @param $bottom (float) bottom margin
	 * @public
	 * @since 5.9.000 (2010-10-03)
	 * @see getCellMargins()
	 */
	public function setCellMargins($left='', $top='', $right='', $bottom='') {
		if (($left !== '') AND ($left >= 0)) {
			$this->cell_margin['L'] = $left;
		}
		if (($top !== '') AND ($top >= 0)) {
			$this->cell_margin['T'] = $top;
		}
		if (($right !== '') AND ($right >= 0)) {
			$this->cell_margin['R'] = $right;
		}
		if (($bottom !== '') AND ($bottom >= 0)) {
			$this->cell_margin['B'] = $bottom;
		}
	}

	/**
	 * Get the internal Cell margin array.
	 * @return array of margin values
	 * @public
	 * @since 5.9.000 (2010-10-03)
	 * @see setCellMargins()
	 */
	public function getCellMargins() {
		return $this->cell_margin;
	}

	/**
	 * Adjust the internal Cell padding array to take account of the line width.
	 * @param $brd (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @return array of adjustments
	 * @public
	 * @since 5.9.000 (2010-10-03)
	 */
	protected function adjustCellPadding($brd=0) {
		if (empty($brd)) {
			return;
		}
		if (is_string($brd)) {
			// convert string to array
			$slen = strlen($brd);
			$newbrd = array();
			for ($i = 0; $i < $slen; ++$i) {
				$newbrd[$brd[$i]] = true;
			}
			$brd = $newbrd;
		} elseif (($brd === 1) OR ($brd === true) OR (is_numeric($brd) AND (intval($brd) > 0))) {
			$brd = array('LRTB' => true);
		}
		if (!is_array($brd)) {
			return;
		}
		// store current cell padding
		$cp = $this->cell_padding;
		// select border mode
		if (isset($brd['mode'])) {
			$mode = $brd['mode'];
			unset($brd['mode']);
		} else {
			$mode = 'normal';
		}
		// process borders
		foreach ($brd as $border => $style) {
			$line_width = $this->LineWidth;
			if (is_array($style) AND isset($style['width'])) {
				// get border width
				$line_width = $style['width'];
			}
			$adj = 0; // line width inside the cell
			switch ($mode) {
				case 'ext': {
					$adj = 0;
					break;
				}
				case 'int': {
					$adj = $line_width;
					break;
				}
				case 'normal':
				default: {
					$adj = ($line_width / 2);
					break;
				}
			}
			// correct internal cell padding if required to avoid overlap between text and lines
			if ((strpos($border,'T') !== false) AND ($this->cell_padding['T'] < $adj)) {
				$this->cell_padding['T'] = $adj;
			}
			if ((strpos($border,'R') !== false) AND ($this->cell_padding['R'] < $adj)) {
				$this->cell_padding['R'] = $adj;
			}
			if ((strpos($border,'B') !== false) AND ($this->cell_padding['B'] < $adj)) {
				$this->cell_padding['B'] = $adj;
			}
			if ((strpos($border,'L') !== false) AND ($this->cell_padding['L'] < $adj)) {
				$this->cell_padding['L'] = $adj;
			}
		}
		return array('T' => ($this->cell_padding['T'] - $cp['T']), 'R' => ($this->cell_padding['R'] - $cp['R']), 'B' => ($this->cell_padding['B'] - $cp['B']), 'L' => ($this->cell_padding['L'] - $cp['L']));
	}

	/**
	 * Enables or disables the automatic page breaking mode. When enabling, the second parameter is the distance from the bottom of the page that defines the triggering limit. By default, the mode is on and the margin is 2 cm.
	 * @param $auto (boolean) Boolean indicating if mode should be on or off.
	 * @param $margin (float) Distance from the bottom of the page.
	 * @public
	 * @since 1.0
	 * @see Cell(), MultiCell(), AcceptPageBreak()
	 */
	public function SetAutoPageBreak($auto, $margin=0) {
		$this->AutoPageBreak = $auto ? true : false;
		$this->bMargin = $margin;
		$this->PageBreakTrigger = $this->h - $margin;
	}

	/**
	 * Return the auto-page-break mode (true or false).
	 * @return boolean auto-page-break mode
	 * @public
	 * @since 5.9.088
	 */
	public function getAutoPageBreak() {
		return $this->AutoPageBreak;
	}

	/**
	 * Defines the way the document is to be displayed by the viewer.
	 * @param $zoom (mixed) The zoom to use. It can be one of the following string values or a number indicating the zooming factor to use. <ul><li>fullpage: displays the entire page on screen </li><li>fullwidth: uses maximum width of window</li><li>real: uses real size (equivalent to 100% zoom)</li><li>default: uses viewer default mode</li></ul>
	 * @param $layout (string) The page layout. Possible values are:<ul><li>SinglePage Display one page at a time</li><li>OneColumn Display the pages in one column</li><li>TwoColumnLeft Display the pages in two columns, with odd-numbered pages on the left</li><li>TwoColumnRight Display the pages in two columns, with odd-numbered pages on the right</li><li>TwoPageLeft (PDF 1.5) Display the pages two at a time, with odd-numbered pages on the left</li><li>TwoPageRight (PDF 1.5) Display the pages two at a time, with odd-numbered pages on the right</li></ul>
	 * @param $mode (string) A name object specifying how the document should be displayed when opened:<ul><li>UseNone Neither document outline nor thumbnail images visible</li><li>UseOutlines Document outline visible</li><li>UseThumbs Thumbnail images visible</li><li>FullScreen Full-screen mode, with no menu bar, window controls, or any other window visible</li><li>UseOC (PDF 1.5) Optional content group panel visible</li><li>UseAttachments (PDF 1.6) Attachments panel visible</li></ul>
	 * @public
	 * @since 1.2
	 */
	public function SetDisplayMode($zoom, $layout='SinglePage', $mode='UseNone') {
		if (($zoom == 'fullpage') OR ($zoom == 'fullwidth') OR ($zoom == 'real') OR ($zoom == 'default') OR (!is_string($zoom))) {
			$this->ZoomMode = $zoom;
		} else {
			$this->Error('Incorrect zoom display mode: '.$zoom);
		}
		$this->LayoutMode = TCPDF_STATIC::getPageLayoutMode($layout);
		$this->PageMode = TCPDF_STATIC::getPageMode($mode);
	}

	/**
	 * Activates or deactivates page compression. When activated, the internal representation of each page is compressed, which leads to a compression ratio of about 2 for the resulting document. Compression is on by default.
	 * Note: the Zlib extension is required for this feature. If not present, compression will be turned off.
	 * @param $compress (boolean) Boolean indicating if compression must be enabled.
	 * @public
	 * @since 1.4
	 */
	public function SetCompression($compress=true) {
		if (function_exists('gzcompress')) {
			$this->compress = $compress ? true : false;
		} else {
			$this->compress = false;
		}
	}

	/**
	 * Set flag to force sRGB_IEC61966-2.1 black scaled ICC color profile for the whole document.
	 * @param $mode (boolean) If true force sRGB output intent.
	 * @public
	 * @since 5.9.121 (2011-09-28)
	 */
	public function setSRGBmode($mode=false) {
		$this->force_srgb = $mode ? true : false;
	}

	/**
	 * Turn on/off Unicode mode for document information dictionary (meta tags).
	 * This has effect only when unicode mode is set to false.
	 * @param $unicode (boolean) if true set the meta information in Unicode
	 * @since 5.9.027 (2010-12-01)
	 * @public
	 */
	public function SetDocInfoUnicode($unicode=true) {
		$this->docinfounicode = $unicode ? true : false;
	}

	/**
	 * Defines the title of the document.
	 * @param $title (string) The title.
	 * @public
	 * @since 1.2
	 * @see SetAuthor(), SetCreator(), SetKeywords(), SetSubject()
	 */
	public function SetTitle($title) {
		$this->title = $title;
	}

	/**
	 * Defines the subject of the document.
	 * @param $subject (string) The subject.
	 * @public
	 * @since 1.2
	 * @see SetAuthor(), SetCreator(), SetKeywords(), SetTitle()
	 */
	public function SetSubject($subject) {
		$this->subject = $subject;
	}

	/**
	 * Defines the author of the document.
	 * @param $author (string) The name of the author.
	 * @public
	 * @since 1.2
	 * @see SetCreator(), SetKeywords(), SetSubject(), SetTitle()
	 */
	public function SetAuthor($author) {
		$this->author = $author;
	}

	/**
	 * Associates keywords with the document, generally in the form 'keyword1 keyword2 ...'.
	 * @param $keywords (string) The list of keywords.
	 * @public
	 * @since 1.2
	 * @see SetAuthor(), SetCreator(), SetSubject(), SetTitle()
	 */
	public function SetKeywords($keywords) {
		$this->keywords = $keywords;
	}

	/**
	 * Defines the creator of the document. This is typically the name of the application that generates the PDF.
	 * @param $creator (string) The name of the creator.
	 * @public
	 * @since 1.2
	 * @see SetAuthor(), SetKeywords(), SetSubject(), SetTitle()
	 */
	public function SetCreator($creator) {
		$this->creator = $creator;
	}

	/**
	 * This method is automatically called in case of fatal error; it simply outputs the message and halts the execution. An inherited class may override it to customize the error handling but should always halt the script, or the resulting document would probably be invalid.
	 * 2004-06-11 :: Nicola Asuni : changed bold tag with strong
	 * @param $msg (string) The error message
	 * @public
	 * @since 1.0
	 */
	public function Error($msg) {
		// unset all class variables
		$this->_destroy(true);
		// exit program and print error
		if (!K_TCPDF_THROW_EXCEPTION_ERROR) {
			die('<strong>TCPDF ERROR: </strong>'.$msg);
		} else {
			throw new Exception('TCPDF ERROR: '.$msg);
		}
	}

	/**
	 * This method begins the generation of the PDF document.
	 * It is not necessary to call it explicitly because AddPage() does it automatically.
	 * Note: no page is created by this method
	 * @public
	 * @since 1.0
	 * @see AddPage(), Close()
	 */
	public function Open() {
		$this->state = 1;
	}

	/**
	 * Terminates the PDF document.
	 * It is not necessary to call this method explicitly because Output() does it automatically.
	 * If the document contains no page, AddPage() is called to prevent from getting an invalid document.
	 * @public
	 * @since 1.0
	 * @see Open(), Output()
	 */
	public function Close() {
		if ($this->state == 3) {
			return;
		}
		if ($this->page == 0) {
			$this->AddPage();
		}
		$this->endLayer();
		if ($this->tcpdflink) {
			// save current graphic settings
			$gvars = $this->getGraphicVars();
			$this->setEqualColumns();
			$this->lastpage(true);
			$this->SetAutoPageBreak(false);
			$this->x = 0;
			$this->y = $this->h - (1 / $this->k);
			$this->lMargin = 0;
			$this->_out('q');
			$font = defined('PDF_FONT_NAME_MAIN')?PDF_FONT_NAME_MAIN:'helvetica';
			$this->SetFont($font, '', 1);
			$this->setTextRenderingMode(0, false, false);
			$msg = "\x50\x6f\x77\x65\x72\x65\x64\x20\x62\x79\x20\x54\x43\x50\x44\x46\x20\x28\x77\x77\x77\x2e\x74\x63\x70\x64\x66\x2e\x6f\x72\x67\x29";
			$lnk = "\x68\x74\x74\x70\x3a\x2f\x2f\x77\x77\x77\x2e\x74\x63\x70\x64\x66\x2e\x6f\x72\x67";
			$this->Cell(0, 0, $msg, 0, 0, 'L', 0, $lnk, 0, false, 'D', 'B');
			$this->_out('Q');
			// restore graphic settings
			$this->setGraphicVars($gvars);
		}
		// close page
		$this->endPage();
		// close document
		$this->_enddoc();
		// unset all class variables (except critical ones)
		$this->_destroy(false);
	}

	/**
	 * Move pointer at the specified document page and update page dimensions.
	 * @param $pnum (int) page number (1 ... numpages)
	 * @param $resetmargins (boolean) if true reset left, right, top margins and Y position.
	 * @public
	 * @since 2.1.000 (2008-01-07)
	 * @see getPage(), lastpage(), getNumPages()
	 */
	public function setPage($pnum, $resetmargins=false) {
		if (($pnum == $this->page) AND ($this->state == 2)) {
			return;
		}
		if (($pnum > 0) AND ($pnum <= $this->numpages)) {
			$this->state = 2;
			// save current graphic settings
			//$gvars = $this->getGraphicVars();
			$oldpage = $this->page;
			$this->page = $pnum;
			$this->wPt = $this->pagedim[$this->page]['w'];
			$this->hPt = $this->pagedim[$this->page]['h'];
			$this->w = $this->pagedim[$this->page]['wk'];
			$this->h = $this->pagedim[$this->page]['hk'];
			$this->tMargin = $this->pagedim[$this->page]['tm'];
			$this->bMargin = $this->pagedim[$this->page]['bm'];
			$this->original_lMargin = $this->pagedim[$this->page]['olm'];
			$this->original_rMargin = $this->pagedim[$this->page]['orm'];
			$this->AutoPageBreak = $this->pagedim[$this->page]['pb'];
			$this->CurOrientation = $this->pagedim[$this->page]['or'];
			$this->SetAutoPageBreak($this->AutoPageBreak, $this->bMargin);
			// restore graphic settings
			//$this->setGraphicVars($gvars);
			if ($resetmargins) {
				$this->lMargin = $this->pagedim[$this->page]['olm'];
				$this->rMargin = $this->pagedim[$this->page]['orm'];
				$this->SetY($this->tMargin);
			} else {
				// account for booklet mode
				if ($this->pagedim[$this->page]['olm'] != $this->pagedim[$oldpage]['olm']) {
					$deltam = $this->pagedim[$this->page]['olm'] - $this->pagedim[$this->page]['orm'];
					$this->lMargin += $deltam;
					$this->rMargin -= $deltam;
				}
			}
		} else {
			$this->Error('Wrong page number on setPage() function: '.$pnum);
		}
	}

	/**
	 * Reset pointer to the last document page.
	 * @param $resetmargins (boolean) if true reset left, right, top margins and Y position.
	 * @public
	 * @since 2.0.000 (2008-01-04)
	 * @see setPage(), getPage(), getNumPages()
	 */
	public function lastPage($resetmargins=false) {
		$this->setPage($this->getNumPages(), $resetmargins);
	}

	/**
	 * Get current document page number.
	 * @return int page number
	 * @public
	 * @since 2.1.000 (2008-01-07)
	 * @see setPage(), lastpage(), getNumPages()
	 */
	public function getPage() {
		return $this->page;
	}

	/**
	 * Get the total number of insered pages.
	 * @return int number of pages
	 * @public
	 * @since 2.1.000 (2008-01-07)
	 * @see setPage(), getPage(), lastpage()
	 */
	public function getNumPages() {
		return $this->numpages;
	}

	/**
	 * Adds a new TOC (Table Of Content) page to the document.
	 * @param $orientation (string) page orientation.
	 * @param $format (mixed) The format used for pages. It can be either: one of the string values specified at getPageSizeFromFormat() or an array of parameters specified at setPageFormat().
	 * @param $keepmargins (boolean) if true overwrites the default page margins with the current margins
	 * @public
	 * @since 5.0.001 (2010-05-06)
	 * @see AddPage(), startPage(), endPage(), endTOCPage()
	 */
	public function addTOCPage($orientation='', $format='', $keepmargins=false) {
		$this->AddPage($orientation, $format, $keepmargins, true);
	}

	/**
	 * Terminate the current TOC (Table Of Content) page
	 * @public
	 * @since 5.0.001 (2010-05-06)
	 * @see AddPage(), startPage(), endPage(), addTOCPage()
	 */
	public function endTOCPage() {
		$this->endPage(true);
	}

	/**
	 * Adds a new page to the document. If a page is already present, the Footer() method is called first to output the footer (if enabled). Then the page is added, the current position set to the top-left corner according to the left and top margins (or top-right if in RTL mode), and Header() is called to display the header (if enabled).
	 * The origin of the coordinate system is at the top-left corner (or top-right for RTL) and increasing ordinates go downwards.
	 * @param $orientation (string) page orientation. Possible values are (case insensitive):<ul><li>P or PORTRAIT (default)</li><li>L or LANDSCAPE</li></ul>
	 * @param $format (mixed) The format used for pages. It can be either: one of the string values specified at getPageSizeFromFormat() or an array of parameters specified at setPageFormat().
	 * @param $keepmargins (boolean) if true overwrites the default page margins with the current margins
	 * @param $tocpage (boolean) if true set the tocpage state to true (the added page will be used to display Table Of Content).
	 * @public
	 * @since 1.0
	 * @see startPage(), endPage(), addTOCPage(), endTOCPage(), getPageSizeFromFormat(), setPageFormat()
	 */
	public function AddPage($orientation='', $format='', $keepmargins=false, $tocpage=false) {
		if ($this->inxobj) {
			// we are inside an XObject template
			return;
		}
		if (!isset($this->original_lMargin) OR $keepmargins) {
			$this->original_lMargin = $this->lMargin;
		}
		if (!isset($this->original_rMargin) OR $keepmargins) {
			$this->original_rMargin = $this->rMargin;
		}
		// terminate previous page
		$this->endPage();
		// start new page
		$this->startPage($orientation, $format, $tocpage);
	}

	/**
	 * Terminate the current page
	 * @param $tocpage (boolean) if true set the tocpage state to false (end the page used to display Table Of Content).
	 * @public
	 * @since 4.2.010 (2008-11-14)
	 * @see AddPage(), startPage(), addTOCPage(), endTOCPage()
	 */
	public function endPage($tocpage=false) {
		// check if page is already closed
		if (($this->page == 0) OR ($this->numpages > $this->page) OR (!$this->pageopen[$this->page])) {
			return;
		}
		// print page footer
		$this->setFooter();
		// close page
		$this->_endpage();
		// mark page as closed
		$this->pageopen[$this->page] = false;
		if ($tocpage) {
			$this->tocpage = false;
		}
	}

	/**
	 * Starts a new page to the document. The page must be closed using the endPage() function.
	 * The origin of the coordinate system is at the top-left corner and increasing ordinates go downwards.
	 * @param $orientation (string) page orientation. Possible values are (case insensitive):<ul><li>P or PORTRAIT (default)</li><li>L or LANDSCAPE</li></ul>
	 * @param $format (mixed) The format used for pages. It can be either: one of the string values specified at getPageSizeFromFormat() or an array of parameters specified at setPageFormat().
	 * @param $tocpage (boolean) if true the page is designated to contain the Table-Of-Content.
	 * @since 4.2.010 (2008-11-14)
	 * @see AddPage(), endPage(), addTOCPage(), endTOCPage(), getPageSizeFromFormat(), setPageFormat()
	 * @public
	 */
	public function startPage($orientation='', $format='', $tocpage=false) {
		if ($tocpage) {
			$this->tocpage = true;
		}
		// move page numbers of documents to be attached
		if ($this->tocpage) {
			// move reference to unexistent pages (used for page attachments)
			// adjust outlines
			$tmpoutlines = $this->outlines;
			foreach ($tmpoutlines as $key => $outline) {
				if ($outline['p'] > $this->numpages) {
					$this->outlines[$key]['p'] = ($outline['p'] + 1);
				}
			}
			// adjust dests
			$tmpdests = $this->dests;
			foreach ($tmpdests as $key => $dest) {
				if ($dest['p'] > $this->numpages) {
					$this->dests[$key]['p'] = ($dest['p'] + 1);
				}
			}
			// adjust links
			$tmplinks = $this->links;
			foreach ($tmplinks as $key => $link) {
				if ($link[0] > $this->numpages) {
					$this->links[$key][0] = ($link[0] + 1);
				}
			}
		}
		if ($this->numpages > $this->page) {
			// this page has been already added
			$this->setPage($this->page + 1);
			$this->SetY($this->tMargin);
			return;
		}
		// start a new page
		if ($this->state == 0) {
			$this->Open();
		}
		++$this->numpages;
		$this->swapMargins($this->booklet);
		// save current graphic settings
		$gvars = $this->getGraphicVars();
		// start new page
		$this->_beginpage($orientation, $format);
		// mark page as open
		$this->pageopen[$this->page] = true;
		// restore graphic settings
		$this->setGraphicVars($gvars);
		// mark this point
		$this->setPageMark();
		// print page header
		$this->setHeader();
		// restore graphic settings
		$this->setGraphicVars($gvars);
		// mark this point
		$this->setPageMark();
		// print table header (if any)
		$this->setTableHeader();
		// set mark for empty page check
		$this->emptypagemrk[$this->page]= $this->pagelen[$this->page];
	}

	/**
	 * Set start-writing mark on current page stream used to put borders and fills.
	 * Borders and fills are always created after content and inserted on the position marked by this method.
	 * This function must be called after calling Image() function for a background image.
	 * Background images must be always inserted before calling Multicell() or WriteHTMLCell() or WriteHTML() functions.
	 * @public
	 * @since 4.0.016 (2008-07-30)
	 */
	public function setPageMark() {
		$this->intmrk[$this->page] = $this->pagelen[$this->page];
		$this->bordermrk[$this->page] = $this->intmrk[$this->page];
		$this->setContentMark();
	}

	/**
	 * Set start-writing mark on selected page.
	 * Borders and fills are always created after content and inserted on the position marked by this method.
	 * @param $page (int) page number (default is the current page)
	 * @protected
	 * @since 4.6.021 (2009-07-20)
	 */
	protected function setContentMark($page=0) {
		if ($page <= 0) {
			$page = $this->page;
		}
		if (isset($this->footerlen[$page])) {
			$this->cntmrk[$page] = $this->pagelen[$page] - $this->footerlen[$page];
		} else {
			$this->cntmrk[$page] = $this->pagelen[$page];
		}
	}

	/**
	 * Set header data.
	 * @param $ln (string) header image logo
	 * @param $lw (string) header image logo width in mm
	 * @param $ht (string) string to print as title on document header
	 * @param $hs (string) string to print on document header
	 * @param $tc (array) RGB array color for text.
	 * @param $lc (array) RGB array color for line.
	 * @public
	 */
	public function setHeaderData($ln='', $lw=0, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0)) {
		$this->header_logo = $ln;
		$this->header_logo_width = $lw;
		$this->header_title = $ht;
		$this->header_string = $hs;
		$this->header_text_color = $tc;
		$this->header_line_color = $lc;
	}

	/**
	 * Set footer data.
	 * @param $tc (array) RGB array color for text.
	 * @param $lc (array) RGB array color for line.
	 * @public
	 */
	public function setFooterData($tc=array(0,0,0), $lc=array(0,0,0)) {
		$this->footer_text_color = $tc;
		$this->footer_line_color = $lc;
	}

	/**
	 * Returns header data:
	 * <ul><li>$ret['logo'] = logo image</li><li>$ret['logo_width'] = width of the image logo in user units</li><li>$ret['title'] = header title</li><li>$ret['string'] = header description string</li></ul>
	 * @return array()
	 * @public
	 * @since 4.0.012 (2008-07-24)
	 */
	public function getHeaderData() {
		$ret = array();
		$ret['logo'] = $this->header_logo;
		$ret['logo_width'] = $this->header_logo_width;
		$ret['title'] = $this->header_title;
		$ret['string'] = $this->header_string;
		$ret['text_color'] = $this->header_text_color;
		$ret['line_color'] = $this->header_line_color;
		return $ret;
	}

	/**
	 * Set header margin.
	 * (minimum distance between header and top page margin)
	 * @param $hm (int) distance in user units
	 * @public
	 */
	public function setHeaderMargin($hm=10) {
		$this->header_margin = $hm;
	}

	/**
	 * Returns header margin in user units.
	 * @return float
	 * @since 4.0.012 (2008-07-24)
	 * @public
	 */
	public function getHeaderMargin() {
		return $this->header_margin;
	}

	/**
	 * Set footer margin.
	 * (minimum distance between footer and bottom page margin)
	 * @param $fm (int) distance in user units
	 * @public
	 */
	public function setFooterMargin($fm=10) {
		$this->footer_margin = $fm;
	}

	/**
	 * Returns footer margin in user units.
	 * @return float
	 * @since 4.0.012 (2008-07-24)
	 * @public
	 */
	public function getFooterMargin() {
		return $this->footer_margin;
	}
	/**
	 * Set a flag to print page header.
	 * @param $val (boolean) set to true to print the page header (default), false otherwise.
	 * @public
	 */
	public function setPrintHeader($val=true) {
		$this->print_header = $val ? true : false;
	}

	/**
	 * Set a flag to print page footer.
	 * @param $val (boolean) set to true to print the page footer (default), false otherwise.
	 * @public
	 */
	public function setPrintFooter($val=true) {
		$this->print_footer = $val ? true : false;
	}

	/**
	 * Return the right-bottom (or left-bottom for RTL) corner X coordinate of last inserted image
	 * @return float
	 * @public
	 */
	public function getImageRBX() {
		return $this->img_rb_x;
	}

	/**
	 * Return the right-bottom (or left-bottom for RTL) corner Y coordinate of last inserted image
	 * @return float
	 * @public
	 */
	public function getImageRBY() {
		return $this->img_rb_y;
	}

	/**
	 * Reset the xobject template used by Header() method.
	 * @public
	 */
	public function resetHeaderTemplate() {
		$this->header_xobjid = -1;
	}

	/**
	 * Set a flag to automatically reset the xobject template used by Header() method at each page.
	 * @param $val (boolean) set to true to reset Header xobject template at each page, false otherwise.
	 * @public
	 */
	public function setHeaderTemplateAutoreset($val=true) {
		$this->header_xobj_autoreset = $val ? true : false;
	}

	/**
	 * This method is used to render the page header.
	 * It is automatically called by AddPage() and could be overwritten in your own inherited class.
	 * @public
	 */
	public function Header() {
		if ($this->header_xobjid < 0) {
			// start a new XObject Template
			$this->header_xobjid = $this->startTemplate($this->w, $this->tMargin);
			$headerfont = $this->getHeaderFont();
			$headerdata = $this->getHeaderData();
			$this->y = $this->header_margin;
			if ($this->rtl) {
				$this->x = $this->w - $this->original_rMargin;
			} else {
				$this->x = $this->original_lMargin;
			}
			if (($headerdata['logo']) AND ($headerdata['logo'] != K_BLANK_IMAGE)) {
				$imgtype = TCPDF_IMAGES::getImageFileType(K_PATH_IMAGES.$headerdata['logo']);
				if (($imgtype == 'eps') OR ($imgtype == 'ai')) {
					$this->ImageEps(K_PATH_IMAGES.$headerdata['logo'], '', '', $headerdata['logo_width']);
				} elseif ($imgtype == 'svg') {
					$this->ImageSVG(K_PATH_IMAGES.$headerdata['logo'], '', '', $headerdata['logo_width']);
				} else {
					$this->Image(K_PATH_IMAGES.$headerdata['logo'], '', '', $headerdata['logo_width']);
				}
				$imgy = $this->getImageRBY();
			} else {
				$imgy = $this->y;
			}
			$cell_height = round(($this->cell_height_ratio * $headerfont[2]) / $this->k, 2);
			// set starting margin for text data cell
			if ($this->getRTL()) {
				$header_x = $this->original_rMargin + ($headerdata['logo_width'] * 1.1);
			} else {
				$header_x = $this->original_lMargin + ($headerdata['logo_width'] * 1.1);
			}
			$cw = $this->w - $this->original_lMargin - $this->original_rMargin - ($headerdata['logo_width'] * 1.1);
			$this->SetTextColorArray($this->header_text_color);
			// header title
			$this->SetFont($headerfont[0], 'B', $headerfont[2] + 1);
			$this->SetX($header_x);
			$this->Cell($cw, $cell_height, $headerdata['title'], 0, 1, '', 0, '', 0);
			// header string
			$this->SetFont($headerfont[0], $headerfont[1], $headerfont[2]);
			$this->SetX($header_x);
			$this->MultiCell($cw, $cell_height, $headerdata['string'], 0, '', 0, 1, '', '', true, 0, false, true, 0, 'T', false);
			// print an ending header line
			$this->SetLineStyle(array('width' => 0.85 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $headerdata['line_color']));
			$this->SetY((2.835 / $this->k) + max($imgy, $this->y));
			if ($this->rtl) {
				$this->SetX($this->original_rMargin);
			} else {
				$this->SetX($this->original_lMargin);
			}
			$this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 0, '', 'T', 0, 'C');
			$this->endTemplate();
		}
		// print header template
		$x = 0;
		$dx = 0;
		if (!$this->header_xobj_autoreset AND $this->booklet AND (($this->page % 2) == 0)) {
			// adjust margins for booklet mode
			$dx = ($this->original_lMargin - $this->original_rMargin);
		}
		if ($this->rtl) {
			$x = $this->w + $dx;
		} else {
			$x = 0 + $dx;
		}
		$this->printTemplate($this->header_xobjid, $x, 0, 0, 0, '', '', false);
		if ($this->header_xobj_autoreset) {
			// reset header xobject template at each page
			$this->header_xobjid = -1;
		}
	}

	/**
	 * This method is used to render the page footer.
	 * It is automatically called by AddPage() and could be overwritten in your own inherited class.
	 * @public
	 */
	public function Footer() {
		$cur_y = $this->y;
		$this->SetTextColorArray($this->footer_text_color);
		//set style for cell border
		$line_width = (0.85 / $this->k);
		$this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $this->footer_line_color));
		//print document barcode
		$barcode = $this->getBarcode();
		if (!empty($barcode)) {
			$this->Ln($line_width);
			$barcode_width = round(($this->w - $this->original_lMargin - $this->original_rMargin) / 3);
			$style = array(
				'position' => $this->rtl?'R':'L',
				'align' => $this->rtl?'R':'L',
				'stretch' => false,
				'fitwidth' => true,
				'cellfitalign' => '',
				'border' => false,
				'padding' => 0,
				'fgcolor' => array(0,0,0),
				'bgcolor' => false,
				'text' => false
			);
			$this->write1DBarcode($barcode, 'C128', '', $cur_y + $line_width, '', (($this->footer_margin / 3) - $line_width), 0.3, $style, '');
		}
		$w_page = isset($this->l['w_page']) ? $this->l['w_page'].' ' : '';
		if (empty($this->pagegroups)) {
			$pagenumtxt = $w_page.$this->getAliasNumPage().' / '.$this->getAliasNbPages();
		} else {
			$pagenumtxt = $w_page.$this->getPageNumGroupAlias().' / '.$this->getPageGroupAlias();
		}
		$this->SetY($cur_y);
		//Print page number
		if ($this->getRTL()) {
			$this->SetX($this->original_rMargin);
			$this->Cell(0, 0, $pagenumtxt, 'T', 0, 'L');
		} else {
			$this->SetX($this->original_lMargin);
			$this->Cell(0, 0, $this->getAliasRightShift().$pagenumtxt, 'T', 0, 'R');
		}
	}

	/**
	 * This method is used to render the page header.
	 * @protected
	 * @since 4.0.012 (2008-07-24)
	 */
	protected function setHeader() {
		if (!$this->print_header OR ($this->state != 2)) {
			return;
		}
		$this->InHeader = true;
		$this->setGraphicVars($this->default_graphic_vars);
		$temp_thead = $this->thead;
		$temp_theadMargins = $this->theadMargins;
		$lasth = $this->lasth;
		$this->_out('q');
		$this->rMargin = $this->original_rMargin;
		$this->lMargin = $this->original_lMargin;
		$this->SetCellPadding(0);
		//set current position
		if ($this->rtl) {
			$this->SetXY($this->original_rMargin, $this->header_margin);
		} else {
			$this->SetXY($this->original_lMargin, $this->header_margin);
		}
		$this->SetFont($this->header_font[0], $this->header_font[1], $this->header_font[2]);
		$this->Header();
		//restore position
		if ($this->rtl) {
			$this->SetXY($this->original_rMargin, $this->tMargin);
		} else {
			$this->SetXY($this->original_lMargin, $this->tMargin);
		}
		$this->_out('Q');
		$this->lasth = $lasth;
		$this->thead = $temp_thead;
		$this->theadMargins = $temp_theadMargins;
		$this->newline = false;
		$this->InHeader = false;
	}

	/**
	 * This method is used to render the page footer.
	 * @protected
	 * @since 4.0.012 (2008-07-24)
	 */
	protected function setFooter() {
		if ($this->state != 2) {
			return;
		}
		$this->InFooter = true;
		// save current graphic settings
		$gvars = $this->getGraphicVars();
		// mark this point
		$this->footerpos[$this->page] = $this->pagelen[$this->page];
		$this->_out("\n");
		if ($this->print_footer) {
			$this->setGraphicVars($this->default_graphic_vars);
			$this->current_column = 0;
			$this->num_columns = 1;
			$temp_thead = $this->thead;
			$temp_theadMargins = $this->theadMargins;
			$lasth = $this->lasth;
			$this->_out('q');
			$this->rMargin = $this->original_rMargin;
			$this->lMargin = $this->original_lMargin;
			$this->SetCellPadding(0);
			//set current position
			$footer_y = $this->h - $this->footer_margin;
			if ($this->rtl) {
				$this->SetXY($this->original_rMargin, $footer_y);
			} else {
				$this->SetXY($this->original_lMargin, $footer_y);
			}
			$this->SetFont($this->footer_font[0], $this->footer_font[1], $this->footer_font[2]);
			$this->Footer();
			//restore position
			if ($this->rtl) {
				$this->SetXY($this->original_rMargin, $this->tMargin);
			} else {
				$this->SetXY($this->original_lMargin, $this->tMargin);
			}
			$this->_out('Q');
			$this->lasth = $lasth;
			$this->thead = $temp_thead;
			$this->theadMargins = $temp_theadMargins;
		}
		// restore graphic settings
		$this->setGraphicVars($gvars);
		$this->current_column = $gvars['current_column'];
		$this->num_columns = $gvars['num_columns'];
		// calculate footer length
		$this->footerlen[$this->page] = $this->pagelen[$this->page] - $this->footerpos[$this->page] + 1;
		$this->InFooter = false;
	}

	/**
	 * Check if we are on the page body (excluding page header and footer).
	 * @return true if we are not in page header nor in page footer, false otherwise.
	 * @protected
	 * @since 5.9.091 (2011-06-15)
	 */
	protected function inPageBody() {
		return (($this->InHeader === false) AND ($this->InFooter === false));
	}

	/**
	 * This method is used to render the table header on new page (if any).
	 * @protected
	 * @since 4.5.030 (2009-03-25)
	 */
	protected function setTableHeader() {
		if ($this->num_columns > 1) {
			// multi column mode
			return;
		}
		if (isset($this->theadMargins['top'])) {
			// restore the original top-margin
			$this->tMargin = $this->theadMargins['top'];
			$this->pagedim[$this->page]['tm'] = $this->tMargin;
			$this->y = $this->tMargin;
		}
		if (!TCPDF_STATIC::empty_string($this->thead) AND (!$this->inthead)) {
			// set margins
			$prev_lMargin = $this->lMargin;
			$prev_rMargin = $this->rMargin;
			$prev_cell_padding = $this->cell_padding;
			$this->lMargin = $this->theadMargins['lmargin'] + ($this->pagedim[$this->page]['olm'] - $this->pagedim[$this->theadMargins['page']]['olm']);
			$this->rMargin = $this->theadMargins['rmargin'] + ($this->pagedim[$this->page]['orm'] - $this->pagedim[$this->theadMargins['page']]['orm']);
			$this->cell_padding = $this->theadMargins['cell_padding'];
			if ($this->rtl) {
				$this->x = $this->w - $this->rMargin;
			} else {
				$this->x = $this->lMargin;
			}
			// account for special "cell" mode
			if ($this->theadMargins['cell']) {
				if ($this->rtl) {
					$this->x -= $this->cell_padding['R'];
				} else {
					$this->x += $this->cell_padding['L'];
				}
			}
			// print table header
			$this->writeHTML($this->thead, false, false, false, false, '');
			// set new top margin to skip the table headers
			if (!isset($this->theadMargins['top'])) {
				$this->theadMargins['top'] = $this->tMargin;
			}
			// store end of header position
			if (!isset($this->columns[0]['th'])) {
				$this->columns[0]['th'] = array();
			}
			$this->columns[0]['th']['\''.$this->page.'\''] = $this->y;
			$this->tMargin = $this->y;
			$this->pagedim[$this->page]['tm'] = $this->tMargin;
			$this->lasth = 0;
			$this->lMargin = $prev_lMargin;
			$this->rMargin = $prev_rMargin;
			$this->cell_padding = $prev_cell_padding;
		}
	}

	/**
	 * Returns the current page number.
	 * @return int page number
	 * @public
	 * @since 1.0
	 * @see getAliasNbPages()
	 */
	public function PageNo() {
		return $this->page;
	}

	/**
	 * Defines a new spot color.
	 * It can be expressed in RGB components or gray scale.
	 * The method can be called before the first page is created and the value is retained from page to page.
	 * @param $name (string) Full name of the spot color.
	 * @param $c (float) Cyan color for CMYK. Value between 0 and 100.
	 * @param $m (float) Magenta color for CMYK. Value between 0 and 100.
	 * @param $y (float) Yellow color for CMYK. Value between 0 and 100.
	 * @param $k (float) Key (Black) color for CMYK. Value between 0 and 100.
	 * @public
	 * @since 4.0.024 (2008-09-12)
	 * @see SetDrawSpotColor(), SetFillSpotColor(), SetTextSpotColor()
	 */
	public function AddSpotColor($name, $c, $m, $y, $k) {
		if (!isset($this->spot_colors[$name])) {
			$i = (1 + count($this->spot_colors));
			$this->spot_colors[$name] = array('C' => $c, 'M' => $m, 'Y' => $y, 'K' => $k, 'name' => $name, 'i' => $i);
		}
	}

	/**
	 * Set the spot color for the specified type ('draw', 'fill', 'text').
	 * @param $type (string) Type of object affected by this color: ('draw', 'fill', 'text').
	 * @param $name (string) Name of the spot color.
	 * @param $tint (float) Intensity of the color (from 0 to 100 ; 100 = full intensity by default).
	 * @return (string) PDF color command.
	 * @public
	 * @since 5.9.125 (2011-10-03)
	 */
	public function setSpotColor($type, $name, $tint=100) {
		$spotcolor = TCPDF_COLORS::getSpotColor($name, $this->spot_colors);
		if ($spotcolor === false) {
			$this->Error('Undefined spot color: '.$name.', you must add it on the spotcolors.php file.');
		}
		$tint = (max(0, min(100, $tint)) / 100);
		$pdfcolor = sprintf('/CS%d ', $this->spot_colors[$name]['i']);
		switch ($type) {
			case 'draw': {
				$pdfcolor .= sprintf('CS %F SCN', $tint);
				$this->DrawColor = $pdfcolor;
				$this->strokecolor = $spotcolor;
				break;
			}
			case 'fill': {
				$pdfcolor .= sprintf('cs %F scn', $tint);
				$this->FillColor = $pdfcolor;
				$this->bgcolor = $spotcolor;
				break;
			}
			case 'text': {
				$pdfcolor .= sprintf('cs %F scn', $tint);
				$this->TextColor = $pdfcolor;
				$this->fgcolor = $spotcolor;
				break;
			}
		}
		$this->ColorFlag = ($this->FillColor != $this->TextColor);
		if ($this->state == 2) {
			$this->_out($pdfcolor);
		}
		if ($this->inxobj) {
			// we are inside an XObject template
			$this->xobjects[$this->xobjid]['spot_colors'][$name] = $this->spot_colors[$name];
		}
		return $pdfcolor;
	}

	/**
	 * Defines the spot color used for all drawing operations (lines, rectangles and cell borders).
	 * @param $name (string) Name of the spot color.
	 * @param $tint (float) Intensity of the color (from 0 to 100 ; 100 = full intensity by default).
	 * @public
	 * @since 4.0.024 (2008-09-12)
	 * @see AddSpotColor(), SetFillSpotColor(), SetTextSpotColor()
	 */
	public function SetDrawSpotColor($name, $tint=100) {
		$this->setSpotColor('draw', $name, $tint);
	}

	/**
	 * Defines the spot color used for all filling operations (filled rectangles and cell backgrounds).
	 * @param $name (string) Name of the spot color.
	 * @param $tint (float) Intensity of the color (from 0 to 100 ; 100 = full intensity by default).
	 * @public
	 * @since 4.0.024 (2008-09-12)
	 * @see AddSpotColor(), SetDrawSpotColor(), SetTextSpotColor()
	 */
	public function SetFillSpotColor($name, $tint=100) {
		$this->setSpotColor('fill', $name, $tint);
	}

	/**
	 * Defines the spot color used for text.
	 * @param $name (string) Name of the spot color.
	 * @param $tint (int) Intensity of the color (from 0 to 100 ; 100 = full intensity by default).
	 * @public
	 * @since 4.0.024 (2008-09-12)
	 * @see AddSpotColor(), SetDrawSpotColor(), SetFillSpotColor()
	 */
	public function SetTextSpotColor($name, $tint=100) {
		$this->setSpotColor('text', $name, $tint);
	}

	/**
	 * Set the color array for the specified type ('draw', 'fill', 'text').
	 * It can be expressed in RGB, CMYK or GRAY SCALE components.
	 * The method can be called before the first page is created and the value is retained from page to page.
	 * @param $type (string) Type of object affected by this color: ('draw', 'fill', 'text').
	 * @param $color (array) Array of colors (1=gray, 3=RGB, 4=CMYK or 5=spotcolor=CMYK+name values).
	 * @param $ret (boolean) If true do not send the PDF command.
	 * @return (string) The PDF command or empty string.
	 * @public
	 * @since 3.1.000 (2008-06-11)
	 */
	public function setColorArray($type, $color, $ret=false) {
		if (is_array($color)) {
			$color = array_values($color);
			// component: grey, RGB red or CMYK cyan
			$c = isset($color[0]) ? $color[0] : -1;
			// component: RGB green or CMYK magenta
			$m = isset($color[1]) ? $color[1] : -1;
			// component: RGB blue or CMYK yellow
			$y = isset($color[2]) ? $color[2] : -1;
			// component: CMYK black
			$k = isset($color[3]) ? $color[3] : -1;
			// color name
			$name = isset($color[4]) ? $color[4] : '';
			if ($c >= 0) {
				return $this->setColor($type, $c, $m, $y, $k, $ret, $name);
			}
		}
		return '';
	}

	/**
	 * Defines the color used for all drawing operations (lines, rectangles and cell borders).
	 * It can be expressed in RGB, CMYK or GRAY SCALE components.
	 * The method can be called before the first page is created and the value is retained from page to page.
	 * @param $color (array) Array of colors (1, 3 or 4 values).
	 * @param $ret (boolean) If true do not send the PDF command.
	 * @return string the PDF command
	 * @public
	 * @since 3.1.000 (2008-06-11)
	 * @see SetDrawColor()
	 */
	public function SetDrawColorArray($color, $ret=false) {
		return $this->setColorArray('draw', $color, $ret);
	}

	/**
	 * Defines the color used for all filling operations (filled rectangles and cell backgrounds).
	 * It can be expressed in RGB, CMYK or GRAY SCALE components.
	 * The method can be called before the first page is created and the value is retained from page to page.
	 * @param $color (array) Array of colors (1, 3 or 4 values).
	 * @param $ret (boolean) If true do not send the PDF command.
	 * @public
	 * @since 3.1.000 (2008-6-11)
	 * @see SetFillColor()
	 */
	public function SetFillColorArray($color, $ret=false) {
		return $this->setColorArray('fill', $color, $ret);
	}

	/**
	 * Defines the color used for text. It can be expressed in RGB components or gray scale.
	 * The method can be called before the first page is created and the value is retained from page to page.
	 * @param $color (array) Array of colors (1, 3 or 4 values).
	 * @param $ret (boolean) If true do not send the PDF command.
	 * @public
	 * @since 3.1.000 (2008-6-11)
	 * @see SetFillColor()
	 */
	public function SetTextColorArray($color, $ret=false) {
		return $this->setColorArray('text', $color, $ret);
	}

	/**
	 * Defines the color used by the specified type ('draw', 'fill', 'text').
	 * @param $type (string) Type of object affected by this color: ('draw', 'fill', 'text').
	 * @param $col1 (float) GRAY level for single color, or Red color for RGB (0-255), or CYAN color for CMYK (0-100).
	 * @param $col2 (float) GREEN color for RGB (0-255), or MAGENTA color for CMYK (0-100).
	 * @param $col3 (float) BLUE color for RGB (0-255), or YELLOW color for CMYK (0-100).
	 * @param $col4 (float) KEY (BLACK) color for CMYK (0-100).
	 * @param $ret (boolean) If true do not send the command.
	 * @param $name (string) spot color name (if any)
	 * @return (string) The PDF command or empty string.
	 * @public
	 * @since 5.9.125 (2011-10-03)
	 */
	public function setColor($type, $col1=0, $col2=-1, $col3=-1, $col4=-1, $ret=false, $name='') {
		// set default values
		if (!is_numeric($col1)) {
			$col1 = 0;
		}
		if (!is_numeric($col2)) {
			$col2 = -1;
		}
		if (!is_numeric($col3)) {
			$col3 = -1;
		}
		if (!is_numeric($col4)) {
			$col4 = -1;
		}
		// set color by case
		$suffix = '';
		if (($col2 == -1) AND ($col3 == -1) AND ($col4 == -1)) {
			// Grey scale
			$col1 = max(0, min(255, $col1));
			$intcolor = array('G' => $col1);
			$pdfcolor = sprintf('%F ', ($col1 / 255));
			$suffix = 'g';
		} elseif ($col4 == -1) {
			// RGB
			$col1 = max(0, min(255, $col1));
			$col2 = max(0, min(255, $col2));
			$col3 = max(0, min(255, $col3));
			$intcolor = array('R' => $col1, 'G' => $col2, 'B' => $col3);
			$pdfcolor = sprintf('%F %F %F ', ($col1 / 255), ($col2 / 255), ($col3 / 255));
			$suffix = 'rg';
		} else {
			$col1 = max(0, min(100, $col1));
			$col2 = max(0, min(100, $col2));
			$col3 = max(0, min(100, $col3));
			$col4 = max(0, min(100, $col4));
			if (empty($name)) {
				// CMYK
				$intcolor = array('C' => $col1, 'M' => $col2, 'Y' => $col3, 'K' => $col4);
				$pdfcolor = sprintf('%F %F %F %F ', ($col1 / 100), ($col2 / 100), ($col3 / 100), ($col4 / 100));
				$suffix = 'k';
			} else {
				// SPOT COLOR
				$intcolor = array('C' => $col1, 'M' => $col2, 'Y' => $col3, 'K' => $col4, 'name' => $name);
				$this->AddSpotColor($name, $col1, $col2, $col3, $col4);
				$pdfcolor = $this->setSpotColor($type, $name, 100);
			}
		}
		switch ($type) {
			case 'draw': {
				$pdfcolor .= strtoupper($suffix);
				$this->DrawColor = $pdfcolor;
				$this->strokecolor = $intcolor;
				break;
			}
			case 'fill': {
				$pdfcolor .= $suffix;
				$this->FillColor = $pdfcolor;
				$this->bgcolor = $intcolor;
				break;
			}
			case 'text': {
				$pdfcolor .= $suffix;
				$this->TextColor = $pdfcolor;
				$this->fgcolor = $intcolor;
				break;
			}
		}
		$this->ColorFlag = ($this->FillColor != $this->TextColor);
		if (($type != 'text') AND ($this->state == 2)) {
			if (!$ret) {
				$this->_out($pdfcolor);
			}
			return $pdfcolor;
		}
		return '';
	}

	/**
	 * Defines the color used for all drawing operations (lines, rectangles and cell borders). It can be expressed in RGB components or gray scale. The method can be called before the first page is created and the value is retained from page to page.
	 * @param $col1 (float) GRAY level for single color, or Red color for RGB (0-255), or CYAN color for CMYK (0-100).
	 * @param $col2 (float) GREEN color for RGB (0-255), or MAGENTA color for CMYK (0-100).
	 * @param $col3 (float) BLUE color for RGB (0-255), or YELLOW color for CMYK (0-100).
	 * @param $col4 (float) KEY (BLACK) color for CMYK (0-100).
	 * @param $ret (boolean) If true do not send the command.
	 * @param $name (string) spot color name (if any)
	 * @return string the PDF command
	 * @public
	 * @since 1.3
	 * @see SetDrawColorArray(), SetFillColor(), SetTextColor(), Line(), Rect(), Cell(), MultiCell()
	 */
	public function SetDrawColor($col1=0, $col2=-1, $col3=-1, $col4=-1, $ret=false, $name='') {
		return $this->setColor('draw', $col1, $col2, $col3, $col4, $ret, $name);
	}

	/**
	 * Defines the color used for all filling operations (filled rectangles and cell backgrounds). It can be expressed in RGB components or gray scale. The method can be called before the first page is created and the value is retained from page to page.
	 * @param $col1 (float) GRAY level for single color, or Red color for RGB (0-255), or CYAN color for CMYK (0-100).
	 * @param $col2 (float) GREEN color for RGB (0-255), or MAGENTA color for CMYK (0-100).
	 * @param $col3 (float) BLUE color for RGB (0-255), or YELLOW color for CMYK (0-100).
	 * @param $col4 (float) KEY (BLACK) color for CMYK (0-100).
	 * @param $ret (boolean) If true do not send the command.
	 * @param $name (string) Spot color name (if any).
	 * @return (string) The PDF command.
	 * @public
	 * @since 1.3
	 * @see SetFillColorArray(), SetDrawColor(), SetTextColor(), Rect(), Cell(), MultiCell()
	 */
	public function SetFillColor($col1=0, $col2=-1, $col3=-1, $col4=-1, $ret=false, $name='') {
		return $this->setColor('fill', $col1, $col2, $col3, $col4, $ret, $name);
	}

	/**
	 * Defines the color used for text. It can be expressed in RGB components or gray scale. The method can be called before the first page is created and the value is retained from page to page.
	 * @param $col1 (float) GRAY level for single color, or Red color for RGB (0-255), or CYAN color for CMYK (0-100).
	 * @param $col2 (float) GREEN color for RGB (0-255), or MAGENTA color for CMYK (0-100).
	 * @param $col3 (float) BLUE color for RGB (0-255), or YELLOW color for CMYK (0-100).
	 * @param $col4 (float) KEY (BLACK) color for CMYK (0-100).
	 * @param $ret (boolean) If true do not send the command.
	 * @param $name (string) Spot color name (if any).
	 * @return (string) Empty string.
	 * @public
	 * @since 1.3
	 * @see SetTextColorArray(), SetDrawColor(), SetFillColor(), Text(), Cell(), MultiCell()
	 */
	public function SetTextColor($col1=0, $col2=-1, $col3=-1, $col4=-1, $ret=false, $name='') {
		return $this->setColor('text', $col1, $col2, $col3, $col4, $ret, $name);
	}

	/**
	 * Returns the length of a string in user unit. A font must be selected.<br>
	 * @param $s (string) The string whose length is to be computed
	 * @param $fontname (string) Family font. It can be either a name defined by AddFont() or one of the standard families. It is also possible to pass an empty string, in that case, the current family is retained.
	 * @param $fontstyle (string) Font style. Possible values are (case insensitive):<ul><li>empty string: regular</li><li>B: bold</li><li>I: italic</li><li>U: underline</li><li>D: line-through</li><li>O: overline</li></ul> or any combination. The default value is regular.
	 * @param $fontsize (float) Font size in points. The default value is the current size.
	 * @param $getarray (boolean) if true returns an array of characters widths, if false returns the total length.
	 * @return mixed int total string length or array of characted widths
	 * @author Nicola Asuni
	 * @public
	 * @since 1.2
	 */
	public function GetStringWidth($s, $fontname='', $fontstyle='', $fontsize=0, $getarray=false) {
		return $this->GetArrStringWidth(TCPDF_FONTS::utf8Bidi(TCPDF_FONTS::UTF8StringToArray($s, $this->isunicode, $this->CurrentFont), $s, $this->tmprtl, $this->isunicode, $this->CurrentFont), $fontname, $fontstyle, $fontsize, $getarray);
	}

	/**
	 * Returns the string length of an array of chars in user unit or an array of characters widths. A font must be selected.<br>
	 * @param $sa (string) The array of chars whose total length is to be computed
	 * @param $fontname (string) Family font. It can be either a name defined by AddFont() or one of the standard families. It is also possible to pass an empty string, in that case, the current family is retained.
	 * @param $fontstyle (string) Font style. Possible values are (case insensitive):<ul><li>empty string: regular</li><li>B: bold</li><li>I: italic</li><li>U: underline</li><li>D: line through</li><li>O: overline</li></ul> or any combination. The default value is regular.
	 * @param $fontsize (float) Font size in points. The default value is the current size.
	 * @param $getarray (boolean) if true returns an array of characters widths, if false returns the total length.
	 * @return mixed int total string length or array of characted widths
	 * @author Nicola Asuni
	 * @public
	 * @since 2.4.000 (2008-03-06)
	 */
	public function GetArrStringWidth($sa, $fontname='', $fontstyle='', $fontsize=0, $getarray=false) {
		// store current values
		if (!TCPDF_STATIC::empty_string($fontname)) {
			$prev_FontFamily = $this->FontFamily;
			$prev_FontStyle = $this->FontStyle;
			$prev_FontSizePt = $this->FontSizePt;
			$this->SetFont($fontname, $fontstyle, $fontsize, '', 'default', false);
		}
		// convert UTF-8 array to Latin1 if required
		if ($this->isunicode AND (!$this->isUnicodeFont())) {
			$sa = TCPDF_FONTS::UTF8ArrToLatin1Arr($sa);
		}
		$w = 0; // total width
		$wa = array(); // array of characters widths
		foreach ($sa as $ck => $char) {
			// character width
			$cw = $this->GetCharWidth($char, isset($sa[($ck + 1)]));
			$wa[] = $cw;
			$w += $cw;
		}
		// restore previous values
		if (!TCPDF_STATIC::empty_string($fontname)) {
			$this->SetFont($prev_FontFamily, $prev_FontStyle, $prev_FontSizePt, '', 'default', false);
		}
		if ($getarray) {
			return $wa;
		}
		return $w;
	}

	/**
	 * Returns the length of the char in user unit for the current font considering current stretching and spacing (tracking).
	 * @param $char (int) The char code whose length is to be returned
	 * @param $notlast (boolean) If false ignore the font-spacing.
	 * @return float char width
	 * @author Nicola Asuni
	 * @public
	 * @since 2.4.000 (2008-03-06)
	 */
	public function GetCharWidth($char, $notlast=true) {
		// get raw width
		$chw = $this->getRawCharWidth($char);
		if (($this->font_spacing < 0) OR (($this->font_spacing > 0) AND $notlast)) {
			// increase/decrease font spacing
			$chw += $this->font_spacing;
		}
		if ($this->font_stretching != 100) {
			// fixed stretching mode
			$chw *= ($this->font_stretching / 100);
		}
		return $chw;
	}

	/**
	 * Returns the length of the char in user unit for the current font.
	 * @param $char (int) The char code whose length is to be returned
	 * @return float char width
	 * @author Nicola Asuni
	 * @public
	 * @since 5.9.000 (2010-09-28)
	 */
	public function getRawCharWidth($char) {
		if ($char == 173) {
			// SHY character will not be printed
			return (0);
		}
		if (isset($this->CurrentFont['cw'][$char])) {
			$w = $this->CurrentFont['cw'][$char];
		} elseif (isset($this->CurrentFont['dw'])) {
			// default width
			$w = $this->CurrentFont['dw'];
		} elseif (isset($this->CurrentFont['cw'][32])) {
			// default width
			$w = $this->CurrentFont['cw'][32];
		} else {
			$w = 600;
		}
		return $this->getAbsFontMeasure($w);
	}

	/**
	 * Returns the numbero of characters in a string.
	 * @param $s (string) The input string.
	 * @return int number of characters
	 * @public
	 * @since 2.0.0001 (2008-01-07)
	 */
	public function GetNumChars($s) {
		if ($this->isUnicodeFont()) {
			return count(TCPDF_FONTS::UTF8StringToArray($s, $this->isunicode, $this->CurrentFont));
		}
		return strlen($s);
	}

	/**
	 * Fill the list of available fonts ($this->fontlist).
	 * @protected
	 * @since 4.0.013 (2008-07-28)
	 */
	protected function getFontsList() {
		if (($fontsdir = opendir(TCPDF_FONTS::_getfontpath())) !== false) {
			while (($file = readdir($fontsdir)) !== false) {
				if (substr($file, -4) == '.php') {
					array_push($this->fontlist, strtolower(basename($file, '.php')));
				}
			}
			closedir($fontsdir);
		}
	}

	/**
	 * Returns the unicode caracter specified by the value
	 * @param $c (int) UTF-8 value
	 * @return Returns the specified character.
	 * @since 2.3.000 (2008-03-05)
	 * @public
	 * @deprecated
	 */
	public function unichr($c) {
		return TCPDF_FONTS::unichr($c, $this->isunicode);
	}

	/**
	 * Convert and add the selected TrueType or Type1 font to the fonts folder (that must be writeable).
	 * @param $fontfile (string) Font file (full path).
	 * @param $fonttype (string) Font type. Leave empty for autodetect mode. Valid values are: TrueTypeUnicode, TrueType, Type1, CID0JP = CID-0 Japanese, CID0KR = CID-0 Korean, CID0CS = CID-0 Chinese Simplified, CID0CT = CID-0 Chinese Traditional.
	 * @param $enc (string) Name of the encoding table to use. Leave empty for default mode. Omit this parameter for TrueType Unicode and symbolic fonts like Symbol or ZapfDingBats.
	 * @param $flags (int) Unsigned 32-bit integer containing flags specifying various characteristics of the font (PDF32000:2008 - 9.8.2 Font Descriptor Flags): +1 for fixed font; +4 for symbol or +32 for non-symbol; +64 for italic. Fixed and Italic mode are generally autodetected so you have to set it to 32 = non-symbolic font (default) or 4 = symbolic font.
	 * @param $outpath (string) Output path for generated font files (must be writeable by the web server). Leave empty for default font folder.
	 * @param $platid (int) Platform ID for CMAP table to extract (when building a Unicode font for Windows this value should be 3, for Macintosh should be 1).
	 * @param $encid (int) Encoding ID for CMAP table to extract (when building a Unicode font for Windows this value should be 1, for Macintosh should be 0). When Platform ID is 3, legal values for Encoding ID are: 0=Symbol, 1=Unicode, 2=ShiftJIS, 3=PRC, 4=Big5, 5=Wansung, 6=Johab, 7=Reserved, 8=Reserved, 9=Reserved, 10=UCS-4.
	 * @param $addcbbox (boolean) If true includes the character bounding box information on the php font file.
	 * @return (string) TCPDF font name.
	 * @author Nicola Asuni
	 * @since 5.9.123 (2010-09-30)
	 * @public
	 * @deprecated
	 */
	public function addTTFfont($fontfile, $fonttype='', $enc='', $flags=32, $outpath='', $platid=3, $encid=1, $addcbbox=false) {
		return TCPDF_FONTS::addTTFfont($fontfile, $fonttype, $enc, $flags, $outpath, $platid, $encid, $addcbbox);
	}

	/**
	 * Imports a TrueType, Type1, core, or CID0 font and makes it available.
	 * It is necessary to generate a font definition file first (read /fonts/utils/README.TXT).
	 * The definition file (and the font file itself when embedding) must be present either in the current directory or in the one indicated by K_PATH_FONTS if the constant is defined. If it could not be found, the error "Could not include font definition file" is generated.
	 * @param $family (string) Font family. The name can be chosen arbitrarily. If it is a standard family name, it will override the corresponding font.
	 * @param $style (string) Font style. Possible values are (case insensitive):<ul><li>empty string: regular (default)</li><li>B: bold</li><li>I: italic</li><li>BI or IB: bold italic</li></ul>
	 * @param $fontfile (string) The font definition file. By default, the name is built from the family and style, in lower case with no spaces.
	 * @return array containing the font data, or false in case of error.
	 * @param $subset (mixed) if true embedd only a subset of the font (stores only the information related to the used characters); if false embedd full font; if 'default' uses the default value set using setFontSubsetting(). This option is valid only for TrueTypeUnicode fonts. If you want to enable users to change the document, set this parameter to false. If you subset the font, the person who receives your PDF would need to have your same font in order to make changes to your PDF. The file size of the PDF would also be smaller because you are embedding only part of a font.
	 * @public
	 * @since 1.5
	 * @see SetFont(), setFontSubsetting()
	 */
	public function AddFont($family, $style='', $fontfile='', $subset='default') {
		if ($subset === 'default') {
			$subset = $this->font_subsetting;
		}
		if ($this->pdfa_mode) {
			$subset = false;
		}
		if (TCPDF_STATIC::empty_string($family)) {
			if (!TCPDF_STATIC::empty_string($this->FontFamily)) {
				$family = $this->FontFamily;
			} else {
				$this->Error('Empty font family');
			}
		}
		// move embedded styles on $style
		if (substr($family, -1) == 'I') {
			$style .= 'I';
			$family = substr($family, 0, -1);
		}
		if (substr($family, -1) == 'B') {
			$style .= 'B';
			$family = substr($family, 0, -1);
		}
		// normalize family name
		$family = strtolower($family);
		if ((!$this->isunicode) AND ($family == 'arial')) {
			$family = 'helvetica';
		}
		if (($family == 'symbol') OR ($family == 'zapfdingbats')) {
			$style = '';
		}
		if ($this->pdfa_mode AND (isset($this->CoreFonts[$family]))) {
			// all fonts must be embedded
			$family = 'pdfa'.$family;
		}
		$tempstyle = strtoupper($style);
		$style = '';
		// underline
		if (strpos($tempstyle, 'U') !== false) {
			$this->underline = true;
		} else {
			$this->underline = false;
		}
		// line-through (deleted)
		if (strpos($tempstyle, 'D') !== false) {
			$this->linethrough = true;
		} else {
			$this->linethrough = false;
		}
		// overline
		if (strpos($tempstyle, 'O') !== false) {
			$this->overline = true;
		} else {
			$this->overline = false;
		}
		// bold
		if (strpos($tempstyle, 'B') !== false) {
			$style .= 'B';
		}
		// oblique
		if (strpos($tempstyle, 'I') !== false) {
			$style .= 'I';
		}
		$bistyle = $style;
		$fontkey = $family.$style;
		$font_style = $style.($this->underline ? 'U' : '').($this->linethrough ? 'D' : '').($this->overline ? 'O' : '');
		$fontdata = array('fontkey' => $fontkey, 'family' => $family, 'style' => $font_style);
		// check if the font has been already added
		$fb = $this->getFontBuffer($fontkey);
		if ($fb !== false) {
			if ($this->inxobj) {
				// we are inside an XObject template
				$this->xobjects[$this->xobjid]['fonts'][$fontkey] = $fb['i'];
			}
			return $fontdata;
		}
		// get specified font directory (if any)
		$fontdir = false;
		if (!TCPDF_STATIC::empty_string($fontfile)) {
			$fontdir = dirname($fontfile);
			if (TCPDF_STATIC::empty_string($fontdir) OR ($fontdir == '.')) {
				$fontdir = '';
			} else {
				$fontdir .= '/';
			}
		}
		$missing_style = false; // true when the font style variation is missing
		// search and include font file
		if (TCPDF_STATIC::empty_string($fontfile) OR (!@file_exists($fontfile))) {
			// build a standard filenames for specified font
			$tmp_fontfile = str_replace(' ', '', $family).strtolower($style).'.php';
			// search files on various directories
			if (($fontdir !== false) AND @file_exists($fontdir.$tmp_fontfile)) {
				$fontfile = $fontdir.$tmp_fontfile;
			} elseif (@file_exists(TCPDF_FONTS::_getfontpath().$tmp_fontfile)) {
				$fontfile = TCPDF_FONTS::_getfontpath().$tmp_fontfile;
			} elseif (@file_exists($tmp_fontfile)) {
				$fontfile = $tmp_fontfile;
			} elseif (!TCPDF_STATIC::empty_string($style)) {
				$missing_style = true;
				// try to remove the style part
				$tmp_fontfile = str_replace(' ', '', $family).'.php';
				if (($fontdir !== false) AND @file_exists($fontdir.$tmp_fontfile)) {
					$fontfile = $fontdir.$tmp_fontfile;
				} elseif (@file_exists(TCPDF_FONTS::_getfontpath().$tmp_fontfile)) {
					$fontfile = TCPDF_FONTS::_getfontpath().$tmp_fontfile;
				} else {
					$fontfile = $tmp_fontfile;
				}
			}
		}
		// include font file
		if (@file_exists($fontfile)) {
			include($fontfile);
		} else {
			$this->Error('Could not include font definition file: '.$family.'');
		}
		// check font parameters
		if ((!isset($type)) OR (!isset($cw))) {
			$this->Error('The font definition file has a bad format: '.$fontfile.'');
		}
		// SET default parameters
		if (!isset($file) OR TCPDF_STATIC::empty_string($file)) {
			$file = '';
		}
		if (!isset($enc) OR TCPDF_STATIC::empty_string($enc)) {
			$enc = '';
		}
		if (!isset($cidinfo) OR TCPDF_STATIC::empty_string($cidinfo)) {
			$cidinfo = array('Registry'=>'Adobe', 'Ordering'=>'Identity', 'Supplement'=>0);
			$cidinfo['uni2cid'] = array();
		}
		if (!isset($ctg) OR TCPDF_STATIC::empty_string($ctg)) {
			$ctg = '';
		}
		if (!isset($desc) OR TCPDF_STATIC::empty_string($desc)) {
			$desc = array();
		}
		if (!isset($up) OR TCPDF_STATIC::empty_string($up)) {
			$up = -100;
		}
		if (!isset($ut) OR TCPDF_STATIC::empty_string($ut)) {
			$ut = 50;
		}
		if (!isset($cw) OR TCPDF_STATIC::empty_string($cw)) {
			$cw = array();
		}
		if (!isset($dw) OR TCPDF_STATIC::empty_string($dw)) {
			// set default width
			if (isset($desc['MissingWidth']) AND ($desc['MissingWidth'] > 0)) {
				$dw = $desc['MissingWidth'];
			} elseif (isset($cw[32])) {
				$dw = $cw[32];
			} else {
				$dw = 600;
			}
		}
		++$this->numfonts;
		if ($type == 'core') {
			$name = $this->CoreFonts[$fontkey];
			$subset = false;
		} elseif (($type == 'TrueType') OR ($type == 'Type1')) {
			$subset = false;
		} elseif ($type == 'TrueTypeUnicode') {
			$enc = 'Identity-H';
		} elseif ($type == 'cidfont0') {
			if ($this->pdfa_mode) {
				$this->Error('All fonts must be embedded in PDF/A mode!');
			}
		} else {
			$this->Error('Unknow font type: '.$type.'');
		}
		// set name if unset
		if (!isset($name) OR empty($name)) {
			$name = $fontkey;
		}
		// create artificial font style variations if missing (only works with non-embedded fonts)
		if (($type != 'core') AND $missing_style) {
			// style variations
			$styles = array('' => '', 'B' => ',Bold', 'I' => ',Italic', 'BI' => ',BoldItalic');
			$name .= $styles[$bistyle];
			// artificial bold
			if (strpos($bistyle, 'B') !== false) {
				if (isset($desc['StemV'])) {
					// from normal to bold
					$desc['StemV'] = round($desc['StemV'] * 1.75);
				} else {
					// bold
					$desc['StemV'] = 123;
				}
			}
			// artificial italic
			if (strpos($bistyle, 'I') !== false) {
				if (isset($desc['ItalicAngle'])) {
					$desc['ItalicAngle'] -= 11;
				} else {
					$desc['ItalicAngle'] = -11;
				}
				if (isset($desc['Flags'])) {
					$desc['Flags'] |= 64; //bit 7
				} else {
					$desc['Flags'] = 64;
				}
			}
		}
		// check if the array of characters bounding boxes is defined
		if (!isset($cbbox)) {
			$cbbox = array();
		}
		// initialize subsetchars
		$subsetchars = array_fill(0, 255, true);
		$this->setFontBuffer($fontkey, array('fontkey' => $fontkey, 'i' => $this->numfonts, 'type' => $type, 'name' => $name, 'desc' => $desc, 'up' => $up, 'ut' => $ut, 'cw' => $cw, 'cbbox' => $cbbox, 'dw' => $dw, 'enc' => $enc, 'cidinfo' => $cidinfo, 'file' => $file, 'ctg' => $ctg, 'subset' => $subset, 'subsetchars' => $subsetchars));
		if ($this->inxobj) {
			// we are inside an XObject template
			$this->xobjects[$this->xobjid]['fonts'][$fontkey] = $this->numfonts;
		}
		if (isset($diff) AND (!empty($diff))) {
			//Search existing encodings
			$d = 0;
			$nb = count($this->diffs);
			for ($i=1; $i <= $nb; ++$i) {
				if ($this->diffs[$i] == $diff) {
					$d = $i;
					break;
				}
			}
			if ($d == 0) {
				$d = $nb + 1;
				$this->diffs[$d] = $diff;
			}
			$this->setFontSubBuffer($fontkey, 'diff', $d);
		}
		if (!TCPDF_STATIC::empty_string($file)) {
			if (!isset($this->FontFiles[$file])) {
				if ((strcasecmp($type,'TrueType') == 0) OR (strcasecmp($type, 'TrueTypeUnicode') == 0)) {
					$this->FontFiles[$file] = array('length1' => $originalsize, 'fontdir' => $fontdir, 'subset' => $subset, 'fontkeys' => array($fontkey));
				} elseif ($type != 'core') {
					$this->FontFiles[$file] = array('length1' => $size1, 'length2' => $size2, 'fontdir' => $fontdir, 'subset' => $subset, 'fontkeys' => array($fontkey));
				}
			} else {
				// update fontkeys that are sharing this font file
				$this->FontFiles[$file]['subset'] = ($this->FontFiles[$file]['subset'] AND $subset);
				if (!in_array($fontkey, $this->FontFiles[$file]['fontkeys'])) {
					$this->FontFiles[$file]['fontkeys'][] = $fontkey;
				}
			}
		}
		return $fontdata;
	}

	/**
	 * Sets the font used to print character strings.
	 * The font can be either a standard one or a font added via the AddFont() method. Standard fonts use Windows encoding cp1252 (Western Europe).
	 * The method can be called before the first page is created and the font is retained from page to page.
	 * If you just wish to change the current font size, it is simpler to call SetFontSize().
	 * Note: for the standard fonts, the font metric files must be accessible. There are three possibilities for this:<ul><li>They are in the current directory (the one where the running script lies)</li><li>They are in one of the directories defined by the include_path parameter</li><li>They are in the directory defined by the K_PATH_FONTS constant</li></ul><br />
	 * @param $family (string) Family font. It can be either a name defined by AddFont() or one of the standard Type1 families (case insensitive):<ul><li>times (Times-Roman)</li><li>timesb (Times-Bold)</li><li>timesi (Times-Italic)</li><li>timesbi (Times-BoldItalic)</li><li>helvetica (Helvetica)</li><li>helveticab (Helvetica-Bold)</li><li>helveticai (Helvetica-Oblique)</li><li>helveticabi (Helvetica-BoldOblique)</li><li>courier (Courier)</li><li>courierb (Courier-Bold)</li><li>courieri (Courier-Oblique)</li><li>courierbi (Courier-BoldOblique)</li><li>symbol (Symbol)</li><li>zapfdingbats (ZapfDingbats)</li></ul> It is also possible to pass an empty string. In that case, the current family is retained.
	 * @param $style (string) Font style. Possible values are (case insensitive):<ul><li>empty string: regular</li><li>B: bold</li><li>I: italic</li><li>U: underline</li><li>D: line through</li><li>O: overline</li></ul> or any combination. The default value is regular. Bold and italic styles do not apply to Symbol and ZapfDingbats basic fonts or other fonts when not defined.
	 * @param $size (float) Font size in points. The default value is the current size. If no size has been specified since the beginning of the document, the value taken is 12
	 * @param $fontfile (string) The font definition file. By default, the name is built from the family and style, in lower case with no spaces.
	 * @param $subset (mixed) if true embedd only a subset of the font (stores only the information related to the used characters); if false embedd full font; if 'default' uses the default value set using setFontSubsetting(). This option is valid only for TrueTypeUnicode fonts. If you want to enable users to change the document, set this parameter to false. If you subset the font, the person who receives your PDF would need to have your same font in order to make changes to your PDF. The file size of the PDF would also be smaller because you are embedding only part of a font.
	 * @param $out (boolean) if true output the font size command, otherwise only set the font properties.
	 * @author Nicola Asuni
	 * @public
	 * @since 1.0
	 * @see AddFont(), SetFontSize()
	 */
	public function SetFont($family, $style='', $size=null, $fontfile='', $subset='default', $out=true) {
		//Select a font; size given in points
		if ($size === null) {
			$size = $this->FontSizePt;
		}
		if ($size < 0) {
			$size = 0;
		}
		// try to add font (if not already added)
		$fontdata = $this->AddFont($family, $style, $fontfile, $subset);
		$this->FontFamily = $fontdata['family'];
		$this->FontStyle = $fontdata['style'];
		if (isset($this->CurrentFont['fontkey']) AND isset($this->CurrentFont['subsetchars'])) {
			// save subset chars of the previous font
			$this->setFontSubBuffer($this->CurrentFont['fontkey'], 'subsetchars', $this->CurrentFont['subsetchars']);
		}
		$this->CurrentFont = $this->getFontBuffer($fontdata['fontkey']);
		$this->SetFontSize($size, $out);
	}

	/**
	 * Defines the size of the current font.
	 * @param $size (float) The font size in points.
	 * @param $out (boolean) if true output the font size command, otherwise only set the font properties.
	 * @public
	 * @since 1.0
	 * @see SetFont()
	 */
	public function SetFontSize($size, $out=true) {
		// font size in points
		$this->FontSizePt = $size;
		// font size in user units
		$this->FontSize = $size / $this->k;
		// calculate some font metrics
		if (isset($this->CurrentFont['desc']['FontBBox'])) {
			$bbox = explode(' ', substr($this->CurrentFont['desc']['FontBBox'], 1, -1));
			$font_height = ((intval($bbox[3]) - intval($bbox[1])) * $size / 1000);
		} else {
			$font_height = $size * 1.219;
		}
		if (isset($this->CurrentFont['desc']['Ascent']) AND ($this->CurrentFont['desc']['Ascent'] > 0)) {
			$font_ascent = ($this->CurrentFont['desc']['Ascent'] * $size / 1000);
		}
		if (isset($this->CurrentFont['desc']['Descent']) AND ($this->CurrentFont['desc']['Descent'] <= 0)) {
			$font_descent = (- $this->CurrentFont['desc']['Descent'] * $size / 1000);
		}
		if (!isset($font_ascent) AND !isset($font_descent)) {
			// core font
			$font_ascent = 0.76 * $font_height;
			$font_descent = $font_height - $font_ascent;
		} elseif (!isset($font_descent)) {
			$font_descent = $font_height - $font_ascent;
		} elseif (!isset($font_ascent)) {
			$font_ascent = $font_height - $font_descent;
		}
		$this->FontAscent = ($font_ascent / $this->k);
		$this->FontDescent = ($font_descent / $this->k);
		if ($out AND ($this->page > 0) AND (isset($this->CurrentFont['i'])) AND ($this->state == 2)) {
			$this->_out(sprintf('BT /F%d %F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
		}
	}

	/**
	 * Returns the bounding box of the current font in user units.
	 * @return array
	 * @public
	 * @since 5.9.152 (2012-03-23)
	 */
	public function getFontBBox() {
		$fbbox = array();
		if (isset($this->CurrentFont['desc']['FontBBox'])) {
			$tmpbbox = explode(' ', substr($this->CurrentFont['desc']['FontBBox'], 1, -1));
			$fbbox = array_map(array($this,'getAbsFontMeasure'), $tmpbbox);
		} else {
			// Find max width
			if (isset($this->CurrentFont['desc']['MaxWidth'])) {
				$maxw = $this->getAbsFontMeasure(intval($this->CurrentFont['desc']['MaxWidth']));
			} else {
				$maxw = 0;
				if (isset($this->CurrentFont['desc']['MissingWidth'])) {
					$maxw = max($maxw, $this->CurrentFont['desc']['MissingWidth']);
				}
				if (isset($this->CurrentFont['desc']['AvgWidth'])) {
					$maxw = max($maxw, $this->CurrentFont['desc']['AvgWidth']);
				}
				if (isset($this->CurrentFont['dw'])) {
					$maxw = max($maxw, $this->CurrentFont['dw']);
				}
				foreach ($this->CurrentFont['cw'] as $char => $w) {
					$maxw = max($maxw, $w);
				}
				if ($maxw == 0) {
					$maxw = 600;
				}
				$maxw = $this->getAbsFontMeasure($maxw);
			}
			$fbbox = array(0, (0 - $this->FontDescent), $maxw, $this->FontAscent);
		}
		return $fbbox;
	}

	/**
	 * Convert a relative font measure into absolute value.
	 * @param $s (int) Font measure.
	 * @return float Absolute measure.
	 * @since 5.9.186 (2012-09-13)
	 */
	public function getAbsFontMeasure($s) {
		return ($s * $this->FontSize / 1000);
	}

	/**
	 * Returns the glyph bounding box of the specified character in the current font in user units.
	 * @param $char (int) Input character code.
	 * @return mixed array(xMin, yMin, xMax, yMax) or FALSE if not defined.
	 * @since 5.9.186 (2012-09-13)
	 */
	public function getCharBBox($char) {
		if (isset($this->CurrentFont['cbbox'][$char])) {
			return array_map(array($this,'getAbsFontMeasure'), $this->CurrentFont['cbbox'][intval($char)]);
		}
		return false;
	}

	/**
	 * Return the font descent value
	 * @param $font (string) font name
	 * @param $style (string) font style
	 * @param $size (float) The size (in points)
	 * @return int font descent
	 * @public
	 * @author Nicola Asuni
	 * @since 4.9.003 (2010-03-30)
	 */
	public function getFontDescent($font, $style='', $size=0) {
		$fontdata = $this->AddFont($font, $style);
		$fontinfo = $this->getFontBuffer($fontdata['fontkey']);
		if (isset($fontinfo['desc']['Descent']) AND ($fontinfo['desc']['Descent'] <= 0)) {
			$descent = (- $fontinfo['desc']['Descent'] * $size / 1000);
		} else {
			$descent = (1.219 * 0.24 * $size);
		}
		return ($descent / $this->k);
	}

	/**
	 * Return the font ascent value.
	 * @param $font (string) font name
	 * @param $style (string) font style
	 * @param $size (float) The size (in points)
	 * @return int font ascent
	 * @public
	 * @author Nicola Asuni
	 * @since 4.9.003 (2010-03-30)
	 */
	public function getFontAscent($font, $style='', $size=0) {
		$fontdata = $this->AddFont($font, $style);
		$fontinfo = $this->getFontBuffer($fontdata['fontkey']);
		if (isset($fontinfo['desc']['Ascent']) AND ($fontinfo['desc']['Ascent'] > 0)) {
			$ascent = ($fontinfo['desc']['Ascent'] * $size / 1000);
		} else {
			$ascent = 1.219 * 0.76 * $size;
		}
		return ($ascent / $this->k);
	}

	/**
	 * Return true in the character is present in the specified font.
	 * @param $char (mixed) Character to check (integer value or string)
	 * @param $font (string) Font name (family name).
	 * @param $style (string) Font style.
	 * @return (boolean) true if the char is defined, false otherwise.
	 * @public
	 * @since 5.9.153 (2012-03-28)
	 */
	public function isCharDefined($char, $font='', $style='') {
		if (is_string($char)) {
			// get character code
			$char = TCPDF_FONTS::UTF8StringToArray($char, $this->isunicode, $this->CurrentFont);
			$char = $char[0];
		}
		if (TCPDF_STATIC::empty_string($font)) {
			if (TCPDF_STATIC::empty_string($style)) {
				return (isset($this->CurrentFont['cw'][intval($char)]));
			}
			$font = $this->FontFamily;
		}
		$fontdata = $this->AddFont($font, $style);
		$fontinfo = $this->getFontBuffer($fontdata['fontkey']);
		return (isset($fontinfo['cw'][intval($char)]));
	}

	/**
	 * Replace missing font characters on selected font with specified substitutions.
	 * @param $text (string) Text to process.
	 * @param $font (string) Font name (family name).
	 * @param $style (string) Font style.
	 * @param $subs (array) Array of possible character substitutions. The key is the character to check (integer value) and the value is a single intege value or an array of possible substitutes.
	 * @return (string) Processed text.
	 * @public
	 * @since 5.9.153 (2012-03-28)
	 */
	public function replaceMissingChars($text, $font='', $style='', $subs=array()) {
		if (empty($subs)) {
			return $text;
		}
		if (TCPDF_STATIC::empty_string($font)) {
			$font = $this->FontFamily;
		}
		$fontdata = $this->AddFont($font, $style);
		$fontinfo = $this->getFontBuffer($fontdata['fontkey']);
		$uniarr = TCPDF_FONTS::UTF8StringToArray($text, $this->isunicode, $this->CurrentFont);
		foreach ($uniarr as $k => $chr) {
			if (!isset($fontinfo['cw'][$chr])) {
				// this character is missing on the selected font
				if (isset($subs[$chr])) {
					// we have available substitutions
					if (is_array($subs[$chr])) {
						foreach($subs[$chr] as $s) {
							if (isset($fontinfo['cw'][$s])) {
								$uniarr[$k] = $s;
								break;
							}
						}
					} elseif (isset($fontinfo['cw'][$subs[$chr]])) {
						$uniarr[$k] = $subs[$chr];
					}
				}
			}
		}
		return TCPDF_FONTS::UniArrSubString(TCPDF_FONTS::UTF8ArrayToUniArray($uniarr, $this->isunicode));
	}

	/**
	 * Defines the default monospaced font.
	 * @param $font (string) Font name.
	 * @public
	 * @since 4.5.025
	 */
	public function SetDefaultMonospacedFont($font) {
		$this->default_monospaced_font = $font;
	}

	/**
	 * Creates a new internal link and returns its identifier. An internal link is a clickable area which directs to another place within the document.<br />
	 * The identifier can then be passed to Cell(), Write(), Image() or Link(). The destination is defined with SetLink().
	 * @public
	 * @since 1.5
	 * @see Cell(), Write(), Image(), Link(), SetLink()
	 */
	public function AddLink() {
		//Create a new internal link
		$n = count($this->links) + 1;
		$this->links[$n] = array(0, 0);
		return $n;
	}

	/**
	 * Defines the page and position a link points to.
	 * @param $link (int) The link identifier returned by AddLink()
	 * @param $y (float) Ordinate of target position; -1 indicates the current position. The default value is 0 (top of page)
	 * @param $page (int) Number of target page; -1 indicates the current page. This is the default value
	 * @public
	 * @since 1.5
	 * @see AddLink()
	 */
	public function SetLink($link, $y=0, $page=-1) {
		if ($y == -1) {
			$y = $this->y;
		}
		if ($page == -1) {
			$page = $this->page;
		}
		$this->links[$link] = array($page, $y);
	}

	/**
	 * Puts a link on a rectangular area of the page.
	 * Text or image links are generally put via Cell(), Write() or Image(), but this method can be useful for instance to define a clickable area inside an image.
	 * @param $x (float) Abscissa of the upper-left corner of the rectangle
	 * @param $y (float) Ordinate of the upper-left corner of the rectangle
	 * @param $w (float) Width of the rectangle
	 * @param $h (float) Height of the rectangle
	 * @param $link (mixed) URL or identifier returned by AddLink()
	 * @param $spaces (int) number of spaces on the text to link
	 * @public
	 * @since 1.5
	 * @see AddLink(), Annotation(), Cell(), Write(), Image()
	 */
	public function Link($x, $y, $w, $h, $link, $spaces=0) {
		$this->Annotation($x, $y, $w, $h, $link, array('Subtype'=>'Link'), $spaces);
	}

	/**
	 * Puts a markup annotation on a rectangular area of the page.
	 * !!!!THE ANNOTATION SUPPORT IS NOT YET FULLY IMPLEMENTED !!!!
	 * @param $x (float) Abscissa of the upper-left corner of the rectangle
	 * @param $y (float) Ordinate of the upper-left corner of the rectangle
	 * @param $w (float) Width of the rectangle
	 * @param $h (float) Height of the rectangle
	 * @param $text (string) annotation text or alternate content
	 * @param $opt (array) array of options (see section 8.4 of PDF reference 1.7).
	 * @param $spaces (int) number of spaces on the text to link
	 * @public
	 * @since 4.0.018 (2008-08-06)
	 */
	public function Annotation($x, $y, $w, $h, $text, $opt=array('Subtype'=>'Text'), $spaces=0) {
		if ($this->inxobj) {
			// store parameters for later use on template
			$this->xobjects[$this->xobjid]['annotations'][] = array('x' => $x, 'y' => $y, 'w' => $w, 'h' => $h, 'text' => $text, 'opt' => $opt, 'spaces' => $spaces);
			return;
		}
		if ($x === '') {
			$x = $this->x;
		}
		if ($y === '') {
			$y = $this->y;
		}
		// check page for no-write regions and adapt page margins if necessary
		list($x, $y) = $this->checkPageRegions($h, $x, $y);
		// recalculate coordinates to account for graphic transformations
		if (isset($this->transfmatrix) AND !empty($this->transfmatrix)) {
			for ($i=$this->transfmatrix_key; $i > 0; --$i) {
				$maxid = count($this->transfmatrix[$i]) - 1;
				for ($j=$maxid; $j >= 0; --$j) {
					$ctm = $this->transfmatrix[$i][$j];
					if (isset($ctm['a'])) {
						$x = $x * $this->k;
						$y = ($this->h - $y) * $this->k;
						$w = $w * $this->k;
						$h = $h * $this->k;
						// top left
						$xt = $x;
						$yt = $y;
						$x1 = ($ctm['a'] * $xt) + ($ctm['c'] * $yt) + $ctm['e'];
						$y1 = ($ctm['b'] * $xt) + ($ctm['d'] * $yt) + $ctm['f'];
						// top right
						$xt = $x + $w;
						$yt = $y;
						$x2 = ($ctm['a'] * $xt) + ($ctm['c'] * $yt) + $ctm['e'];
						$y2 = ($ctm['b'] * $xt) + ($ctm['d'] * $yt) + $ctm['f'];
						// bottom left
						$xt = $x;
						$yt = $y - $h;
						$x3 = ($ctm['a'] * $xt) + ($ctm['c'] * $yt) + $ctm['e'];
						$y3 = ($ctm['b'] * $xt) + ($ctm['d'] * $yt) + $ctm['f'];
						// bottom right
						$xt = $x + $w;
						$yt = $y - $h;
						$x4 = ($ctm['a'] * $xt) + ($ctm['c'] * $yt) + $ctm['e'];
						$y4 = ($ctm['b'] * $xt) + ($ctm['d'] * $yt) + $ctm['f'];
						// new coordinates (rectangle area)
						$x = min($x1, $x2, $x3, $x4);
						$y = max($y1, $y2, $y3, $y4);
						$w = (max($x1, $x2, $x3, $x4) - $x) / $this->k;
						$h = ($y - min($y1, $y2, $y3, $y4)) / $this->k;
						$x = $x / $this->k;
						$y = $this->h - ($y / $this->k);
					}
				}
			}
		}
		if ($this->page <= 0) {
			$page = 1;
		} else {
			$page = $this->page;
		}
		if (!isset($this->PageAnnots[$page])) {
			$this->PageAnnots[$page] = array();
		}
		$this->PageAnnots[$page][] = array('n' => ++$this->n, 'x' => $x, 'y' => $y, 'w' => $w, 'h' => $h, 'txt' => $text, 'opt' => $opt, 'numspaces' => $spaces);
		if (!$this->pdfa_mode) {
			if ((($opt['Subtype'] == 'FileAttachment') OR ($opt['Subtype'] == 'Sound')) AND (!TCPDF_STATIC::empty_string($opt['FS']))
				AND (@file_exists($opt['FS']) OR TCPDF_STATIC::isValidURL($opt['FS']))
				AND (!isset($this->embeddedfiles[basename($opt['FS'])]))) {
				$this->embeddedfiles[basename($opt['FS'])] = array('f' => ++$this->n, 'n' => ++$this->n, 'file' => $opt['FS']);
			}
		}
		// Add widgets annotation's icons
		if (isset($opt['mk']['i']) AND @file_exists($opt['mk']['i'])) {
			$this->Image($opt['mk']['i'], '', '', 10, 10, '', '', '', false, 300, '', false, false, 0, false, true);
		}
		if (isset($opt['mk']['ri']) AND @file_exists($opt['mk']['ri'])) {
			$this->Image($opt['mk']['ri'], '', '', 0, 0, '', '', '', false, 300, '', false, false, 0, false, true);
		}
		if (isset($opt['mk']['ix']) AND @file_exists($opt['mk']['ix'])) {
			$this->Image($opt['mk']['ix'], '', '', 0, 0, '', '', '', false, 300, '', false, false, 0, false, true);
		}
	}

	/**
	 * Embedd the attached files.
	 * @since 4.4.000 (2008-12-07)
	 * @protected
	 * @see Annotation()
	 */
	protected function _putEmbeddedFiles() {
		if ($this->pdfa_mode) {
			// embedded files are not allowed in PDF/A mode
			return;
		}
		reset($this->embeddedfiles);
		foreach ($this->embeddedfiles as $filename => $filedata) {
			// update name tree
			$this->efnames[$filename] = $filedata['f'].' 0 R';
			// embedded file specification object
			$out = $this->_getobj($filedata['f'])."\n";
			$out .= '<</Type /Filespec /F '.$this->_datastring($filename, $filedata['f']).' /EF <</F '.$filedata['n'].' 0 R>> >>';
			$out .= "\n".'endobj';
			$this->_out($out);
			// embedded file object
			$data = file_get_contents($filedata['file']);
			$filter = '';
			$rawsize = strlen($data);
			if ($this->compress) {
				$data = gzcompress($data);
				$filter = ' /Filter /FlateDecode';
			}
			$stream = $this->_getrawstream($data, $filedata['n']);
			$out = $this->_getobj($filedata['n'])."\n";
			$out .= '<< /Type /EmbeddedFile'.$filter.' /Length '.strlen($stream).' /Params <</Size '.$rawsize.'>> >>';
			$out .= ' stream'."\n".$stream."\n".'endstream';
			$out .= "\n".'endobj';
			$this->_out($out);
		}
	}

	/**
	 * Prints a text cell at the specified position.
	 * This method allows to place a string precisely on the page.
	 * @param $x (float) Abscissa of the cell origin
	 * @param $y (float) Ordinate of the cell origin
	 * @param $txt (string) String to print
	 * @param $fstroke (int) outline size in user units (false = disable)
	 * @param $fclip (boolean) if true activate clipping mode (you must call StartTransform() before this function and StopTransform() to stop the clipping tranformation).
	 * @param $ffill (boolean) if true fills the text
	 * @param $border (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @param $ln (int) Indicates where the current position should go after the call. Possible values are:<ul><li>0: to the right (or left for RTL languages)</li><li>1: to the beginning of the next line</li><li>2: below</li></ul>Putting 1 is equivalent to putting 0 and calling Ln() just after. Default value: 0.
	 * @param $align (string) Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align (default value)</li><li>C: center</li><li>R: right align</li><li>J: justify</li></ul>
	 * @param $fill (boolean) Indicates if the cell background must be painted (true) or transparent (false).
	 * @param $link (mixed) URL or identifier returned by AddLink().
	 * @param $stretch (int) font stretch mode: <ul><li>0 = disabled</li><li>1 = horizontal scaling only if text is larger than cell width</li><li>2 = forced horizontal scaling to fit cell width</li><li>3 = character spacing only if text is larger than cell width</li><li>4 = forced character spacing to fit cell width</li></ul> General font stretching and scaling values will be preserved when possible.
	 * @param $ignore_min_height (boolean) if true ignore automatic minimum height value.
	 * @param $calign (string) cell vertical alignment relative to the specified Y value. Possible values are:<ul><li>T : cell top</li><li>A : font top</li><li>L : font baseline</li><li>D : font bottom</li><li>B : cell bottom</li></ul>
	 * @param $valign (string) text vertical alignment inside the cell. Possible values are:<ul><li>T : top</li><li>C : center</li><li>B : bottom</li></ul>
	 * @param $rtloff (boolean) if true uses the page top-left corner as origin of axis for $x and $y initial position.
	 * @public
	 * @since 1.0
	 * @see Cell(), Write(), MultiCell(), WriteHTML(), WriteHTMLCell()
	 */
	public function Text($x, $y, $txt, $fstroke=false, $fclip=false, $ffill=true, $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M', $rtloff=false) {
		$textrendermode = $this->textrendermode;
		$textstrokewidth = $this->textstrokewidth;
		$this->setTextRenderingMode($fstroke, $ffill, $fclip);
		$this->SetXY($x, $y, $rtloff);
		$this->Cell(0, 0, $txt, $border, $ln, $align, $fill, $link, $stretch, $ignore_min_height, $calign, $valign);
		// restore previous rendering mode
		$this->textrendermode = $textrendermode;
		$this->textstrokewidth = $textstrokewidth;
	}

	/**
	 * Whenever a page break condition is met, the method is called, and the break is issued or not depending on the returned value.
	 * The default implementation returns a value according to the mode selected by SetAutoPageBreak().<br />
	 * This method is called automatically and should not be called directly by the application.
	 * @return boolean
	 * @public
	 * @since 1.4
	 * @see SetAutoPageBreak()
	 */
	public function AcceptPageBreak() {
		if ($this->num_columns > 1) {
			// multi column mode
			if ($this->current_column < ($this->num_columns - 1)) {
				// go to next column
				$this->selectColumn($this->current_column + 1);
			} elseif ($this->AutoPageBreak) {
				// add a new page
				$this->AddPage();
				// set first column
				$this->selectColumn(0);
			}
			// avoid page breaking from checkPageBreak()
			return false;
		}
		return $this->AutoPageBreak;
	}

	/**
	 * Add page if needed.
	 * @param $h (float) Cell height. Default value: 0.
	 * @param $y (mixed) starting y position, leave empty for current position.
	 * @param $addpage (boolean) if true add a page, otherwise only return the true/false state
	 * @return boolean true in case of page break, false otherwise.
	 * @since 3.2.000 (2008-07-01)
	 * @protected
	 */
	protected function checkPageBreak($h=0, $y='', $addpage=true) {
		if (TCPDF_STATIC::empty_string($y)) {
			$y = $this->y;
		}
		$current_page = $this->page;
		if ((($y + $h) > $this->PageBreakTrigger) AND ($this->inPageBody()) AND ($this->AcceptPageBreak())) {
			if ($addpage) {
				//Automatic page break
				$x = $this->x;
				$this->AddPage($this->CurOrientation);
				$this->y = $this->tMargin;
				$oldpage = $this->page - 1;
				if ($this->rtl) {
					if ($this->pagedim[$this->page]['orm'] != $this->pagedim[$oldpage]['orm']) {
						$this->x = $x - ($this->pagedim[$this->page]['orm'] - $this->pagedim[$oldpage]['orm']);
					} else {
						$this->x = $x;
					}
				} else {
					if ($this->pagedim[$this->page]['olm'] != $this->pagedim[$oldpage]['olm']) {
						$this->x = $x + ($this->pagedim[$this->page]['olm'] - $this->pagedim[$oldpage]['olm']);
					} else {
						$this->x = $x;
					}
				}
			}
			return true;
		}
		if ($current_page != $this->page) {
			// account for columns mode
			return true;
		}
		return false;
	}

	/**
	 * Prints a cell (rectangular area) with optional borders, background color and character string. The upper-left corner of the cell corresponds to the current position. The text can be aligned or centered. After the call, the current position moves to the right or to the next line. It is possible to put a link on the text.<br />
	 * If automatic page breaking is enabled and the cell goes beyond the limit, a page break is done before outputting.
	 * @param $w (float) Cell width. If 0, the cell extends up to the right margin.
	 * @param $h (float) Cell height. Default value: 0.
	 * @param $txt (string) String to print. Default value: empty string.
	 * @param $border (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @param $ln (int) Indicates where the current position should go after the call. Possible values are:<ul><li>0: to the right (or left for RTL languages)</li><li>1: to the beginning of the next line</li><li>2: below</li></ul> Putting 1 is equivalent to putting 0 and calling Ln() just after. Default value: 0.
	 * @param $align (string) Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align (default value)</li><li>C: center</li><li>R: right align</li><li>J: justify</li></ul>
	 * @param $fill (boolean) Indicates if the cell background must be painted (true) or transparent (false).
	 * @param $link (mixed) URL or identifier returned by AddLink().
	 * @param $stretch (int) font stretch mode: <ul><li>0 = disabled</li><li>1 = horizontal scaling only if text is larger than cell width</li><li>2 = forced horizontal scaling to fit cell width</li><li>3 = character spacing only if text is larger than cell width</li><li>4 = forced character spacing to fit cell width</li></ul> General font stretching and scaling values will be preserved when possible.
	 * @param $ignore_min_height (boolean) if true ignore automatic minimum height value.
	 * @param $calign (string) cell vertical alignment relative to the specified Y value. Possible values are:<ul><li>T : cell top</li><li>C : center</li><li>B : cell bottom</li><li>A : font top</li><li>L : font baseline</li><li>D : font bottom</li></ul>
	 * @param $valign (string) text vertical alignment inside the cell. Possible values are:<ul><li>T : top</li><li>C : center</li><li>B : bottom</li></ul>
	 * @public
	 * @since 1.0
	 * @see SetFont(), SetDrawColor(), SetFillColor(), SetTextColor(), SetLineWidth(), AddLink(), Ln(), MultiCell(), Write(), SetAutoPageBreak()
	 */
	public function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M') {
		$prev_cell_margin = $this->cell_margin;
		$prev_cell_padding = $this->cell_padding;
		$this->adjustCellPadding($border);
		if (!$ignore_min_height) {
			$min_cell_height = ($this->FontSize * $this->cell_height_ratio) + $this->cell_padding['T'] + $this->cell_padding['B'];
			if ($h < $min_cell_height) {
				$h = $min_cell_height;
			}
		}
		$this->checkPageBreak($h + $this->cell_margin['T'] + $this->cell_margin['B']);
		// apply text shadow if enabled
		if ($this->txtshadow['enabled']) {
			// save data
			$x = $this->x;
			$y = $this->y;
			$bc = $this->bgcolor;
			$fc = $this->fgcolor;
			$sc = $this->strokecolor;
			$alpha = $this->alpha;
			// print shadow
			$this->x += $this->txtshadow['depth_w'];
			$this->y += $this->txtshadow['depth_h'];
			$this->SetFillColorArray($this->txtshadow['color']);
			$this->SetTextColorArray($this->txtshadow['color']);
			$this->SetDrawColorArray($this->txtshadow['color']);
			if ($this->txtshadow['opacity'] != $alpha['CA']) {
				$this->setAlpha($this->txtshadow['opacity'], $this->txtshadow['blend_mode']);
			}
			if ($this->state == 2) {
				$this->_out($this->getCellCode($w, $h, $txt, $border, $ln, $align, $fill, $link, $stretch, true, $calign, $valign));
			}
			//restore data
			$this->x = $x;
			$this->y = $y;
			$this->SetFillColorArray($bc);
			$this->SetTextColorArray($fc);
			$this->SetDrawColorArray($sc);
			if ($this->txtshadow['opacity'] != $alpha['CA']) {
				$this->setAlpha($alpha['CA'], $alpha['BM'], $alpha['ca'], $alpha['AIS']);
			}
		}
		if ($this->state == 2) {
			$this->_out($this->getCellCode($w, $h, $txt, $border, $ln, $align, $fill, $link, $stretch, true, $calign, $valign));
		}
		$this->cell_padding = $prev_cell_padding;
		$this->cell_margin = $prev_cell_margin;
	}

	/**
	 * Returns the PDF string code to print a cell (rectangular area) with optional borders, background color and character string. The upper-left corner of the cell corresponds to the current position. The text can be aligned or centered. After the call, the current position moves to the right or to the next line. It is possible to put a link on the text.<br />
	 * If automatic page breaking is enabled and the cell goes beyond the limit, a page break is done before outputting.
	 * @param $w (float) Cell width. If 0, the cell extends up to the right margin.
	 * @param $h (float) Cell height. Default value: 0.
	 * @param $txt (string) String to print. Default value: empty string.
	 * @param $border (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @param $ln (int) Indicates where the current position should go after the call. Possible values are:<ul><li>0: to the right (or left for RTL languages)</li><li>1: to the beginning of the next line</li><li>2: below</li></ul>Putting 1 is equivalent to putting 0 and calling Ln() just after. Default value: 0.
	 * @param $align (string) Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align (default value)</li><li>C: center</li><li>R: right align</li><li>J: justify</li></ul>
	 * @param $fill (boolean) Indicates if the cell background must be painted (true) or transparent (false).
	 * @param $link (mixed) URL or identifier returned by AddLink().
	 * @param $stretch (int) font stretch mode: <ul><li>0 = disabled</li><li>1 = horizontal scaling only if text is larger than cell width</li><li>2 = forced horizontal scaling to fit cell width</li><li>3 = character spacing only if text is larger than cell width</li><li>4 = forced character spacing to fit cell width</li></ul> General font stretching and scaling values will be preserved when possible.
	 * @param $ignore_min_height (boolean) if true ignore automatic minimum height value.
	 * @param $calign (string) cell vertical alignment relative to the specified Y value. Possible values are:<ul><li>T : cell top</li><li>C : center</li><li>B : cell bottom</li><li>A : font top</li><li>L : font baseline</li><li>D : font bottom</li></ul>
	 * @param $valign (string) text vertical alignment inside the cell. Possible values are:<ul><li>T : top</li><li>M : middle</li><li>B : bottom</li></ul>
	 * @return string containing cell code
	 * @protected
	 * @since 1.0
	 * @see Cell()
	 */
	protected function getCellCode($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M') {
		// replace 'NO-BREAK SPACE' (U+00A0) character with a simple space
		$txt = str_replace(TCPDF_FONTS::unichr(160, $this->isunicode), ' ', $txt);
		$prev_cell_margin = $this->cell_margin;
		$prev_cell_padding = $this->cell_padding;
		$txt = TCPDF_STATIC::removeSHY($txt, $this->isunicode);
		$rs = ''; //string to be returned
		$this->adjustCellPadding($border);
		if (!$ignore_min_height) {
			$min_cell_height = ($this->FontSize * $this->cell_height_ratio) + $this->cell_padding['T'] + $this->cell_padding['B'];
			if ($h < $min_cell_height) {
				$h = $min_cell_height;
			}
		}
		$k = $this->k;
		// check page for no-write regions and adapt page margins if necessary
		list($this->x, $this->y) = $this->checkPageRegions($h, $this->x, $this->y);
		if ($this->rtl) {
			$x = $this->x - $this->cell_margin['R'];
		} else {
			$x = $this->x + $this->cell_margin['L'];
		}
		$y = $this->y + $this->cell_margin['T'];
		$prev_font_stretching = $this->font_stretching;
		$prev_font_spacing = $this->font_spacing;
		// cell vertical alignment
		switch ($calign) {
			case 'A': {
				// font top
				switch ($valign) {
					case 'T': {
						// top
						$y -= $this->cell_padding['T'];
						break;
					}
					case 'B': {
						// bottom
						$y -= ($h - $this->cell_padding['B'] - $this->FontAscent - $this->FontDescent);
						break;
					}
					default:
					case 'C':
					case 'M': {
						// center
						$y -= (($h - $this->FontAscent - $this->FontDescent) / 2);
						break;
					}
				}
				break;
			}
			case 'L': {
				// font baseline
				switch ($valign) {
					case 'T': {
						// top
						$y -= ($this->cell_padding['T'] + $this->FontAscent);
						break;
					}
					case 'B': {
						// bottom
						$y -= ($h - $this->cell_padding['B'] - $this->FontDescent);
						break;
					}
					default:
					case 'C':
					case 'M': {
						// center
						$y -= (($h + $this->FontAscent - $this->FontDescent) / 2);
						break;
					}
				}
				break;
			}
			case 'D': {
				// font bottom
				switch ($valign) {
					case 'T': {
						// top
						$y -= ($this->cell_padding['T'] + $this->FontAscent + $this->FontDescent);
						break;
					}
					case 'B': {
						// bottom
						$y -= ($h - $this->cell_padding['B']);
						break;
					}
					default:
					case 'C':
					case 'M': {
						// center
						$y -= (($h + $this->FontAscent + $this->FontDescent) / 2);
						break;
					}
				}
				break;
			}
			case 'B': {
				// cell bottom
				$y -= $h;
				break;
			}
			case 'C':
			case 'M': {
				// cell center
				$y -= ($h / 2);
				break;
			}
			default:
			case 'T': {
				// cell top
				break;
			}
		}
		// text vertical alignment
		switch ($valign) {
			case 'T': {
				// top
				$yt = $y + $this->cell_padding['T'];
				break;
			}
			case 'B': {
				// bottom
				$yt = $y + $h - $this->cell_padding['B'] - $this->FontAscent - $this->FontDescent;
				break;
			}
			default:
			case 'C':
			case 'M': {
				// center
				$yt = $y + (($h - $this->FontAscent - $this->FontDescent) / 2);
				break;
			}
		}
		$basefonty = $yt + $this->FontAscent;
		if (TCPDF_STATIC::empty_string($w) OR ($w <= 0)) {
			if ($this->rtl) {
				$w = $x - $this->lMargin;
			} else {
				$w = $this->w - $this->rMargin - $x;
			}
		}
		$s = '';
		// fill and borders
		if (is_string($border) AND (strlen($border) == 4)) {
			// full border
			$border = 1;
		}
		if ($fill OR ($border == 1)) {
			if ($fill) {
				$op = ($border == 1) ? 'B' : 'f';
			} else {
				$op = 'S';
			}
			if ($this->rtl) {
				$xk = (($x - $w) * $k);
			} else {
				$xk = ($x * $k);
			}
			$s .= sprintf('%F %F %F %F re %s ', $xk, (($this->h - $y) * $k), ($w * $k), (-$h * $k), $op);
		}
		// draw borders
		$s .= $this->getCellBorder($x, $y, $w, $h, $border);
		if ($txt != '') {
			$txt2 = $txt;
			if ($this->isunicode) {
				if (($this->CurrentFont['type'] == 'core') OR ($this->CurrentFont['type'] == 'TrueType') OR ($this->CurrentFont['type'] == 'Type1')) {
					$txt2 = TCPDF_FONTS::UTF8ToLatin1($txt2, $this->isunicode, $this->CurrentFont);
				} else {
					$unicode = TCPDF_FONTS::UTF8StringToArray($txt, $this->isunicode, $this->CurrentFont); // array of UTF-8 unicode values
					$unicode = TCPDF_FONTS::utf8Bidi($unicode, '', $this->tmprtl, $this->isunicode, $this->CurrentFont);
					// replace thai chars (if any)
					if (defined('K_THAI_TOPCHARS') AND (K_THAI_TOPCHARS == true)) {
						// number of chars
						$numchars = count($unicode);
						// po pla, for far, for fan
						$longtail = array(0x0e1b, 0x0e1d, 0x0e1f);
						// do chada, to patak
						$lowtail = array(0x0e0e, 0x0e0f);
						// mai hun arkad, sara i, sara ii, sara ue, sara uee
						$upvowel = array(0x0e31, 0x0e34, 0x0e35, 0x0e36, 0x0e37);
						// mai ek, mai tho, mai tri, mai chattawa, karan
						$tonemark = array(0x0e48, 0x0e49, 0x0e4a, 0x0e4b, 0x0e4c);
						// sara u, sara uu, pinthu
						$lowvowel = array(0x0e38, 0x0e39, 0x0e3a);
						$output = array();
						for ($i = 0; $i < $numchars; $i++) {
							if (($unicode[$i] >= 0x0e00) && ($unicode[$i] <= 0x0e5b)) {
								$ch0 = $unicode[$i];
								$ch1 = ($i > 0) ? $unicode[($i - 1)] : 0;
								$ch2 = ($i > 1) ? $unicode[($i - 2)] : 0;
								$chn = ($i < ($numchars - 1)) ? $unicode[($i + 1)] : 0;
								if (in_array($ch0, $tonemark)) {
									if ($chn == 0x0e33) {
										// sara um
										if (in_array($ch1, $longtail)) {
											// tonemark at upper left
											$output[] = $this->replaceChar($ch0, (0xf713 + $ch0 - 0x0e48));
										} else {
											// tonemark at upper right (normal position)
											$output[] = $ch0;
										}
									} elseif (in_array($ch1, $longtail) OR (in_array($ch2, $longtail) AND in_array($ch1, $lowvowel))) {
										// tonemark at lower left
										$output[] = $this->replaceChar($ch0, (0xf705 + $ch0 - 0x0e48));
									} elseif (in_array($ch1, $upvowel)) {
										if (in_array($ch2, $longtail)) {
											// tonemark at upper left
											$output[] = $this->replaceChar($ch0, (0xf713 + $ch0 - 0x0e48));
										} else {
											// tonemark at upper right (normal position)
											$output[] = $ch0;
										}
									} else {
										// tonemark at lower right
										$output[] = $this->replaceChar($ch0, (0xf70a + $ch0 - 0x0e48));
									}
								} elseif (($ch0 == 0x0e33) AND (in_array($ch1, $longtail) OR (in_array($ch2, $longtail) AND in_array($ch1, $tonemark)))) {
									// add lower left nikhahit and sara aa
									if ($this->isCharDefined(0xf711) AND $this->isCharDefined(0x0e32)) {
										$output[] = 0xf711;
										$this->CurrentFont['subsetchars'][0xf711] = true;
										$output[] = 0x0e32;
										$this->CurrentFont['subsetchars'][0x0e32] = true;
									} else {
										$output[] = $ch0;
									}
								} elseif (in_array($ch1, $longtail)) {
									if ($ch0 == 0x0e31) {
										// lower left mai hun arkad
										$output[] = $this->replaceChar($ch0, 0xf710);
									} elseif (in_array($ch0, $upvowel)) {
										// lower left
										$output[] = $this->replaceChar($ch0, (0xf701 + $ch0 - 0x0e34));
									} elseif ($ch0 == 0x0e47) {
										// lower left mai tai koo
										$output[] = $this->replaceChar($ch0, 0xf712);
									} else {
										// normal character
										$output[] = $ch0;
									}
								} elseif (in_array($ch1, $lowtail) AND in_array($ch0, $lowvowel)) {
									// lower vowel
									$output[] = $this->replaceChar($ch0, (0xf718 + $ch0 - 0x0e38));
								} elseif (($ch0 == 0x0e0d) AND in_array($chn, $lowvowel)) {
									// yo ying without lower part
									$output[] = $this->replaceChar($ch0, 0xf70f);
								} elseif (($ch0 == 0x0e10) AND in_array($chn, $lowvowel)) {
									// tho santan without lower part
									$output[] = $this->replaceChar($ch0, 0xf700);
								} else {
									$output[] = $ch0;
								}
							} else {
								// non-thai character
								$output[] = $unicode[$i];
							}
						}
						$unicode = $output;
						// update font subsetchars
						$this->setFontSubBuffer($this->CurrentFont['fontkey'], 'subsetchars', $this->CurrentFont['subsetchars']);
					} // end of K_THAI_TOPCHARS
					$txt2 = TCPDF_FONTS::arrUTF8ToUTF16BE($unicode, false);
				}
			}
			$txt2 = TCPDF_STATIC::_escape($txt2);
			// get current text width (considering general font stretching and spacing)
			$txwidth = $this->GetStringWidth($txt);
			$width = $txwidth;
			// check for stretch mode
			if ($stretch > 0) {
				// calculate ratio between cell width and text width
				if ($width <= 0) {
					$ratio = 1;
				} else {
					$ratio = (($w - $this->cell_padding['L'] - $this->cell_padding['R']) / $width);
				}
				// check if stretching is required
				if (($ratio < 1) OR (($ratio > 1) AND (($stretch % 2) == 0))) {
					// the text will be stretched to fit cell width
					if ($stretch > 2) {
						// set new character spacing
						$this->font_spacing += ($w - $this->cell_padding['L'] - $this->cell_padding['R'] - $width) / (max(($this->GetNumChars($txt) - 1), 1) * ($this->font_stretching / 100));
					} else {
						// set new horizontal stretching
						$this->font_stretching *= $ratio;
					}
					// recalculate text width (the text fills the entire cell)
					$width = $w - $this->cell_padding['L'] - $this->cell_padding['R'];
					// reset alignment
					$align = '';
				}
			}
			if ($this->font_stretching != 100) {
				// apply font stretching
				$rs .= sprintf('BT %F Tz ET ', $this->font_stretching);
			}
			if ($this->font_spacing != 0) {
				// increase/decrease font spacing
				$rs .= sprintf('BT %F Tc ET ', ($this->font_spacing * $this->k));
			}
			if ($this->ColorFlag AND ($this->textrendermode < 4)) {
				$s .= 'q '.$this->TextColor.' ';
			}
			// rendering mode
			$s .= sprintf('BT %d Tr %F w ET ', $this->textrendermode, ($this->textstrokewidth * $this->k));
			// count number of spaces
			$ns = substr_count($txt, chr(32));
			// Justification
			$spacewidth = 0;
			if (($align == 'J') AND ($ns > 0)) {
				if ($this->isUnicodeFont()) {
					// get string width without spaces
					$width = $this->GetStringWidth(str_replace(' ', '', $txt));
					// calculate average space width
					$spacewidth = -1000 * ($w - $width - $this->cell_padding['L'] - $this->cell_padding['R']) / ($ns?$ns:1) / $this->FontSize;
					if ($this->font_stretching != 100) {
						// word spacing is affected by stretching
						$spacewidth /= ($this->font_stretching / 100);
					}
					// set word position to be used with TJ operator
					$txt2 = str_replace(chr(0).chr(32), ') '.sprintf('%F', $spacewidth).' (', $txt2);
					$unicode_justification = true;
				} else {
					// get string width
					$width = $txwidth;
					// new space width
					$spacewidth = (($w - $width - $this->cell_padding['L'] - $this->cell_padding['R']) / ($ns?$ns:1)) * $this->k;
					if ($this->font_stretching != 100) {
						// word spacing (Tw) is affected by stretching
						$spacewidth /= ($this->font_stretching / 100);
					}
					// set word spacing
					$rs .= sprintf('BT %F Tw ET ', $spacewidth);
				}
				$width = $w - $this->cell_padding['L'] - $this->cell_padding['R'];
			}
			// replace carriage return characters
			$txt2 = str_replace("\r", ' ', $txt2);
			switch ($align) {
				case 'C': {
					$dx = ($w - $width) / 2;
					break;
				}
				case 'R': {
					if ($this->rtl) {
						$dx = $this->cell_padding['R'];
					} else {
						$dx = $w - $width - $this->cell_padding['R'];
					}
					break;
				}
				case 'L': {
					if ($this->rtl) {
						$dx = $w - $width - $this->cell_padding['L'];
					} else {
						$dx = $this->cell_padding['L'];
					}
					break;
				}
				case 'J':
				default: {
					if ($this->rtl) {
						$dx = $this->cell_padding['R'];
					} else {
						$dx = $this->cell_padding['L'];
					}
					break;
				}
			}
			if ($this->rtl) {
				$xdx = $x - $dx - $width;
			} else {
				$xdx = $x + $dx;
			}
			$xdk = $xdx * $k;
			// print text
			$s .= sprintf('BT %F %F Td [(%s)] TJ ET', $xdk, (($this->h - $basefonty) * $k), $txt2);
			if (isset($uniblock)) {
				// print overlapping characters as separate string
				$xshift = 0; // horizontal shift
				$ty = (($this->h - $basefonty + (0.2 * $this->FontSize)) * $k);
				$spw = (($w - $txwidth - $this->cell_padding['L'] - $this->cell_padding['R']) / ($ns?$ns:1));
				foreach ($uniblock as $uk => $uniarr) {
					if (($uk % 2) == 0) {
						// x space to skip
						if ($spacewidth != 0) {
							// justification shift
							$xshift += (count(array_keys($uniarr, 32)) * $spw);
						}
						$xshift += $this->GetArrStringWidth($uniarr); // + shift justification
					} else {
						// character to print
						$topchr = TCPDF_FONTS::arrUTF8ToUTF16BE($uniarr, false);
						$topchr = TCPDF_STATIC::_escape($topchr);
						$s .= sprintf(' BT %F %F Td [(%s)] TJ ET', ($xdk + ($xshift * $k)), $ty, $topchr);
					}
				}
			}
			if ($this->underline) {
				$s .= ' '.$this->_dounderlinew($xdx, $basefonty, $width);
			}
			if ($this->linethrough) {
				$s .= ' '.$this->_dolinethroughw($xdx, $basefonty, $width);
			}
			if ($this->overline) {
				$s .= ' '.$this->_dooverlinew($xdx, $basefonty, $width);
			}
			if ($this->ColorFlag AND ($this->textrendermode < 4)) {
				$s .= ' Q';
			}
			if ($link) {
				$this->Link($xdx, $yt, $width, ($this->FontAscent + $this->FontDescent), $link, $ns);
			}
		}
		// output cell
		if ($s) {
			// output cell
			$rs .= $s;
			if ($this->font_spacing != 0) {
				// reset font spacing mode
				$rs .= ' BT 0 Tc ET';
			}
			if ($this->font_stretching != 100) {
				// reset font stretching mode
				$rs .= ' BT 100 Tz ET';
			}
		}
		// reset word spacing
		if (!$this->isUnicodeFont() AND ($align == 'J')) {
			$rs .= ' BT 0 Tw ET';
		}
		// reset stretching and spacing
		$this->font_stretching = $prev_font_stretching;
		$this->font_spacing = $prev_font_spacing;
		$this->lasth = $h;
		if ($ln > 0) {
			//Go to the beginning of the next line
			$this->y = $y + $h + $this->cell_margin['B'];
			if ($ln == 1) {
				if ($this->rtl) {
					$this->x = $this->w - $this->rMargin;
				} else {
					$this->x = $this->lMargin;
				}
			}
		} else {
			// go left or right by case
			if ($this->rtl) {
				$this->x = $x - $w - $this->cell_margin['L'];
			} else {
				$this->x = $x + $w + $this->cell_margin['R'];
			}
		}
		$gstyles = ''.$this->linestyleWidth.' '.$this->linestyleCap.' '.$this->linestyleJoin.' '.$this->linestyleDash.' '.$this->DrawColor.' '.$this->FillColor."\n";
		$rs = $gstyles.$rs;
		$this->cell_padding = $prev_cell_padding;
		$this->cell_margin = $prev_cell_margin;
		return $rs;
	}

	/**
	 * Replace a char if is defined on the current font.
	 * @param $oldchar (int) Integer code (unicode) of the character to replace.
	 * @param $newchar (int) Integer code (unicode) of the new character.
	 * @return int the replaced char or the old char in case the new char i not defined
	 * @protected
	 * @since 5.9.167 (2012-06-22)
	 */
	protected function replaceChar($oldchar, $newchar) {
		if ($this->isCharDefined($newchar)) {
			// add the new char on the subset list
			$this->CurrentFont['subsetchars'][$newchar] = true;
			// return the new character
			return $newchar;
		}
		// return the old char
		return $oldchar;
	}

	/**
	 * Returns the code to draw the cell border
	 * @param $x (float) X coordinate.
	 * @param $y (float) Y coordinate.
	 * @param $w (float) Cell width.
	 * @param $h (float) Cell height.
	 * @param $brd (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @return string containing cell border code
	 * @protected
	 * @see SetLineStyle()
	 * @since 5.7.000 (2010-08-02)
	 */
	protected function getCellBorder($x, $y, $w, $h, $brd) {
		$s = ''; // string to be returned
		if (empty($brd)) {
			return $s;
		}
		if ($brd == 1) {
			$brd = array('LRTB' => true);
		}
		// calculate coordinates for border
		$k = $this->k;
		if ($this->rtl) {
			$xeL = ($x - $w) * $k;
			$xeR = $x * $k;
		} else {
			$xeL = $x * $k;
			$xeR = ($x + $w) * $k;
		}
		$yeL = (($this->h - ($y + $h)) * $k);
		$yeT = (($this->h - $y) * $k);
		$xeT = $xeL;
		$xeB = $xeR;
		$yeR = $yeT;
		$yeB = $yeL;
		if (is_string($brd)) {
			// convert string to array
			$slen = strlen($brd);
			$newbrd = array();
			for ($i = 0; $i < $slen; ++$i) {
				$newbrd[$brd[$i]] = array('cap' => 'square', 'join' => 'miter');
			}
			$brd = $newbrd;
		}
		if (isset($brd['mode'])) {
			$mode = $brd['mode'];
			unset($brd['mode']);
		} else {
			$mode = 'normal';
		}
		foreach ($brd as $border => $style) {
			if (is_array($style) AND !empty($style)) {
				// apply border style
				$prev_style = $this->linestyleWidth.' '.$this->linestyleCap.' '.$this->linestyleJoin.' '.$this->linestyleDash.' '.$this->DrawColor.' ';
				$s .= $this->SetLineStyle($style, true)."\n";
			}
			switch ($mode) {
				case 'ext': {
					$off = (($this->LineWidth / 2) * $k);
					$xL = $xeL - $off;
					$xR = $xeR + $off;
					$yT = $yeT + $off;
					$yL = $yeL - $off;
					$xT = $xL;
					$xB = $xR;
					$yR = $yT;
					$yB = $yL;
					$w += $this->LineWidth;
					$h += $this->LineWidth;
					break;
				}
				case 'int': {
					$off = ($this->LineWidth / 2) * $k;
					$xL = $xeL + $off;
					$xR = $xeR - $off;
					$yT = $yeT - $off;
					$yL = $yeL + $off;
					$xT = $xL;
					$xB = $xR;
					$yR = $yT;
					$yB = $yL;
					$w -= $this->LineWidth;
					$h -= $this->LineWidth;
					break;
				}
				case 'normal':
				default: {
					$xL = $xeL;
					$xT = $xeT;
					$xB = $xeB;
					$xR = $xeR;
					$yL = $yeL;
					$yT = $yeT;
					$yB = $yeB;
					$yR = $yeR;
					break;
				}
			}
			// draw borders by case
			if (strlen($border) == 4) {
				$s .= sprintf('%F %F %F %F re S ', $xT, $yT, ($w * $k), (-$h * $k));
			} elseif (strlen($border) == 3) {
				if (strpos($border,'B') === false) { // LTR
					$s .= sprintf('%F %F m ', $xL, $yL);
					$s .= sprintf('%F %F l ', $xT, $yT);
					$s .= sprintf('%F %F l ', $xR, $yR);
					$s .= sprintf('%F %F l ', $xB, $yB);
					$s .= 'S ';
				} elseif (strpos($border,'L') === false) { // TRB
					$s .= sprintf('%F %F m ', $xT, $yT);
					$s .= sprintf('%F %F l ', $xR, $yR);
					$s .= sprintf('%F %F l ', $xB, $yB);
					$s .= sprintf('%F %F l ', $xL, $yL);
					$s .= 'S ';
				} elseif (strpos($border,'T') === false) { // RBL
					$s .= sprintf('%F %F m ', $xR, $yR);
					$s .= sprintf('%F %F l ', $xB, $yB);
					$s .= sprintf('%F %F l ', $xL, $yL);
					$s .= sprintf('%F %F l ', $xT, $yT);
					$s .= 'S ';
				} elseif (strpos($border,'R') === false) { // BLT
					$s .= sprintf('%F %F m ', $xB, $yB);
					$s .= sprintf('%F %F l ', $xL, $yL);
					$s .= sprintf('%F %F l ', $xT, $yT);
					$s .= sprintf('%F %F l ', $xR, $yR);
					$s .= 'S ';
				}
			} elseif (strlen($border) == 2) {
				if ((strpos($border,'L') !== false) AND (strpos($border,'T') !== false)) { // LT
					$s .= sprintf('%F %F m ', $xL, $yL);
					$s .= sprintf('%F %F l ', $xT, $yT);
					$s .= sprintf('%F %F l ', $xR, $yR);
					$s .= 'S ';
				} elseif ((strpos($border,'T') !== false) AND (strpos($border,'R') !== false)) { // TR
					$s .= sprintf('%F %F m ', $xT, $yT);
					$s .= sprintf('%F %F l ', $xR, $yR);
					$s .= sprintf('%F %F l ', $xB, $yB);
					$s .= 'S ';
				} elseif ((strpos($border,'R') !== false) AND (strpos($border,'B') !== false)) { // RB
					$s .= sprintf('%F %F m ', $xR, $yR);
					$s .= sprintf('%F %F l ', $xB, $yB);
					$s .= sprintf('%F %F l ', $xL, $yL);
					$s .= 'S ';
				} elseif ((strpos($border,'B') !== false) AND (strpos($border,'L') !== false)) { // BL
					$s .= sprintf('%F %F m ', $xB, $yB);
					$s .= sprintf('%F %F l ', $xL, $yL);
					$s .= sprintf('%F %F l ', $xT, $yT);
					$s .= 'S ';
				} elseif ((strpos($border,'L') !== false) AND (strpos($border,'R') !== false)) { // LR
					$s .= sprintf('%F %F m ', $xL, $yL);
					$s .= sprintf('%F %F l ', $xT, $yT);
					$s .= 'S ';
					$s .= sprintf('%F %F m ', $xR, $yR);
					$s .= sprintf('%F %F l ', $xB, $yB);
					$s .= 'S ';
				} elseif ((strpos($border,'T') !== false) AND (strpos($border,'B') !== false)) { // TB
					$s .= sprintf('%F %F m ', $xT, $yT);
					$s .= sprintf('%F %F l ', $xR, $yR);
					$s .= 'S ';
					$s .= sprintf('%F %F m ', $xB, $yB);
					$s .= sprintf('%F %F l ', $xL, $yL);
					$s .= 'S ';
				}
			} else { // strlen($border) == 1
				if (strpos($border,'L') !== false) { // L
					$s .= sprintf('%F %F m ', $xL, $yL);
					$s .= sprintf('%F %F l ', $xT, $yT);
					$s .= 'S ';
				} elseif (strpos($border,'T') !== false) { // T
					$s .= sprintf('%F %F m ', $xT, $yT);
					$s .= sprintf('%F %F l ', $xR, $yR);
					$s .= 'S ';
				} elseif (strpos($border,'R') !== false) { // R
					$s .= sprintf('%F %F m ', $xR, $yR);
					$s .= sprintf('%F %F l ', $xB, $yB);
					$s .= 'S ';
				} elseif (strpos($border,'B') !== false) { // B
					$s .= sprintf('%F %F m ', $xB, $yB);
					$s .= sprintf('%F %F l ', $xL, $yL);
					$s .= 'S ';
				}
			}
			if (is_array($style) AND !empty($style)) {
				// reset border style to previous value
				$s .= "\n".$this->linestyleWidth.' '.$this->linestyleCap.' '.$this->linestyleJoin.' '.$this->linestyleDash.' '.$this->DrawColor."\n";
			}
		}
		return $s;
	}

	/**
	 * This method allows printing text with line breaks.
	 * They can be automatic (as soon as the text reaches the right border of the cell) or explicit (via the \n character). As many cells as necessary are output, one below the other.<br />
	 * Text can be aligned, centered or justified. The cell block can be framed and the background painted.
	 * @param $w (float) Width of cells. If 0, they extend up to the right margin of the page.
	 * @param $h (float) Cell minimum height. The cell extends automatically if needed.
	 * @param $txt (string) String to print
	 * @param $border (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @param $align (string) Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align</li><li>C: center</li><li>R: right align</li><li>J: justification (default value when $ishtml=false)</li></ul>
	 * @param $fill (boolean) Indicates if the cell background must be painted (true) or transparent (false).
	 * @param $ln (int) Indicates where the current position should go after the call. Possible values are:<ul><li>0: to the right</li><li>1: to the beginning of the next line [DEFAULT]</li><li>2: below</li></ul>
	 * @param $x (float) x position in user units
	 * @param $y (float) y position in user units
	 * @param $reseth (boolean) if true reset the last cell height (default true).
	 * @param $stretch (int) font stretch mode: <ul><li>0 = disabled</li><li>1 = horizontal scaling only if text is larger than cell width</li><li>2 = forced horizontal scaling to fit cell width</li><li>3 = character spacing only if text is larger than cell width</li><li>4 = forced character spacing to fit cell width</li></ul> General font stretching and scaling values will be preserved when possible.
	 * @param $ishtml (boolean) INTERNAL USE ONLY -- set to true if $txt is HTML content (default = false). Never set this parameter to true, use instead writeHTMLCell() or writeHTML() methods.
	 * @param $autopadding (boolean) if true, uses internal padding and automatically adjust it to account for line width.
	 * @param $maxh (float) maximum height. It should be >= $h and less then remaining space to the bottom of the page, or 0 for disable this feature. This feature works only when $ishtml=false.
	 * @param $valign (string) Vertical alignment of text (requires $maxh = $h > 0). Possible values are:<ul><li>T: TOP</li><li>M: middle</li><li>B: bottom</li></ul>. This feature works only when $ishtml=false and the cell must fit in a single page.
	 * @param $fitcell (boolean) if true attempt to fit all the text within the cell by reducing the font size (do not work in HTML mode).
	 * @return int Return the number of cells or 1 for html mode.
	 * @public
	 * @since 1.3
	 * @see SetFont(), SetDrawColor(), SetFillColor(), SetTextColor(), SetLineWidth(), Cell(), Write(), SetAutoPageBreak()
	 */
	public function MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false) {
		$prev_cell_margin = $this->cell_margin;
		$prev_cell_padding = $this->cell_padding;
		// adjust internal padding
		$this->adjustCellPadding($border);
		$mc_padding = $this->cell_padding;
		$mc_margin = $this->cell_margin;
		$this->cell_padding['T'] = 0;
		$this->cell_padding['B'] = 0;
		$this->setCellMargins(0, 0, 0, 0);
		if (TCPDF_STATIC::empty_string($this->lasth) OR $reseth) {
			// reset row height
			$this->resetLastH();
		}
		if (!TCPDF_STATIC::empty_string($y)) {
			$this->SetY($y);
		} else {
			$y = $this->GetY();
		}
		$resth = 0;
		if (($h > 0) AND $this->inPageBody() AND (($y + $h + $mc_margin['T'] + $mc_margin['B']) > $this->PageBreakTrigger)) {
			// spit cell in more pages/columns
			$newh = ($this->PageBreakTrigger - $y);
			$resth = ($h - $newh); // cell to be printed on the next page/column
			$h = $newh;
		}
		// get current page number
		$startpage = $this->page;
		// get current column
		$startcolumn = $this->current_column;
		if (!TCPDF_STATIC::empty_string($x)) {
			$this->SetX($x);
		} else {
			$x = $this->GetX();
		}
		// check page for no-write regions and adapt page margins if necessary
		list($x, $y) = $this->checkPageRegions(0, $x, $y);
		// apply margins
		$oy = $y + $mc_margin['T'];
		if ($this->rtl) {
			$ox = ($this->w - $x - $mc_margin['R']);
		} else {
			$ox = ($x + $mc_margin['L']);
		}
		$this->x = $ox;
		$this->y = $oy;
		// set width
		if (TCPDF_STATIC::empty_string($w) OR ($w <= 0)) {
			if ($this->rtl) {
				$w = ($this->x - $this->lMargin - $mc_margin['L']);
			} else {
				$w = ($this->w - $this->x - $this->rMargin - $mc_margin['R']);
			}
		}
		// store original margin values
		$lMargin = $this->lMargin;
		$rMargin = $this->rMargin;
		if ($this->rtl) {
			$this->rMargin = ($this->w - $this->x);
			$this->lMargin = ($this->x - $w);
		} else {
			$this->lMargin = ($this->x);
			$this->rMargin = ($this->w - $this->x - $w);
		}
		$this->clMargin = $this->lMargin;
		$this->crMargin = $this->rMargin;
		if ($autopadding) {
			// add top padding
			$this->y += $mc_padding['T'];
		}
		if ($ishtml) { // ******* Write HTML text
			$this->writeHTML($txt, true, false, $reseth, true, $align);
			$nl = 1;
		} else { // ******* Write simple text
			$prev_FontSizePt = $this->FontSizePt;
			// vertical alignment
			if ($maxh > 0) {
				// get text height
				$text_height = $this->getStringHeight($w, $txt, $reseth, $autopadding, $mc_padding, $border);
				if ($fitcell) {
					// try to reduce font size to fit text on cell (use a quick search algorithm)
					$fmin = 1;
					$fmax = $this->FontSizePt;
					$prev_text_height = $text_height;
					$maxit = 100; // max number of iterations
					while ($maxit > 0) {
						$fmid = (($fmax + $fmin) / 2);
						$this->SetFontSize($fmid, false);
						$this->resetLastH();
						$text_height = $this->getStringHeight($w, $txt, $reseth, $autopadding, $mc_padding, $border);
						if (($text_height == $maxh) OR (($text_height < $maxh) AND ($fmin >= ($fmax - 0.01)))) {
							break;
						} elseif ($text_height < $maxh) {
							$fmin = $fmid;
						} else {
							$fmax = $fmid;
						}
						--$maxit;
					}
					$this->SetFontSize($this->FontSizePt);
				}
				if ($text_height < $maxh) {
					if ($valign == 'M') {
						// text vertically centered
						$this->y += (($maxh - $text_height) / 2);
					} elseif ($valign == 'B') {
						// text vertically aligned on bottom
						$this->y += ($maxh - $text_height);
					}
				}
			}
			$nl = $this->Write($this->lasth, $txt, '', 0, $align, true, $stretch, false, true, $maxh, 0, $mc_margin);
			if ($fitcell) {
				// restore font size
				$this->SetFontSize($prev_FontSizePt);
			}
		}
		if ($autopadding) {
			// add bottom padding
			$this->y += $mc_padding['B'];
		}
		// Get end-of-text Y position
		$currentY = $this->y;
		// get latest page number
		$endpage = $this->page;
		if ($resth > 0) {
			$skip = ($endpage - $startpage);
			$tmpresth = $resth;
			while ($tmpresth > 0) {
				if ($skip <= 0) {
					// add a page (or trig AcceptPageBreak() for multicolumn mode)
					$this->checkPageBreak($this->PageBreakTrigger + 1);
				}
				if ($this->num_columns > 1) {
					$tmpresth -= ($this->h - $this->y - $this->bMargin);
				} else {
					$tmpresth -= ($this->h - $this->tMargin - $this->bMargin);
				}
				--$skip;
			}
			$currentY = $this->y;
			$endpage = $this->page;
		}
		// get latest column
		$endcolumn = $this->current_column;
		if ($this->num_columns == 0) {
			$this->num_columns = 1;
		}
		// disable page regions check
		$check_page_regions = $this->check_page_regions;
		$this->check_page_regions = false;
		// get border modes
		$border_start = TCPDF_STATIC::getBorderMode($border, $position='start', $this->opencell);
		$border_end = TCPDF_STATIC::getBorderMode($border, $position='end', $this->opencell);
		$border_middle = TCPDF_STATIC::getBorderMode($border, $position='middle', $this->opencell);
		// design borders around HTML cells.
		for ($page = $startpage; $page <= $endpage; ++$page) { // for each page
			$ccode = '';
			$this->setPage($page);
			if ($this->num_columns < 2) {
				// single-column mode
				$this->SetX($x);
				$this->y = $this->tMargin;
			}
			// account for margin changes
			if ($page > $startpage) {
				if (($this->rtl) AND ($this->pagedim[$page]['orm'] != $this->pagedim[$startpage]['orm'])) {
					$this->x -= ($this->pagedim[$page]['orm'] - $this->pagedim[$startpage]['orm']);
				} elseif ((!$this->rtl) AND ($this->pagedim[$page]['olm'] != $this->pagedim[$startpage]['olm'])) {
					$this->x += ($this->pagedim[$page]['olm'] - $this->pagedim[$startpage]['olm']);
				}
			}
			if ($startpage == $endpage) {
				// single page
				for ($column = $startcolumn; $column <= $endcolumn; ++$column) { // for each column
					$this->selectColumn($column);
					if ($this->rtl) {
						$this->x -= $mc_margin['R'];
					} else {
						$this->x += $mc_margin['L'];
					}
					if ($startcolumn == $endcolumn) { // single column
						$cborder = $border;
						$h = max($h, ($currentY - $oy));
						$this->y = $oy;
					} elseif ($column == $startcolumn) { // first column
						$cborder = $border_start;
						$this->y = $oy;
						$h = $this->h - $this->y - $this->bMargin;
					} elseif ($column == $endcolumn) { // end column
						$cborder = $border_end;
						$h = $currentY - $this->y;
						if ($resth > $h) {
							$h = $resth;
						}
					} else { // middle column
						$cborder = $border_middle;
						$h = $this->h - $this->y - $this->bMargin;
						$resth -= $h;
					}
					$ccode .= $this->getCellCode($w, $h, '', $cborder, 1, '', $fill, '', 0, true)."\n";
				} // end for each column
			} elseif ($page == $startpage) { // first page
				for ($column = $startcolumn; $column < $this->num_columns; ++$column) { // for each column
					$this->selectColumn($column);
					if ($this->rtl) {
						$this->x -= $mc_margin['R'];
					} else {
						$this->x += $mc_margin['L'];
					}
					if ($column == $startcolumn) { // first column
						$cborder = $border_start;
						$this->y = $oy;
						$h = $this->h - $this->y - $this->bMargin;
					} else { // middle column
						$cborder = $border_middle;
						$h = $this->h - $this->y - $this->bMargin;
						$resth -= $h;
					}
					$ccode .= $this->getCellCode($w, $h, '', $cborder, 1, '', $fill, '', 0, true)."\n";
				} // end for each column
			} elseif ($page == $endpage) { // last page
				for ($column = 0; $column <= $endcolumn; ++$column) { // for each column
					$this->selectColumn($column);
					if ($this->rtl) {
						$this->x -= $mc_margin['R'];
					} else {
						$this->x += $mc_margin['L'];
					}
					if ($column == $endcolumn) {
						// end column
						$cborder = $border_end;
						$h = $currentY - $this->y;
						if ($resth > $h) {
							$h = $resth;
						}
					} else {
						// middle column
						$cborder = $border_middle;
						$h = $this->h - $this->y - $this->bMargin;
						$resth -= $h;
					}
					$ccode .= $this->getCellCode($w, $h, '', $cborder, 1, '', $fill, '', 0, true)."\n";
				} // end for each column
			} else { // middle page
				for ($column = 0; $column < $this->num_columns; ++$column) { // for each column
					$this->selectColumn($column);
					if ($this->rtl) {
						$this->x -= $mc_margin['R'];
					} else {
						$this->x += $mc_margin['L'];
					}
					$cborder = $border_middle;
					$h = $this->h - $this->y - $this->bMargin;
					$resth -= $h;
					$ccode .= $this->getCellCode($w, $h, '', $cborder, 1, '', $fill, '', 0, true)."\n";
				} // end for each column
			}
			if ($cborder OR $fill) {
				$offsetlen = strlen($ccode);
				// draw border and fill
				if ($this->inxobj) {
					// we are inside an XObject template
					if (end($this->xobjects[$this->xobjid]['transfmrk']) !== false) {
						$pagemarkkey = key($this->xobjects[$this->xobjid]['transfmrk']);
						$pagemark = $this->xobjects[$this->xobjid]['transfmrk'][$pagemarkkey];
						$this->xobjects[$this->xobjid]['transfmrk'][$pagemarkkey] += $offsetlen;
					} else {
						$pagemark = $this->xobjects[$this->xobjid]['intmrk'];
						$this->xobjects[$this->xobjid]['intmrk'] += $offsetlen;
					}
					$pagebuff = $this->xobjects[$this->xobjid]['outdata'];
					$pstart = substr($pagebuff, 0, $pagemark);
					$pend = substr($pagebuff, $pagemark);
					$this->xobjects[$this->xobjid]['outdata'] = $pstart.$ccode.$pend;
				} else {
					if (end($this->transfmrk[$this->page]) !== false) {
						$pagemarkkey = key($this->transfmrk[$this->page]);
						$pagemark = $this->transfmrk[$this->page][$pagemarkkey];
						$this->transfmrk[$this->page][$pagemarkkey] += $offsetlen;
					} elseif ($this->InFooter) {
						$pagemark = $this->footerpos[$this->page];
						$this->footerpos[$this->page] += $offsetlen;
					} else {
						$pagemark = $this->intmrk[$this->page];
						$this->intmrk[$this->page] += $offsetlen;
					}
					$pagebuff = $this->getPageBuffer($this->page);
					$pstart = substr($pagebuff, 0, $pagemark);
					$pend = substr($pagebuff, $pagemark);
					$this->setPageBuffer($this->page, $pstart.$ccode.$pend);
				}
			}
		} // end for each page
		// restore page regions check
		$this->check_page_regions = $check_page_regions;
		// Get end-of-cell Y position
		$currentY = $this->GetY();
		// restore previous values
		if ($this->num_columns > 1) {
			$this->selectColumn();
		} else {
			// restore original margins
			$this->lMargin = $lMargin;
			$this->rMargin = $rMargin;
			if ($this->page > $startpage) {
				// check for margin variations between pages (i.e. booklet mode)
				$dl = ($this->pagedim[$this->page]['olm'] - $this->pagedim[$startpage]['olm']);
				$dr = ($this->pagedim[$this->page]['orm'] - $this->pagedim[$startpage]['orm']);
				if (($dl != 0) OR ($dr != 0)) {
					$this->lMargin += $dl;
					$this->rMargin += $dr;
				}
			}
		}
		if ($ln > 0) {
			//Go to the beginning of the next line
			$this->SetY($currentY + $mc_margin['B']);
			if ($ln == 2) {
				$this->SetX($x + $w + $mc_margin['L'] + $mc_margin['R']);
			}
		} else {
			// go left or right by case
			$this->setPage($startpage);
			$this->y = $y;
			$this->SetX($x + $w + $mc_margin['L'] + $mc_margin['R']);
		}
		$this->setContentMark();
		$this->cell_padding = $prev_cell_padding;
		$this->cell_margin = $prev_cell_margin;
		$this->clMargin = $this->lMargin;
		$this->crMargin = $this->rMargin;
		return $nl;
	}

	/**
	 * This method return the estimated number of lines for print a simple text string using Multicell() method.
	 * @param $txt (string) String for calculating his height
	 * @param $w (float) Width of cells. If 0, they extend up to the right margin of the page.
	 * @param $reseth (boolean) if true reset the last cell height (default false).
	 * @param $autopadding (boolean) if true, uses internal padding and automatically adjust it to account for line width (default true).
	 * @param $cellpadding (float) Internal cell padding, if empty uses default cell padding.
	 * @param $border (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @return float Return the minimal height needed for multicell method for printing the $txt param.
	 * @author Alexander Escalona Fernández, Nicola Asuni
	 * @public
	 * @since 4.5.011
	 */
	public function getNumLines($txt, $w=0, $reseth=false, $autopadding=true, $cellpadding='', $border=0) {
		if ($txt === '') {
			// empty string
			return 1;
		}
		// adjust internal padding
		$prev_cell_padding = $this->cell_padding;
		$prev_lasth = $this->lasth;
		if (is_array($cellpadding)) {
			$this->cell_padding = $cellpadding;
		}
		$this->adjustCellPadding($border);
		if (TCPDF_STATIC::empty_string($w) OR ($w <= 0)) {
			if ($this->rtl) {
				$w = $this->x - $this->lMargin;
			} else {
				$w = $this->w - $this->rMargin - $this->x;
			}
		}
		$wmax = $w - $this->cell_padding['L'] - $this->cell_padding['R'];
		if ($reseth) {
			// reset row height
			$this->resetLastH();
		}
		$lines = 1;
		$sum = 0;
		$chars = TCPDF_FONTS::utf8Bidi(TCPDF_FONTS::UTF8StringToArray($txt, $this->isunicode, $this->CurrentFont), $txt, $this->tmprtl, $this->isunicode, $this->CurrentFont);
		$charsWidth = $this->GetArrStringWidth($chars, '', '', 0, true);
		$length = count($chars);
		$lastSeparator = -1;
		for ($i = 0; $i < $length; ++$i) {
			$charWidth = $charsWidth[$i];
			if (preg_match($this->re_spaces, TCPDF_FONTS::unichr($chars[$i], $this->isunicode))) {
				$lastSeparator = $i;
			}
			if ((($sum + $charWidth) > $wmax) OR ($chars[$i] == 10)) {
				++$lines;
				if ($chars[$i] == 10) {
					$lastSeparator = -1;
					$sum = 0;
				} elseif ($lastSeparator != -1) {
					$i = $lastSeparator;
					$lastSeparator = -1;
					$sum = 0;
				} else {
					$sum = $charWidth;
				}
			} else {
				$sum += $charWidth;
			}
		}
		if ($chars[($length - 1)] == 10) {
			--$lines;
		}
		$this->cell_padding = $prev_cell_padding;
		$this->lasth = $prev_lasth;
		return $lines;
	}

	/**
	 * This method return the estimated height needed for printing a simple text string using the Multicell() method.
	 * Generally, if you want to know the exact height for a block of content you can use the following alternative technique:
	 * @pre
	 *  // store current object
	 *  $pdf->startTransaction();
	 *  // store starting values
	 *  $start_y = $pdf->GetY();
	 *  $start_page = $pdf->getPage();
	 *  // call your printing functions with your parameters
	 *  // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 *  $pdf->MultiCell($w=0, $h=0, $txt, $border=1, $align='L', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
	 *  // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 *  // get the new Y
	 *  $end_y = $pdf->GetY();
	 *  $end_page = $pdf->getPage();
	 *  // calculate height
	 *  $height = 0;
	 *  if ($end_page == $start_page) {
	 *  	$height = $end_y - $start_y;
	 *  } else {
	 *  	for ($page=$start_page; $page <= $end_page; ++$page) {
	 *  		$this->setPage($page);
	 *  		if ($page == $start_page) {
	 *  			// first page
	 *  			$height = $this->h - $start_y - $this->bMargin;
	 *  		} elseif ($page == $end_page) {
	 *  			// last page
	 *  			$height = $end_y - $this->tMargin;
	 *  		} else {
	 *  			$height = $this->h - $this->tMargin - $this->bMargin;
	 *  		}
	 *  	}
	 *  }
	 *  // restore previous object
	 *  $pdf = $pdf->rollbackTransaction();
	 *
	 * @param $w (float) Width of cells. If 0, they extend up to the right margin of the page.
	 * @param $txt (string) String for calculating his height
	 * @param $reseth (boolean) if true reset the last cell height (default false).
	 * @param $autopadding (boolean) if true, uses internal padding and automatically adjust it to account for line width (default true).
	 * @param $cellpadding (float) Internal cell padding, if empty uses default cell padding.
	 * @param $border (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @return float Return the minimal height needed for multicell method for printing the $txt param.
	 * @author Nicola Asuni, Alexander Escalona Fernández
	 * @public
	 */
	public function getStringHeight($w, $txt, $reseth=false, $autopadding=true, $cellpadding='', $border=0) {
		// adjust internal padding
		$prev_cell_padding = $this->cell_padding;
		$prev_lasth = $this->lasth;
		if (is_array($cellpadding)) {
			$this->cell_padding = $cellpadding;
		}
		$this->adjustCellPadding($border);
		$lines = $this->getNumLines($txt, $w, $reseth, $autopadding, $cellpadding, $border);
		$height = $lines * ($this->FontSize * $this->cell_height_ratio);
		if ($autopadding) {
			// add top and bottom padding
			$height += ($this->cell_padding['T'] + $this->cell_padding['B']);
		}
		$this->cell_padding = $prev_cell_padding;
		$this->lasth = $prev_lasth;
		return $height;
	}

	/**
	 * This method prints text from the current position.<br />
	 * @param $h (float) Line height
	 * @param $txt (string) String to print
	 * @param $link (mixed) URL or identifier returned by AddLink()
	 * @param $fill (boolean) Indicates if the cell background must be painted (true) or transparent (false).
	 * @param $align (string) Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align (default value)</li><li>C: center</li><li>R: right align</li><li>J: justify</li></ul>
	 * @param $ln (boolean) if true set cursor at the bottom of the line, otherwise set cursor at the top of the line.
	 * @param $stretch (int) font stretch mode: <ul><li>0 = disabled</li><li>1 = horizontal scaling only if text is larger than cell width</li><li>2 = forced horizontal scaling to fit cell width</li><li>3 = character spacing only if text is larger than cell width</li><li>4 = forced character spacing to fit cell width</li></ul> General font stretching and scaling values will be preserved when possible.
	 * @param $firstline (boolean) if true prints only the first line and return the remaining string.
	 * @param $firstblock (boolean) if true the string is the starting of a line.
	 * @param $maxh (float) maximum height. The remaining unprinted text will be returned. It should be >= $h and less then remaining space to the bottom of the page, or 0 for disable this feature.
	 * @param $wadj (float) first line width will be reduced by this amount (used in HTML mode).
	 * @param $margin (array) margin array of the parent container
	 * @return mixed Return the number of cells or the remaining string if $firstline = true.
	 * @public
	 * @since 1.5
	 */
	public function Write($h, $txt, $link='', $fill=false, $align='', $ln=false, $stretch=0, $firstline=false, $firstblock=false, $maxh=0, $wadj=0, $margin='') {
		// check page for no-write regions and adapt page margins if necessary
		list($this->x, $this->y) = $this->checkPageRegions($h, $this->x, $this->y);
		if (strlen($txt) == 0) {
			// fix empty text
			$txt = ' ';
		}
		if ($margin === '') {
			// set default margins
			$margin = $this->cell_margin;
		}
		// remove carriage returns
		$s = str_replace("\r", '', $txt);
		// check if string contains arabic text
		if (preg_match(TCPDF_FONT_DATA::$uni_RE_PATTERN_ARABIC, $s)) {
			$arabic = true;
		} else {
			$arabic = false;
		}
		// check if string contains RTL text
		if ($arabic OR ($this->tmprtl == 'R') OR preg_match(TCPDF_FONT_DATA::$uni_RE_PATTERN_RTL, $s)) {
			$rtlmode = true;
		} else {
			$rtlmode = false;
		}
		// get a char width
		$chrwidth = $this->GetCharWidth(46); // dot character
		// get array of unicode values
		$chars = TCPDF_FONTS::UTF8StringToArray($s, $this->isunicode, $this->CurrentFont);
		// calculate maximum width for a single character on string
		$chrw = $this->GetArrStringWidth($chars, '', '', 0, true);
		array_walk($chrw, array($this, 'getRawCharWidth'));
		$maxchwidth = max($chrw);
		// get array of chars
		$uchars = TCPDF_FONTS::UTF8ArrayToUniArray($chars, $this->isunicode);
		// get the number of characters
		$nb = count($chars);
		// replacement for SHY character (minus symbol)
		$shy_replacement = 45;
		$shy_replacement_char = TCPDF_FONTS::unichr($shy_replacement, $this->isunicode);
		// widht for SHY replacement
		$shy_replacement_width = $this->GetCharWidth($shy_replacement);
		// max Y
		$maxy = $this->y + $maxh - $h - $this->cell_padding['T'] - $this->cell_padding['B'];
		// page width
		$pw = $w = $this->w - $this->lMargin - $this->rMargin;
		// calculate remaining line width ($w)
		if ($this->rtl) {
			$w = $this->x - $this->lMargin;
		} else {
			$w = $this->w - $this->rMargin - $this->x;
		}
		// max column width
		$wmax = ($w - $wadj);
		if (!$firstline) {
			$wmax -= ($this->cell_padding['L'] + $this->cell_padding['R']);
		}
		if ((!$firstline) AND (($chrwidth > $wmax) OR ($maxchwidth > $wmax))) {
			// the maximum width character do not fit on column
			return '';
		}
		// minimum row height
		$row_height = max($h, $this->FontSize * $this->cell_height_ratio);
		$start_page = $this->page;
		$i = 0; // character position
		$j = 0; // current starting position
		$sep = -1; // position of the last blank space
		$shy = false; // true if the last blank is a soft hypen (SHY)
		$l = 0; // current string length
		$nl = 0; //number of lines
		$linebreak = false;
		$pc = 0; // previous character
		// for each character
		while ($i < $nb) {
			if (($maxh > 0) AND ($this->y >= $maxy) ) {
				break;
			}
			//Get the current character
			$c = $chars[$i];
			if ($c == 10) { // 10 = "\n" = new line
				//Explicit line break
				if ($align == 'J') {
					if ($this->rtl) {
						$talign = 'R';
					} else {
						$talign = 'L';
					}
				} else {
					$talign = $align;
				}
				$tmpstr = TCPDF_FONTS::UniArrSubString($uchars, $j, $i);
				if ($firstline) {
					$startx = $this->x;
					$tmparr = array_slice($chars, $j, ($i - $j));
					if ($rtlmode) {
						$tmparr = TCPDF_FONTS::utf8Bidi($tmparr, $tmpstr, $this->tmprtl, $this->isunicode, $this->CurrentFont);
					}
					$linew = $this->GetArrStringWidth($tmparr);
					unset($tmparr);
					if ($this->rtl) {
						$this->endlinex = $startx - $linew;
					} else {
						$this->endlinex = $startx + $linew;
					}
					$w = $linew;
					$tmpcellpadding = $this->cell_padding;
					if ($maxh == 0) {
						$this->SetCellPadding(0);
					}
				}
				if ($firstblock AND $this->isRTLTextDir()) {
					$tmpstr = $this->stringRightTrim($tmpstr);
				}
				// Skip newlines at the begining of a page or column
				if (!empty($tmpstr) OR ($this->y < ($this->PageBreakTrigger - $row_height))) {
					$this->Cell($w, $h, $tmpstr, 0, 1, $talign, $fill, $link, $stretch);
				}
				unset($tmpstr);
				if ($firstline) {
					$this->cell_padding = $tmpcellpadding;
					return (TCPDF_FONTS::UniArrSubString($uchars, $i));
				}
				++$nl;
				$j = $i + 1;
				$l = 0;
				$sep = -1;
				$shy = false;
				// account for margin changes
				if ((($this->y + $this->lasth) > $this->PageBreakTrigger) AND ($this->inPageBody())) {
					$this->AcceptPageBreak();
					if ($this->rtl) {
						$this->x -= $margin['R'];
					} else {
						$this->x += $margin['L'];
					}
					$this->lMargin += $margin['L'];
					$this->rMargin += $margin['R'];
				}
				$w = $this->getRemainingWidth();
				$wmax = ($w - $this->cell_padding['L'] - $this->cell_padding['R']);
			} else {
				// 160 is the non-breaking space.
				// 173 is SHY (Soft Hypen).
				// \p{Z} or \p{Separator}: any kind of Unicode whitespace or invisible separator.
				// \p{Lo} or \p{Other_Letter}: a Unicode letter or ideograph that does not have lowercase and uppercase variants.
				// \p{Lo} is needed because Chinese characters are packed next to each other without spaces in between.
				if (($c != 160)
					AND (($c == 173)
						OR preg_match($this->re_spaces, TCPDF_FONTS::unichr($c, $this->isunicode))
						OR (($c == 45)
							AND ($i < ($nb - 1))
							AND @preg_match('/[\p{L}]/'.$this->re_space['m'], TCPDF_FONTS::unichr($pc, $this->isunicode))
							AND @preg_match('/[\p{L}]/'.$this->re_space['m'], TCPDF_FONTS::unichr($chars[($i + 1)], $this->isunicode))
						)
					)
				) {
					// update last blank space position
					$sep = $i;
					// check if is a SHY
					if (($c == 173) OR ($c == 45)) {
						$shy = true;
						if ($pc == 45) {
							$tmp_shy_replacement_width = 0;
							$tmp_shy_replacement_char = '';
						} else {
							$tmp_shy_replacement_width = $shy_replacement_width;
							$tmp_shy_replacement_char = $shy_replacement_char;
						}
					} else {
						$shy = false;
					}
				}
				// update string length
				if ($this->isUnicodeFont() AND ($arabic)) {
					// with bidirectional algorithm some chars may be changed affecting the line length
					// *** very slow ***
					$l = $this->GetArrStringWidth(TCPDF_FONTS::utf8Bidi(array_slice($chars, $j, ($i - $j)), '', $this->tmprtl, $this->isunicode, $this->CurrentFont));
				} else {
					$l += $this->GetCharWidth($c);
				}
				if (($l > $wmax) OR (($c == 173) AND (($l + $tmp_shy_replacement_width) > $wmax)) ) {
					// we have reached the end of column
					if ($sep == -1) {
						// check if the line was already started
						if (($this->rtl AND ($this->x <= ($this->w - $this->rMargin - $this->cell_padding['R'] - $margin['R'] - $chrwidth)))
							OR ((!$this->rtl) AND ($this->x >= ($this->lMargin + $this->cell_padding['L'] + $margin['L'] + $chrwidth)))) {
							// print a void cell and go to next line
							$this->Cell($w, $h, '', 0, 1);
							$linebreak = true;
							if ($firstline) {
								return (TCPDF_FONTS::UniArrSubString($uchars, $j));
							}
						} else {
							// truncate the word because do not fit on column
							$tmpstr = TCPDF_FONTS::UniArrSubString($uchars, $j, $i);
							if ($firstline) {
								$startx = $this->x;
								$tmparr = array_slice($chars, $j, ($i - $j));
								if ($rtlmode) {
									$tmparr = TCPDF_FONTS::utf8Bidi($tmparr, $tmpstr, $this->tmprtl, $this->isunicode, $this->CurrentFont);
								}
								$linew = $this->GetArrStringWidth($tmparr);
								unset($tmparr);
								if ($this->rtl) {
									$this->endlinex = $startx - $linew;
								} else {
									$this->endlinex = $startx + $linew;
								}
								$w = $linew;
								$tmpcellpadding = $this->cell_padding;
								if ($maxh == 0) {
									$this->SetCellPadding(0);
								}
							}
							if ($firstblock AND $this->isRTLTextDir()) {
								$tmpstr = $this->stringRightTrim($tmpstr);
							}
							$this->Cell($w, $h, $tmpstr, 0, 1, $align, $fill, $link, $stretch);
							unset($tmpstr);
							if ($firstline) {
								$this->cell_padding = $tmpcellpadding;
								return (TCPDF_FONTS::UniArrSubString($uchars, $i));
							}
							$j = $i;
							--$i;
						}
					} else {
						// word wrapping
						if ($this->rtl AND (!$firstblock) AND ($sep < $i)) {
							$endspace = 1;
						} else {
							$endspace = 0;
						}
						// check the length of the next string
						$strrest = TCPDF_FONTS::UniArrSubString($uchars, ($sep + $endspace));
						$nextstr = TCPDF_STATIC::pregSplit('/'.$this->re_space['p'].'/', $this->re_space['m'], $this->stringTrim($strrest));
						if (isset($nextstr[0]) AND ($this->GetStringWidth($nextstr[0]) > $pw)) {
							// truncate the word because do not fit on a full page width
							$tmpstr = TCPDF_FONTS::UniArrSubString($uchars, $j, $i);
							if ($firstline) {
								$startx = $this->x;
								$tmparr = array_slice($chars, $j, ($i - $j));
								if ($rtlmode) {
									$tmparr = TCPDF_FONTS::utf8Bidi($tmparr, $tmpstr, $this->tmprtl, $this->isunicode, $this->CurrentFont);
								}
								$linew = $this->GetArrStringWidth($tmparr);
								unset($tmparr);
								if ($this->rtl) {
									$this->endlinex = ($startx - $linew);
								} else {
									$this->endlinex = ($startx + $linew);
								}
								$w = $linew;
								$tmpcellpadding = $this->cell_padding;
								if ($maxh == 0) {
									$this->SetCellPadding(0);
								}
							}
							if ($firstblock AND $this->isRTLTextDir()) {
								$tmpstr = $this->stringRightTrim($tmpstr);
							}
							$this->Cell($w, $h, $tmpstr, 0, 1, $align, $fill, $link, $stretch);
							unset($tmpstr);
							if ($firstline) {
								$this->cell_padding = $tmpcellpadding;
								return (TCPDF_FONTS::UniArrSubString($uchars, $i));
							}
							$j = $i;
							--$i;
						} else {
							// word wrapping
							if ($shy) {
								// add hypen (minus symbol) at the end of the line
								$shy_width = $tmp_shy_replacement_width;
								if ($this->rtl) {
									$shy_char_left = $tmp_shy_replacement_char;
									$shy_char_right = '';
								} else {
									$shy_char_left = '';
									$shy_char_right = $tmp_shy_replacement_char;
								}
							} else {
								$shy_width = 0;
								$shy_char_left = '';
								$shy_char_right = '';
							}
							$tmpstr = TCPDF_FONTS::UniArrSubString($uchars, $j, ($sep + $endspace));
							if ($firstline) {
								$startx = $this->x;
								$tmparr = array_slice($chars, $j, (($sep + $endspace) - $j));
								if ($rtlmode) {
									$tmparr = TCPDF_FONTS::utf8Bidi($tmparr, $tmpstr, $this->tmprtl, $this->isunicode, $this->CurrentFont);
								}
								$linew = $this->GetArrStringWidth($tmparr);
								unset($tmparr);
								if ($this->rtl) {
									$this->endlinex = $startx - $linew - $shy_width;
								} else {
									$this->endlinex = $startx + $linew + $shy_width;
								}
								$w = $linew;
								$tmpcellpadding = $this->cell_padding;
								if ($maxh == 0) {
									$this->SetCellPadding(0);
								}
							}
							// print the line
							if ($firstblock AND $this->isRTLTextDir()) {
								$tmpstr = $this->stringRightTrim($tmpstr);
							}
							$this->Cell($w, $h, $shy_char_left.$tmpstr.$shy_char_right, 0, 1, $align, $fill, $link, $stretch);
							unset($tmpstr);
							if ($firstline) {
								if ($chars[$sep] == 45) {
									$endspace += 1;
								}
								// return the remaining text
								$this->cell_padding = $tmpcellpadding;
								return (TCPDF_FONTS::UniArrSubString($uchars, ($sep + $endspace)));
							}
							$i = $sep;
							$sep = -1;
							$shy = false;
							$j = ($i + 1);
						}
					}
					// account for margin changes
					if ((($this->y + $this->lasth) > $this->PageBreakTrigger) AND ($this->inPageBody())) {
						$this->AcceptPageBreak();
						if ($this->rtl) {
							$this->x -= $margin['R'];
						} else {
							$this->x += $margin['L'];
						}
						$this->lMargin += $margin['L'];
						$this->rMargin += $margin['R'];
					}
					$w = $this->getRemainingWidth();
					$wmax = $w - $this->cell_padding['L'] - $this->cell_padding['R'];
					if ($linebreak) {
						$linebreak = false;
					} else {
						++$nl;
						$l = 0;
					}
				}
			}
			// save last character
			$pc = $c;
			++$i;
		} // end while i < nb
		// print last substring (if any)
		if ($l > 0) {
			switch ($align) {
				case 'J':
				case 'C': {
					$w = $w;
					break;
				}
				case 'L': {
					if ($this->rtl) {
						$w = $w;
					} else {
						$w = $l;
					}
					break;
				}
				case 'R': {
					if ($this->rtl) {
						$w = $l;
					} else {
						$w = $w;
					}
					break;
				}
				default: {
					$w = $l;
					break;
				}
			}
			$tmpstr = TCPDF_FONTS::UniArrSubString($uchars, $j, $nb);
			if ($firstline) {
				$startx = $this->x;
				$tmparr = array_slice($chars, $j, ($nb - $j));
				if ($rtlmode) {
					$tmparr = TCPDF_FONTS::utf8Bidi($tmparr, $tmpstr, $this->tmprtl, $this->isunicode, $this->CurrentFont);
				}
				$linew = $this->GetArrStringWidth($tmparr);
				unset($tmparr);
				if ($this->rtl) {
					$this->endlinex = $startx - $linew;
				} else {
					$this->endlinex = $startx + $linew;
				}
				$w = $linew;
				$tmpcellpadding = $this->cell_padding;
				if ($maxh == 0) {
					$this->SetCellPadding(0);
				}
			}
			if ($firstblock AND $this->isRTLTextDir()) {
				$tmpstr = $this->stringRightTrim($tmpstr);
			}
			$this->Cell($w, $h, $tmpstr, 0, $ln, $align, $fill, $link, $stretch);
			unset($tmpstr);
			if ($firstline) {
				$this->cell_padding = $tmpcellpadding;
				return (TCPDF_FONTS::UniArrSubString($uchars, $nb));
			}
			++$nl;
		}
		if ($firstline) {
			return '';
		}
		return $nl;
	}

	/**
	 * Returns the remaining width between the current position and margins.
	 * @return int Return the remaining width
	 * @protected
	 */
	protected function getRemainingWidth() {
		list($this->x, $this->y) = $this->checkPageRegions(0, $this->x, $this->y);
		if ($this->rtl) {
			return ($this->x - $this->lMargin);
		} else {
			return ($this->w - $this->rMargin - $this->x);
		}
	}

	/**
	 * Set the block dimensions accounting for page breaks and page/column fitting
	 * @param $w (float) width
	 * @param $h (float) height
	 * @param $x (float) X coordinate
	 * @param $y (float) Y coodiante
	 * @param $fitonpage (boolean) if true the block is resized to not exceed page dimensions.
	 * @return array($w, $h, $x, $y)
	 * @protected
	 * @since 5.5.009 (2010-07-05)
	 */
	protected function fitBlock($w, $h, $x, $y, $fitonpage=false) {
		if ($w <= 0) {
			// set maximum width
			$w = ($this->w - $this->lMargin - $this->rMargin);
		}
		if ($h <= 0) {
			// set maximum height
			$h = ($this->PageBreakTrigger - $this->tMargin);
		}
		// resize the block to be vertically contained on a single page or single column
		if ($fitonpage OR $this->AutoPageBreak) {
			$ratio_wh = ($w / $h);
			if ($h > ($this->PageBreakTrigger - $this->tMargin)) {
				$h = $this->PageBreakTrigger - $this->tMargin;
				$w = ($h * $ratio_wh);
			}
			// resize the block to be horizontally contained on a single page or single column
			if ($fitonpage) {
				$maxw = ($this->w - $this->lMargin - $this->rMargin);
				if ($w > $maxw) {
					$w = $maxw;
					$h = ($w / $ratio_wh);
				}
			}
		}
		// Check whether we need a new page or new column first as this does not fit
		$prev_x = $this->x;
		$prev_y = $this->y;
		if ($this->checkPageBreak($h, $y) OR ($this->y < $prev_y)) {
			$y = $this->y;
			if ($this->rtl) {
				$x += ($prev_x - $this->x);
			} else {
				$x += ($this->x - $prev_x);
			}
			$this->newline = true;
		}
		// resize the block to be contained on the remaining available page or column space
		if ($fitonpage) {
			$ratio_wh = ($w / $h);
			if (($y + $h) > $this->PageBreakTrigger) {
				$h = $this->PageBreakTrigger - $y;
				$w = ($h * $ratio_wh);
			}
			if ((!$this->rtl) AND (($x + $w) > ($this->w - $this->rMargin))) {
				$w = $this->w - $this->rMargin - $x;
				$h = ($w / $ratio_wh);
			} elseif (($this->rtl) AND (($x - $w) < ($this->lMargin))) {
				$w = $x - $this->lMargin;
				$h = ($w / $ratio_wh);
			}
		}
		return array($w, $h, $x, $y);
	}

	/**
	 * Puts an image in the page.
	 * The upper-left corner must be given.
	 * The dimensions can be specified in different ways:<ul>
	 * <li>explicit width and height (expressed in user unit)</li>
	 * <li>one explicit dimension, the other being calculated automatically in order to keep the original proportions</li>
	 * <li>no explicit dimension, in which case the image is put at 72 dpi</li></ul>
	 * Supported formats are JPEG and PNG images whitout GD library and all images supported by GD: GD, GD2, GD2PART, GIF, JPEG, PNG, BMP, XBM, XPM;
	 * The format can be specified explicitly or inferred from the file extension.<br />
	 * It is possible to put a link on the image.<br />
	 * Remark: if an image is used several times, only one copy will be embedded in the file.<br />
	 * @param $file (string) Name of the file containing the image or a '@' character followed by the image data string. To link an image without embedding it on the document, set an asterisk character before the URL (i.e.: '*http://www.example.com/image.jpg').
	 * @param $x (float) Abscissa of the upper-left corner (LTR) or upper-right corner (RTL).
	 * @param $y (float) Ordinate of the upper-left corner (LTR) or upper-right corner (RTL).
	 * @param $w (float) Width of the image in the page. If not specified or equal to zero, it is automatically calculated.
	 * @param $h (float) Height of the image in the page. If not specified or equal to zero, it is automatically calculated.
	 * @param $type (string) Image format. Possible values are (case insensitive): JPEG and PNG (whitout GD library) and all images supported by GD: GD, GD2, GD2PART, GIF, JPEG, PNG, BMP, XBM, XPM;. If not specified, the type is inferred from the file extension.
	 * @param $link (mixed) URL or identifier returned by AddLink().
	 * @param $align (string) Indicates the alignment of the pointer next to image insertion relative to image height. The value can be:<ul><li>T: top-right for LTR or top-left for RTL</li><li>M: middle-right for LTR or middle-left for RTL</li><li>B: bottom-right for LTR or bottom-left for RTL</li><li>N: next line</li></ul>
	 * @param $resize (mixed) If true resize (reduce) the image to fit $w and $h (requires GD or ImageMagick library); if false do not resize; if 2 force resize in all cases (upscaling and downscaling).
	 * @param $dpi (int) dot-per-inch resolution used on resize
	 * @param $palign (string) Allows to center or align the image on the current line. Possible values are:<ul><li>L : left align</li><li>C : center</li><li>R : right align</li><li>'' : empty string : left for LTR or right for RTL</li></ul>
	 * @param $ismask (boolean) true if this image is a mask, false otherwise
	 * @param $imgmask (mixed) image object returned by this function or false
	 * @param $border (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @param $fitbox (mixed) If not false scale image dimensions proportionally to fit within the ($w, $h) box. $fitbox can be true or a 2 characters string indicating the image alignment inside the box. The first character indicate the horizontal alignment (L = left, C = center, R = right) the second character indicate the vertical algnment (T = top, M = middle, B = bottom).
	 * @param $hidden (boolean) If true do not display the image.
	 * @param $fitonpage (boolean) If true the image is resized to not exceed page dimensions.
	 * @param $alt (boolean) If true the image will be added as alternative and not directly printed (the ID of the image will be returned).
	 * @param $altimgs (array) Array of alternate images IDs. Each alternative image must be an array with two values: an integer representing the image ID (the value returned by the Image method) and a boolean value to indicate if the image is the default for printing.
	 * @return image information
	 * @public
	 * @since 1.1
	 */
	public function Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false, $alt=false, $altimgs=array()) {
		if ($this->state != 2) {
			return;
		}
		if ($x === '') {
			$x = $this->x;
		}
		if ($y === '') {
			$y = $this->y;
		}
		// check page for no-write regions and adapt page margins if necessary
		list($x, $y) = $this->checkPageRegions($h, $x, $y);
		$exurl = ''; // external streams
		// check if we are passing an image as file or string
		if ($file[0] === '@') {
			// image from string
			$imgdata = substr($file, 1);
		} else { // image file
			if ($file{0} === '*') {
				// image as external stream
				$file = substr($file, 1);
				$exurl = $file;
			}
			// check if is local file
			if (!@file_exists($file)) {
				// encode spaces on filename (file is probably an URL)
				$file = str_replace(' ', '%20', $file);
			}
			if (@file_exists($file)) {
				// get image dimensions
				$imsize = @getimagesize($file);
			} else {
				$imsize = FALSE;
			}
			if ($imsize === FALSE) {
				if (function_exists('curl_init')) {
					// try to get remote file data using cURL
					$cs = curl_init(); // curl session
					curl_setopt($cs, CURLOPT_URL, $file);
					curl_setopt($cs, CURLOPT_BINARYTRANSFER, true);
					curl_setopt($cs, CURLOPT_FAILONERROR, true);
					curl_setopt($cs, CURLOPT_RETURNTRANSFER, true);
					if ((ini_get('open_basedir') == '') AND (!ini_get('safe_mode'))) {
						curl_setopt($cs, CURLOPT_FOLLOWLOCATION, true);
					}
					curl_setopt($cs, CURLOPT_CONNECTTIMEOUT, 5);
					curl_setopt($cs, CURLOPT_TIMEOUT, 30);
					curl_setopt($cs, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($cs, CURLOPT_SSL_VERIFYHOST, false);
					curl_setopt($cs, CURLOPT_USERAGENT, 'TCPDF');
					$imgdata = curl_exec($cs);
					curl_close($cs);
				} else {
					$imgdata = @file_get_contents($file);
				}
			}
		}
		if (isset($imgdata) AND ($imgdata !== FALSE)) {
			// copy image to cache
			$file = TCPDF_STATIC::getObjFilename('img');
			$fp = fopen($file, 'w');
			fwrite($fp, $imgdata);
			fclose($fp);
			unset($imgdata);
			$imsize = @getimagesize($file);
			if ($imsize === FALSE) {
				unlink($file);
			} else {
				$this->cached_files[] = $file;
			}
		}
		if ($imsize === FALSE) {
			if (($w > 0) AND ($h > 0)) {
				// get measures from specified data
				$pw = $this->getHTMLUnitToUnits($w, 0, $this->pdfunit, true) * $this->imgscale * $this->k;
				$ph = $this->getHTMLUnitToUnits($h, 0, $this->pdfunit, true) * $this->imgscale * $this->k;
				$imsize = array($pw, $ph);
			} else {
				$this->Error('[Image] Unable to get image: '.$file);
			}
		}
		// file hash
		$filehash = md5($this->file_id.$file);
		// get original image width and height in pixels
		list($pixw, $pixh) = $imsize;
		// calculate image width and height on document
		if (($w <= 0) AND ($h <= 0)) {
			// convert image size to document unit
			$w = $this->pixelsToUnits($pixw);
			$h = $this->pixelsToUnits($pixh);
		} elseif ($w <= 0) {
			$w = $h * $pixw / $pixh;
		} elseif ($h <= 0) {
			$h = $w * $pixh / $pixw;
		} elseif (($fitbox !== false) AND ($w > 0) AND ($h > 0)) {
			if (strlen($fitbox) !== 2) {
				// set default alignment
				$fitbox = '--';
			}
			// scale image dimensions proportionally to fit within the ($w, $h) box
			if ((($w * $pixh) / ($h * $pixw)) < 1) {
				// store current height
				$oldh = $h;
				// calculate new height
				$h = $w * $pixh / $pixw;
				// height difference
				$hdiff = ($oldh - $h);
				// vertical alignment
				switch (strtoupper($fitbox{1})) {
					case 'T': {
						break;
					}
					case 'M': {
						$y += ($hdiff / 2);
						break;
					}
					case 'B': {
						$y += $hdiff;
						break;
					}
				}
			} else {
				// store current width
				$oldw = $w;
				// calculate new width
				$w = $h * $pixw / $pixh;
				// width difference
				$wdiff = ($oldw - $w);
				// horizontal alignment
				switch (strtoupper($fitbox{0})) {
					case 'L': {
						if ($this->rtl) {
							$x -= $wdiff;
						}
						break;
					}
					case 'C': {
						if ($this->rtl) {
							$x -= ($wdiff / 2);
						} else {
							$x += ($wdiff / 2);
						}
						break;
					}
					case 'R': {
						if (!$this->rtl) {
							$x += $wdiff;
						}
						break;
					}
				}
			}
		}
		// fit the image on available space
		list($w, $h, $x, $y) = $this->fitBlock($w, $h, $x, $y, $fitonpage);
		// calculate new minimum dimensions in pixels
		$neww = round($w * $this->k * $dpi / $this->dpi);
		$newh = round($h * $this->k * $dpi / $this->dpi);
		// check if resize is necessary (resize is used only to reduce the image)
		$newsize = ($neww * $newh);
		$pixsize = ($pixw * $pixh);
		if (intval($resize) == 2) {
			$resize = true;
		} elseif ($newsize >= $pixsize) {
			$resize = false;
		}
		// check if image has been already added on document
		$newimage = true;
		if (in_array($file, $this->imagekeys)) {
			$newimage = false;
			// get existing image data
			$info = $this->getImageBuffer($file);
			if (substr($file, 0, -34) != K_PATH_CACHE.'msk') {
				// check if the newer image is larger
				$oldsize = ($info['w'] * $info['h']);
				if ((($oldsize < $newsize) AND ($resize)) OR (($oldsize < $pixsize) AND (!$resize))) {
					$newimage = true;
				}
			}
		} elseif (substr($file, 0, -34) != K_PATH_CACHE.'msk') {
			// check for cached images with alpha channel
			$tempfile_plain = K_PATH_CACHE.'mskp_'.$filehash;
			$tempfile_alpha = K_PATH_CACHE.'mska_'.$filehash;
			if (in_array($tempfile_plain, $this->imagekeys)) {
				// get existing image data
				$info = $this->getImageBuffer($tempfile_plain);
				// check if the newer image is larger
				$oldsize = ($info['w'] * $info['h']);
				if ((($oldsize < $newsize) AND ($resize)) OR (($oldsize < $pixsize) AND (!$resize))) {
					$newimage = true;
				} else {
					$newimage = false;
					// embed mask image
					$imgmask = $this->Image($tempfile_alpha, $x, $y, $w, $h, 'PNG', '', '', $resize, $dpi, '', true, false);
					// embed image, masked with previously embedded mask
					return $this->Image($tempfile_plain, $x, $y, $w, $h, $type, $link, $align, $resize, $dpi, $palign, false, $imgmask);
				}
			}
		}
		if ($newimage) {
			//First use of image, get info
			$type = strtolower($type);
			if ($type == '') {
				$type = TCPDF_IMAGES::getImageFileType($file, $imsize);
			} elseif ($type == 'jpg') {
				$type = 'jpeg';
			}
			$mqr = TCPDF_STATIC::get_mqr();
			TCPDF_STATIC::set_mqr(false);
			// Specific image handlers (defined on TCPDF_IMAGES CLASS)
			$mtd = '_parse'.$type;
			// GD image handler function
			$gdfunction = 'imagecreatefrom'.$type;
			$info = false;
			if ((method_exists('TCPDF_IMAGES', $mtd)) AND (!($resize AND (function_exists($gdfunction) OR extension_loaded('imagick'))))) {
				// TCPDF image functions
				$info = TCPDF_IMAGES::$mtd($file);
				if (($info === 'pngalpha') OR (isset($info['trns']) AND !empty($info['trns']))) {
					return $this->ImagePngAlpha($file, $x, $y, $pixw, $pixh, $w, $h, 'PNG', $link, $align, $resize, $dpi, $palign, $filehash);
				}
			}
			if (!$info) {
				if (function_exists($gdfunction)) {
					// GD library
					$img = $gdfunction($file);
					if ($resize) {
						$imgr = imagecreatetruecolor($neww, $newh);
						if (($type == 'gif') OR ($type == 'png')) {
							$imgr = TCPDF_IMAGES::setGDImageTransparency($imgr, $img);
						}
						imagecopyresampled($imgr, $img, 0, 0, 0, 0, $neww, $newh, $pixw, $pixh);
						if (($type == 'gif') OR ($type == 'png')) {
							$info = TCPDF_IMAGES::_toPNG($imgr);
						} else {
							$info = TCPDF_IMAGES::_toJPEG($imgr, $this->jpeg_quality);
						}
					} else {
						if (($type == 'gif') OR ($type == 'png')) {
							$info = TCPDF_IMAGES::_toPNG($img);
						} else {
							$info = TCPDF_IMAGES::_toJPEG($img, $this->jpeg_quality);
						}
					}
				} elseif (extension_loaded('imagick')) {
					// ImageMagick library
					$img = new Imagick();
					if ($type == 'SVG') {
						// get SVG file content
						$svgimg = file_get_contents($file);
						// get width and height
						$regs = array();
						if (preg_match('/<svg([^\>]*)>/si', $svgimg, $regs)) {
							$svgtag = $regs[1];
							$tmp = array();
							if (preg_match('/[\s]+width[\s]*=[\s]*"([^"]*)"/si', $svgtag, $tmp)) {
								$ow = $this->getHTMLUnitToUnits($tmp[1], 1, $this->svgunit, false);
								$owu = sprintf('%F', ($ow * $dpi / 72)).$this->pdfunit;
								$svgtag = preg_replace('/[\s]+width[\s]*=[\s]*"[^"]*"/si', ' width="'.$owu.'"', $svgtag, 1);
							} else {
								$ow = $w;
							}
							$tmp = array();
							if (preg_match('/[\s]+height[\s]*=[\s]*"([^"]*)"/si', $svgtag, $tmp)) {
								$oh = $this->getHTMLUnitToUnits($tmp[1], 1, $this->svgunit, false);
								$ohu = sprintf('%F', ($oh * $dpi / 72)).$this->pdfunit;
								$svgtag = preg_replace('/[\s]+height[\s]*=[\s]*"[^"]*"/si', ' height="'.$ohu.'"', $svgtag, 1);
							} else {
								$oh = $h;
							}
							$tmp = array();
							if (!preg_match('/[\s]+viewBox[\s]*=[\s]*"[\s]*([0-9\.]+)[\s]+([0-9\.]+)[\s]+([0-9\.]+)[\s]+([0-9\.]+)[\s]*"/si', $svgtag, $tmp)) {
								$vbw = ($ow * $this->imgscale * $this->k);
								$vbh = ($oh * $this->imgscale * $this->k);
								$vbox = sprintf(' viewBox="0 0 %F %F" ', $vbw, $vbh);
								$svgtag = $vbox.$svgtag;
							}
							$svgimg = preg_replace('/<svg([^\>]*)>/si', '<svg'.$svgtag.'>', $svgimg, 1);
						}
						$img->readImageBlob($svgimg);
					} else {
						$img->readImage($file);
					}
					if ($resize) {
						$img->resizeImage($neww, $newh, 10, 1, false);
					}
					$img->setCompressionQuality($this->jpeg_quality);
					$img->setImageFormat('jpeg');
					$tempname = TCPDF_STATIC::getObjFilename('jpg');
					$img->writeImage($tempname);
					$info = TCPDF_IMAGES::_parsejpeg($tempname);
					unlink($tempname);
					$img->destroy();
				} else {
					return;
				}
			}
			if ($info === false) {
				//If false, we cannot process image
				return;
			}
			TCPDF_STATIC::set_mqr($mqr);
			if ($ismask) {
				// force grayscale
				$info['cs'] = 'DeviceGray';
			}
			if ($imgmask !== false) {
				$info['masked'] = $imgmask;
			}
			if (!empty($exurl)) {
				$info['exurl'] = $exurl;
			}
			// array of alternative images
			$info['altimgs'] = $altimgs;
			// add image to document
			$info['i'] = $this->setImageBuffer($file, $info);
		}
		// set alignment
		$this->img_rb_y = $y + $h;
		// set alignment
		if ($this->rtl) {
			if ($palign == 'L') {
				$ximg = $this->lMargin;
			} elseif ($palign == 'C') {
				$ximg = ($this->w + $this->lMargin - $this->rMargin - $w) / 2;
			} elseif ($palign == 'R') {
				$ximg = $this->w - $this->rMargin - $w;
			} else {
				$ximg = $x - $w;
			}
			$this->img_rb_x = $ximg;
		} else {
			if ($palign == 'L') {
				$ximg = $this->lMargin;
			} elseif ($palign == 'C') {
				$ximg = ($this->w + $this->lMargin - $this->rMargin - $w) / 2;
			} elseif ($palign == 'R') {
				$ximg = $this->w - $this->rMargin - $w;
			} else {
				$ximg = $x;
			}
			$this->img_rb_x = $ximg + $w;
		}
		if ($ismask OR $hidden) {
			// image is not displayed
			return $info['i'];
		}
		$xkimg = $ximg * $this->k;
		if (!$alt) {
			// only non-alternative immages will be set
			$this->_out(sprintf('q %F 0 0 %F %F %F cm /I%u Do Q', ($w * $this->k), ($h * $this->k), $xkimg, (($this->h - ($y + $h)) * $this->k), $info['i']));
		}
		if (!empty($border)) {
			$bx = $this->x;
			$by = $this->y;
			$this->x = $ximg;
			if ($this->rtl) {
				$this->x += $w;
			}
			$this->y = $y;
			$this->Cell($w, $h, '', $border, 0, '', 0, '', 0, true);
			$this->x = $bx;
			$this->y = $by;
		}
		if ($link) {
			$this->Link($ximg, $y, $w, $h, $link, 0);
		}
		// set pointer to align the next text/objects
		switch($align) {
			case 'T': {
				$this->y = $y;
				$this->x = $this->img_rb_x;
				break;
			}
			case 'M': {
				$this->y = $y + round($h/2);
				$this->x = $this->img_rb_x;
				break;
			}
			case 'B': {
				$this->y = $this->img_rb_y;
				$this->x = $this->img_rb_x;
				break;
			}
			case 'N': {
				$this->SetY($this->img_rb_y);
				break;
			}
			default:{
				break;
			}
		}
		$this->endlinex = $this->img_rb_x;
		if ($this->inxobj) {
			// we are inside an XObject template
			$this->xobjects[$this->xobjid]['images'][] = $info['i'];
		}
		return $info['i'];
	}

	/**
	 * Extract info from a PNG image with alpha channel using the Imagick or GD library.
	 * @param $file (string) Name of the file containing the image.
	 * @param $x (float) Abscissa of the upper-left corner.
	 * @param $y (float) Ordinate of the upper-left corner.
	 * @param $wpx (float) Original width of the image in pixels.
	 * @param $hpx (float) original height of the image in pixels.
	 * @param $w (float) Width of the image in the page. If not specified or equal to zero, it is automatically calculated.
	 * @param $h (float) Height of the image in the page. If not specified or equal to zero, it is automatically calculated.
	 * @param $type (string) Image format. Possible values are (case insensitive): JPEG and PNG (whitout GD library) and all images supported by GD: GD, GD2, GD2PART, GIF, JPEG, PNG, BMP, XBM, XPM;. If not specified, the type is inferred from the file extension.
	 * @param $link (mixed) URL or identifier returned by AddLink().
	 * @param $align (string) Indicates the alignment of the pointer next to image insertion relative to image height. The value can be:<ul><li>T: top-right for LTR or top-left for RTL</li><li>M: middle-right for LTR or middle-left for RTL</li><li>B: bottom-right for LTR or bottom-left for RTL</li><li>N: next line</li></ul>
	 * @param $resize (boolean) If true resize (reduce) the image to fit $w and $h (requires GD library).
	 * @param $dpi (int) dot-per-inch resolution used on resize
	 * @param $palign (string) Allows to center or align the image on the current line. Possible values are:<ul><li>L : left align</li><li>C : center</li><li>R : right align</li><li>'' : empty string : left for LTR or right for RTL</li></ul>
	 * @param $filehash (string) File hash used to build unique file names.
	 * @author Nicola Asuni
	 * @protected
	 * @since 4.3.007 (2008-12-04)
	 * @see Image()
	 */
	protected function ImagePngAlpha($file, $x, $y, $wpx, $hpx, $w, $h, $type, $link, $align, $resize, $dpi, $palign, $filehash='') {
		if (empty($filehash)) {
			$filehash = md5($this->file_id.$file);
		}
		// create temp image file (without alpha channel)
		$tempfile_plain = K_PATH_CACHE.'mskp_'.$filehash;
		// create temp alpha file
		$tempfile_alpha = K_PATH_CACHE.'mska_'.$filehash;
		if (extension_loaded('imagick')) { // ImageMagick extension
			// ImageMagick library
			$img = new Imagick();
			$img->readImage($file);
			// clone image object
			$imga = TCPDF_STATIC::objclone($img);
			// extract alpha channel
			if (method_exists($img, 'setImageAlphaChannel') AND defined('Imagick::ALPHACHANNEL_EXTRACT')) {
				$img->setImageAlphaChannel(Imagick::ALPHACHANNEL_EXTRACT);
			} else {
				$img->separateImageChannel(8); // 8 = (imagick::CHANNEL_ALPHA | imagick::CHANNEL_OPACITY | imagick::CHANNEL_MATTE);
				$img->negateImage(true);
			}
			$img->setImageFormat('png');
			$img->writeImage($tempfile_alpha);
			// remove alpha channel
			if (method_exists($imga, 'setImageMatte')) {
				$imga->setImageMatte(false);
			} else {
				$imga->separateImageChannel(39); // 39 = (imagick::CHANNEL_ALL & ~(imagick::CHANNEL_ALPHA | imagick::CHANNEL_OPACITY | imagick::CHANNEL_MATTE));
			}
			$imga->setImageFormat('png');
			$imga->writeImage($tempfile_plain);
		} elseif (function_exists('imagecreatefrompng')) { // GD extension
			// generate images
			$img = imagecreatefrompng($file);
			$imgalpha = imagecreate($wpx, $hpx);
			// generate gray scale palette (0 -> 255)
			for ($c = 0; $c < 256; ++$c) {
				ImageColorAllocate($imgalpha, $c, $c, $c);
			}
			// extract alpha channel
			for ($xpx = 0; $xpx < $wpx; ++$xpx) {
				for ($ypx = 0; $ypx < $hpx; ++$ypx) {
					$color = imagecolorat($img, $xpx, $ypx);
					$alpha = $this->getGDgamma($color); // correct gamma
					imagesetpixel($imgalpha, $xpx, $ypx, $alpha);
				}
			}
			imagepng($imgalpha, $tempfile_alpha);
			imagedestroy($imgalpha);
			// extract image without alpha channel
			$imgplain = imagecreatetruecolor($wpx, $hpx);
			imagecopy($imgplain, $img, 0, 0, 0, 0, $wpx, $hpx);
			imagepng($imgplain, $tempfile_plain);
			imagedestroy($imgplain);
		} else {
			$this->Error('TCPDF requires the Imagick or GD extension to handle PNG images with alpha channel.');
		}
		// embed mask image
		$imgmask = $this->Image($tempfile_alpha, $x, $y, $w, $h, 'PNG', '', '', $resize, $dpi, '', true, false);
		// embed image, masked with previously embedded mask
		$this->Image($tempfile_plain, $x, $y, $w, $h, $type, $link, $align, $resize, $dpi, $palign, false, $imgmask);
		// remove temp files
		unlink($tempfile_alpha);
		unlink($tempfile_plain);
	}

	/**
	 * Get the GD-corrected PNG gamma value from alpha color
	 * @param $c (int) alpha color
	 * @protected
	 * @since 4.3.007 (2008-12-04)
	 */
	protected function getGDgamma($c) {
		if (!isset($this->gdgammacache["'".$c."'"])) {
			// shifts off the first 24 bits (where 8x3 are used for each color),
			// and returns the remaining 7 allocated bits (commonly used for alpha)
			$alpha = ($c >> 24);
			// GD alpha is only 7 bit (0 -> 127)
			$alpha = (((127 - $alpha) / 127) * 255);
			// correct gamma
			$this->gdgammacache["'".$c."'"] = (pow(($alpha / 255), 2.2) * 255);
			// store the latest values on cache to improve performances
			if (count($this->gdgammacache) > 8) {
				// remove one element from the cache array
				array_shift($this->gdgammacache);
			}
		}
		return $this->gdgammacache["'".$c."'"];
	}

	/**
	 * Performs a line break.
	 * The current abscissa goes back to the left margin and the ordinate increases by the amount passed in parameter.
	 * @param $h (float) The height of the break. By default, the value equals the height of the last printed cell.
	 * @param $cell (boolean) if true add the current left (or right o for RTL) padding to the X coordinate
	 * @public
	 * @since 1.0
	 * @see Cell()
	 */
	public function Ln($h='', $cell=false) {
		if (($this->num_columns > 1) AND ($this->y == $this->columns[$this->current_column]['y']) AND isset($this->columns[$this->current_column]['x']) AND ($this->x == $this->columns[$this->current_column]['x'])) {
			// revove vertical space from the top of the column
			return;
		}
		if ($cell) {
			if ($this->rtl) {
				$cellpadding = $this->cell_padding['R'];
			} else {
				$cellpadding = $this->cell_padding['L'];
			}
		} else {
			$cellpadding = 0;
		}
		if ($this->rtl) {
			$this->x = $this->w - $this->rMargin - $cellpadding;
		} else {
			$this->x = $this->lMargin + $cellpadding;
		}
		if (is_string($h)) {
			$this->y += $this->lasth;
		} else {
			$this->y += $h;
		}
		$this->newline = true;
	}

	/**
	 * Returns the relative X value of current position.
	 * The value is relative to the left border for LTR languages and to the right border for RTL languages.
	 * @return float
	 * @public
	 * @since 1.2
	 * @see SetX(), GetY(), SetY()
	 */
	public function GetX() {
		//Get x position
		if ($this->rtl) {
			return ($this->w - $this->x);
		} else {
			return $this->x;
		}
	}

	/**
	 * Returns the absolute X value of current position.
	 * @return float
	 * @public
	 * @since 1.2
	 * @see SetX(), GetY(), SetY()
	 */
	public function GetAbsX() {
		return $this->x;
	}

	/**
	 * Returns the ordinate of the current position.
	 * @return float
	 * @public
	 * @since 1.0
	 * @see SetY(), GetX(), SetX()
	 */
	public function GetY() {
		return $this->y;
	}

	/**
	 * Defines the abscissa of the current position.
	 * If the passed value is negative, it is relative to the right of the page (or left if language is RTL).
	 * @param $x (float) The value of the abscissa in user units.
	 * @param $rtloff (boolean) if true always uses the page top-left corner as origin of axis.
	 * @public
	 * @since 1.2
	 * @see GetX(), GetY(), SetY(), SetXY()
	 */
	public function SetX($x, $rtloff=false) {
		$x = floatval($x);
		if (!$rtloff AND $this->rtl) {
			if ($x >= 0) {
				$this->x = $this->w - $x;
			} else {
				$this->x = abs($x);
			}
		} else {
			if ($x >= 0) {
				$this->x = $x;
			} else {
				$this->x = $this->w + $x;
			}
		}
		if ($this->x < 0) {
			$this->x = 0;
		}
		if ($this->x > $this->w) {
			$this->x = $this->w;
		}
	}

	/**
	 * Moves the current abscissa back to the left margin and sets the ordinate.
	 * If the passed value is negative, it is relative to the bottom of the page.
	 * @param $y (float) The value of the ordinate in user units.
	 * @param $resetx (bool) if true (default) reset the X position.
	 * @param $rtloff (boolean) if true always uses the page top-left corner as origin of axis.
	 * @public
	 * @since 1.0
	 * @see GetX(), GetY(), SetY(), SetXY()
	 */
	public function SetY($y, $resetx=true, $rtloff=false) {
		$y = floatval($y);
		if ($resetx) {
			//reset x
			if (!$rtloff AND $this->rtl) {
				$this->x = $this->w - $this->rMargin;
			} else {
				$this->x = $this->lMargin;
			}
		}
		if ($y >= 0) {
			$this->y = $y;
		} else {
			$this->y = $this->h + $y;
		}
		if ($this->y < 0) {
			$this->y = 0;
		}
		if ($this->y > $this->h) {
			$this->y = $this->h;
		}
	}

	/**
	 * Defines the abscissa and ordinate of the current position.
	 * If the passed values are negative, they are relative respectively to the right and bottom of the page.
	 * @param $x (float) The value of the abscissa.
	 * @param $y (float) The value of the ordinate.
	 * @param $rtloff (boolean) if true always uses the page top-left corner as origin of axis.
	 * @public
	 * @since 1.2
	 * @see SetX(), SetY()
	 */
	public function SetXY($x, $y, $rtloff=false) {
		$this->SetY($y, false, $rtloff);
		$this->SetX($x, $rtloff);
	}

	/**
	 * Set the absolute X coordinate of the current pointer.
	 * @param $x (float) The value of the abscissa in user units.
	 * @public
	 * @since 5.9.186 (2012-09-13)
	 * @see setAbsX(), setAbsY(), SetAbsXY()
	 */
	public function SetAbsX($x) {
		$this->x = floatval($x);
	}

	/**
	 * Set the absolute Y coordinate of the current pointer.
	 * @param $y (float) (float) The value of the ordinate in user units.
	 * @public
	 * @since 5.9.186 (2012-09-13)
	 * @see setAbsX(), setAbsY(), SetAbsXY()
	 */
	public function SetAbsY($y) {
		$this->y = floatval($y);
	}

	/**
	 * Set the absolute X and Y coordinates of the current pointer.
	 * @param $x (float) The value of the abscissa in user units.
	 * @param $y (float) (float) The value of the ordinate in user units.
	 * @public
	 * @since 5.9.186 (2012-09-13)
	 * @see setAbsX(), setAbsY(), SetAbsXY()
	 */
	public function SetAbsXY($x, $y) {
		$this->SetAbsX($x);
		$this->SetAbsY($y);
	}

	/**
	 * Send the document to a given destination: string, local file or browser.
	 * In the last case, the plug-in may be used (if present) or a download ("Save as" dialog box) may be forced.<br />
	 * The method first calls Close() if necessary to terminate the document.
	 * @param $name (string) The name of the file when saved. Note that special characters are removed and blanks characters are replaced with the underscore character.
	 * @param $dest (string) Destination where to send the document. It can take one of the following values:<ul><li>I: send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.</li><li>D: send to the browser and force a file download with the name given by name.</li><li>F: save to a local server file with the name given by name.</li><li>S: return the document as a string (name is ignored).</li><li>FI: equivalent to F + I option</li><li>FD: equivalent to F + D option</li><li>E: return the document as base64 mime multi-part email attachment (RFC 2045)</li></ul>
	 * @public
	 * @since 1.0
	 * @see Close()
	 */
	public function Output($name='doc.pdf', $dest='I') {
		//Output PDF to some destination
		//Finish document if necessary
		if ($this->state < 3) {
			$this->Close();
		}
		//Normalize parameters
		if (is_bool($dest)) {
			$dest = $dest ? 'D' : 'F';
		}
		$dest = strtoupper($dest);
		if ($dest{0} != 'F') {
			$name = preg_replace('/[\s]+/', '_', $name);
			$name = preg_replace('/[^a-zA-Z0-9_\.-]/', '', $name);
		}
		if ($this->sign) {
			// *** apply digital signature to the document ***
			// get the document content
			$pdfdoc = $this->getBuffer();
			// remove last newline
			$pdfdoc = substr($pdfdoc, 0, -1);
			// Remove the original buffer
			if (isset($this->diskcache) AND $this->diskcache) {
				// remove buffer file from cache
				unlink($this->buffer);
			}
			unset($this->buffer);
			// remove filler space
			$byterange_string_len = strlen(TCPDF_STATIC::$byterange_string);
			// define the ByteRange
			$byte_range = array();
			$byte_range[0] = 0;
			$byte_range[1] = strpos($pdfdoc, TCPDF_STATIC::$byterange_string) + $byterange_string_len + 10;
			$byte_range[2] = $byte_range[1] + $this->signature_max_length + 2;
			$byte_range[3] = strlen($pdfdoc) - $byte_range[2];
			$pdfdoc = substr($pdfdoc, 0, $byte_range[1]).substr($pdfdoc, $byte_range[2]);
			// replace the ByteRange
			$byterange = sprintf('/ByteRange[0 %u %u %u]', $byte_range[1], $byte_range[2], $byte_range[3]);
			$byterange .= str_repeat(' ', ($byterange_string_len - strlen($byterange)));
			$pdfdoc = str_replace(TCPDF_STATIC::$byterange_string, $byterange, $pdfdoc);
			// write the document to a temporary folder
			$tempdoc = TCPDF_STATIC::getObjFilename('tmppdf');
			$f = fopen($tempdoc, 'wb');
			if (!$f) {
				$this->Error('Unable to create temporary file: '.$tempdoc);
			}
			$pdfdoc_length = strlen($pdfdoc);
			fwrite($f, $pdfdoc, $pdfdoc_length);
			fclose($f);
			// get digital signature via openssl library
			$tempsign = TCPDF_STATIC::getObjFilename('tmpsig');
			if (empty($this->signature_data['extracerts'])) {
				openssl_pkcs7_sign($tempdoc, $tempsign, $this->signature_data['signcert'], array($this->signature_data['privkey'], $this->signature_data['password']), array(), PKCS7_BINARY | PKCS7_DETACHED);
			} else {
				openssl_pkcs7_sign($tempdoc, $tempsign, $this->signature_data['signcert'], array($this->signature_data['privkey'], $this->signature_data['password']), array(), PKCS7_BINARY | PKCS7_DETACHED, $this->signature_data['extracerts']);
			}
			unlink($tempdoc);
			// read signature
			$signature = file_get_contents($tempsign);
			unlink($tempsign);
			// extract signature
			$signature = substr($signature, $pdfdoc_length);
			$signature = substr($signature, (strpos($signature, "%%EOF\n\n------") + 13));
			$tmparr = explode("\n\n", $signature);
			$signature = $tmparr[1];
			unset($tmparr);
			// decode signature
			$signature = base64_decode(trim($signature));
			// convert signature to hex
			$signature = current(unpack('H*', $signature));
			$signature = str_pad($signature, $this->signature_max_length, '0');
			// disable disk caching
			$this->diskcache = false;
			// Add signature to the document
			$this->buffer = substr($pdfdoc, 0, $byte_range[1]).'<'.$signature.'>'.substr($pdfdoc, $byte_range[1]);
			$this->bufferlen = strlen($this->buffer);
		}
		switch($dest) {
			case 'I': {
				// Send PDF to the standard output
				if (ob_get_contents()) {
					$this->Error('Some data has already been output, can\'t send PDF file');
				}
				if (php_sapi_name() != 'cli') {
					// send output to a browser
					header('Content-Type: application/pdf');
					if (headers_sent()) {
						$this->Error('Some data has already been output to browser, can\'t send PDF file');
					}
					header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=1');
					//header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
					header('Pragma: public');
					header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
					header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
					header('Content-Disposition: inline; filename="'.basename($name).'"');
					TCPDF_STATIC::sendOutputData($this->getBuffer(), $this->bufferlen);
				} else {
					echo $this->getBuffer();
				}
				break;
			}
			case 'D': {
				// download PDF as file
				if (ob_get_contents()) {
					$this->Error('Some data has already been output, can\'t send PDF file');
				}
				header('Content-Description: File Transfer');
				if (headers_sent()) {
					$this->Error('Some data has already been output to browser, can\'t send PDF file');
				}
				header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=1');
				//header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
				header('Pragma: public');
				header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
				header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
				// force download dialog
				if (strpos(php_sapi_name(), 'cgi') === false) {
					header('Content-Type: application/force-download');
					header('Content-Type: application/octet-stream', false);
					header('Content-Type: application/download', false);
					header('Content-Type: application/pdf', false);
				} else {
					header('Content-Type: application/pdf');
				}
				// use the Content-Disposition header to supply a recommended filename
				header('Content-Disposition: attachment; filename="'.basename($name).'"');
				header('Content-Transfer-Encoding: binary');
				TCPDF_STATIC::sendOutputData($this->getBuffer(), $this->bufferlen);
				break;
			}
			case 'F':
			case 'FI':
			case 'FD': {
				// save PDF to a local file
				if ($this->diskcache) {
					copy($this->buffer, $name);
				} else {
					$f = fopen($name, 'wb');
					if (!$f) {
						$this->Error('Unable to create output file: '.$name);
					}
					fwrite($f, $this->getBuffer(), $this->bufferlen);
					fclose($f);
				}
				if ($dest == 'FI') {
					// send headers to browser
					header('Content-Type: application/pdf');
					header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=1');
					//header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
					header('Pragma: public');
					header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
					header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
					header('Content-Disposition: inline; filename="'.basename($name).'"');
					TCPDF_STATIC::sendOutputData(file_get_contents($name), filesize($name));
				} elseif ($dest == 'FD') {
					// send headers to browser
					if (ob_get_contents()) {
						$this->Error('Some data has already been output, can\'t send PDF file');
					}
					header('Content-Description: File Transfer');
					if (headers_sent()) {
						$this->Error('Some data has already been output to browser, can\'t send PDF file');
					}
					header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=1');
					header('Pragma: public');
					header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
					header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
					// force download dialog
					if (strpos(php_sapi_name(), 'cgi') === false) {
						header('Content-Type: application/force-download');
						header('Content-Type: application/octet-stream', false);
						header('Content-Type: application/download', false);
						header('Content-Type: application/pdf', false);
					} else {
						header('Content-Type: application/pdf');
					}
					// use the Content-Disposition header to supply a recommended filename
					header('Content-Disposition: attachment; filename="'.basename($name).'"');
					header('Content-Transfer-Encoding: binary');
					TCPDF_STATIC::sendOutputData(file_get_contents($name), filesize($name));
				}
				break;
			}
			case 'E': {
				// return PDF as base64 mime multi-part email attachment (RFC 2045)
				$retval = 'Content-Type: application/pdf;'."\r\n";
				$retval .= ' name="'.$name.'"'."\r\n";
				$retval .= 'Content-Transfer-Encoding: base64'."\r\n";
				$retval .= 'Content-Disposition: attachment;'."\r\n";
				$retval .= ' filename="'.$name.'"'."\r\n\r\n";
				$retval .= chunk_split(base64_encode($this->getBuffer()), 76, "\r\n");
				return $retval;
			}
			case 'S': {
				// returns PDF as a string
				return $this->getBuffer();
			}
			default: {
				$this->Error('Incorrect output destination: '.$dest);
			}
		}
		return '';
	}

	/**
	 * Unset all class variables except the following critical variables.
	 * @param $destroyall (boolean) if true destroys all class variables, otherwise preserves critical variables.
	 * @param $preserve_objcopy (boolean) if true preserves the objcopy variable
	 * @public
	 * @since 4.5.016 (2009-02-24)
	 */
	public function _destroy($destroyall=false, $preserve_objcopy=false) {
		if ($destroyall AND isset($this->diskcache) AND $this->diskcache AND (!$preserve_objcopy) AND (!TCPDF_STATIC::empty_string($this->buffer))) {
			// remove buffer file from cache
			unlink($this->buffer);
		}
		if ($destroyall AND isset($this->cached_files) AND !empty($this->cached_files)) {
			// remove cached files
			foreach ($this->cached_files as $cachefile) {
				if (is_file($cachefile)) {
					unlink($cachefile);
				}
			}
			unset($this->cached_files);
		}
		foreach (array_keys(get_object_vars($this)) as $val) {
			if ($destroyall OR (
				($val != 'internal_encoding')
				AND ($val != 'state')
				AND ($val != 'bufferlen')
				AND ($val != 'buffer')
				AND ($val != 'diskcache')
				AND ($val != 'cached_files')
				AND ($val != 'sign')
				AND ($val != 'signature_data')
				AND ($val != 'signature_max_length')
				AND ($val != 'byterange_string')
				)) {
				if ((!$preserve_objcopy OR ($val != 'objcopy')) AND isset($this->$val)) {
					unset($this->$val);
				}
			}
		}
	}

	/**
	 * Check for locale-related bug
	 * @protected
	 */
	protected function _dochecks() {
		//Check for locale-related bug
		if (1.1 == 1) {
			$this->Error('Don\'t alter the locale before including class file');
		}
		//Check for decimal separator
		if (sprintf('%.1F', 1.0) != '1.0') {
			setlocale(LC_NUMERIC, 'C');
		}
	}

	/**
	 * Return an array containing variations for the basic page number alias.
	 * @param $a (string) Base alias.
	 * @return array of page number aliases
	 * @protected
	 */
	protected function getInternalPageNumberAliases($a= '') {
		$alias = array();
		// build array of Unicode + ASCII variants (the order is important)
		$alias = array('u' => array(), 'a' => array());
		$u = '{'.$a.'}';
		$alias['u'][] = TCPDF_STATIC::_escape($u);
		if ($this->isunicode) {
			$alias['u'][] = TCPDF_STATIC::_escape(TCPDF_FONTS::UTF8ToLatin1($u, $this->isunicode, $this->CurrentFont));
			$alias['u'][] = TCPDF_STATIC::_escape(TCPDF_FONTS::utf8StrRev($u, false, $this->tmprtl, $this->isunicode, $this->CurrentFont));
			$alias['a'][] = TCPDF_STATIC::_escape(TCPDF_FONTS::UTF8ToLatin1($a, $this->isunicode, $this->CurrentFont));
			$alias['a'][] = TCPDF_STATIC::_escape(TCPDF_FONTS::utf8StrRev($a, false, $this->tmprtl, $this->isunicode, $this->CurrentFont));
		}
		$alias['a'][] = TCPDF_STATIC::_escape($a);
		return $alias;
	}

	/**
	 * Return an array containing all internal page aliases.
	 * @return array of page number aliases
	 * @protected
	 */
	protected function getAllInternalPageNumberAliases() {
		$basic_alias = array(TCPDF_STATIC::$alias_tot_pages, TCPDF_STATIC::$alias_num_page, TCPDF_STATIC::$alias_group_tot_pages, TCPDF_STATIC::$alias_group_num_page, TCPDF_STATIC::$alias_right_shift);
		$pnalias = array();
		foreach($basic_alias as $k => $a) {
			$pnalias[$k] = $this->getInternalPageNumberAliases($a);
		}
		return $pnalias;
	}

	/**
	 * Replace right shift page number aliases with spaces to correct right alignment.
	 * This works perfectly only when using monospaced fonts.
	 * @param $page (string) Page content.
	 * @param $aliases (array) Array of page aliases.
	 * @param $diff (int) initial difference to add.
	 * @return replaced page content.
	 * @protected
	 */
	protected function replaceRightShiftPageNumAliases($page, $aliases, $diff) {
		foreach ($aliases as $type => $alias) {
			foreach ($alias as $a) {
				// find position of compensation factor
				$startnum = (strpos($a, ':') + 1);
				$a = substr($a, 0, $startnum);
				if (($pos = strpos($page, $a)) !== false) {
					// end of alias
					$endnum = strpos($page, '}', $pos);
					// string to be replaced
					$aa = substr($page, $pos, ($endnum - $pos + 1));
					// get compensation factor
					$ratio = substr($page, ($pos + $startnum), ($endnum - $pos - $startnum));
					$ratio = preg_replace('/[^0-9\.]/', '', $ratio);
					$ratio = floatval($ratio);
					if ($type == 'u') {
						$chrdiff = floor(($diff + 12) * $ratio);
						$shift = str_repeat(' ', $chrdiff);
						$shift = TCPDF_FONTS::UTF8ToUTF16BE($shift, false, $this->isunicode, $this->CurrentFont);
					} else {
						$chrdiff = floor(($diff + 11) * $ratio);
						$shift = str_repeat(' ', $chrdiff);
					}
					$page = str_replace($aa, $shift, $page);
				}
			}
		}
		return $page;
	}

	/**
	 * Set page boxes to be included on page descriptions.
	 * @param $boxes (array) Array of page boxes to set on document: ('MediaBox', 'CropBox', 'BleedBox', 'TrimBox', 'ArtBox').
	 * @protected
	 */
	protected function setPageBoxTypes($boxes) {
		$this->page_boxes = array();
		foreach ($boxes as $box) {
			if (in_array($box, TCPDF_STATIC::$pageboxes)) {
				$this->page_boxes[] = $box;
			}
		}
	}

	/**
	 * Output pages (and replace page number aliases).
	 * @protected
	 */
	protected function _putpages() {
		$filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
		// get internal aliases for page numbers
		$pnalias = $this->getAllInternalPageNumberAliases();
		$num_pages = $this->numpages;
		$ptpa = TCPDF_STATIC::formatPageNumber(($this->starting_page_number + $num_pages - 1));
		$ptpu = TCPDF_FONTS::UTF8ToUTF16BE($ptpa, false, $this->isunicode, $this->CurrentFont);
		$ptp_num_chars = $this->GetNumChars($ptpa);
		$pagegroupnum = 0;
		$groupnum = 0;
		$ptgu = 1;
		$ptga = 1;
		for ($n = 1; $n <= $num_pages; ++$n) {
			// get current page
			$temppage = $this->getPageBuffer($n);
			$pagelen = strlen($temppage);
			// set replacements for total pages number
			$pnpa = TCPDF_STATIC::formatPageNumber(($this->starting_page_number + $n - 1));
			$pnpu = TCPDF_FONTS::UTF8ToUTF16BE($pnpa, false, $this->isunicode, $this->CurrentFont);
			$pnp_num_chars = $this->GetNumChars($pnpa);
			$pdiff = 0; // difference used for right shift alignment of page numbers
			$gdiff = 0; // difference used for right shift alignment of page group numbers
			if (!empty($this->pagegroups)) {
				if (isset($this->newpagegroup[$n])) {
					$pagegroupnum = 0;
					++$groupnum;
					$ptga = TCPDF_STATIC::formatPageNumber($this->pagegroups[$groupnum]);
					$ptgu = TCPDF_FONTS::UTF8ToUTF16BE($ptga, false, $this->isunicode, $this->CurrentFont);
					$ptg_num_chars = $this->GetNumChars($ptga);
				}
				++$pagegroupnum;
				$pnga = TCPDF_STATIC::formatPageNumber($pagegroupnum);
				$pngu = TCPDF_FONTS::UTF8ToUTF16BE($pnga, false, $this->isunicode, $this->CurrentFont);
				$png_num_chars = $this->GetNumChars($pnga);
				// replace page numbers
				$replace = array();
				$replace[] = array($ptgu, $ptg_num_chars, 9, $pnalias[2]['u']);
				$replace[] = array($ptga, $ptg_num_chars, 7, $pnalias[2]['a']);
				$replace[] = array($pngu, $png_num_chars, 9, $pnalias[3]['u']);
				$replace[] = array($pnga, $png_num_chars, 7, $pnalias[3]['a']);
				list($temppage, $gdiff) = TCPDF_STATIC::replacePageNumAliases($temppage, $replace, $gdiff);
			}
			// replace page numbers
			$replace = array();
			$replace[] = array($ptpu, $ptp_num_chars, 9, $pnalias[0]['u']);
			$replace[] = array($ptpa, $ptp_num_chars, 7, $pnalias[0]['a']);
			$replace[] = array($pnpu, $pnp_num_chars, 9, $pnalias[1]['u']);
			$replace[] = array($pnpa, $pnp_num_chars, 7, $pnalias[1]['a']);
			list($temppage, $pdiff) = TCPDF_STATIC::replacePageNumAliases($temppage, $replace, $pdiff);
			// replace right shift alias
			$temppage = $this->replaceRightShiftPageNumAliases($temppage, $pnalias[4], max($pdiff, $gdiff));
			// replace EPS marker
			$temppage = str_replace($this->epsmarker, '', $temppage);
			//Page
			$this->page_obj_id[$n] = $this->_newobj();
			$out = '<<';
			$out .= ' /Type /Page';
			$out .= ' /Parent 1 0 R';
			$out .= ' /LastModified '.$this->_datestring(0, $this->doc_modification_timestamp);
			$out .= ' /Resources 2 0 R';
			foreach ($this->page_boxes as $box) {
				$out .= ' /'.$box;
				$out .= sprintf(' [%F %F %F %F]', $this->pagedim[$n][$box]['llx'], $this->pagedim[$n][$box]['lly'], $this->pagedim[$n][$box]['urx'], $this->pagedim[$n][$box]['ury']);
			}
			if (isset($this->pagedim[$n]['BoxColorInfo']) AND !empty($this->pagedim[$n]['BoxColorInfo'])) {
				$out .= ' /BoxColorInfo <<';
				foreach ($this->page_boxes as $box) {
					if (isset($this->pagedim[$n]['BoxColorInfo'][$box])) {
						$out .= ' /'.$box.' <<';
						if (isset($this->pagedim[$n]['BoxColorInfo'][$box]['C'])) {
							$color = $this->pagedim[$n]['BoxColorInfo'][$box]['C'];
							$out .= ' /C [';
							$out .= sprintf(' %F %F %F', ($color[0] / 255), ($color[1] / 255), ($color[2] / 255));
							$out .= ' ]';
						}
						if (isset($this->pagedim[$n]['BoxColorInfo'][$box]['W'])) {
							$out .= ' /W '.($this->pagedim[$n]['BoxColorInfo'][$box]['W'] * $this->k);
						}
						if (isset($this->pagedim[$n]['BoxColorInfo'][$box]['S'])) {
							$out .= ' /S /'.$this->pagedim[$n]['BoxColorInfo'][$box]['S'];
						}
						if (isset($this->pagedim[$n]['BoxColorInfo'][$box]['D'])) {
							$dashes = $this->pagedim[$n]['BoxColorInfo'][$box]['D'];
							$out .= ' /D [';
							foreach ($dashes as $dash) {
								$out .= sprintf(' %F', ($dash * $this->k));
							}
							$out .= ' ]';
						}
						$out .= ' >>';
					}
				}
				$out .= ' >>';
			}
			$out .= ' /Contents '.($this->n + 1).' 0 R';
			$out .= ' /Rotate '.$this->pagedim[$n]['Rotate'];
			if (!$this->pdfa_mode) {
				$out .= ' /Group << /Type /Group /S /Transparency /CS /DeviceRGB >>';
			}
			if (isset($this->pagedim[$n]['trans']) AND !empty($this->pagedim[$n]['trans'])) {
				// page transitions
				if (isset($this->pagedim[$n]['trans']['Dur'])) {
					$out .= ' /Dur '.$this->pagedim[$n]['trans']['Dur'];
				}
				$out .= ' /Trans <<';
				$out .= ' /Type /Trans';
				if (isset($this->pagedim[$n]['trans']['S'])) {
					$out .= ' /S /'.$this->pagedim[$n]['trans']['S'];
				}
				if (isset($this->pagedim[$n]['trans']['D'])) {
					$out .= ' /D '.$this->pagedim[$n]['trans']['D'];
				}
				if (isset($this->pagedim[$n]['trans']['Dm'])) {
					$out .= ' /Dm /'.$this->pagedim[$n]['trans']['Dm'];
				}
				if (isset($this->pagedim[$n]['trans']['M'])) {
					$out .= ' /M /'.$this->pagedim[$n]['trans']['M'];
				}
				if (isset($this->pagedim[$n]['trans']['Di'])) {
					$out .= ' /Di '.$this->pagedim[$n]['trans']['Di'];
				}
				if (isset($this->pagedim[$n]['trans']['SS'])) {
					$out .= ' /SS '.$this->pagedim[$n]['trans']['SS'];
				}
				if (isset($this->pagedim[$n]['trans']['B'])) {
					$out .= ' /B '.$this->pagedim[$n]['trans']['B'];
				}
				$out .= ' >>';
			}
			$out .= $this->_getannotsrefs($n);
			$out .= ' /PZ '.$this->pagedim[$n]['PZ'];
			$out .= ' >>';
			$out .= "\n".'endobj';
			$this->_out($out);
			//Page content
			$p = ($this->compress) ? gzcompress($temppage) : $temppage;
			$this->_newobj();
			$p = $this->_getrawstream($p);
			$this->_out('<<'.$filter.'/Length '.strlen($p).'>> stream'."\n".$p."\n".'endstream'."\n".'endobj');
			if ($this->diskcache) {
				// remove temporary files
				unlink($this->pages[$n]);
			}
		}
		//Pages root
		$out = $this->_getobj(1)."\n";
		$out .= '<< /Type /Pages /Kids [';
		foreach($this->page_obj_id as $page_obj) {
			$out .= ' '.$page_obj.' 0 R';
		}
		$out .= ' ] /Count '.$num_pages.' >>';
		$out .= "\n".'endobj';
		$this->_out($out);
	}

	/**
	 * Output references to page annotations
	 * @param $n (int) page number
	 * @protected
	 * @author Nicola Asuni
	 * @since 4.7.000 (2008-08-29)
	 * @deprecated
	 */
	protected function _putannotsrefs($n) {
		$this->_out($this->_getannotsrefs($n));
	}

	/**
	 * Get references to page annotations.
	 * @param $n (int) page number
	 * @return string
	 * @protected
	 * @author Nicola Asuni
	 * @since 5.0.010 (2010-05-17)
	 */
	protected function _getannotsrefs($n) {
		if (!(isset($this->PageAnnots[$n]) OR ($this->sign AND isset($this->signature_data['cert_type'])))) {
			return '';
		}
		$out = ' /Annots [';
		if (isset($this->PageAnnots[$n])) {
			foreach ($this->PageAnnots[$n] as $key => $val) {
				if (!in_array($val['n'], $this->radio_groups)) {
					$out .= ' '.$val['n'].' 0 R';
				}
			}
			// add radiobutton groups
			if (isset($this->radiobutton_groups[$n])) {
				foreach ($this->radiobutton_groups[$n] as $key => $data) {
					if (isset($data['n'])) {
						$out .= ' '.$data['n'].' 0 R';
					}
				}
			}
		}
		if ($this->sign AND ($n == $this->signature_appearance['page']) AND isset($this->signature_data['cert_type'])) {
			// set reference for signature object
			$out .= ' '.$this->sig_obj_id.' 0 R';
		}
		if (!empty($this->empty_signature_appearance)) {
			foreach ($this->empty_signature_appearance as $esa) {
				if ($esa['page'] == $n) {
					// set reference for empty signature objects
					$out .= ' '.$esa['objid'].' 0 R';
				}
			}
		}
		$out .= ' ]';
		return $out;
	}

	/**
	 * Output annotations objects for all pages.
	 * !!! THIS METHOD IS NOT YET COMPLETED !!!
	 * See section 12.5 of PDF 32000_2008 reference.
	 * @protected
	 * @author Nicola Asuni
	 * @since 4.0.018 (2008-08-06)
	 */
	protected function _putannotsobjs() {
		// reset object counter
		for ($n=1; $n <= $this->numpages; ++$n) {
			if (isset($this->PageAnnots[$n])) {
				// set page annotations
				foreach ($this->PageAnnots[$n] as $key => $pl) {
					$annot_obj_id = $this->PageAnnots[$n][$key]['n'];
					// create annotation object for grouping radiobuttons
					if (isset($this->radiobutton_groups[$n][$pl['txt']]) AND is_array($this->radiobutton_groups[$n][$pl['txt']])) {
						$radio_button_obj_id = $this->radiobutton_groups[$n][$pl['txt']]['n'];
						$annots = '<<';
						$annots .= ' /Type /Annot';
						$annots .= ' /Subtype /Widget';
						$annots .= ' /Rect [0 0 0 0]';
						if ($this->radiobutton_groups[$n][$pl['txt']]['#readonly#']) {
							// read only
							$annots .= ' /F 68';
							$annots .= ' /Ff 49153';
						} else {
							$annots .= ' /F 4'; // default print for PDF/A
							$annots .= ' /Ff 49152';
						}
						$annots .= ' /T '.$this->_datastring($pl['txt'], $radio_button_obj_id);
						if (isset($pl['opt']['tu']) AND is_string($pl['opt']['tu'])) {
							$annots .= ' /TU '.$this->_datastring($pl['opt']['tu'], $radio_button_obj_id);
						}
						$annots .= ' /FT /Btn';
						$annots .= ' /Kids [';
						$defval = '';
						foreach ($this->radiobutton_groups[$n][$pl['txt']] as $key => $data) {
							if (isset($data['kid'])) {
								$annots .= ' '.$data['kid'].' 0 R';
								if ($data['def'] !== 'Off') {
									$defval = $data['def'];
								}
							}
						}
						$annots .= ' ]';
						if (!empty($defval)) {
							$annots .= ' /V /'.$defval;
						}
						$annots .= ' >>';
						$this->_out($this->_getobj($radio_button_obj_id)."\n".$annots."\n".'endobj');
						$this->form_obj_id[] = $radio_button_obj_id;
						// store object id to be used on Parent entry of Kids
						$this->radiobutton_groups[$n][$pl['txt']] = $radio_button_obj_id;
					}
					$formfield = false;
					$pl['opt'] = array_change_key_case($pl['opt'], CASE_LOWER);
					$a = $pl['x'] * $this->k;
					$b = $this->pagedim[$n]['h'] - (($pl['y'] + $pl['h']) * $this->k);
					$c = $pl['w'] * $this->k;
					$d = $pl['h'] * $this->k;
					$rect = sprintf('%F %F %F %F', $a, $b, $a+$c, $b+$d);
					// create new annotation object
					$annots = '<</Type /Annot';
					$annots .= ' /Subtype /'.$pl['opt']['subtype'];
					$annots .= ' /Rect ['.$rect.']';
					$ft = array('Btn', 'Tx', 'Ch', 'Sig');
					if (isset($pl['opt']['ft']) AND in_array($pl['opt']['ft'], $ft)) {
						$annots .= ' /FT /'.$pl['opt']['ft'];
						$formfield = true;
					}
					$annots .= ' /Contents '.$this->_textstring($pl['txt'], $annot_obj_id);
					$annots .= ' /P '.$this->page_obj_id[$n].' 0 R';
					$annots .= ' /NM '.$this->_datastring(sprintf('%04u-%04u', $n, $key), $annot_obj_id);
					$annots .= ' /M '.$this->_datestring($annot_obj_id, $this->doc_modification_timestamp);
					if (isset($pl['opt']['f'])) {
						$fval = 0;
						if (is_array($pl['opt']['f'])) {
							foreach ($pl['opt']['f'] as $f) {
								switch (strtolower($f)) {
									case 'invisible': {
										$fval += 1 << 0;
										break;
									}
									case 'hidden': {
										$fval += 1 << 1;
										break;
									}
									case 'print': {
										$fval += 1 << 2;
										break;
									}
									case 'nozoom': {
										$fval += 1 << 3;
										break;
									}
									case 'norotate': {
										$fval += 1 << 4;
										break;
									}
									case 'noview': {
										$fval += 1 << 5;
										break;
									}
									case 'readonly': {
										$fval += 1 << 6;
										break;
									}
									case 'locked': {
										$fval += 1 << 8;
										break;
									}
									case 'togglenoview': {
										$fval += 1 << 9;
										break;
									}
									case 'lockedcontents': {
										$fval += 1 << 10;
										break;
									}
									default: {
										break;
									}
								}
							}
						} else {
							$fval = intval($pl['opt']['f']);
						}
					} else {
						$fval = 4;
					}
					if ($this->pdfa_mode) {
						// force print flag for PDF/A mode
						$fval |= 4;
					}
					$annots .= ' /F '.intval($fval);
					if (isset($pl['opt']['as']) AND is_string($pl['opt']['as'])) {
						$annots .= ' /AS /'.$pl['opt']['as'];
					}
					if (isset($pl['opt']['ap'])) {
						// appearance stream
						$annots .= ' /AP <<';
						if (is_array($pl['opt']['ap'])) {
							foreach ($pl['opt']['ap'] as $apmode => $apdef) {
								// $apmode can be: n = normal; r = rollover; d = down;
								$annots .= ' /'.strtoupper($apmode);
								if (is_array($apdef)) {
									$annots .= ' <<';
									foreach ($apdef as $apstate => $stream) {
										// reference to XObject that define the appearance for this mode-state
										$apsobjid = $this->_putAPXObject($c, $d, $stream);
										$annots .= ' /'.$apstate.' '.$apsobjid.' 0 R';
									}
									$annots .= ' >>';
								} else {
									// reference to XObject that define the appearance for this mode
									$apsobjid = $this->_putAPXObject($c, $d, $apdef);
									$annots .= ' '.$apsobjid.' 0 R';
								}
							}
						} else {
							$annots .= $pl['opt']['ap'];
						}
						$annots .= ' >>';
					}
					if (isset($pl['opt']['bs']) AND (is_array($pl['opt']['bs']))) {
						$annots .= ' /BS <<';
						$annots .= ' /Type /Border';
						if (isset($pl['opt']['bs']['w'])) {
							$annots .= ' /W '.intval($pl['opt']['bs']['w']);
						}
						$bstyles = array('S', 'D', 'B', 'I', 'U');
						if (isset($pl['opt']['bs']['s']) AND in_array($pl['opt']['bs']['s'], $bstyles)) {
							$annots .= ' /S /'.$pl['opt']['bs']['s'];
						}
						if (isset($pl['opt']['bs']['d']) AND (is_array($pl['opt']['bs']['d']))) {
							$annots .= ' /D [';
							foreach ($pl['opt']['bs']['d'] as $cord) {
								$annots .= ' '.intval($cord);
							}
							$annots .= ']';
						}
						$annots .= ' >>';
					} else {
						$annots .= ' /Border [';
						if (isset($pl['opt']['border']) AND (count($pl['opt']['border']) >= 3)) {
							$annots .= intval($pl['opt']['border'][0]).' ';
							$annots .= intval($pl['opt']['border'][1]).' ';
							$annots .= intval($pl['opt']['border'][2]);
							if (isset($pl['opt']['border'][3]) AND is_array($pl['opt']['border'][3])) {
								$annots .= ' [';
								foreach ($pl['opt']['border'][3] as $dash) {
									$annots .= intval($dash).' ';
								}
								$annots .= ']';
							}
						} else {
							$annots .= '0 0 0';
						}
						$annots .= ']';
					}
					if (isset($pl['opt']['be']) AND (is_array($pl['opt']['be']))) {
						$annots .= ' /BE <<';
						$bstyles = array('S', 'C');
						if (isset($pl['opt']['be']['s']) AND in_array($pl['opt']['be']['s'], $bstyles)) {
							$annots .= ' /S /'.$pl['opt']['bs']['s'];
						} else {
							$annots .= ' /S /S';
						}
						if (isset($pl['opt']['be']['i']) AND ($pl['opt']['be']['i'] >= 0) AND ($pl['opt']['be']['i'] <= 2)) {
							$annots .= ' /I '.sprintf(' %F', $pl['opt']['be']['i']);
						}
						$annots .= '>>';
					}
					if (isset($pl['opt']['c']) AND (is_array($pl['opt']['c'])) AND !empty($pl['opt']['c'])) {
						$annots .= ' /C '.TCPDF_COLORS::getColorStringFromArray($pl['opt']['c']);
					}
					//$annots .= ' /StructParent ';
					//$annots .= ' /OC ';
					$markups = array('text', 'freetext', 'line', 'square', 'circle', 'polygon', 'polyline', 'highlight', 'underline', 'squiggly', 'strikeout', 'stamp', 'caret', 'ink', 'fileattachment', 'sound');
					if (in_array(strtolower($pl['opt']['subtype']), $markups)) {
						// this is a markup type
						if (isset($pl['opt']['t']) AND is_string($pl['opt']['t'])) {
							$annots .= ' /T '.$this->_textstring($pl['opt']['t'], $annot_obj_id);
						}
						//$annots .= ' /Popup ';
						if (isset($pl['opt']['ca'])) {
							$annots .= ' /CA '.sprintf('%F', floatval($pl['opt']['ca']));
						}
						if (isset($pl['opt']['rc'])) {
							$annots .= ' /RC '.$this->_textstring($pl['opt']['rc'], $annot_obj_id);
						}
						$annots .= ' /CreationDate '.$this->_datestring($annot_obj_id, $this->doc_creation_timestamp);
						//$annots .= ' /IRT ';
						if (isset($pl['opt']['subj'])) {
							$annots .= ' /Subj '.$this->_textstring($pl['opt']['subj'], $annot_obj_id);
						}
						//$annots .= ' /RT ';
						//$annots .= ' /IT ';
						//$annots .= ' /ExData ';
					}
					$lineendings = array('Square', 'Circle', 'Diamond', 'OpenArrow', 'ClosedArrow', 'None', 'Butt', 'ROpenArrow', 'RClosedArrow', 'Slash');
					// Annotation types
					switch (strtolower($pl['opt']['subtype'])) {
						case 'text': {
							if (isset($pl['opt']['open'])) {
								$annots .= ' /Open '. (strtolower($pl['opt']['open']) == 'true' ? 'true' : 'false');
							}
							$iconsapp = array('Comment', 'Help', 'Insert', 'Key', 'NewParagraph', 'Note', 'Paragraph');
							if (isset($pl['opt']['name']) AND in_array($pl['opt']['name'], $iconsapp)) {
								$annots .= ' /Name /'.$pl['opt']['name'];
							} else {
								$annots .= ' /Name /Note';
							}
							$statemodels = array('Marked', 'Review');
							if (isset($pl['opt']['statemodel']) AND in_array($pl['opt']['statemodel'], $statemodels)) {
								$annots .= ' /StateModel /'.$pl['opt']['statemodel'];
							} else {
								$pl['opt']['statemodel'] = 'Marked';
								$annots .= ' /StateModel /'.$pl['opt']['statemodel'];
							}
							if ($pl['opt']['statemodel'] == 'Marked') {
								$states = array('Accepted', 'Unmarked');
							} else {
								$states = array('Accepted', 'Rejected', 'Cancelled', 'Completed', 'None');
							}
							if (isset($pl['opt']['state']) AND in_array($pl['opt']['state'], $states)) {
								$annots .= ' /State /'.$pl['opt']['state'];
							} else {
								if ($pl['opt']['statemodel'] == 'Marked') {
									$annots .= ' /State /Unmarked';
								} else {
									$annots .= ' /State /None';
								}
							}
							break;
						}
						case 'link': {
							if (is_string($pl['txt'])) {
								if ($pl['txt'][0] == '#') {
									// internal destination
									$annots .= ' /Dest /'.TCPDF_STATIC::encodeNameObject(substr($pl['txt'], 1));
								} elseif ($pl['txt'][0] == '%') {
									// embedded PDF file
									$filename = basename(substr($pl['txt'], 1));
									$annots .= ' /A << /S /GoToE /D [0 /Fit] /NewWindow true /T << /R /C /P '.($n - 1).' /A '.$this->embeddedfiles[$filename]['a'].' >> >>';
								} elseif ($pl['txt'][0] == '*') {
									// embedded generic file
									$filename = basename(substr($pl['txt'], 1));
									$jsa = 'var D=event.target.doc;var MyData=D.dataObjects;for (var i in MyData) if (MyData[i].path=="'.$filename.'") D.exportDataObject( { cName : MyData[i].name, nLaunch : 2});';
									$annots .= ' /A << /S /JavaScript /JS '.$this->_textstring($jsa, $annot_obj_id).'>>';
								} else {
									// external URI link
									$annots .= ' /A <</S /URI /URI '.$this->_datastring($this->unhtmlentities($pl['txt']), $annot_obj_id).'>>';
								}
							} elseif (isset($this->links[$pl['txt']])) {
								// internal link ID
								$l = $this->links[$pl['txt']];
								if (isset($this->page_obj_id[($l[0])])) {
									$annots .= sprintf(' /Dest [%u 0 R /XYZ 0 %F null]', $this->page_obj_id[($l[0])], ($this->pagedim[$l[0]]['h'] - ($l[1] * $this->k)));
								}
							}
							$hmodes = array('N', 'I', 'O', 'P');
							if (isset($pl['opt']['h']) AND in_array($pl['opt']['h'], $hmodes)) {
								$annots .= ' /H /'.$pl['opt']['h'];
							} else {
								$annots .= ' /H /I';
							}
							//$annots .= ' /PA ';
							//$annots .= ' /Quadpoints ';
							break;
						}
						case 'freetext': {
							if (isset($pl['opt']['da']) AND !empty($pl['opt']['da'])) {
								$annots .= ' /DA ('.$pl['opt']['da'].')';
							}
							if (isset($pl['opt']['q']) AND ($pl['opt']['q'] >= 0) AND ($pl['opt']['q'] <= 2)) {
								$annots .= ' /Q '.intval($pl['opt']['q']);
							}
							if (isset($pl['opt']['rc'])) {
								$annots .= ' /RC '.$this->_textstring($pl['opt']['rc'], $annot_obj_id);
							}
							if (isset($pl['opt']['ds'])) {
								$annots .= ' /DS '.$this->_textstring($pl['opt']['ds'], $annot_obj_id);
							}
							if (isset($pl['opt']['cl']) AND is_array($pl['opt']['cl'])) {
								$annots .= ' /CL [';
								foreach ($pl['opt']['cl'] as $cl) {
									$annots .= sprintf('%F ', $cl * $this->k);
								}
								$annots .= ']';
							}
							$tfit = array('FreeText', 'FreeTextCallout', 'FreeTextTypeWriter');
							if (isset($pl['opt']['it']) AND in_array($pl['opt']['it'], $tfit)) {
								$annots .= ' /IT /'.$pl['opt']['it'];
							}
							if (isset($pl['opt']['rd']) AND is_array($pl['opt']['rd'])) {
								$l = $pl['opt']['rd'][0] * $this->k;
								$r = $pl['opt']['rd'][1] * $this->k;
								$t = $pl['opt']['rd'][2] * $this->k;
								$b = $pl['opt']['rd'][3] * $this->k;
								$annots .= ' /RD ['.sprintf('%F %F %F %F', $l, $r, $t, $b).']';
							}
							if (isset($pl['opt']['le']) AND in_array($pl['opt']['le'], $lineendings)) {
								$annots .= ' /LE /'.$pl['opt']['le'];
							}
							break;
						}
						case 'line': {
							break;
						}
						case 'square': {
							break;
						}
						case 'circle': {
							break;
						}
						case 'polygon': {
							break;
						}
						case 'polyline': {
							break;
						}
						case 'highlight': {
							break;
						}
						case 'underline': {
							break;
						}
						case 'squiggly': {
							break;
						}
						case 'strikeout': {
							break;
						}
						case 'stamp': {
							break;
						}
						case 'caret': {
							break;
						}
						case 'ink': {
							break;
						}
						case 'popup': {
							break;
						}
						case 'fileattachment': {
							if ($this->pdfa_mode) {
								// embedded files are not allowed in PDF/A mode
								break;
							}
							if (!isset($pl['opt']['fs'])) {
								break;
							}
							$filename = basename($pl['opt']['fs']);
							if (isset($this->embeddedfiles[$filename]['f'])) {
								$annots .= ' /FS '.$this->embeddedfiles[$filename]['f'].' 0 R';
								$iconsapp = array('Graph', 'Paperclip', 'PushPin', 'Tag');
								if (isset($pl['opt']['name']) AND in_array($pl['opt']['name'], $iconsapp)) {
									$annots .= ' /Name /'.$pl['opt']['name'];
								} else {
									$annots .= ' /Name /PushPin';
								}
								// index (zero-based) of the annotation in the Annots array of this page
								$this->embeddedfiles[$filename]['a'] = $key;
							}
							break;
						}
						case 'sound': {
							if (!isset($pl['opt']['fs'])) {
								break;
							}
							$filename = basename($pl['opt']['fs']);
							if (isset($this->embeddedfiles[$filename]['f'])) {
								// ... TO BE COMPLETED ...
								// /R /C /B /E /CO /CP
								$annots .= ' /Sound '.$this->embeddedfiles[$filename]['f'].' 0 R';
								$iconsapp = array('Speaker', 'Mic');
								if (isset($pl['opt']['name']) AND in_array($pl['opt']['name'], $iconsapp)) {
									$annots .= ' /Name /'.$pl['opt']['name'];
								} else {
									$annots .= ' /Name /Speaker';
								}
							}
							break;
						}
						case 'movie': {
							break;
						}
						case 'widget': {
							$hmode = array('N', 'I', 'O', 'P', 'T');
							if (isset($pl['opt']['h']) AND in_array($pl['opt']['h'], $hmode)) {
								$annots .= ' /H /'.$pl['opt']['h'];
							}
							if (isset($pl['opt']['mk']) AND (is_array($pl['opt']['mk'])) AND !empty($pl['opt']['mk'])) {
								$annots .= ' /MK <<';
								if (isset($pl['opt']['mk']['r'])) {
									$annots .= ' /R '.$pl['opt']['mk']['r'];
								}
								if (isset($pl['opt']['mk']['bc']) AND (is_array($pl['opt']['mk']['bc']))) {
									$annots .= ' /BC '.TCPDF_COLORS::getColorStringFromArray($pl['opt']['mk']['bc']);
								}
								if (isset($pl['opt']['mk']['bg']) AND (is_array($pl['opt']['mk']['bg']))) {
									$annots .= ' /BG '.TCPDF_COLORS::getColorStringFromArray($pl['opt']['mk']['bg']);
								}
								if (isset($pl['opt']['mk']['ca'])) {
									$annots .= ' /CA '.$pl['opt']['mk']['ca'];
								}
								if (isset($pl['opt']['mk']['rc'])) {
									$annots .= ' /RC '.$pl['opt']['mk']['rc'];
								}
								if (isset($pl['opt']['mk']['ac'])) {
									$annots .= ' /AC '.$pl['opt']['mk']['ac'];
								}
								if (isset($pl['opt']['mk']['i'])) {
									$info = $this->getImageBuffer($pl['opt']['mk']['i']);
									if ($info !== false) {
										$annots .= ' /I '.$info['n'].' 0 R';
									}
								}
								if (isset($pl['opt']['mk']['ri'])) {
									$info = $this->getImageBuffer($pl['opt']['mk']['ri']);
									if ($info !== false) {
										$annots .= ' /RI '.$info['n'].' 0 R';
									}
								}
								if (isset($pl['opt']['mk']['ix'])) {
									$info = $this->getImageBuffer($pl['opt']['mk']['ix']);
									if ($info !== false) {
										$annots .= ' /IX '.$info['n'].' 0 R';
									}
								}
								if (isset($pl['opt']['mk']['if']) AND (is_array($pl['opt']['mk']['if'])) AND !empty($pl['opt']['mk']['if'])) {
									$annots .= ' /IF <<';
									$if_sw = array('A', 'B', 'S', 'N');
									if (isset($pl['opt']['mk']['if']['sw']) AND in_array($pl['opt']['mk']['if']['sw'], $if_sw)) {
										$annots .= ' /SW /'.$pl['opt']['mk']['if']['sw'];
									}
									$if_s = array('A', 'P');
									if (isset($pl['opt']['mk']['if']['s']) AND in_array($pl['opt']['mk']['if']['s'], $if_s)) {
										$annots .= ' /S /'.$pl['opt']['mk']['if']['s'];
									}
									if (isset($pl['opt']['mk']['if']['a']) AND (is_array($pl['opt']['mk']['if']['a'])) AND !empty($pl['opt']['mk']['if']['a'])) {
										$annots .= sprintf(' /A [%F %F]', $pl['opt']['mk']['if']['a'][0], $pl['opt']['mk']['if']['a'][1]);
									}
									if (isset($pl['opt']['mk']['if']['fb']) AND ($pl['opt']['mk']['if']['fb'])) {
										$annots .= ' /FB true';
									}
									$annots .= '>>';
								}
								if (isset($pl['opt']['mk']['tp']) AND ($pl['opt']['mk']['tp'] >= 0) AND ($pl['opt']['mk']['tp'] <= 6)) {
									$annots .= ' /TP '.intval($pl['opt']['mk']['tp']);
								}
								$annots .= '>>';
							} // end MK
							// --- Entries for field dictionaries ---
							if (isset($this->radiobutton_groups[$n][$pl['txt']])) {
								// set parent
								$annots .= ' /Parent '.$this->radiobutton_groups[$n][$pl['txt']].' 0 R';
							}
							if (isset($pl['opt']['t']) AND is_string($pl['opt']['t'])) {
								$annots .= ' /T '.$this->_datastring($pl['opt']['t'], $annot_obj_id);
							}
							if (isset($pl['opt']['tu']) AND is_string($pl['opt']['tu'])) {
								$annots .= ' /TU '.$this->_datastring($pl['opt']['tu'], $annot_obj_id);
							}
							if (isset($pl['opt']['tm']) AND is_string($pl['opt']['tm'])) {
								$annots .= ' /TM '.$this->_datastring($pl['opt']['tm'], $annot_obj_id);
							}
							if (isset($pl['opt']['ff'])) {
								if (is_array($pl['opt']['ff'])) {
									// array of bit settings
									$flag = 0;
									foreach($pl['opt']['ff'] as $val) {
										$flag += 1 << ($val - 1);
									}
								} else {
									$flag = intval($pl['opt']['ff']);
								}
								$annots .= ' /Ff '.$flag;
							}
							if (isset($pl['opt']['maxlen'])) {
								$annots .= ' /MaxLen '.intval($pl['opt']['maxlen']);
							}
							if (isset($pl['opt']['v'])) {
								$annots .= ' /V';
								if (is_array($pl['opt']['v'])) {
									foreach ($pl['opt']['v'] AS $optval) {
										if (is_float($optval)) {
											$optval = sprintf('%F', $optval);
										}
										$annots .= ' '.$optval;
									}
								} else {
									$annots .= ' '.$this->_textstring($pl['opt']['v'], $annot_obj_id);
								}
							}
							if (isset($pl['opt']['dv'])) {
								$annots .= ' /DV';
								if (is_array($pl['opt']['dv'])) {
									foreach ($pl['opt']['dv'] AS $optval) {
										if (is_float($optval)) {
											$optval = sprintf('%F', $optval);
										}
										$annots .= ' '.$optval;
									}
								} else {
									$annots .= ' '.$this->_textstring($pl['opt']['dv'], $annot_obj_id);
								}
							}
							if (isset($pl['opt']['rv'])) {
								$annots .= ' /RV';
								if (is_array($pl['opt']['rv'])) {
									foreach ($pl['opt']['rv'] AS $optval) {
										if (is_float($optval)) {
											$optval = sprintf('%F', $optval);
										}
										$annots .= ' '.$optval;
									}
								} else {
									$annots .= ' '.$this->_textstring($pl['opt']['rv'], $annot_obj_id);
								}
							}
							if (isset($pl['opt']['a']) AND !empty($pl['opt']['a'])) {
								$annots .= ' /A << '.$pl['opt']['a'].' >>';
							}
							if (isset($pl['opt']['aa']) AND !empty($pl['opt']['aa'])) {
								$annots .= ' /AA << '.$pl['opt']['aa'].' >>';
							}
							if (isset($pl['opt']['da']) AND !empty($pl['opt']['da'])) {
								$annots .= ' /DA ('.$pl['opt']['da'].')';
							}
							if (isset($pl['opt']['q']) AND ($pl['opt']['q'] >= 0) AND ($pl['opt']['q'] <= 2)) {
								$annots .= ' /Q '.intval($pl['opt']['q']);
							}
							if (isset($pl['opt']['opt']) AND (is_array($pl['opt']['opt'])) AND !empty($pl['opt']['opt'])) {
								$annots .= ' /Opt [';
								foreach($pl['opt']['opt'] AS $copt) {
									if (is_array($copt)) {
										$annots .= ' ['.$this->_textstring($copt[0], $annot_obj_id).' '.$this->_textstring($copt[1], $annot_obj_id).']';
									} else {
										$annots .=