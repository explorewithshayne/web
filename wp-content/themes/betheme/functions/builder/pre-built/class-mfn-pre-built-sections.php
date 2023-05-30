<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

class Mfn_Pre_Built_Sections {

  private static $categories = [
    'all' => 'All',
		'bas'	=> 'Basic',
		'lis'	=> 'List & Menus',
		'off'	=> 'Offer',
		'cal'	=> 'Call to action',
		'con'	=> 'Contact',
		'mis'	=> 'Misc',
	];

  private static $sections = [

    1 => [
      'title' => 'Text + image',
      'category' => 'bas',
    ],
    2 => [
      'title' => 'Image + text',
      'category' => 'bas',
    ],
    3 => [
      'title' => 'Text in columns',
      'category' => 'bas',
    ],
    4 => [
      'title' => 'Text in equal height columns',
      'category' => 'bas',
    ],
    5 => [
      'title' => 'Equal height of wraps',
      'category' => 'bas',
    ],
    6 => [
      'title' => 'Full width',
      'category' => 'bas',
    ],
    7 => [
      'title' => 'Full width with side padding',
      'category' => 'bas',
    ],
    8 => [
      'title' => 'Highlight left',
      'category' => 'bas',
    ],
    9 => [
      'title' => 'Highlight right',
      'category' => 'bas',
    ],
    10 => [
      'title' => 'List with icons',
      'category' => 'lis',
    ],
    11 => [
      'title' => 'List with images',
      'category' => 'lis',
    ],
    12 => [
      'title' => 'Feature list',
      'category' => 'lis',
    ],
    13 => [
      'title' => 'Custom list with numbers',
      'category' => 'lis',
    ],
    14 => [
      'title' => 'Custom lists',
      'category' => 'lis',
    ],
    15 => [
      'title' => 'Helper',
      'category' => 'lis',
    ],
    16 => [
      'title' => 'Accordion',
      'category' => 'lis',
    ],
    17 => [
      'title' => 'FAQ',
      'category' => 'lis',
    ],
    18 => [
      'title' => 'Menu with image',
      'category' => 'lis',
    ],
    19 => [
      'title' => 'Menu with heading on the background',
      'category' => 'lis',
    ],
    20 => [
      'title' => 'Boxes with hover',
      'category' => 'off',
    ],
    21 => [
      'title' => 'Images with description',
      'category' => 'off',
    ],
    22 => [
      'title' => 'Images with description centered',
      'category' => 'off',
    ],
    23 => [
      'title' => 'Trailer boxes with description',
      'category' => 'off',
    ],
    24 => [
      'title' => 'List with numbers',
      'category' => 'off',
    ],
    25 => [
      'title' => 'Icon boxes with prices',
      'category' => 'off',
    ],
    26 => [
      'title' => 'Zoom boxes with description',
      'category' => 'off',
    ],
    27 => [
      'title' => 'Sliding boxes',
      'category' => 'off',
    ],
    28 => [
      'title' => 'Flat boxes',
      'category' => 'off',
    ],
    29 => [
      'title' => 'Trailer boxes',
      'category' => 'off',
    ],
    30 => [
      'title' => 'Hover color',
      'category' => 'cal',
    ],
    31 => [
      'title' => 'Hover color in two columns',
      'category' => 'cal',
    ],
    32 => [
      'title' => 'Heading with text & button',
      'category' => 'cal',
    ],
    33 => [
      'title' => 'Headings with buttons',
      'category' => 'cal',
    ],
    34 => [
      'title' => 'Headings with buttons 2',
      'category' => 'cal',
    ],
    35 => [
      'title' => 'Headings with buttons 3',
      'category' => 'cal',
    ],
    36 => [
      'title' => 'Headings with buttons 4',
      'category' => 'cal',
    ],
    37 => [
      'title' => 'Headings with Quick facts',
      'category' => 'cal',
    ],
    38 => [
      'title' => 'Heading with bottom image',
      'category' => 'cal',
    ],
    39 => [
      'title' => 'Heading with Countdown',
      'category' => 'cal',
    ],
    40 => [
      'title' => 'Contact details with Map',
      'category' => 'con',
    ],
    41 => [
      'title' => 'Address and Opening hours with Map',
      'category' => 'con',
    ],
    42 => [
      'title' => 'Contact info with photo',
      'category' => 'con',
    ],
    43 => [
      'title' => 'Contact info with photo 2',
      'category' => 'con',
    ],
    44 => [
      'title' => 'Boxes with contact details',
      'category' => 'con',
    ],
    45 => [
      'title' => 'Heading with phone and address',
      'category' => 'con',
    ],
    46 => [
      'title' => 'Address and boxes with contact details',
      'category' => 'con',
    ],
    47 => [
      'title' => 'Heading and boxes with contact details',
      'category' => 'con',
    ],
    48 => [
      'title' => 'Contact box with background',
      'category' => 'con',
    ],
    49 => [
      'title' => 'Heading with contact info',
      'category' => 'con',
    ],
    50 => [
      'title' => 'Text with boxes',
      'category' => 'mis',
    ],
    51 => [
      'title' => 'Heading with text and Counters',
      'category' => 'mis',
    ],
    52 => [
      'title' => 'Image with text and stats',
      'category' => 'mis',
    ],
    53 => [
      'title' => 'Reviews',
      'category' => 'mis',
    ],
    54 => [
      'title' => 'Heading with list',
      'category' => 'mis',
    ],
    55 => [
      'title' => 'Timeline',
      'category' => 'mis',
    ],
    56 => [
      'title' => 'Heading with Quick facts',
      'category' => 'mis',
    ],
    57 => [
      'title' => 'Heading with Charts',
      'category' => 'mis',
    ],
    58 => [
      'title' => 'Heading with Progress bars',
      'category' => 'mis',
    ],
    59 => [
      'title' => 'Pricing items',
      'category' => 'mis',
    ],
    60 => [
      'title' => 'Text + image & image + text',
      'category' => 'bas',
    ],
    61 => [
      'title' => 'Wraps with no margin in columns',
      'category' => 'bas',
    ],
    62 => [
      'title' => 'Full screen with centered heading',
      'category' => 'bas',
    ],
    63 => [
      'title' => 'Pizza menu',
      'category' => 'lis',
    ],
    64 => [
      'title' => 'Bordered boxes with custom list',
      'category' => 'lis',
    ],
    64 => [
      'title' => 'Listing in boxes with rounded corners',
      'category' => 'lis',
    ],
    66 => [
      'title' => 'Boxes with features',
      'category' => 'lis',
    ],
    67 => [
      'title' => '5 icon boxes layout',
      'category' => 'lis',
    ],
    68 => [
      'title' => '4 wraps with shadow and border radius',
      'category' => 'lis',
    ],
    69 => [
      'title' => '4 feature boxes',
      'category' => 'lis',
    ],
    70 => [
      'title' => '4 columns with border left',
      'category' => 'lis',
    ],
    71 => [
      'title' => 'Pricing box - compare list',
      'category' => 'lis',
    ],
    72 => [
      'title' => 'Table of day schedule',
      'category' => 'lis',
    ],
    73 => [
      'title' => 'Weekly schedule',
      'category' => 'lis',
    ],
    74 => [
      'title' => 'Icon with content box',
      'category' => 'off',
    ],
    75 => [
      'title' => 'Heading with description and counters',
      'category' => 'off',
    ],
    76 => [
      'title' => 'Image, description and quick facts',
      'category' => 'off',
    ],
    77 => [
      'title' => 'Full width offer',
      'category' => 'off',
    ],
    78 => [
      'title' => 'Price list',
      'category' => 'off',
    ],
    79 => [
      'title' => 'Icon + price + details',
      'category' => 'off',
    ],
    80 => [
      'title' => 'Icon + price + details',
      'category' => 'off',
    ],
    81 => [
      'title' => 'Menu in boxes',
      'category' => 'off',
    ],
    82 => [
      'title' => 'Text + image',
      'category' => 'cal',
    ],
    83 => [
      'title' => 'Full width 2 wraps with call to action',
      'category' => 'cal',
    ],
    84 => [
      'title' => 'Call to action Item',
      'category' => 'cal',
    ],
    85 => [
      'title' => 'Map + 4 addresses',
      'category' => 'con',
    ],
    86=> [
      'title' => 'Full width map + list icons',
      'category' => 'con',
    ],
    87 => [
      'title' => 'Full width map with multiple addresses at bottom',
      'category' => 'con',
    ],
    88 => [
      'title' => 'Map with description',
      'category' => 'con',
    ],
    89 => [
      'title' => 'Image and heading + image and description',
      'category' => 'mis',
    ],
    90 => [
      'title' => 'Heading + Meet the team',
      'category' => 'mis',
    ],
    91 => [
      'title' => 'Image + heading and 4 blocks',
      'category' => 'mis',
    ],
    92 => [
      'title' => 'Custom gallery trailer',
      'category' => 'mis',
    ],
    93 => [
      'title' => 'Full width hover colors',
      'category' => 'mis',
    ],
    94 => [
      'title' => 'Sliding box with content around',
      'category' => 'mis',
    ],
    95 => [
      'title' => 'Offer in blocks with hover colors',
      'category' => 'mis',
    ],
    96 => [
      'title' => '2 wraps - one with two blocks',
      'category' => 'mis',
    ],
    97 => [
      'title' => 'Box with desc + image',
      'category' => 'mis',
    ],
    98 => [
      'title' => 'Image with headings',
      'category' => 'mis',
    ],
    99 => [
      'title' => '3 wraps with images and heading + desc',
      'category' => 'mis',
    ],
    100 => [
      'title' => 'Blocks list with description',
      'category' => 'mis',
    ],
    101 => [
      'title' => 'Full width blocks Image and Headings + desc',
      'category' => 'mis',
    ],
    102 => [
      'title' => '2 wraps - right splitted on two blocks',
      'category' => 'mis',
    ],
    103 => [
      'title' => 'Full width 3 images and heading + desc',
      'category' => 'mis',
    ],
    104 => [
      'title' => '3 border columns and Heading + text',
      'category' => 'mis',
    ],
    105 => [
      'title' => '3 wraps with customized position',
      'category' => 'mis',
    ],
    106 => [
      'title' => 'Before After with Call to action',
      'category' => 'mis',
    ],
    107 => [
      'title' => 'Hover colors with social media',
      'category' => 'mis',
    ],
    108 => [
      'title' => '3 wraps with customized position',
      'category' => 'mis',
    ],
    109 => [
      'title' => '2 boxes on wraps with background',
      'category' => 'mis',
    ],
    110 => [
      'title' => '4 boxes with border at the bottom',
      'category' => 'mis',
    ],
    111 => [
      'title' => 'Heading and 3 boxes with shadows',
      'category' => 'mis',
    ],
    112 => [
      'title' => 'Progress bars box with heading',
      'category' => 'mis',
    ],
    113 => [
      'title' => 'Headings + info boxes with images',
      'category' => 'mis',
    ],

		// footers 800+

		801 => [
			'title' => 'Footer 01',
			'category' => 'footer',
		],
		802 => [
			'title' => 'Footer 02',
			'category' => 'footer',
		],
		803 => [
			'title' => 'Footer 03',
			'category' => 'footer',
		],
		804 => [
			'title' => 'Footer 04',
			'category' => 'footer',
		],

		// headers 900+

    901 => [
      'title' => 'Header 01',
      'category' => 'header',
    ],
    902 => [
      'title' => 'Header 02',
      'category' => 'header',
    ],
    903 => [
      'title' => 'Header 03',
      'category' => 'header',
    ],
    904 => [
      'title' => 'Header 04',
      'category' => 'header',
    ],
    905 => [
      'title' => 'Header 05',
      'category' => 'header',
    ],
    906 => [
      'title' => 'Header 06',
      'category' => 'header',
    ],
    907 => [
      'title' => 'Header 07',
      'category' => 'header',
    ],
    908 => [
      'title' => 'Header 08',
      'category' => 'header',
    ],
    909 => [
      'title' => 'Header 09',
      'category' => 'header',
    ],
    910 => [
      'title' => 'Header 10',
      'category' => 'header',
    ],
    911 => [
      'title' => 'Header 11',
      'category' => 'header',
    ],
    912 => [
      'title' => 'Header 12',
      'category' => 'header',
    ],
    913 => [
      'title' => 'Header 13',
      'category' => 'header',
    ],
    914 => [
      'title' => 'Header 14',
      'category' => 'header',
    ],
  ];

  /**
   * GET sections
   */

  public static function get_sections( $category = false ){

		if( $category ){
			$return = [];
			foreach( self::$sections as $key => $section ){
				if( $category == $section['category'] ){
					$return[$key] = $section;
				}
			}
			return $return;
		}

    return self::$sections;

  }

  /**
   * GET categories
   */

  public static function get_categories(){

    return self::$categories;

  }

}
