<?php
// Stop direct call
if (preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
	die('Please do not call this page directly.');
}

// tips that repeat
$height_percentage_tip = esc_html__('Tip: setting height, min-height, or max-height as a percentage won\'t work unless the parent element has an explicit value for height. <a target="_blank" href="http://stackoverflow.com/questions/5657964/css-why-doesn-t-percentage-height-work">Read this for more info</a>.', 'microthemer');
$border_radius_unconvertable = esc_html__('There is no direct equivalent between pixels and percent values for border radius.', 'microthemer');

$propertyOptions = array();

// Custom code
$propertyOptions['code']['css'] = array(
	'short_label' => esc_html__('Styles', 'microthemer'),
	'label' => esc_attr__('Styles', 'microthemer'),
	'pg_label' => esc_attr__('Custom CSS', 'microthemer'),
	'sub_label' => esc_html__('Custom CSS', 'microthemer'),
	'field-class' => 'icon-size-3',
	'input-class' => 'tvr-editor-hidden',
	'sub_slug' => 'custom_css',
	'type' => 'editor',
	'icon' => '15, 1',
	// ref
	'ref_desc' => "<p>Enter CSS properties by hand instead/as well as using the GUI options. This is useful if Microthemer doesn't support a particular CSS property, or if you just prefer writing CSS styles by hand.</p>
<p>This hybrid method of using the GUI with a code editor may be preferable over using just the custom code editor for many. Using this hybrid method, you can leverage the time saving selector wizard, as well as the repetition saving responsive tabs in the GUI view. You only need to update the CSS selector code in one place - the quick edit option in the top toolbar. The CSS selector will automatically update for all media queries.</p>",
	'ref_values' => array(
		"property:value;" => "Enter one or more css properties and values e.g. transform: rotate(7deg);",
		".my-selector { @include my-mixin(); }" => "You can enter SASS code here too e.g. &:hover { @include animate-button-background(); color:\$button_hover_text_color; }"
	),
	'tutorials' => array(
		array(
			'url' => 'http://www.w3schools.com/cssref/',
			'title' => 'W3Schools CSS Reference',
		),
		array(
			'url' => 'http://sass-lang.com/',
			'title' => 'SASS documentation',
		),
	)
);

// font
// ------------------------------------------------------------

$propertyOptions['font']['font_family'] = array(
	'sh' => array('font', 5),
	'short_label' => esc_html_x('Family', 'noun: Font Family', 'microthemer'),
	'label' => esc_attr__('Font Family', 'microthemer'),
	'pg_label' => esc_attr__('Font', 'microthemer'),
	'sub_label' => esc_html__('Font', 'microthemer'),
	'sub_slug' => 'font',
	// reference map for getting property values from stylesheet
	'sug_values' => array(
		'this' => 1,
		// 'sh' => is checked too
	),
	'type' => 'combobox',
	'input-class' => 'tvr-font-select size-big',
	'select_options' => array(
		'',
		'Google Font...',
		'Arial',
		'"Book Antiqua"',
		'"Bookman Old Style"',
		'"Arial Black"',
		'Charcoal',
		'"Comic Sans MS"',
		'cursive',
		'Courier',
		'"Courier New"',
		'Gadget',
		'Garamond',
		'Geneva',
		'Georgia',
		'Helvetica',
		'Impact',
		'"Lucida Console"',
		'"Lucida Grande"',
		'"Lucida Sans Unicode"',
		'Monaco',
		'monospace',
		'"MS Sans Serif"',
		'"MS Serif"',
		'"New York"',
		'Palatino',
		'"Palatino Linotype"',
		'sans-serif',
		'serif',
		'Symbol',
		'Tahoma',
		'"Times New Roman"',
		'Times',
		'"Trebuchet MS"',
		'Verdana',
		'Webdings',
		'Wingdings',
		'"Zapf Dingbats"'
	),
	'icon' => '33, 14',
	// ref
	'ref_desc' => "<p>The font-family property specifies the type of font for an element. You can specify just one font such as Arial, but it's also commonplace to specify multiple fonts separated by commas e.g. \"Book Antiqua\", Garamond, serif (hence the name font-family). The browser will try to load the first font, in this case \"Book Antiqua\". If the user doesn't have that font installed on their computer the second font will be loaded (e.g. Garamond) or the third - and so on. Note that if a font has spaces in the name in needs to be wrapped in quotes as has been done with \"Book Antiqua\".</p>",
	'ref_values' => array(
		"font name" => "The name of the font e.g. 'Arial'"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/f/font-family/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/font-family',
		'quackit' => 'http://www.quackit.com/css/properties/css_font-family.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_font_font-family.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'https://www.smashingmagazine.com/2010/12/what-font-should-i-use-five-principles-for-choosing-and-using-typefaces/',
			'title' => '“What Font Should I Use?”: Five Principles for Choosing and Using Typefaces',
		),
		array(
			'url' => 'http://webdesign.tutsplus.com/articles/choosing-the-right-font-a-practical-guide-to-typography-on-the-web--webdesign-15',
			'title' => 'Choosing the Right Font: A Practical Guide to Typography on the Web',
		),
		array(
			'url' => 'http://learn.shayhowe.com/html-css/working-with-typography/',
			'title' => 'Working with Typography',
		),
		array(
			'url' => 'http://ilovetypography.com/2008/04/04/on-choosing-type/',
			'title' => 'On Choosing Type',
		),
	)
);

$propertyOptions['font']['google_font'] = array(
	'short_label' => esc_html__('Google Font', 'microthemer'),
	'label' => esc_attr__('Google Font Family', 'microthemer'),
	'field-class' => 'tvr-font-custom',
	'input-class' => 'size-big',
	// set empty array for this, we're not currently getting this from site scan, as it will show up in font-family
	// but my_props will update with user inserting google fonts
	'sug_values' => array(
		'non_gathered' => 1
	),
	'icon' => '30',
	// ref
	'ref_desc' => "<p>Choose from hundreds of free, open-source fonts optimized for the web. Google Fonts is a service Google offers free of charge that allows web designers to use a wide variety of openly licensed fonts on their web pages. Prior to font services like Google Web Fonts, web designers were limited to using a small selection of 'web safe' fonts that were very likely to be installed on any computer. Now we can use Google fonts that may not be installed on a user's computer (because they are downloaded from Google). Microthemer makes use of Google's Web Fonts API to make adding Google Fonts really easy. Just select 'Google Fonts...' from the font-family menu, and then click the 'Use This Font' link next to the name of the font. For efficiency, Microthemer only loads the Google Fonts you've specified in your Microthemer workspace settings. This automation makes experimenting with different Google fonts hassle free.</p>",
	'ref_values' => array(
		"font name" => "The name of the font e.g. 'Oswald'. Note Microthemer includes the variation e.g. (normal) or (italic 700) in brackets so that Microthemer can download the correct font file (and only that font file) from Google."),
	'tutorials' => array(
		array(
			'url' => 'http://www.google.com/fonts/',
			'title' =>'Browse All Google Fonts',
			'tool' => 1,
		),
		array(
			'url' => 'http://designshack.net/articles/css/a-beginners-guide-to-using-google-web-fonts/',
			'title' =>'A Beginner’s Guide to Using Google Web Fonts',
		),
		array(
			'url' => 'https://developers.google.com/fonts/docs/getting_started',
			'title' =>'Get Started with the Google Fonts API',
		),
	)
);

$propertyOptions['font']['color'] = array(
	'short_label' => esc_html_x('Color', 'noun', 'microthemer'),
	'label' => esc_attr_x('Color', 'noun', 'microthemer'),
	'field-class' => 'is-picker',
	'input-class' => 'color',
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'color'
	),
	'icon' => '26',
	// ref
	'ref_desc' => "<p>The color property specifies the color of text. The reason it wasn't named \"text-color\" is a mystery.</p>",
	'ref_values' => array(
		"(hex code or RGB/A)" => "Microthemer provides a color picker for specifying color without having to remember hex codes or RGB/A values. Just click your mouse in the Color text field to reveal the color picker."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#feat=css3-colors',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/c/color/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/color',
		'quackit' => 'http://www.quackit.com/css/properties/css_color.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_text_color.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://practicaltypography.com/color.html',
			'title' => 'Color: Black is still best',
		),
		array(
			'url' => 'http://paletton.com/',
			'title' => 'Paletton: The Color Scheme Designer',
			'tool' => 1,
		),
		array(
			'url' => 'https://color.adobe.com',
			'title' => 'Adobe Color CC',
			'tool' => 1,
		),
		array(
			'url' => 'http://www.colourlovers.com/palettes',
			'title' => 'COLOURlovers is a creative community where people from around the world create
			and share colors, palettes and patterns',
			'tool' => 1,
		),
		array(
			'url' => 'http://www.pictaculous.com/',
			'title' => 'Pictaculous: upload your image, get a color palette',
			'tool' => 1,
		),
	)
);

$propertyOptions['font']['font_size'] = array(
	'sh' => array('font', 3, array(
		'initial' => 'medium'
	)),
	'short_label' => esc_html_x('Size', 'noun', 'microthemer'),
	'label' => esc_attr__('Font Size', 'microthemer'),
	'field-class' => 'icon-size-0',
	'input-class' => 'size-0',
	'auto' => array(
		'%' => array(
			'node' => 'parent',
			'prop' => 'font-size'
		)
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1
	),
	'icon' => '21',
	// ref
	'ref_desc' => "<p>As you might imagine, the font-size property sets the font-size of text.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '12' would set the font size to 12 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '1.2em' in the Font Size field."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/f/font-size/',
		'mozilla' => 'https://developer.mozilla.org/en/docs/Web/CSS/font-size',
		'quackit' => 'http://www.quackit.com/css/properties/html_font_size_code.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_font_font-size.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://www.sitepoint.com/css-font-sizing-tutorial/',
			'title' => 'CSS Font-Sizing: a Definitive Guide',
		),
		array(
			'url' => 'https://www.smashingmagazine.com/2014/09/balancing-line-length-font-size-responsive-web-design/',
			'title' => 'Size Matters: Balancing Line Length And Font Size In Responsive Web Design',
		),
		array(
			'url' => 'http://www.css3-tutorial.net/text-font/font-size/',
			'title' => 'Font size',
		),
		array(
			'url' => 'A Visual Type Scale',
			'title' => 'http://type-scale.com/',
			'tool' => 1,
		),
	)
);

$propertyOptions['font']['line_height'] = array(
	'sh' => array('font', 4, array(
		'initial' => 'normal'
	)),
	'short_label' => esc_html__('Line Height', 'microthemer'),
	'label' => esc_attr__('Line Height', 'microthemer'),
	'input-class' => 'size-0',
	'auto' => array(
		'%' => array(
			'node' => 'element',
			'prop' => 'font-size'
		)
	),
	'icon' => '22',
	// ref
	'ref_desc' => "<p>The line-height property specifies the line height of an element. A line of text will be vertically centered within the specified height.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '1.5' would set the line height to 18 pixels if the font-size for the element was set to 12px (12 x 1.5).
		Note that with line-height it is valid and often advisable not to specify a unit value, thus allowing the browser to calculate line-height based on font-size. Microthemer therefore does not automatically add the 'px' unit if no unit is specified."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/l/line-height/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/line-height',
		'quackit' => 'http://www.quackit.com/css/properties/css_line-height.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_dim_line-height.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://practicaltypography.com/line-spacing.html',
			'title' => 'Line Spacing: 120–145% of the point size',
		),
		array(
			'url' => 'http://www.webteacher.ws/2009/09/30/improve-readability-with-line-height/',
			'title' => 'Improve readability with line-height',
		),
		array(
			'url' => 'http://kingdesk.com/articles/optimal-line-height/',
			'title' => 'Optimal Line Height',
		),
	)
);

$propertyOptions['font']['font_weight'] = array(
	'sh' => array('font', 2, array(
		'initial' => 'normal'
	)),
	'short_label' => esc_html_x('Weight', 'noun: Font Weight', 'microthemer'),
	'label' => esc_attr__('Font Weight', 'microthemer'),
	'field-class' => 'icon-size-0a',
	'input-class' => 'size-2',
	'type' => 'combobox',
	'select_options' => array(
		'',
		"normal",
		"bold",
		"bolder",
		"lighter",
		"100",
		"200",
		"300",
		"400",
		"500",
		"600",
		"700",
		"800",
		"900"
	),
	'icon' => '27',
	// ref
	'ref_desc' => "<p>The font-weight property sets the thickness of text characters.</p>",
	'ref_values' => array(
		"normal" => "Defines normal characters. This is default",
		"bold" => "Defines thick characters",
		"bolder" => "Defines thicker characters",
		"lighter" => "Defines lighter characters",
		"100" => "a numeric definition of thickness",
		"200" => "a numeric definition of thickness",
		"300" => "a numeric definition of thickness",
		"400" => "a numeric definition of thickness (equivalent to the 'normal' keyword)",
		"500" => "a numeric definition of thickness",
		"600" => "a numeric definition of thickness",
		"700" => "a numeric definition of thickness (equivalent to the 'bold' keyword)",
		"800" => "a numeric definition of thickness",
		"900" => "a numeric definition of thickness"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/f/font-weight/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/font-weight',
		'quackit' => 'http://www.quackit.com/css/properties/css_font-weight.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_font_weight.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://www.css3-tutorial.net/text-font/font-weight/',
			'title' => 'Font weight',
		),
		array(
			'url' => 'http://practicaltypography.com/bold-or-italic.html',
			'title' => 'Bold or italic: One or the other, as little as possible',
		),
	)
);

$propertyOptions['font']['font_style'] = array(
	'sh' => array('font', 0, array(
		'initial' => 'normal'
	)),
	'short_label' => esc_html_x('Style', 'noun: Font Style', 'microthemer'),
	'label' => esc_attr__('Font Style', 'microthemer'),
	'field-class' => 'icon-size-0a',
	'type' => 'combobox',
	'select_options' => array(
		'',
		"normal",
		"italic",
		"oblique"
	),
	'icon' => '28',
	// ref
	'ref_desc' => "<p>The font-style property specifies the font style for text. Generally used for setting italic text.</p>",
	'ref_values' => array(
		"normal" => "The browser displays a normal font style. This is default",
		"italic" => "The browser displays an italic font style",
		"oblique" => "The browser displays an oblique font style"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/f/font-style/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/font-style',
		'quackit' => 'http://www.quackit.com/css/properties/css_font-style.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_font_font-style.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://docstore.mik.ua/orelly/web2/css/ch05_04.htm',
			'title' => 'Styles and Variants',
		),
		array(
			'url' => 'http://www.css3-tutorial.net/text-font/font-style/',
			'title' => 'The font-style property',
		),
	)
);

$propertyOptions['font']['text_decoration'] = array(
	'short_label' => esc_html__('Decoration', 'microthemer'),
	'label' => esc_attr__('Text Decoration', 'microthemer'),
	'field-class' => 'icon-size-0a',
	'input-class' => 'size-5',
	'type' => 'combobox',
	'select_options' => array(
		"",
		"underline",
		"overline",
		"line-through",
		"none"
	),
	'icon' => '31',
	// ref
	'ref_desc' => "<p>The text-decoration property specifies the line decoration below, above, or through text.</p>",
	'ref_values' => array(
		"underline" => "Defines a line below the text",
		"overline" => "Defines a line above the text",
		"line-through" => "Defines a line through the text",
		"none" => "	Defines normal text. This is default"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/t/text-decoration/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/text-decoration',
		'quackit' => 'http://www.quackit.com/css/properties/css_text-decoration.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_text_text-decoration.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'https://www.1keydata.com/css-tutorial/text-decoration.php',
			'title' => 'Examples of text-decoration property values',
		),
	)
);

$propertyOptions['font']['font_variant'] = array(
	'sh' => array('font', 1, array(
		'initial' => 'normal'
	)),
	'short_label' => esc_html__('Variant', 'microthemer'),
	'label' => esc_attr__('Font Variant', 'microthemer'),
	'field-class' => 'icon-size-2',
	'input-class' => 'size-4',
	// It would have been better to structure the data with [padding_margin][padding][padding_left] but it's too late now.
	// last_in_sub is a dirty work around for closing the subgroup-tag divs properly
	// I'm not sure we used it in the end...
	'last_in_sub' => 1,
	'type' => 'combobox',
	'select_options' => array(
		'',
		"normal",
		"small-caps"
	),
	'icon' => '29',
	// ref
	'ref_desc' => "<p>The font-variant property specifies whether or not text should
be displayed in a small-caps font. And that is the only option!</p>",
	'ref_values' => array(
		"normal" => "The browser displays a normal font. This is default",
		"small-caps" => "The browser displays a small-caps font"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/f/font-variant/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/font-variant',
		'quackit' => 'http://www.quackit.com/css/properties/css_font-variant.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_font_font-variant.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://ilovetypography.com/2008/02/20/small-caps/',
			'title' => 'Small caps',
		),
		array(
			'url' => 'http://practicaltypography.com/small-caps.html',
			'title' => 'Use real small caps; avoid fakes',
		),
	)
);

// text
// ------------------------------------------------------------

$propertyOptions['text']['text_align'] = array(
	'short_label' => esc_html__('Text Align', 'microthemer'),
	'label' => esc_attr__('Text Align', 'microthemer'),
	'pg_label' => esc_attr__('Text', 'microthemer'),
	'sub_label' => esc_html__('Text', 'microthemer'),
	'sub_slug' => 'text',
	'input-class' => 'size-1',
	'type' => 'combobox',
	'select_options' => array(
		'',
		"left",
		"right",
		"center",
		"justify"
	),
	'icon' => '38, 14',
	// ref
	'ref_desc' => "<p>The text-align property specifies the horizontal alignment of text in an element.</p>",
	'ref_values' => array(
		"left" => "Aligns the text to the left. This is default",
		"right" => "Aligns the text to the right",
		"center" => "Centers the text",
		"justify" => "Stretches the lines so that each line has equal width (like in newspapers and magazines)"),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/t/text-align/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/text-align',
		'quackit' => 'http://www.quackit.com/css/properties/css_text-align.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_text_text-align.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'https://css-tricks.com/centering-css-complete-guide/',
			'title' => 'Centering in CSS: A Complete Guide',
		),
	)
);

$propertyOptions['text']['text_indent'] = array(
	'short_label' => esc_html_x('Indent', 'noun', 'microthemer'),
	'label' => esc_attr__('Text Indent', 'microthemer'),
	'field-class' => 'icon-size-2',
	'input-class' => 'size-0b',
	'auto' => array(
		'%' => array(
			'node' => 'parent',
			'prop' => 'width'
		)
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1
	),
	'icon' => '23, 4',
	// ref
	'ref_desc' => "<p>The text-indent property specifies the indentation of the first line in a text-block. You might choose to set this property on dense articles of text to improve readability where paragraphs have no bottom margin.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '80' would set the text indent to 80 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '15%' in the Text Indent field."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/t/text-indent/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/text-indent',
		'quackit' => 'http://www.quackit.com/css/properties/css_text-indent.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_text_text-indent.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://www.goer.org/HTML/intermediate/align_and_indent/',
			'title' => 'Align and Indent',
		),
		array(
			'url' => 'http://www.thesitewizard.com/css/hanging-indents.shtml',
			'title' => 'How to Create Hanging Indents in HTML and CSS',
		),
	)
);

$propertyOptions['text']['text_transform'] = array(
	'short_label' => esc_html__('Transform', 'noun', 'microthemer'),
	'label' => esc_attr__('Text Transform', 'microthemer'),
	'input-class' => 'size-4',
	'type' => 'combobox',
	'select_options' => array(
		'',
		"capitalize",
		"uppercase",
		"lowercase",
		"none"
	),
	'field-class' => 'last',
	'icon' => '32',
	// ref
	'ref_desc' => "<p>The text-transform property controls the capitalization of text.</p>",
	'ref_values' => array(
		"capitalise" => "Transforms the first character of each word to uppercase",
		"uppercase" => "Transforms all characters to uppercase",
		"lowercase" => "Transforms all characters to lowercase",
		"none" => "No capitalization. The text renders as it is. This is default"),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/t/text-transform/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/text-transform',
		'quackit' => 'http://www.quackit.com/css/properties/css_text-transform.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_text_text-transform.asp',
	),
	'tutorials' => array()
);

$propertyOptions['text']['word_spacing'] = array(
	'short_label' => esc_html__('Word Spacing', 'microthemer'),
	'field-class' => 'icon-size-4',
	'input-class' => 'size-0b',
	'auto' => array(
		'%' => false
	),
	'label' => esc_attr__('Word Spacing', 'microthemer'),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1
	),
	'icon' => '22, 4',
	// ref
	'ref_desc' => "<p>The word-spacing property increases or decreases the white space between words.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '10' would set the font size to 10 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '1em' in the Word Spacing field."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/w/word-spacing/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/word-spacing',
		'quackit' => 'http://www.quackit.com/css/properties/css_word-spacing.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_text_word-spacing.asp',
	),
	'tutorials' => array()
);

$propertyOptions['text']['letter_spacing'] = array(
	'short_label' => esc_html__('Letter Spacing', 'microthemer'),
	'label' => esc_attr__('Letter Spacing', 'microthemer'),
	'input-class' => 'size-0b',
	'auto' => array(
		'%' => false
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1
	),
	'icon' => '24',
	// ref
	'ref_desc' => "<p>The letter-spacing property increases or decreases the space between characters in text.<p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '2' would set the letter spacing to 2 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified)."),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/l/letter-spacing/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/letter-spacing',
		'quackit' => 'http://www.quackit.com/css/properties/css_letter-spacing.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_text_letter-spacing.asp',
	),
	'tutorials' => array()
);

$propertyOptions['text']['word_wrap'] = array(
	'short_label' => esc_html__('Word Wrap', 'microthemer'),
	'label' => esc_attr__('Word Wrap', 'microthemer'),
	'input-class' => 'size-4a',
	'type' => 'combobox',
	'select_options' => array(
		'',
		"normal",
		"break-word"
	),
	'icon' => '41, 14',
	// ref
	'ref_desc' => "<p>The word-wrap property determines if whole words can be broken over two lines.<p>",
	'ref_values' => array(
		"normal" => "Words will only split in allowed places, like when a hyphen is used.",
		"break-word" => "Words will break at any point to ensure that they stay within their container element.",
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#feat=wordwrap',
		'css_tricks' => '', // is not there
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/letter-spacing',
		'quackit' => 'http://www.quackit.com/css/css3/properties/css_word-wrap.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/css3_pr_word-wrap.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://www.impressivewebs.com/word-wrap-css3/',
			'title' => 'Word-Wrap: A CSS3 Property That Works in Every Browser',
		),
	)
);

$propertyOptions['text']['white_space'] = array(
	'short_label' => esc_html__('White Space', 'microthemer'),
	'label' => esc_attr__('White Space', 'microthemer'),
	'input-class' => 'size-3a',
	'type' => 'combobox',
	'select_options' => array(
		'',
		"normal",
		"nowrap",
		"pre",
		"pre-line",
		"pre-wrap"
	),
	'icon' => '43, 14',
	// ref
	'ref_desc' => "<p>The white-space property determines how white spaces characters like spaces, tabs, and returns are handled. It also controls how text should wrap.<p>",
	'ref_values' => array(
		"normal" => "Multiple whitespace characters will be treated as one, text will wrap when necessary (default).",
		"nowrap" => "Multiple whitespace characters will be treated as one, text will never wrap to the next line until a br tag is used.",
		"pre" => "Whitespace characters are honoured. Text only wraps on line breaks - acts like the pre tag in HTML",
		"pre-line" => "Multiple whitespace characters will be treated as one, text will wrap when necessaryand on line breaks",
		"pre-wrap" => "Whitespace characters are honoured, text will wrap when necessary, and on line breaks"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/w/whitespace/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/white-space',
		'quackit' => 'http://www.quackit.com/css/properties/css_white-space.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_text_white-space.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'https://perishablepress.com/wrapping-content/',
			'title' => 'Wrapping Long URLs and Text Content with CSS',
		),
	)
);

$propertyOptions['text']['direction'] = array(
	'short_label' => esc_html__('Direction', 'microthemer'),
	'label' => esc_attr__('Text Direction', 'microthemer'),
	'input-class' => '',
	'type' => 'combobox',
	'select_options' => array(
		'',
		"ltr",
		"rtl"
	),
	'icon' => '42, 14',
	// ref
	'ref_desc' => "<p>The text-direction property specifies the direction of the text. Arabic sites would set this to 'right', as they read from right to left. Western sites are not likely to use this property as the default is 'left'.<p>",
	'ref_values' => array(
		"lte" => "The writing direction is left to right (default).",
		"rtl" => "The writing direction is right to left."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/d/direction/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/direction',
		'quackit' => 'http://www.quackit.com/css/properties/css_direction.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_text_direction.asp',
	),
	'tutorials' => array()
);

$propertyOptions['text']['vertical_align'] = array(
	'short_label' => esc_html__('Vertical Align', 'microthemer'),
	'label' => esc_attr__('Vertical Align', 'microthemer'),
	'input-class' => 'size-5',
	'type' => 'combobox',
	'select_options' => array(
		'',
		'baseline',
		'bottom',
		'middle',
		'sub',
		'super',
		'text-bottom',
		'text-top',
		'top'
	),
	'icon' => '31, 14',
	// ref
	'ref_desc' => "<p>The vertical-align property sets the vertical alignment of an element. Elements with a 'display' value of 'block' ignore the vertical-align property, but their inline children (if any) will inherit the vertical-align value. Tip: if you set the 'display' property to 'table-cell' you may find that vertical-align works in the way you expect (the same goes for applying vertical align on actual table cells). This <a target='_blank' href='http://phrogz.net/css/vertical-align/'>tutorial on vertical-align</a> is worth reading.<p>",
	'ref_values' => array(
		"baseline" => "Align the baseline of the element with the baseline of the parent element. This is default",
		"length" => "Raises or lower an element by the specified length. Negative values are allowed",
		"%" => "Raises or lower an element in a percent of the 'line-height' property. Negative values are allowed",
		"sub" => "Aligns the element as if it was subscript",
		"super" => "Aligns the element as if it was superscript",
		"top" => "The top of the element is aligned with the top of the tallest element on the line",
		"text-top" => "The top of the element is aligned with the top of the parent element's font",
		"middle" => "The element is placed in the middle of the parent element",
		"bottom" => "The bottom of the element is aligned with the lowest element on the line",
		"text-bottom" => "The bottom of the element is aligned with the bottom of the parent element's font"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=vertical-align',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/v/vertical-align/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/vertical-align',
		'quackit' => 'http://www.quackit.com/css/properties/css_vertical-align.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_pos_vertical-align.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://christopheraue.net/2014/03/05/vertical-align/',
			'title' => 'Vertical-Align: All You Need To Know',
		),
		array(
			'url' => 'http://createdineden.com/blog/2014/september/24/a-professional-guide-how-to-vertically-align-elements-using-css/',
			'title' => 'A Professional Guide: How to Vertically Align Elements Using CSS',
		),
		array(
			'url' => 'http://www.hongkiat.com/blog/css-tricks-vertical-align-content/',
			'title' => '6 CSS Tricks to Align Content Vertically',
		),
	)
);

// list
// ------------------------------------------------------------

$propertyOptions['list']['list_style_type'] = array(
	'sh' => array('list-style', 0, array(
		'initial' => 'disc'
	)),
	'short_label' => esc_html_x('Type', 'noun: List Style Type', 'microthemer'),
	'label' => esc_attr__('List Style Type', 'microthemer'),
	'pg_label' => esc_attr__('List', 'microthemer'),
	'sub_label' => esc_html__('List', 'microthemer'),
	'sub_slug' => 'list',
	'last_in_sub' => 1,
	'input-class' => 'size-big',
	'type' => 'combobox',
	'select_options' => array(
		'',
		'circle',
		'disc',
		'square',
		'armenian',
		'decimal',
		'decimal-leading-zero',
		'georgian',
		'lower-alpha',
		'lower-greek',
		'lower-latin',
		'lower-roman',
		'upper-alpha',
		'upper-latin',
		'upper-roman',
		'cjk-ideographic',
		'hebrew',
		'hiragana',
		'hiragana-iroha',
		'katakana',
		'katakana-iroha',
		'none'
	),
	'field-class' => 'last',
	'icon' => '23',
	// ref
	'ref_desc' => "<p>The list-style-type specifies the type of list-item marker in a list. Circle, disc and square can be applied to unordered lists (&#60;ul&#62;), commonly referred to as bulleted lists. All the rest can be applied to ordered lists (&#60;ol&#62;), such as those with numbers at the start.</p>",
	'ref_values' => array(

		// we shouldn't be repeating this, flatten array and use this as central source of knowledge

		"circle" => "The marker is a circle",
		"disc" => "The marker is a filled circle. This is default",
		"square" => "The marker is a square",
		"armenian" => "The marker is traditional Armenian numbering",
		"decimal" => "	The marker is a number",
		"decimal-leading-zero" => "	The marker is a number padded by initial zeros (01, 02, 03, etc.)",
		"georgian" => "The marker is traditional Georgian numbering (an, ban, gan, etc.)",
		"lower-alpha" => "The marker is lower-alpha (a, b, c, d, e, etc.)",
		"lower-greek" => "The marker is lower-greek (alpha, beta, gamma, etc.)",
		"lower-latin" => "The marker is lower-latin (a, b, c, d, e, etc.)",
		"lower-roman" => "The marker is lower-roman (i, ii, iii, iv, v, etc.)",
		"upper-alpha" => "The marker is upper-alpha (A, B, C, D, E, etc.)",
		"upper-latin" => "upper-latin	The marker is upper-latin (A, B, C, D, E, etc.)",
		"upper-roman" => "The marker is upper-roman (I, II, III, IV, V, etc.)",

		"cjk-ideographic" => "The marker is plain ideographic numbers",
		"hebrew" => "The marker is traditional Hebrew numbering",
		"hiragana" => "The marker is traditional Hiragana numbering",
		"hiragana-iroha" => "The marker is traditional Hiragana iroha numbering",
		"katakana" => "The marker is traditional Katakana numbering",
		"katakana-iroha" => "The marker is traditional Katakana iroha numbering",

		"none" => ""
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/l/list-style/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/list-style-type',
		'quackit' => 'http://www.quackit.com/css/properties/css_list-style-type.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_list-style-type.asp'
	),
	'tutorials' => array(
		array(
			'url' => 'http://alistapart.com/article/taminglists',
			'title' => 'CSS Design: Taming Lists',
		),
		array(
			'url' => 'http://www.tizag.com/cssT/list.php',
			'title' => 'CSS lists',
		),
		array(
			'url' => 'http://css.maxdesign.com.au/listutorial/index.htm',
			'title' => 'Listutorial: simple tutorials on CSS based lists',
		),
		array(
			'url' => 'http://learn.shayhowe.com/html-css/creating-lists/',
			'title' => 'Creating Lists',
		),
	),
	'group_tutorials' => 1
);

$propertyOptions['list']['list_style_image'] = array(
	'sh' => array('list-style', 1, array(
		'initial' => 'none'
	)),
	'short_label' => esc_html_x('Image', 'noun', 'microthemer'),
	'label' => esc_attr__('List Style Image', 'microthemer'),
	'type' => 'combobox',
	'field-class' => 'last span-3 icon-size-3',
	'input-class' => 'bg-image-select size-very-big strictly-dropdown',
	'sug_values' => array(
		'this' => 1
	),
	'select_options' => array(
		'',
		'none'
	),
	'icon' => '28, 14',
	// ref
	'ref_desc' => "<p>The list-style-image property sets an image to use for each item in the list (instead of a regular bullet point or number).<p>",
	'ref_values' => array(
		"none" => "No image will be used, the value for list-style-type will be used (default).",
		"url" => "The path to an image. You can use Microthemer's image browser to set an image you've uploaded to your WordPress media library."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/l/list-style/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/list-style-image',
		'quackit' => 'http://www.quackit.com/css/properties/css_list-style-image.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_list-style-image.asp',
	),
	'tutorials' => $propertyOptions['list']['list_style_type']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['list']['list_style_position'] = array(
	'sh' => array('list-style', 2, array(
		'initial' => 'outside'
	)),
	'short_label' => esc_html__('Position', 'microthemer'),
	'label' => esc_attr__('List Style Position', 'microthemer'),
	'field-class' => 'icon-size-2',
	'input-class' => 'size-2',
	'type' => 'combobox',
	'select_options' => array(
		'',
		"inside",
		"outside"
	),
	'icon' => '27, 14',
	// ref
	'ref_desc' => "<p>The list-style-position property determines if the list item marker should appear inside or outside the flow of the content.<p>",
	'ref_values' => array(
		"outside" => "Keeps the marker to the left of the text (default).",
		"inside" => "Indents the item marker."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/l/list-style/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/list-style-position',
		'quackit' => 'http://www.quackit.com/css/properties/css_list-style-position.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_list-style-position.asp',
	),
	'tutorials' => $propertyOptions['list']['list_style_type']['tutorials'],
	'group_tutorials' => 1
);

// text shadow
// ------------------------------------------------------------

$propertyOptions['shadow']['text_shadow_x'] = array(
	'sh' => array('text-shadow', 0, array(
		'onlyShort' => 1,
		// required value, no initial needed
	)),
	'multiple' => 1,
	'short_label' => esc_html__('X-Offset', 'microthemer'),
	'label' => esc_attr__('Text Shadow X-offset', 'microthemer'),
	'pg_label' => esc_attr__('Shadow', 'microthemer'),
	'sub_label' => esc_html__('Text Shadow', 'microthemer'),
	'sub_slug' => 'text_shadow',
	'input-class' => 'size-0b',
	'auto' => array(
		'%' => false
	),
	'default_unit' => 1,
	'sug_values' => array(
		'root_cat' => 'text_shadow'
	),
	'hide imp' => 1,
	'icon' => '39',
	// ref
	'ref_desc' => "<p>The position of the horizontal shadow. Negative values are allowed</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '1' would create a 1 pixel shadow to the right of the text (Microthemer automatically adds the 'px' unit if a unit isn't specified)."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#feat=css-textshadow',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/t/text-shadow/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/text-shadow',
		'quackit' => 'http://www.quackit.com/css/properties/css_text-shadow.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/css3_pr_text-shadow.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://www.css3-tutorial.net/text-font/text-shadow/',
			'title' => 'Text shadow',
		),
		array(
			'url' => 'http://xahlee.info/js/css_text_shadow.html',
			'title' => 'CSS: Text Shadow, Glow/Outline Effects',
		),
	),
	'related_tutorials' => esc_attr__('Shadow', 'microthemer')
);

$propertyOptions['shadow']['text_shadow_y'] = array(
	'sh' => array('text-shadow', 1, array(
		'onlyShort' => 1,
		// required value, no initial needed
	)),
	'short_label' => esc_html__('Y-Offset', 'microthemer'),
	'label' => esc_attr__('Text Shadow Y-offset', 'microthemer'),
	'input-class' => 'size-0b',
	'auto' => array(
		'%' => false
	),
	'default_unit' => 1,
	'sug_values' => array(
		'root_cat' => 'text_shadow'
	),
	'hide imp' => 1,
	'icon' => '40',
	// ref
	'ref_desc' => "<p>The position of the vertical shadow. Negative values are allowed</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '-1' would create a 1 pixel shadow above the element (Microthemer automatically adds the 'px' unit if a unit isn't specified)."
	),
	'ref_links' => $propertyOptions['shadow']['text_shadow_x']['ref_links'],
	'tutorials' => $propertyOptions['shadow']['text_shadow_x']['tutorials'],
	'related_tutorials' => $propertyOptions['shadow']['text_shadow_x']['sub_label']
);

$propertyOptions['shadow']['text_shadow_blur'] = array(
	'sh' => array('text-shadow', 2, array(
		'onlyShort' => 1,
		// optional, but only shorthand so no initial
	)),
	'short_label' => esc_html_x('Blur', 'noun', 'microthemer'),
	'label' => esc_attr__('Text Shadow Blur', 'microthemer'),
	'input-class' => 'size-0b',
	'last_in_sub' => 1,
	'auto' => array(
		'%' => false
	),
	'default_unit' => 1,
	'sug_values' => array(
		'root_cat' => 'text_shadow'
	),
	'hide imp' => 1,
	'icon' => '42',
	// ref
	'ref_desc' => "<p>The blur distance. If you define a black text shadow and a blur of 3px, their will be a 3 pixel blur area where the shadow fades evenly from black to transparent.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '4' would create a 4 pixel text blur."
	),
	'ref_links' => $propertyOptions['shadow']['text_shadow_x']['ref_links'],
	'tutorials' => $propertyOptions['shadow']['text_shadow_x']['tutorials'],
	'related_tutorials' => $propertyOptions['shadow']['text_shadow_x']['sub_label']
);

$propertyOptions['shadow']['text_shadow_color'] = array(
	'sh' => array('text-shadow', 3, array(
		'onlyShort' => 1,
		// optional, but only shorthand so no initial needed
	)),
	'short_label' => esc_html_x('Color', 'noun', 'microthemer'),
	'label' => esc_attr__('Text Shadow Color', 'microthemer'),
	'field-class' => 'is-picker last icon-size-2',
	'input-class' => 'color',
	'sug_values' => array(
		'root_cat' => 'color'
	),
	'last_in_sub' => 1,
	'important_carrier' => 1,
	'icon' => '41',
	// ref
	'ref_desc' => "<p>The color of the text shadow.</p>",
	'ref_values' => array(
		"(hex code or RGB/A)" => "Microthemer provides a color picker for specifying color without having to remember hex codes or RGB/A values. Just click your mouse in the 'Text Shadow Color' text field to reveal the color picker."
	),
	'ref_links' => $propertyOptions['shadow']['text_shadow_x']['ref_links'],
	'tutorials' => $propertyOptions['shadow']['text_shadow_x']['tutorials'],
	'related_tutorials' => $propertyOptions['shadow']['text_shadow_x']['sub_label']
);

$propertyOptions['shadow']['box_shadow_x'] = array(
	'sh' => array('box-shadow', 0, array(
		'onlyShort' => 1
		// required, but onlyShort so no initial needed anyway
	)),
	'multiple' => 1,
	'short_label' => esc_html__('X-Offset', 'microthemer'),
	'label' => esc_attr__('Box Shadow x-offset', 'microthemer'),
	'sub_label' => esc_html__('Box Shadow', 'microthemer'),
	'sub_slug' => 'box_shadow',
	'auto' => array(
		'%' => false
	),
	'default_unit' => 1,
	'sug_values' => array(
		'root_cat' => 'box_shadow'
	),
	'field-class' => 'icon-size-2',
	'input-class' => 'size-0b',
	'hide imp' => 1,
	'icon' => '34',
	// ref
	'ref_desc' => "<p>The position of the horizontal shadow. Negative values are allowed</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '15' would create a 15 pixel shadow to the right of the element (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '2%'."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#feat=css-boxshadow',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/box-shadow/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/box-shadow',
		'quackit' => 'http://www.quackit.com/css/css3/properties/css_box-shadow.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/css3_pr_box-shadow.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'https://paulund.co.uk/creating-different-css3-box-shadows-effects',
			'title' => 'CSS Box Shadows Effects',
		),
		array(
			'url' => 'http://red-team-design.com/how-to-create-slick-effects-with-css3-box-shadow/',
			'title' => 'How to create slick effects with CSS3 box-shadow',
		),
		array(
			'url' => 'http://xahlee.info/js/css_box_shadow.html',
			'title' => 'CSS: Box Shadow Examples',
		),
		array(
			'url' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Box_Model/Box-shadow_generator',
			'title' => 'Box-shadow generator',
			'tool' => 1,
		),
		array(
			'url' => 'http://www.cssmatic.com/box-shadow',
			'title' => 'CSSmatic Box Shadow',
			'tool' => 1,
		),
	),
	'related_tutorials' => esc_html__('Box Shadow', 'microthemer')
);
$propertyOptions['shadow']['box_shadow_y'] = array(
	'sh' => array('box-shadow', 1, array(
		'onlyShort' => 1
		// required, but onlyShort so no initial needed anyway
	)),
	'short_label' => esc_html__('Y-Offset', 'microthemer'),
	'label' => esc_attr__('Box Shadow y-offset', 'microthemer'),
	'field-class' => 'icon-size-3',
	'auto' => array(
		'%' => false
	),
	'default_unit' => 1,
	'sug_values' => array(
		'root_cat' => 'box_shadow'
	),
	'input-class' => 'size-0b',
	'hide imp' => 1,
	'icon' => '35',
	// ref
	'ref_desc' => "<p>The position of the vertical shadow. Negative values are allowed.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '-10' would create a 10 pixel shadow above the element (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '-2%'."
	),
	'ref_links' => $propertyOptions['shadow']['box_shadow_x']['ref_links'],
	'tutorials' => $propertyOptions['shadow']['box_shadow_x']['tutorials'],
	'related_tutorials' => $propertyOptions['shadow']['box_shadow_x']['sub_label']
);

$propertyOptions['shadow']['box_shadow_blur'] = array(
	'sh' => array('box-shadow', 2, array(
		'onlyShort' => 1
		// optional, but onlyShort so no initial needed
	)),
	'short_label' => esc_html_x('Blur', 'noun', 'microthemer'),
	'label' => esc_attr__('Box Shadow Blur', 'microthemer'),
	'auto' => array(
		'%' => false
	),
	'default_unit' => 1,
	'sug_values' => array(
		'root_cat' => 'box_shadow'
	),
	'field-class' => 'icon-size-2',
	'input-class' => 'size-0b',
	'hide imp' => 1,
	'icon' => '37',
	// ref
	'ref_desc' => "<p>The blur distance. If you defined a black shadow and a blur of 10px, their would be a 10 pixel blur area where the shadow faded evenly from black to transparent at every extremity.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '10' would create a 10 pixel blur at the edge of the element's shadow (Microthemer automatically adds the 'px' unit if a unit isn't specified. Other commonly used units include 'em' and '%'. So you could enter '5%'.)"
	),
	'ref_links' => $propertyOptions['shadow']['box_shadow_x']['ref_links'],
	'tutorials' => $propertyOptions['shadow']['box_shadow_x']['tutorials'],
	'related_tutorials' => $propertyOptions['shadow']['box_shadow_x']['sub_label']
);

$propertyOptions['shadow']['box_shadow_spread'] = array(
	'sh' => array('box-shadow', 3, array(
		'onlyShort' => 1
		// optional, but onlyShort so no initial needed
	)),
	'short_label' => esc_html_x('Spread', 'noun', 'microthemer'),
	'label' => esc_attr__('Box Shadow Spread', 'microthemer'),
	'auto' => array(
		'%' => false
	),
	'default_unit' => 1,
	'sug_values' => array(
		'root_cat' => 'box_shadow'
	),
	'input-class' => 'size-0b',
	'icon' => '31,4',
	'hide imp' => 1,
	// ref
	'ref_desc' => "<p>The size of the shadow. If X and Y offsets are set to 0, setting a positive spread will result in an even shadow on all sides. Negative values are also permitted.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '20' would create a 20 pixel shadow surrounding the element (Microthemer automatically adds the 'px' unit if a unit isn't specified)."
	),
	'ref_links' => $propertyOptions['shadow']['box_shadow_x']['ref_links'],
	'tutorials' => $propertyOptions['shadow']['box_shadow_x']['tutorials'],
	'related_tutorials' => $propertyOptions['shadow']['box_shadow_x']['sub_label']
);

$propertyOptions['shadow']['box_shadow_color'] = array(
	'sh' => array('box-shadow', 4, array(
		'onlyShort' => 1
		// optional, but onlyShort so no initial needed
	)),
	'short_label' => esc_html_x('Color', 'noun', 'microthemer'),
	'label' => esc_attr__('Box Shadow Color', 'microthemer'),
	'field-class' => 'icon-size-4 is-picker',
	'input-class' => 'color',
	'sug_values' => array(
		'root_cat' => 'color'
	),
	'hide imp' => 1,
	'icon' => '36',
	// ref
	'ref_desc' => "<p>The color of the shadow. Choosing a darker version of the parent element's background color produces the most natural effect.</p>",
	'ref_values' => array(
		"(hex code or RGB/A)" => "Microthemer provides a color picker for specifying color without having to remember hex codes or RGB/A values. Just click your mouse in the Color text field to reveal the color picker."
	),
	'ref_links' => $propertyOptions['shadow']['box_shadow_x']['ref_links'],
	'tutorials' => $propertyOptions['shadow']['box_shadow_x']['tutorials'],
	'related_tutorials' => $propertyOptions['shadow']['box_shadow_x']['sub_label']
);

$propertyOptions['shadow']['box_shadow_inset'] = array(
	'sh' => array('box-shadow', 5, array(
		'onlyShort' => 1
		// optional, but onlyShort so no initial needed
	)),
	'short_label' => esc_html_x('Inset', 'noun', 'microthemer'),
	'label' => esc_attr__('Box Shadow Inset', 'microthemer'),
	//'input-class' => 'size-0b',
	'field-class' => 'last',
	'last_in_sub' => 1,
	'important_carrier' => 1,
	'type' => 'combobox',
	// ref
	'select_options' => array(
		'',
		"inset"
	),
	'icon' => '30, 4',
	// ref
	'ref_desc' => "<p>If inset is defined, the box-shadow will be an inner shadow rather than an outer shadow.</p>",
	'ref_values' => array(
		"outset" => "Defines an outer box-shadow. This is default.",
		"inset" => "Defines an inner box-shadow."
	),
	'ref_links' => $propertyOptions['shadow']['box_shadow_x']['ref_links'],
	'tutorials' => $propertyOptions['shadow']['box_shadow_x']['tutorials'],
	'related_tutorials' => $propertyOptions['shadow']['box_shadow_x']['sub_label']
);

// background
// ------------------------------------------------------------

$propertyOptions['background']['background_color'] = array(
	'sh' => array('background', 0, array(
		'initial' => 'transparent'
		//'wl' => '[-a-z%:#,\'"\\/\\.\\d\\(\\)]+' // background props white list (matches any bg prop value)
	)),
	'short_label' => esc_html__('Color', 'noun', 'microthemer'),
	'label' => esc_attr__('Background Color', 'microthemer'),
	'pg_label' => esc_attr__('Background', 'microthemer'),
	'sub_label' => esc_html__('Background', 'microthemer'),
	'sub_slug' => 'background',
	'field-class' => 'is-picker',
	'input-class' => 'color',
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'color'
	),
	'icon' => '25',
	// ref
	'ref_desc' => "<p>The background-color property sets the background color of an element.</p>",
	'ref_values' => array(
		"(hex code or RGB/A)" => "Microthemer provides a color picker for specifying color without having to remember hex codes or RGB/A values. Just click your mouse in the Color text field to reveal the color picker."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/background-color/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/background-color',
		'quackit' => 'http://www.quackit.com/css/properties/css_background-color.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_background-color.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://www.cssbasics.com/chapter_12_css_backgrounds.html',
			'title' => 'CSS Backgrounds',
		),
		array(
			'url' => 'http://tutorials.jenkov.com/css/background-image.html',
			'title' => 'CSS Background Images',
		),
		array(
			'url' => 'http://learn.shayhowe.com/html-css/setting-backgrounds-and-gradients/#background-color',
			'title' => 'Adding a background color',
		),
		array(
			'url' => 'http://www.quackit.com/css/tutorial/css_background_code.cfm',
			'title' => 'CSS Background Code',
		),
		array(
			'url' => 'https://css-tricks.com/perfect-full-page-background-image/',
			'title' => 'Perfect Full Page Background Image',
		),
		array(
			'url' => 'http://www.css3.info/preview/background-origin-and-background-clip/',
			'title' => 'CSS3: background-origin and background-clip',
		),
		array(
			'url' => 'http://www.css3.info/preview/background-size/',
			'title' => 'Background-size',
		),
		array(
			'url' => 'http://www.css3.info/preview/multiple-backgrounds/',
			'title' => 'Multiple Backgrounds with CSS3',
		),
	),
	'group_tutorials' => 1
);

$propertyOptions['background']['background_image'] = array(
	'sh' => array('background', 1, array(
		'initial' => 'none',
	)),
	'multiple' => 1,
	'short_label' => esc_html_x('Image', 'noun', 'microthemer'),
	'label' => esc_attr__('Background Image', 'microthemer'),
	'type' => 'combobox',
	'field-class' => 'last span-3',
	'input-class' => 'bg-image-select size-very-big strictly-dropdown',
	'sug_values' => array(
		'this' => 1
	),
	'potential_gradient' => 1,
	'select_options' => array(
		'',
		'none'
	),
	'icon' => '39, 14',
	// ref
	'ref_desc' => "<p>The background-image property sets the background image for an element.</p>",
	'ref_values' => array(
		"(image)" => "Microthemer lists all the images contained within micro themes in a dropdown menu. You can also click the 'view images' link at the top right of the images menu to browse the images visually. Tip: the image slidehow will start from the image selected in the menu and will iterate through in the same order."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/background-image/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/background-image',
		'quackit' => 'http://www.quackit.com/css/properties/css_background-image.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_background-image.asp',
	),
	'tutorials' => $propertyOptions['background']['background_color']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['background']['background_position'] = array(
	'sh' => array('background', 2, array(
		'initial' => '0% 0%'
	)),
	'multiple' => 1,
	'short_label' => esc_html_x('Position', 'noun', 'microthemer'),
	'label' => esc_attr__('Background Position', 'microthemer'),
	'type' => 'combobox',
	'input-class' => 'bg-position-select size-6',
	'auto' => array(
		'%' => array(
			'node' => 'element',
			'prop' => array('width', 'height')
		)
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1
	),
	'select_options' => array(
		'',
		'left top',
		'left center',
		'left bottom',
		'right top',
		'right center',
		'right bottom',
		'center top',
		'center center',
		'center bottom'
	),
	'icon' => '3, 14',
	// ref
	'ref_desc' => "<p>The background-position property sets the starting position of a background image.</p>
<p>You can enter two values separated by a space. The first value will determine the horizontal (x-axis) position of the background image. The second value wil determine the vertical (y-axis) position of the background image. Microthemer will default to 'px' if no unit is specified, you can also use '%' or 'em' though.</p>",
	'ref_values' => array(
		"left top" => "The left and top edges of the background image are flush againt the left and top edges of the element. This is default",
		"left center" => "The left edge of the background image is flush againt the left edge of the element and is vertically centered",
		"left bottom" => "The left and bottom edges of the background image are flush againt the left and bottom edges of the element",
		"right top" => "The right and top edges of the background image are flush againt the right and top edges of the element",
		"right center" => "The right edge of the background image is flush againt the right edge of the element and is vertically centered",
		"right bottom" => "The right and bottom edges of the background image are flush againt the right and bottom edges of the element",
		"center top" => "The top edge of the background image is flush againt the top edge of the element and is horizontally centered",
		"center center" => "The center of the background image is aligned with the center of the element",
		"center bottom" => "The bottom edge of the background image is flush againt the bottom edge of the element and is horizontally centered"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/background-position/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/background-position',
		'quackit' => 'http://www.quackit.com/css/properties/css_background-position.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_background-position.asp',
	),
	'tutorials' => $propertyOptions['background']['background_color']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['background']['background_repeat'] = array(
	'sh' => array('background', 3, array(
		'initial' => 'repeat'
	)),
	'multiple' => 1,
	'short_label' => esc_html_x('Repeat', 'noun', 'microthemer'),
	'label' => esc_attr__('Background Repeat', 'microthemer'),
	'input-class' => 'size-3a',
	'type' => 'combobox',
	'select_options' => array(
		'',
		'repeat',
		'repeat-x',
		'repeat-y',
		'no-repeat'
	), 'icon' => '1, 14',
	// ref
	'ref_desc' => "<p>The background-repeat property sets if/how a background image will be repeated.</p>",
	'ref_values' => array(
		"repeat" => "The background image will be repeated both vertically and horizontally. This is default",
		"repeat-x" => "The background image will be repeated only horizontally",
		"repeat-y" => "The background image will be repeated only vertically",
		"no-repeat" => "The background-image will not be repeated"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/background-repeat/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/',
		'quackit' => 'http://www.quackit.com/css/properties/css_background-repeat.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_background-repeat.asp',
	),
	'tutorials' => $propertyOptions['background']['background_color']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['background']['background_attachment'] = array(
	'sh' => array('background', 4, array(
		'initial' => 'scroll'
	)),
	'multiple' => 1,
	'short_label' => esc_html__('Attachment', 'microthemer'),
	'label' => esc_attr__('Background Attachment', 'microthemer'),
	'type' => 'combobox',
	'input-class' => 'size-0',
	'select_options' => array(
		'',
		'scroll',
		'fixed'
	), 'icon' => '2, 14',
	// ref
	'ref_desc' => "<p>The background-attachment property sets whether a background image is
fixed or scrolls with the rest of the page.</p>",
	'ref_values' => array(
		"scroll" => "The background image scrolls with the rest of the page. This is default",
		"fixed" => "The background image is fixed"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#feat=background-img-opts',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/background-attachment/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/background-attachment',
		'quackit' => 'http://www.quackit.com/css/properties/css_background-attachment.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_background-attachment.asp',
	),
	'tutorials' => $propertyOptions['background']['background_color']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['background']['background_size'] = array(
	'sh' => array('background', 5, array(
		'initial' => 'auto'
	)),
	'multiple' => 1,
	'short_label' => esc_html_x('Size', 'noun', 'microthemer'),
	'label' => esc_attr__('Background Size', 'microthemer'),
	'type' => 'combobox',
	'input-class' => 'size-3a',
	'auto' => array(
		'%' => array(
			'node' => 'element',
			'prop' => array('width', 'height')
		)
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1
	),
	'select_options' => array(
		'',
		'auto',
		'cover',
		'contain'
	),
	'field-class' => 'last',
	'icon' => '25, 14',
	// ref
	'ref_desc' => "<p>The background-size property controls the size of the background image.<p>",
	'ref_values' => array(
		"auto" => "The background image is actual size (default).",
		"cover" => "Set the background image to cover the element's entire area. The image retains it's proportions and so is cropped if necessary.",
		"contain" => "Scale the image to the largest size such that both its width and its height can fit inside the content area.",
		"numeric" => "Specify two values separated by a space. The first is the width, the second is the height. px and ems etc can be used for the units. If you specify percentage units, this is calculated based on the width/height of the element.",
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/background-size/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/background-size',
		'quackit' => 'http://www.quackit.com/css/css3/properties/css_background-size.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/css3_pr_background-size.asp',
	),
	'tutorials' => $propertyOptions['background']['background_color']['tutorials'],
	'group_tutorials' => 1
);

// hide this as not room in interface, but keep for background shorthand map
$propertyOptions['background']['background_origin'] = array(
	'sh' => array('background', 6, array(
		'initial' => 'padding-box'
	)),
	'multiple' => 1,
	'short_label' => esc_html_x('Origin', 'noun', 'microthemer'),
	'label' => esc_attr__('Background Origin', 'microthemer'),
	'type' => 'combobox',
	'input-class' => 'size-5',
	'select_options' => array(
		'',
		'border-box',
		'padding-box',
		'content-box'
	),
	'icon' => '26, 14',
	// ref
	'ref_desc' => "<p>The background-origin property specifies where the background image is positioned.<p>",
	'ref_values' => array(
		"padding-box" => "The default. The background image starts from the upper left corner of the padding edge.",
		"border-box" => "The background image starts from the upper left corner of the border.",
		"content-box" => "The background image starts from the upper left corner of the content."
	),
	'tutorials' => $propertyOptions['background']['background_color']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['background']['background_clip'] = array(
	'sh' => array('background', 7, array(
		'initial' => 'border-box'
	)),
	'multiple' => 1,
	'short_label' => esc_html_x('Clip', 'noun', 'microthemer'),
	'label' => esc_attr__('Background Clip', 'microthemer'),
	'type' => 'combobox',
	'input-class' => 'size-5',
	'last_in_sub' => 1,
	'select_options' => array(
		'',
		'border-box',
		'padding-box',
		'content-box'
	),
	'icon' => '26, 14',
	// ref
	'ref_desc' => "<p>The background-clip property controls the painting area of the background.<p>",
	'ref_values' => array(
		"border-box" => "The background is clipped at the outer edge of the border (default). The extent of the fill to the outer edge of the border is only evident if the border isn't solid e.g. dashed",
		"padding-box" => "The background is clipped at the outer edge of the padding (it doesn't show behind the border).",
		"content-box" => "The background is clipped at the outer edge of the content (it doesn't show behind the padding)."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#feat=background-img-opts',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/background-clip/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/background-clip',
		'quackit' => 'http://www.quackit.com/css/css3/properties/css_background-clip.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/css3_pr_background-clip.asp',
	),
	'tutorials' => $propertyOptions['background']['background_color']['tutorials'],
	'group_tutorials' => 1
);

/* - it is hard to understand the difference between clip and origin, include if requested.
$propertyOptions['background']['background_origin'] = array(
	'short_label' => 'Origin',
	'label' => 'Background Origin',
	'type' => 'combobox',
	'select_options' => array(
		'',
		'border-box',
		'padding-box',
		'content-box'
	));
*/

// dimensions
// ------------------------------------------------------------

$propertyOptions['dimensions']['width'] = array(
	'short_label' => esc_html__('Width', 'microthemer'),
	'label' => esc_attr__('Width', 'microthemer'),
	'pg_label' => esc_attr__('Dimensions', 'microthemer'),
	'sub_label' => esc_html__('Width', 'microthemer'),
	'sub_slug' => 'width',
	'auto' => array(
		'%' => array(
			'node' => 'parent',
			'prop' => 'width'
		)
	),
	'input-class' => 'size-1',
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		//'pattern' => '^(?:(?:min|max)\-)?width',
		'root_cat' => 'width' // common key shared by all width properties, for storing all width values in on array
	),
	'icon' => '9',
	// ref
	'ref_desc' => "<p>The width property sets the width of an element. If 'box-sizing' is set to 'content-box' (default) the total width of an element is
	width + padding + borders (and in terms of the space it takes up on the page + margin too). However, if the width hasn't been given a numeric or percentage value (or has been explicitly set to 'auto') it will have a value of 'auto'. Applying padding, margin and border values when width is 'auto' causes the browser to decrease the value it calculates for width. Otherwise the element would be too big for it's parent element - which is what happens if you enter a value of '100%' for width and then add margins, padding or borders.</p>
	<p>If 'box-sizing' is set to 'border-box' padding and border values are not added to the defined width. The defined width specifies the total width. So if you set width to '100' and border-left to '20' the total width would be '100' as opposed to '120' (the padding forces the width down to '80').</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '400' would set the width to 400 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '50%' in the Width field."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/w/width/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/width',
		'quackit' => 'http://www.quackit.com/css/properties/css_width.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_dim_width.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://www.impressivewebs.com/min-max-width-height-css/',
			'title' => 'Using Min/Max Width and Height in CSS',
		),
		array(
			'url' => 'http://www.quackit.com/css/tutorial/css_height_width.cfm',
			'title' => 'CSS Height and Width',
		),
	),
	'group_tutorials' => 1
);

$propertyOptions['dimensions']['min_width'] = array(
	'short_label' => esc_html__('Min', 'microthemer'),
	'label' => esc_attr__('Min Width', 'microthemer'),
	'input-class' => 'size-1',
	'auto' => array(
		'%' => array(
			'node' => 'parent',
			'prop' => 'width'
		)
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		//'pattern' => '^(?:(?:min|max)\-)?width',
		'root_cat' => 'width'
	),
	'icon' => '36, 14',
	// ref
	'ref_desc' => "<p>The min-width property sets the minimum width of an element. Note: The min-width property does not include padding, borders, or margins.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '400' would set the minimun width to 400 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '50%' in the Min Width field."),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#feat=minmaxwh',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/m/min-width/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/min-width',
		'quackit' => 'http://www.quackit.com/css/properties/css_min-width.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_dim_min-width.asp',
	),
	'tutorials' => $propertyOptions['dimensions']['width']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['dimensions']['max_width'] = array(
	'short_label' => esc_html__('Max', 'microthemer'),
	'label' => esc_attr__('Max Width', 'microthemer'),
	'input-class' => 'size-1',
	'last_in_sub' => 1,
	'auto' => array(
		'%' => array(
			'node' => 'parent',
			'prop' => 'width'
		)
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		//'pattern' => '^(?:(?:min|max)\-)?width',
		'root_cat' => 'width'
	),
	'icon' => '34, 14',
	// ref
	'ref_desc' => "<p>The max-width property sets the maximum width of an element. Note: The max-width property does not include padding, borders, or margins.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '400' would set the maximun width to 400 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '50%' in the Max Width field."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#feat=minmaxwh',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/m/max-width/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/max-width',
		'quackit' => 'http://www.quackit.com/css/properties/css_max-width.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_dim_max-width.asp',
	),
	'tutorials' => $propertyOptions['dimensions']['width']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['dimensions']['height'] = array(
	'short_label' => esc_html__('Height', 'microthemer'),
	'label' => esc_attr__('Height', 'microthemer'),
	'field-class' => 'icon-size-0b',
	'sub_label' => esc_html__('Height', 'microthemer'),
	'sub_slug' => 'height',
	'input-class' => 'size-1',
	'auto' => array(
		'%' => array(
			'node' => 'parent',
			'prop' => 'height',
			'tip' => $height_percentage_tip
		)
	),
	'default_unit' => 1,
	// we don't want line-height, so use restricted pattern
	'sug_values' => array(
		'this' => 1,
		//'pattern' => '^(?:(?:min|max)\-)?height',
		'root_cat' => 'height'
	),
	'icon' => '10',
	// ref
	'ref_desc' => "<p>The height property sets the height of an element. <b>Note:</b> The total height of an element is
	height + padding + borders (+ margins, if you consider the total space the element takes up on the page). However, if box-sizing is set to border-box padding and border are incorporated in the value set for height.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '200' would set the height to 400 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '10em' in the Height field."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#feat=minmaxwh',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/h/height/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/',
		'quackit' => 'http://www.quackit.com/css/properties/css_height.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_dim_height.asp',
	),
	'tutorials' => $propertyOptions['dimensions']['width']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['dimensions']['min_height'] = array(
	'short_label' => esc_html__('Min', 'microthemer'),
	'label' => esc_attr__('Min Height', 'microthemer'),
	'field-class' => 'icon-size-2',
	'input-class' => 'size-1',
	'auto' => array(
		'%' => array(
			'node' => 'parent',
			'prop' => 'height',
			'tip' => $height_percentage_tip
		)
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		//'pattern' => '^(?:(?:min|max)\-)?height',
		'root_cat' => 'height'
	),
	'icon' => '37, 14',
	// ref
	'ref_desc' => "<p>The min-height property sets the minimum height of an element. Note: The min-height property does not include padding, borders, or margins</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '400' would set the minimun height to 400 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified)."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#feat=minmaxwh',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/m/min-height/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/min-height',
		'quackit' => 'http://www.quackit.com/css/properties/css_min-height.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_dim_min-height.asp',
	),
	'tutorials' => $propertyOptions['dimensions']['width']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['dimensions']['max_height'] = array(
	'short_label' => esc_html__('Max', 'microthemer'),
	'label' => esc_attr__('Max Height', 'microthemer'),
	'field-class' => 'icon-size-2',
	'input-class' => 'size-1',
	'auto' => array(
		'%' => array(
			'node' => 'parent',
			'prop' => 'height',
			'tip' => $height_percentage_tip
		)
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		//'pattern' => '^(?:(?:min|max)\-)?height',
		'root_cat' => 'height'
	),
	'icon' => '35, 14',
	// ref
	'ref_desc' => "<p>The max-height property sets the maximum height of an element. Note: The max-height property does not include padding, borders, or margins.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '400' would set the maximun height to 400 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified)."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#feat=minmaxwh',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/m/max-height/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/max-height',
		'quackit' => 'http://www.quackit.com/css/properties/css_max-height.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_dim_max-height.asp',
	),
	'tutorials' => $propertyOptions['dimensions']['width']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['dimensions']['box_sizing'] = array(
	'short_label' => esc_html__('Box Sizing', 'microthemer'),
	'label' => esc_attr__('Box Sizing', 'microthemer'),
	'input-class' => 'size-5',
	'type' => 'combobox',
	'last_in_sub' => 1,
	'select_options' => array(
		'',
		'content-box',
		'border-box'
	),
	'field-class' => 'last',
	'icon' => '32, 14',
	// ref
	'ref_desc' => "<p>The box-sizing property determines if padding and border should be <b>added to the value</b> set for width/height or <b>form part of the value</b> set for width/height (including min/max). Although the default value for box-sizing is content-box, many view this to be a mistake as elements can be easier to layout when padding and border are included in the width (border-box).</p>",
	'ref_values' => array(
		"content-box" => "Padding and border values are added to the value given for width/height. For instance, total width = width + padding + border. This is the default.",
		"border-box" => "Padding and border values form part of the value given for width/height. For instance, total width = width."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#feat=css3-boxsizing',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/box-sizing/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/box-sizing',
		'quackit' => 'http://www.quackit.com/css/css3/properties/css_box-sizing.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/css3_pr_box-sizing.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'https://css-tricks.com/box-sizing/',
			'title' => 'Box Sizing',
		),
		array(
			'url' => 'http://blog.teamtreehouse.com/box-sizing-secret-simple-css-layouts',
			'title' => 'Box-Sizing: The Secret to Simple CSS Layouts',
		),
		array(
			'url' => 'http://blog.teamtreehouse.com/take-control-of-the-box-model-with-box-sizing',
			'title' => 'Take Control of the Box Model with box-sizing',
		),
		array(
			'url' => 'http://learn.shayhowe.com/html-css/opening-the-box-model/#box-model',
			'title' => 'Working with the Box Model',
		),
	)
);

// padding
// ------------------------------------------------------------

$propertyOptions['padding_margin']['padding_top'] = array(
	'sh' => array('padding', 0),
	'short_label' => esc_html__('Top', 'microthemer'),
	'label' => esc_attr__('Padding Top', 'microthemer'),
	'pg_label' => esc_attr__('Padding & Margin', 'microthemer'),
	'sub_label' => esc_html__('Padding', 'microthemer'),
	'sub_slug' => 'padding',
	'input-class' => 'size-0',
	'auto' => array(
		'%' => array(
			'node' => 'parent',
			'prop' => 'width'
		)
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'padding' // I considered padding_margin here, but there will be lots of P&M values
	),
	'rel' => 'padding',
	'icon' => '3',
	// ref
	'ref_desc' => "<p>The padding-top property sets the top padding (space) of an element. The space is created <i>inside</i> the element's border.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '15' would set the top padding for an element to 15 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '5%' in the Top Padding field."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/p/padding/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/padding-top',
		'quackit' => 'http://www.quackit.com/css/properties/css_padding-top.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_padding-top.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://www.xul.fr/en/css/margin-padding.php',
			'title' => 'Padding and margin',
		),
		array(
			'url' => 'http://www.goer.org/HTML/intermediate/margins_and_padding/',
			'title' => 'Box Model: Margins and Padding',
		),
		array(
			'url' => 'http://xahlee.info/js/css_margin_vs_padding.html',
			'title' => 'CSS: Margin vs Padding',
		),
	),
	'group_tutorials' => 1
);

$propertyOptions['padding_margin']['padding_right'] = array(
	'sh' => array('padding', 1),
	'short_label' => esc_html__('Right', 'microthemer'),
	'label' => esc_attr__('Padding Right', 'microthemer'),
	'input-class' => 'size-0',
	'auto' => array(
		'%' => array(
			'node' => 'parent',
			'prop' => 'width'
		)
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'padding' // I considered padding_margin here, but there will be lots of P&M values
	),
	'rel' => 'padding',
	'icon' => '2',
	// ref
	'ref_desc' => "<p>The padding-right property sets the right padding (space) of an element. The space is created <i>inside</i> the element's border.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '15' would set the right padding for an element to 15 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '5%' in the Right Padding field."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/p/padding/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/padding-right',
		'quackit' => 'http://www.quackit.com/css/properties/css_padding-right.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_padding-right.asp',
	),
	'tutorials' => $propertyOptions['padding_margin']['padding_top']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['padding_margin']['padding_bottom'] = array(
	'sh' => array('padding', 2),
	'short_label' => esc_html__('Bottom', 'microthemer'),
	'label' => esc_attr__('Padding Bottom', 'microthemer'),
	'input-class' => 'size-0',
	'auto' => array(
		'%' => array(
			'node' => 'parent',
			'prop' => 'width'
		)
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'padding' // I considered padding_margin here, but there will be lots of P&M values
	),
	'rel' => 'padding',
	'icon' => '4',
	// ref
	'ref_desc' => "<p>The padding-bottom property sets the bottom padding (space) of an element. The space is created <i>inside</i> the element's border.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '15' would set the bottom padding for an element to 15 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '5%' in the Bottom Padding field."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/p/padding/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/padding-bottom',
		'quackit' => 'http://www.quackit.com/css/properties/css_padding-bottom.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_padding-bottom.asp',
	),
	'tutorials' => $propertyOptions['padding_margin']['padding_top']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['padding_margin']['padding_left'] = array(
	'sh' => array('padding', 3),
	'short_label' => esc_html__('Left', 'microthemer'),
	'label' => esc_attr__('Padding Left', 'microthemer'),
	'input-class' => 'size-0',
	'last_in_sub' => 1,
	'auto' => array(
		'%' => array(
			'node' => 'parent',
			'prop' => 'width'
		)
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'padding' // I considered padding_margin here, but there will be lots of P&M values
	),
	'rel' => 'padding',
	'field-class' => 'last',
	'icon' => '1',
	// ref
	'ref_desc' => "<p>The padding-left property sets the left padding (space) of an element. The space is created <i>inside</i> the element's border.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '15' would set the left padding for an element to 15 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '5%' in the Left Padding field."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/p/padding/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/padding-left',
		'quackit' => 'http://www.quackit.com/css/properties/css_padding-left.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_padding-left.asp',
	),
	'tutorials' => $propertyOptions['padding_margin']['padding_top']['tutorials'],
	'group_tutorials' => 1
);

// margin
// ------------------------------------------------------------

$propertyOptions['padding_margin']['margin_top'] = array(
	'sh' => array('margin', 0),
	'short_label' => esc_html__('Top', 'microthemer'),
	'label' => esc_attr__('Margin Top', 'microthemer'),
	'sub_label' => esc_html__('Margin', 'microthemer'),
	'sub_slug' => 'margin',
	'input-class' => 'size-0',
	'auto' => array(
		'%' => array(
			'node' => 'parent',
			'prop' => 'width'
		)
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'margin'
	),
	'rel' => 'margin',
	'icon' => '7',
	// ref
	'ref_desc' => "<p>The margin-top property sets the top margin (space) of an element.
The space is created <i>outside</i> the element's border.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '15' would set the top margin for an element to 15 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '5%' in the Top Margin field."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/m/margin/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/margin-top',
		'quackit' => 'http://www.quackit.com/css/properties/css_margin-top.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_margin-top.asp',
	),
	'tutorials' => $propertyOptions['padding_margin']['padding_top']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['padding_margin']['margin_right'] = array(
	'sh' => array('margin', 1),
	'short_label' => esc_html__('Right', 'microthemer'),
	'label' => esc_attr__('Margin Right', 'microthemer'),
	'field-class' => 'icon-size-2',
	'input-class' => 'size-0',
	'auto' => array(
		'%' => array(
			'node' => 'parent',
			'prop' => 'width'
		)
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'margin'
	),
	'rel' => 'margin',
	'icon' => '6',
	// ref
	'ref_desc' => "<p>The margin-right property sets the right margin (space) of an element. The space is created <i>outside</i> the element's border.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '15' would set the right margin for an element to 15 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '5%' in the Right Margin field."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/m/margin/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/margin-right',
		'quackit' => 'http://www.quackit.com/css/properties/css_margin-right.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_margin-right.asp',
	),
	'tutorials' => $propertyOptions['padding_margin']['padding_top']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['padding_margin']['margin_bottom'] = array(
	'sh' => array('margin', 2),
	'short_label' => esc_html__('Bottom', 'microthemer'),
	'label' => esc_attr__('Margin Bottom', 'microthemer'),
	'input-class' => 'size-0',
	'auto' => array(
		'%' => array(
			'node' => 'parent',
			'prop' => 'width'
		)
	),
	'default_unit' => 1,
	'rel' => 'margin',
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'margin'
	),
	'icon' => '8',
	// ref
	'ref_desc' => "<p>The margin-bottom property sets the bottom margin (space) of an element. The space is created <i>outside</i> the element's border.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '15' would set the bottom margin for an element to 15 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '5%' in the Bottom Margin field."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/m/margin/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/margin-bottom',
		'quackit' => 'http://www.quackit.com/css/properties/css_margin-bottom.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_margin-bottom.asp',
	),
	'tutorials' => $propertyOptions['padding_margin']['padding_top']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['padding_margin']['margin_left'] = array(
	'sh' => array('margin', 3),
	'short_label' => esc_html__('Left', 'microthemer'),
	'label' => esc_attr__('Margin Left', 'microthemer'),
	'field-class' => 'icon-size-3 last',
	'input-class' => 'size-0',
	'last_in_sub' => 1,
	'auto' => array(
		'%' => array(
			'node' => 'parent',
			'prop' => 'width'
		)
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'margin'
	),
	'rel' => 'margin',
	'icon' => '5',
	// ref
	'ref_desc' => "<p>The margin-left property sets the left margin (space) of an element. The space is created <i>outside</i> the element's border.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '15' would set the left margin for an element to 15 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '5%' in the Left Margin field."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/m/margin/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/margin-left',
		'quackit' => 'http://www.quackit.com/css/properties/css_margin-left.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_margin-left.asp',
	),
	'tutorials' => $propertyOptions['padding_margin']['padding_top']['tutorials'],
	'group_tutorials' => 1
);

// border
// ------------------------------------------------------------

$propertyOptions['border']['border_top_color'] = array(
	'sh' => array(
		array('border', 8, array('initial' => '')),
		array('border-top', 2, array('initial' => '')),
		array('border-color', 0, array('initial' => ''))
	),
	'short_label' => esc_html__('Top', 'microthemer'),
	'label' => esc_attr__('Border Top Color', 'microthemer'),
	'pg_label' => esc_attr__('Border', 'microthemer'),
	'sub_label' => esc_html__('Border Color', 'microthemer'),
	'sub_slug' => 'border_color',
	'rel' => 'border_color',
	'field-class' => 'is-picker',
	'input-class' => 'color',
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'color'
	),
	'icon' => '10, 14',
	// ref
	'ref_desc' => "<p>The border-top-color property sets the top border color of an element. <b>Note</b>: the Border Style property must be set for any of the other border properties to work.</p>",
	'ref_values' => array(
		"(hex code or RGB/A)" => "Microthemer provides a color picker for specifying color without having to remember hex code or RGB/A values. Just click your mouse in the Top Border Color text field to reveal the color picker."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/border/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/border-top-color',
		'quackit' => 'http://www.quackit.com/css/properties/css_border-top-color.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_border-top_color.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://code.tutsplus.com/tutorials/css-refreshers-borders--net-24655',
			'title' => 'CSS Refreshers: Borders',
		),
		array(
			'url' => 'http://www.entheosweb.com/tutorials/css/borders.asp',
			'title' => 'CSS Borders Tutorial',
		),
		array(
			'url' => 'http://www.tizag.com/cssT/border.php',
			'title' => 'CSS border',
		),
	),
	'group_tutorials' => 1
);

$propertyOptions['border']['border_right_color'] = array(
	'sh' => array(
		array('border', 9, array('initial' => '')),
		array('border-right', 2, array('initial' => '')),
		array('border-color', 1, array('initial' => ''))
	),
	'short_label' => esc_html__('Right', 'microthemer'),
	'label' => esc_attr__('Border Right Color', 'microthemer'),
	'rel' => 'border_color',
	'field-class' => 'is-picker',
	'input-class' => 'color',
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'color'
	),
	'icon' => '13, 14',
	// ref
	'ref_desc' => "<p>The border-right-color property sets the right border color of an element. <b>Note</b>: the Border Style property must be set for any of the other border properties to work.</p>",
	'ref_values' => array(
		"(hex code or RGB/A)" => "Microthemer provides a color picker for specifying color without having to remember hex codes or RGB/A values. Just click your mouse in the Right Border Color text field to reveal the color picker."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/border/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/border-right-color',
		'quackit' => 'http://www.quackit.com/css/properties/css_border-right-color.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_border-right_color.asp',
	),
	'tutorials' => $propertyOptions['border']['border_top_color']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['border']['border_bottom_color'] = array(
	'sh' => array(
		array('border', 10, array('initial' => '')),
		array('border-bottom', 2, array('initial' => '')),
		array('border-color', 2, array('initial' => ''))
	),
	'short_label' => esc_html__('Bottom', 'microthemer'),
	'label' => esc_attr__('Border Bottom Color', 'microthemer'),
	'rel' => 'border_color',
	'field-class' => 'is-picker',
	'input-class' => 'color',
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'color'
	),
	'icon' => '11, 14',
	// ref
	'ref_desc' => "<p>The border-bottom-color property sets the bottom border color of an element. <b>Note</b>: the Border Style property must be set for any of the other border properties to work.</p>",
	'ref_values' => array(
		"(hex code or RGB/A)" => "Microthemer provides a color picker for specifying color without having to remember hex codes or RGB/A values. Just click your mouse in the Bottom Border Color text field to reveal the color picker."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/border/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/border-bottom-color',
		'quackit' => 'http://www.quackit.com/css/properties/css_border-bottom-color.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_border-bottom_color.asp',
	),
	'tutorials' => $propertyOptions['border']['border_top_color']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['border']['border_left_color'] = array(
	'sh' => array(
		array('border', 11, array('initial' => '')),
		array('border-left', 2, array('initial' => '')),
		array('border-color', 3, array('initial' => ''))
	),
	'short_label' => esc_html__('Left', 'microthemer'),
	'label' => esc_attr__('Border Left Color', 'microthemer'),
	'rel' => 'border_color',
	'field-class' => 'last is-picker',
	'input-class' => 'color',
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'color'
	),
	'last_in_sub' => 1,
	'icon' => '12, 14',
	// ref
	'ref_desc' => "<p>The border-left-color property sets the left border color of an element. <b>Note</b>: the Border Style property must be set for any of the other border properties to work.</p>",
	'ref_values' => array(
		"(hex code or RGB/A)" => "Microthemer provides a color picker for specifying color without having to remember hex codes or RGB/A values. Just click your mouse in the Left Border Color text field to reveal the color picker."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/border/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/border-left-color',
		'quackit' => 'http://www.quackit.com/css/properties/css_border-left-color.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_border-left_color.asp',
	),
	'tutorials' => $propertyOptions['border']['border_top_color']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['border']['border_top_width'] = array(
	'sh' => array(
		array('border', 0, array('initial' => 'medium')),
		array('border-top', 0, array('initial' => 'medium')),
		array('border-width', 0, array('initial' => 'medium'))
	),
	'short_label' => esc_html__('Top', 'microthemer'),
	'label' => esc_attr__('Border Top Width', 'microthemer'),
	'sub_label' => esc_html__('Border Width', 'microthemer'),
	'sub_slug' => 'border_width',
	'auto' => array(
		'%' => false
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'border_width'
	),
	'rel' => 'border_width',
	'icon' => '6, 14',
	// ref
	'ref_desc' => "<p>The border-top-width property sets the top border width of an element. <b>Note</b>: the Border Style property must be set for any of the other border properties to work.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '15' would set the top border width for an element to 15 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '5%' in the Top Border Width field."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/border/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/border-top-width',
		'quackit' => 'http://www.quackit.com/css/properties/css_border-top-width.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_border-top_width.asp',
	),
	'tutorials' => $propertyOptions['border']['border_top_color']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['border']['border_right_width'] = array(
	'sh' => array(
		array('border', 1, array('initial' => 'medium')),
		array('border-right', 0, array('initial' => 'medium')),
		array('border-width', 1, array('initial' => 'medium'))
	),
	'short_label' => esc_html__('Right', 'microthemer'),
	'label' => esc_attr__('Border Right Width', 'microthemer'),
	'auto' => array(
		'%' => false
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'border_width'
	),
	'rel' => 'border_width',
	'icon' => '9, 14',
	// ref
	'ref_desc' => "<p>The border-right-width property sets the right border width of an element. <b>Note</b>: the Border Style property must be set for any of the other border properties to work.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '15' would set the right border for an element to 15 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '5%' in the Right Border Width field."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/border/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/border-right-width',
		'quackit' => 'http://www.quackit.com/css/properties/css_border-right-width.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_border-right_width.asp',
	),
	'tutorials' => $propertyOptions['border']['border_top_color']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['border']['border_bottom_width'] = array(
	'sh' => array(
		array('border', 2, array('initial' => 'medium')),
		array('border-bottom', 0, array('initial' => 'medium')),
		array('border-width', 2, array('initial' => 'medium'))
	),
	'short_label' => esc_html__('Bottom', 'microthemer'),
	'label' => esc_attr__('Border Bottom Width', 'microthemer'),
	'auto' => array(
		'%' => false
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'border_width'
	),
	'rel' => 'border_width',
	'icon' => '7, 14',
	// ref
	'ref_desc' => "<p>The border-bottom-width property sets the bottom border width of an element. <b>Note</b>: the Border Style property must be set for any of the other border properties to work.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '15' would set the bottom border for an element to 15 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '5%' in the Bottom Border Width field."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/border/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/border-bottom-width',
		'quackit' => 'http://www.quackit.com/css/properties/css_border-bottom-width.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_border-bottom_width.asp',
	),
	'tutorials' => $propertyOptions['border']['border_top_color']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['border']['border_left_width'] = array(
	'sh' => array(
		array('border', 3, array('initial' => 'medium')),
		array('border-left', 0, array('initial' => 'medium')),
		array('border-width', 3, array('initial' => 'medium'))
	),
	'short_label' => esc_html__('Left', 'microthemer'),
	'label' => esc_attr__('Border Left Width', 'microthemer'),
	'auto' => array(
		'%' => false
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'border_width'
	),
	'rel' => 'border_width',
	'field-class' => 'last',
	'last_in_sub' => 1,
	'icon' => '8, 14',
	'linebreak' => 1,
	// ref
	'ref_desc' => "<p>The border-left-width property sets the left border width of an element. <b>Note</b>: the Border Style property must be set for any of the other border properties to work.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '15' would set the left border for an element to 15 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '5%' in the Left Border Width field."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/border/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/border-left-width',
		'quackit' => 'http://www.quackit.com/css/properties/css_border-left-width.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_border-left_width.asp',
	),
	'tutorials' => $propertyOptions['border']['border_top_color']['tutorials'],
	'group_tutorials' => 1
);

$border_style_options = array(
	'hidden',
	'dotted',
	'dashed',
	'solid',
	'double',
	'groove',
	'ridge',
	'inset',
	'outset',
	'none'
);

$propertyOptions['border']['border_top_style'] = array(
	'sh' => array(
		array('border', 4, array('initial' => 'none')),
		array('border-top', 1, array('initial' => 'none')),
		array('border-style', 0, array('initial' => 'none'))
	),
	'short_label' => esc_html__('Top', 'microthemer'),
	'label' => esc_attr__('Border Top Style', 'microthemer'),
	'sub_label' => esc_html__('Border Style', 'microthemer'),
	'sub_slug' => 'border_style',
	'type' => 'combobox',
	'rel' => 'border_style',
	'select_options' => $border_style_options,
	'icon' => '14, 14',
	// ref
	'ref_desc' => "<p>The border-top-style property sets the style of an element's top border.</p>",
	'ref_values' => array(
		"hidden" => "The same as 'none', except in border conflict resolution for table elements",
		"dotted" => "Specifies a dotted border",
		"dashed" => "Specifies a dashed border",
		"solid" => "Specifies a solid border",
		"double" => "Specifies a double border",
		"groove" => "Specifies a 3D grooved border. The effect depends on the border-color value",
		"ridge" => "Specifies a 3D ridged border. The effect depends on the border-color value!",
		"inset" => "Specifies a 3D inset border. The effect depends on the border-color value",
		"outset" => "Specifies a 3D outset border. The effect depends on the border-color value",
		"none" => "Specifies no border"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/border/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/border-top-style',
		'quackit' => 'http://www.quackit.com/css/properties/css_border-top-style.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_border-top_style.asp',
	),
	'tutorials' => $propertyOptions['border']['border_top_color']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['border']['border_right_style'] = array(
	'sh' => array(
		array('border', 5, array('initial' => 'none')),
		array('border-right', 1, array('initial' => 'none')),
		array('border-style', 1, array('initial' => 'none'))
	),
	'short_label' => esc_html__('Right', 'microthemer'),
	'label' => esc_attr__('Border Right Style', 'microthemer'),
	'type' => 'combobox',
	'rel' => 'border_style',
	'select_options' => $border_style_options,
	'icon' => '17, 14',
	// ref
	'ref_desc' => "<p>The border-right-style property sets the style of an element's right border.</p>",
	'ref_values' => array(
		"hidden" => "The same as 'none', except in border conflict resolution for table elements",
		"dotted" => "Specifies a dotted border",
		"dashed" => "Specifies a dashed border",
		"solid" => "Specifies a solid border",
		"double" => "Specifies a double border",
		"groove" => "Specifies a 3D grooved border. The effect depends on the border-color value",
		"ridge" => "Specifies a 3D ridged border. The effect depends on the border-color value!",
		"inset" => "Specifies a 3D inset border. The effect depends on the border-color value",
		"outset" => "Specifies a 3D outset border. The effect depends on the border-color value",
		"none" => "Specifies no border"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/border/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/border-right-style',
		'quackit' => 'http://www.quackit.com/css/properties/css_border-right-style.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_border-right_style.asp',
	),
	'tutorials' => $propertyOptions['border']['border_top_color']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['border']['border_bottom_style'] = array(
	'sh' => array(
		array('border', 6, array('initial' => 'none')),
		array('border-bottom', 1, array('initial' => 'none')),
		array('border-style', 2, array('initial' => 'none'))
	),
	'short_label' => esc_html__('Bottom', 'microthemer'),
	'label' => esc_attr__('Border Bottom Style', 'microthemer'),
	'type' => 'combobox',
	'rel' => 'border_style',
	'select_options' => $border_style_options,
	'icon' => '15, 14',
	// ref
	'ref_desc' => "<p>The border-bottom-style property sets the style of an element's bottom border.</p>",
	'ref_values' => array(
		"hidden" => "The same as 'none', except in border conflict resolution for table elements",
		"dotted" => "Specifies a dotted border",
		"dashed" => "Specifies a dashed border",
		"solid" => "Specifies a solid border",
		"double" => "Specifies a double border",
		"groove" => "Specifies a 3D grooved border. The effect depends on the border-color value",
		"ridge" => "Specifies a 3D ridged border. The effect depends on the border-color value!",
		"inset" => "Specifies a 3D inset border. The effect depends on the border-color value",
		"outset" => "Specifies a 3D outset border. The effect depends on the border-color value",
		"none" => "Specifies no border"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/border/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/border-bottom-style',
		'quackit' => 'http://www.quackit.com/css/properties/css_border-bottom-style.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_border-right_style.asp',
	),
	'tutorials' => $propertyOptions['border']['border_top_color']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['border']['border_left_style'] = array(
	'sh' => array(
		array('border', 7, array('initial' => 'none')),
		array('border-left', 1, array('initial' => 'none')),
		array('border-style', 3, array('initial' => 'none'))
	),
	'short_label' => esc_html__('Left', 'microthemer'),
	'label' => esc_attr__('Border Left Style', 'microthemer'),
	'type' => 'combobox',
	'field-class' => 'last',
	'last_in_sub' => 1,
	'rel' => 'border_style',
	'select_options' => $border_style_options,
	'icon' => '16, 14',
	// ref
	'ref_desc' => "<p>The border-left-style property sets the style of an element's left border.</p>",
	'ref_values' => array(
		"hidden" => "The same as 'none', except in border conflict resolution for table elements",
		"dotted" => "Specifies a dotted border",
		"dashed" => "Specifies a dashed border",
		"solid" => "Specifies a solid border",
		"double" => "Specifies a double border",
		"groove" => "Specifies a 3D grooved border. The effect depends on the border-color value",
		"ridge" => "Specifies a 3D ridged border. The effect depends on the border-color value!",
		"inset" => "Specifies a 3D inset border. The effect depends on the border-color value",
		"outset" => "Specifies a 3D outset border. The effect depends on the border-color value",
		"none" => "Specifies no border"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/border/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/border-left-style',
		'quackit' => 'http://www.quackit.com/css/properties/css_border-left-style.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_border-left_style.asp',
	),
	'tutorials' => $propertyOptions['border']['border_top_color']['tutorials'],
	'group_tutorials' => 1
);

// border radius
// ------------------------------------------------------------

$propertyOptions['border']['border_top_left_radius'] = array(
	'sh' => array('border-radius', 0),
	'short_label' => esc_html__('Top Left', 'microthemer'),
	'label' => esc_attr__('Top Left Border Radius', 'microthemer'),
	'sub_label' => esc_html__('Border Radius', 'microthemer'),
	'sub_slug' => 'border_radius',
	//'field-class' => 'icon-size-2',
	'auto' => array(
		'%' => $border_radius_unconvertable
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'border_radius'
	),
	'icon' => '17',
	'rel' => 'border_radius',
	'hide imp' => 1,
	// ref
	'ref_desc' => "<p>The top left radius property defines the shape of the border of the top-left corner. A higher value creates a more rounded curve.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '5' would set the top left border radius for an element to 5 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '5%'."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#feat=border-radius',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/border-radius/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/border-top-left-radius',
		'quackit' => 'http://www.quackit.com/css/css3/properties/css_border-top-left-radius.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/css3_pr_border-top-left-radius.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://xahlee.info/js/css_round_corners.html',
			'title' => 'CSS: Round Corners: border-radius',
		),
		array(
			'url' => 'http://www.css3.info/preview/rounded-border/',
			'title' => 'Border-radius: create rounded corners with CSS!',
		),
		array(
			'url' => 'http://www.cssmatic.com/border-radius',
			'title' => 'CSSmatic Border Radius',
			'tool' => 1
		),
	),
	'related_tutorials' => esc_html__('Border Radius', 'microthemer')
);

$propertyOptions['border']['border_top_right_radius'] = array(
	'sh' => array('border-radius', 1),
	'short_label' => esc_html__('Top Right', 'microthemer'),
	'label' => esc_attr__('Top Right Border Radius', 'microthemer'),
	'auto' => array(
		'%' => $border_radius_unconvertable
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'border_radius'
	),
	'icon' => '18',
	'rel' => 'border_radius',
	'hide imp' => 1,
	//ref
	'ref_desc' => "<p>The top right radius property defines the shape of the border of the top-right corner. A higher value creates a more rounded curve.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '5' would set the top right border radius for an element to 5 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '5%'."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#feat=border-radius',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/border-radius/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/border-top-right-radius',
		'quackit' => 'http://www.quackit.com/css/css3/properties/css_border-top-right-radius.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/css3_pr_border-top-right-radius.asp',
	),
	'tutorials' => $propertyOptions['border']['border_top_left_radius']['tutorials']
);

$propertyOptions['border']['border_bottom_right_radius'] = array(
	'sh' => array('border-radius', 2),
	'short_label' => esc_html__('Bottom Right', 'microthemer'),
	'label' => esc_attr__('Bottom Right Border Radius', 'microthemer'),
	'auto' => array(
		'%' => $border_radius_unconvertable
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'border_radius'
	),
	'icon' => '20',
	'rel' => 'border_radius',
	'hide imp' => 1,
	// ref
	'ref_desc' => "<p>The bottom left radius property defines the shape of the border of the bottom-left corner. A higher value creates a more rounded curve.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '5' would set the bottom left border radius for an element to 5 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '5%'."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#feat=border-radius',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/border-radius/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/border-bottom-right-radius',
		'quackit' => 'http://www.quackit.com/css/css3/properties/css_border-bottom-right-radius.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/css3_pr_border-bottom-right-radius.asp',
	),
	'tutorials' => $propertyOptions['border']['border_top_left_radius']['tutorials'],
	'related_tutorials' => $propertyOptions['border']['border_top_left_radius']['sub_label']
);

$propertyOptions['border']['border_bottom_left_radius'] = array(
	'sh' => array('border-radius', 3),
	'short_label' => esc_html__('Bottom Left', 'microthemer'),
	'label' => esc_attr__('Bottom Left Border Radius', 'microthemer'),
	'auto' => array(
		'%' => $border_radius_unconvertable
	),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
		'root_cat' => 'border_radius'
	),
	'icon' => '19',
	'rel' => 'border_radius',
	'field-class' => 'last',
	'last_in_sub' => 1,
	'important_carrier' => 1,
	// ref
	'ref_desc' => "<p>The bottom right radius property defines the shape of the border of the bottom-right corner. A higher value creates a more rounded curve.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '5' would set the bottom right border radius for an element to 5 pixels (Microthemer automatically adds the 'px' unit if a unit isn't specified). Other commonly used units include 'em' and '%'. So you could enter '5%'."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#feat=border-radius',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/border-radius/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/border-bottom-left-radius',
		'quackit' => 'http://www.quackit.com/css/css3/properties/css_border-bottom-left-radius.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/css3_pr_border-bottom-left-radius.asp',
	),
	'tutorials' => $propertyOptions['border']['border_top_left_radius']['tutorials'],
	'related_tutorials' => $propertyOptions['border']['border_top_left_radius']['sub_label']
);

// behaviour
// ------------------------------------------------------------

$propertyOptions['behaviour']['display'] = array(
	'short_label' => esc_html_x('Display', 'noun', 'microthemer'),
	'label' => esc_attr_x('Display', 'noun', 'microthemer'),
	'pg_label' => esc_attr__('Behaviour', 'microthemer'),
	'sub_label' => esc_html__('Behaviour', 'microthemer'),
	'sub_slug' => 'behaviour',
	'input-class' => 'size-9a',
	'type' => 'combobox',
	'select_options' => array(
		'',
		'block',
		//'flex',
		'inline',
		'inline-block',
		//'inline-flex',
		'inline-table',
		'list-item',
		'run-in',
		'table',
		'table-caption',
		'table-column-group',
		'table-header-group',
		'table-footer-group',
		'table-row-group',
		'table-cell',
		'table-column',
		'table-row',
		'none'
	),
	'icon' => '23, 14',
	// ref
	'ref_desc' => "<p>The display property specifies the type of box an element should generate.</p>",
	'ref_values' => array(
		"block" => "Displays an element as if it were a block level element like a paragraph or heading.",
		//"flex" => "Displays an element as a block-level flex container. New in CSS3",
		"inline" => "Displays an element if it were an inline element like a link or an image.",
		"inline-block" => "Displays an element with all the properties of a block-level element apart from displaying inline with other content (rather than having a row of it's own).",
		//"inline-flex" => "Displays an element as an inline-level flex container. New in CSS3.",
		"inline-table" => "The element is displayed as an inline-level table.",
		"list-item" => "The element behaves like a list item element.",
		"run-in" => "Displays an element as either block or inline, depending on context.",
		"table" => "The element behaves like a table element.",
		"table-caption" => "The element behaves like a caption element.",
		"table-column-group" => "The element behaves like a column group element.",
		"table-header-group" => "The element behaves like a table head element.",
		"table-footer-group" => "The element behaves like a table foot element.",
		"table-row-group" => "The element behaves like a tbody element.",
		"table-cell" => "The element behaves like a td element (useful if you want vertical align to work as expected).",
		"table-column" => "The element behaves like a table column element.",
		"table-row" => "The element behaves like a table row element.",
		"none" => "The element doesn't appear on the page at all. This is different from setting the visibility property to 'hidden' whereby the hidden element still takes up space on the page (it's just invisible)."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/d/display/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/display',
		'quackit' => 'http://www.quackit.com/css/properties/css_display.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_class_display.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://www.css3.com/display/',
			'title' => 'CSS DISPLAY',
		),
		array(
			'url' => 'http://colintoh.com/blog/display-table-anti-hero',
			'title' => 'The Anti-hero of CSS Layout - "display:table"',
		),
	)
);

$propertyOptions['behaviour']['overflow'] = array(
	'short_label' => esc_html__('Overflow', 'microthemer'),
	'label' => esc_attr__('Overflow', 'microthemer'),
	'field-class' => 'icon-size-2',
	'input-class' => 'size-2',
	'type' => 'combobox',
	'select_options' => array(
		'',
		'visible',
		'scroll',
		'auto',
		'hidden'
	),
	'icon' => '20, 14',
	// ref
	'ref_desc' => "<p>The overflow property specifies what happens if content overflows an element's box.</p>",
	'ref_values' => array(
		"visible" => "The overflow is not clipped. It renders outside the element's box. This is default",
		"scroll" => "The overflow is clipped, but a scroll-bar is added to see the rest of the content",
		"auto" => "If overflow is clipped, a scroll-bar should be added to see the rest of the content",
		"hidden" => "The overflow is clipped, and the rest of the content will be invisible"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/o/overflow/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/overflow',
		'quackit' => 'http://www.quackit.com/css/css3/properties/css_overflow.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_pos_overflow.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'https://css-tricks.com/the-css-overflow-property/',
			'title' => 'The CSS Overflow Property',
		),
		array(
			'url' => 'http://marksheet.io/css-height-width-overflow.html',
			'title' => 'Setting fixed dimensions to your rectangles',
		),
		array(
			'url' => 'http://www.wickham43.net/scrollingdivs.php',
			'title' => 'Scrolling divs and overflow: hidden',
		),
	)
);

$propertyOptions['behaviour']['overflow_x'] = array(
	'short_label' => esc_html__('Overflow X', 'microthemer'),
	'label' => esc_attr__('Overflow X', 'microthemer'),
	'field-class' => 'icon-size-2',
	'input-class' => 'size-2',
	'type' => 'combobox',
	'select_options' => array(
		'',
		'visible',
		'scroll',
		'auto',
		'hidden'
	),
	'icon' => '29, 14',
	// ref
	'ref_desc' => "<p>The overflow-x property specifies what happens if content overflows an element's box on the <b>horizontal axis</b>. The same <a href='admin.php?page=tvr-docs.php&prop=overflow&prop_group=behaviour' target='_blank'>overflow values</a> can be used for overflow-x.</p>",
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/o/overflow/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/overflow-x',
		'quackit' => 'http://www.quackit.com/css/css3/properties/css_overflow-x.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/css3_pr_overflow-x.asp',
	),
	'tutorials' => $propertyOptions['behaviour']['overflow']['tutorials'],
	'related_tutorials' => $propertyOptions['behaviour']['overflow']['label']
);

$propertyOptions['behaviour']['overflow_y'] = array(
	'short_label' => esc_html__('Overflow Y', 'microthemer'),
	'label' => esc_attr__('Overflow Y', 'microthemer'),
	'field-class' => 'icon-size-4',
	'input-class' => 'size-2',
	'type' => 'combobox',
	'select_options' => array(
		'',
		'visible',
		'scroll',
		'auto',
		'hidden'
	),
	'icon' => '30, 14',
	// ref
	// ref
	'ref_desc' => "<p>The overflow-y property specifies what happens if content overflows an element's box on the <b>vertical axis</b>. The same <a href='admin.php?page=tvr-docs.php&prop=overflow&prop_group=behaviour' target='_blank'>overflow values</a> can be used for overflow-y.</p>",
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/o/overflow/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/overflow-y',
		'quackit' => 'http://www.quackit.com/css/css3/properties/css_overflow-y.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/css3_pr_overflow-y.asp',
	),
	'tutorials' => $propertyOptions['behaviour']['overflow']['tutorials'],
	'related_tutorials' => $propertyOptions['behaviour']['overflow']['label']
);

$propertyOptions['behaviour']['visibility'] = array(
	'short_label' => esc_html__('Visibility', 'microthemer'),
	'label' => esc_attr__('Visibility', 'microthemer'),
	'type' => 'combobox',
	'field-class' => 'icon-size-2',
	'input-class' => 'size-3',
	'select_options' => array(
		'',
		'visible',
		'hidden',
		'collapse'
	),
	'icon' => '24, 14',
	// ref
	'ref_desc' => "<p>The visibility property specifies whether or not an element is visible. But unlike setting 'display' to 'none', if you set 'visibility' to 'hidden' the hidden element will still take up the same space on the page - it just won't be visible.</p>",
	'ref_values' => array(
		"visible" => "The element is visible. This is default",
		"hidden" => "The element is invisible (but still takes up space)",
		"collapse" => "Only for table elements. collapse removes a row or column, but it does not affect the table layout. The space taken up by the row or column will be available for other content. If collapse is used on other elements, it renders as 'hidden'"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/v/visibility/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/visibility',
		'quackit' => 'http://www.quackit.com/css/properties/css_visibility.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_class_visibility.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://www.tutorialrepublic.com/css-tutorial/css-visibility.php',
			'title' => 'CSS Visibility',
		),
	)
);

$propertyOptions['behaviour']['cursor'] = array(
	'short_label' => esc_html__('Cursor', 'microthemer'),
	'label' => esc_attr__('Cursor', 'microthemer'),
	'field-class' => 'icon-size-0a',
	'input-class' => 'size-3',
	'type' => 'combobox',
	'select_options' => array(
		'',
		'auto',
		'crosshair',
		'default',
		'e-resize',
		'help',
		'move',
		'n-resize',
		'ne-resize',
		'nw-resize',
		'pointer',
		'progress',
		's-resize',
		'se-resize',
		'sw-resize',
		'text',
		'w-resize',
		'wait'
	),
	'icon' => '22, 14',
	// ref
	'ref_desc' => "<p>The cursor property specifies the type of cursor to be displayed when pointing on an element.</p>",
	'ref_values' => array(
		"auto" => "	Default. The browser sets a cursor",
		"crosshair" => "The cursor render as a crosshair",
		"default" => "The default cursor",
		"e-resize" => "The cursor indicates that an edge of a box is to be moved right (east)",
		"help" => "The cursor indicates that help is available",
		"move" => "The cursor indicates something that should be moved",
		"n-resize" => "The cursor indicates that an edge of a box is to be moved up (north)",
		"ne-resize" => "The cursor indicates that an edge of a box is to be moved up and right (north/east)",
		"nw-resize" => "The cursor indicates that an edge of a box is to be moved up and left (north/west)",
		"pointer" => "The cursor render as a pointer",
		"progress" => "	The cursor indicates that the program is busy (in progress)",
		"s-resize" => "The cursor indicates that an edge of a box is to be moved down (south)",
		"se-resize" => "The cursor indicates that an edge of a box is to be moved down and right (south/east)",
		"sw-resize" => "The cursor indicates that an edge of a box is to be moved down and left (south/west)",
		"text" => "The cursor indicates text",
		"w-resize" => "The cursor indicates that an edge of a box is to be moved left (west)",
		"wait" => "The cursor indicates that the program is busy"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=css3%20cursor',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/c/cursor/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/cursor',
		'quackit' => 'http://www.quackit.com/css/properties/css_cursor.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_class_visibility.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://www.sitepoint.com/css3-cursor-styles/',
			'title' => 'Introducing the New CSS Cursor Styles in CSS3',
		),
	)
);

$propertyOptions['behaviour']['opacity'] = array(
	'short_label' => esc_html__('Opacity', 'microthemer'),
	'label' => esc_attr__('Opacity', 'microthemer'),
	'field-class' => 'icon-size-2',
	'input-class' => 'size-0b',
	'icon' => '4, 14',
	// ref
	'ref_desc' => "<p>The opacity property sets the opacity level for an element. You can enter any numeric value between 0 and 1 (e.g. 0.25 or 0.9)</p>",
	'ref_values' => array(
		"(decimal 0 - 1)" => "e.g. '0.5' would set the opacity to 50% (half transparent)."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#feat=css-opacity',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/o/opacity/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/opacity',
		'quackit' => 'http://www.quackit.com/css/css3/properties/css_opacity.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/css3_pr_opacity.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://xahlee.info/js/css_color_opacity.html',
			'title' => 'CSS: Opacity',
		),
		array(
			'url' => 'http://www.tutorialrepublic.com/css-tutorial/css-opacity.php',
			'title' => 'CSS Opacity',
		),
	)
);

$propertyOptions['behaviour']['content'] = array(
	'short_label' => esc_html__('Content', 'microthemer'),
	'label' => esc_attr__('Content', 'microthemer'),
	'last_in_sub' => 1,
	//'field-class' => 'icon-size-2',
	//'input-class' => 'size-0b',
	//'icon' => '4, 14',
	// ref
	'ref_desc' => "<p>The content property is used with the :before and :after pseudo-elements, to insert generated content.</p>",
	'ref_values' => array(
		"normal" => "Default value. Sets the content, if specified, to normal, which default is 'none' (which is nothing)",
		"none" => "Sets the content, if specified, to nothing",
		"counter" => "Sets the content as a counter",
		"attr(attribute)" => "Sets the content as one of the selector's attribute",
		"string" => "Sets the content to the text you specify",
		"open-quote" => "Sets the content to be an opening quote",
		"close-quote" => "Sets the content to be a closing quote",
		"no-open-quote" => "Removes the opening quote from the content, if specified",
		"no-close-quote" => "Removes the closing quote from the content, if specified",
		"url(url)" => "Sets the content to be some kind of media (an image, a sound, a video, etc.)"
	),
	'ref_links' => array(
		'can_i_use' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/content',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/c/content/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/content',
		'quackit' => 'http://www.quackit.com/css/properties/css_content.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_gen_content.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://www.sitepoint.com/understanding-css-content-property/',
			'title' => 'Understanding the CSS ‘content’ Property',
		),
		array(
			'url' => 'http://www.hongkiat.com/blog/pseudo-element-before-after/',
			'title' => 'Understanding Pseudo-Element :before and :after',
		),
		array(
			'url' => 'http://tympanus.net/codrops/2013/07/05/using-custom-data-attributes-and-pseudo-elements/',
			'title' => 'Using Custom Data Attributes and Pseudo-Elements',
		),
	)
);

// position
// ------------------------------------------------------------

$propertyOptions['position']['position'] = array(
	'short_label' => esc_html__('Position', 'microthemer'),
	'label' => esc_attr__('Position', 'microthemer'),
	'pg_label' => esc_attr__('Position', 'microthemer'),
	'sub_label' => esc_html__('Position', 'microthemer'),
	'sub_slug' => 'position',
	'input-class' => 'size-3',
	'type' => 'combobox',
	'select_options' => array(
		'',
		'absolute',
		'relative',
		'fixed',
		'static'
	),
	'icon' => '40, 14',
	// ref
	'ref_desc' => "<p>The position property is used to position an element.</p>",
	'ref_values' => array(
		"absolute" => "Generates an absolutely positioned element, positioned relative to the first parent element that has a position other than static. The element's position is specified with the 'left', 'top', 'right', and 'bottom' properties",
		"relative" => "	Generates a relatively positioned element, positioned relative to its normal position. The element's position is specified with the 'left', 'top', 'right', and 'bottom' properties",
		"fixed" => "Generates an absolutely positioned element, positioned relative to the browser window. The element's position is specified with the 'left', 'top', 'right', and 'bottom' properties",
		"static" => "Default. No position, the element occurs in the normal flow (ignores any top, bottom, left, right, or z-index declarations)"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/p/position/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/position',
		'quackit' => 'http://www.quackit.com/css/properties/css_position.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_class_position.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://learnlayout.com/position.html',
			'title' => 'Learn CSS Layout: position',
		),
		array(
			'url' => 'http://www.elated.com/articles/css-positioning/',
			'title' => 'CSS Positioning',
		),
		array(
			'url' => 'http://learn.shayhowe.com/html-css/positioning-content/#uniquely-positioning-elements',
			'title' => 'Uniquely Positioning Elements',
		),
		array(
			'url' => 'http://www.barelyfitz.com/screencast/html-training/css/positioning/',
			'title' => 'Learn CSS Positioning in Ten Steps',
		),
	),
	'group_tutorials' => 1
);

$propertyOptions['position']['top'] = array(
	'short_label' => esc_html__('Top', 'microthemer'),
	'label' => esc_attr__('Top (Position)', 'microthemer'),
	'default_unit' => 1,
	// not sure if sug_values are useful here, but hey
	'sug_values' => array(
		'this' => 1,
	),
	'icon' => '11',
	// ref
	'ref_desc' => "<p>For absolutely positioned elements, the top property sets the top edge of an element to a unit above/below the top edge of its containing element. For relatively positioned elements, the top property sets the top edge of an element to a unit above/below its normal position. Negative values are allowed.</p>
	<p><b>Note</b>: the way an element moves on screen when you apply a positive 'top' value may seem counterintuitive. It moves down on the screen when given a positive value because the browser increases the distance between the top of the element and some reference point. If in doubt, just look at the direction of the property icon. The icon depicts the direction the element will move on the page as you increase the value for 'top'.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '75' would move an element 75 pixels below the top edge of its parent element (if the element is absolutely positioned), or 75px below it's normal position (if the element is relatively positioned)"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/t/top/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/top',
		'quackit' => 'http://www.quackit.com/css/properties/css_top.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_pos_top.asp',
	),
	'tutorials' => $propertyOptions['position']['position']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['position']['bottom'] = array(
	'short_label' => esc_html__('Bottom', 'microthemer'),
	'label' => esc_attr__('Bottom (Position)', 'microthemer'),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
	),
	'icon' => '12',
	// ref
	'ref_desc' => "<p>For absolutely positioned elements, the bottom property sets the bottom edge of an element to a unit above/below the bottom edge of its containing element. For relatively positioned elements, the bottom property sets the bottom edge of an element to a unit above/below its normal position. Negative values are allowed.</p>
	<p><b>Note</b>: the way an element moves on screen when you apply a positive 'bottom' value may seem counterintuitive. It moves up on the screen when given a positive value because the browser increases the distance between the bottom of the element and some reference point. If in doubt, just look at the direction of the property icon. The icon depicts the direction the element will move on the page as you increase the value for 'bottom'.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '75' would move an element 75 pixels below the bottom edge of its parent element (if the element is absolutely positioned), or 75px below it's normal position (if the element is relatively positioned)"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/b/bottom/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/bottom',
		'quackit' => 'http://www.quackit.com/css/properties/css_bottom.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_pos_bottom.asp',
	),
	'tutorials' => $propertyOptions['position']['position']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['position']['left'] = array(
	'short_label' => esc_html__('Left', 'microthemer'),
	'label' => esc_attr__('Left (Position)', 'microthemer'),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
	),
	'field-class' => 'icon-size-2', // fix alignment in the sprite then remove this fix
	'icon' => '13',
	// ref
	'ref_desc' => "<p>For absolutely positioned elements, the left property sets the left edge of an element to a unit to the
	left or right of the left edge of its containing element. For relatively positioned elements, the left property sets the left edge of an element to a unit to the left or right of its normal position. Negative values are allowed.</p>
	<p><b>Note</b>: the way an element moves on screen when you apply a positive 'left' value may seem counterintuitive. It moves right on the screen when given a positive value because the browser increases the distance between the left of the element and some reference point. If in doubt, just look at the direction of the icon. The icon depicts the direction the element will move on the page as you increase the value for 'left'.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '20' would move an element 20 pixels to the right of the left edge of its parent element (if the element is absolutely positioned), or 20px to the right of it's normal position (if the element is relatively positioned)"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/l/left/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/left',
		'quackit' => 'http://www.quackit.com/css/properties/css_left.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_pos_left.asp',
	),
	'tutorials' => $propertyOptions['position']['position']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['position']['right'] = array(
	'short_label' => esc_html__('Right', 'microthemer'),
	'label' => esc_attr__('Right (Position)', 'microthemer'),
	'default_unit' => 1,
	'sug_values' => array(
		'this' => 1,
	),
	'icon' => '14',
	'field-class' => 'last',
	// ref
	'ref_desc' => "<p>For absolutely positioned elements, the right property sets the right edge of an element to a unit to the left or right of the right edge of its containing element. For relatively positioned elements, the right property sets the right edge of an element to a unit to the left or right of its normal position. Negative values are allowed.</p>
	<p><b>Note</b>: the way an element moves on screen when you apply a positive 'right' value may seem counterintuitive. It moves left on the screen when given a positive value because the browser increases the distance between the right of the element and some reference point. If in doubt, just look at the direction of the icon. The icon depicts the direction the element will move on the page as you increase the value for 'right'.</p>",
	'ref_values' => array(
		"(numeric)" => "e.g. '20' would move an element 20 pixels to the left of the right edge of its parent element (if the element is absolutely positioned), or 20px to the left of it's normal position (if the element is relatively positioned)"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/r/right/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/right',
		'quackit' => 'http://www.quackit.com/css/properties/css_right.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_pos_right.asp',
	),
	'tutorials' => $propertyOptions['position']['position']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['position']['z_index'] = array(
	'short_label' => esc_html__('Z-index', 'microthemer'),
	'label' => esc_attr__('Z-index', 'microthemer'),
	'icon' => '21, 14',
	// ref
	'ref_desc' => "<p>The z-index property specifies the stack order of an element. An element with greater stack order is always in front of an element with a lower stack order. Note: z-index only works on positioned elements (position:absolute, position:relative, or position:fixed).</p>",
	'ref_values' => array(
		"(numeric)" => "If you had 2 absolutely positioned elements that overlapped and you gave element A a z-index value of 5 and element B a z-index value of 10, element B would show in front of element A."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/z/z-index/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/z-index',
		'quackit' => 'http://www.quackit.com/css/properties/css_z-index.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_pos_z-index.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://www.quackit.com/css/tutorial/css_layers.cfm',
			'title' => 'CSS Layers',
		),
		array(
			'url' => 'http://html.net/tutorials/css/lesson15.php',
			'title' => 'Layer on layer with z-index',
		),
		array(
			'url' => 'https://www.smashingmagazine.com/2009/09/the-z-index-css-property-a-comprehensive-look/',
			'title' => 'The Z-Index CSS Property: A Comprehensive Look',
		),
		array(
			'url' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Positioning/Understanding_z_index',
			'title' => 'Understanding CSS z-index',
		),
	)
);

$propertyOptions['position']['float'] = array(
	'short_label' => esc_html__('Float', 'microthemer'),
	'label' => esc_attr__('Float', 'microthemer'),
	'field-class' => 'icon-size-2',
	'input-class' => 'size-0',
	'type' => 'combobox',
	'select_options' => array(
		'',
		'left',
		'right',
		'none'
	),
	'icon' => '18, 14',
	// ref
	'ref_desc' => "<p>The float property specifies whether or not an element should float. An element can either float left or right.</p>",
	'ref_values' => array(
		"left" => "The element floats to the left",
		"right" => "The element floats to the right",
		"none" => "The element is not floated. This is the default."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/f/float/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/float',
		'quackit' => 'http://www.quackit.com/css/properties/css_float.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_class_float.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://phrogz.net/css/understandingfloats.html',
			'title' => 'Understanding Floats. A mini-tutorial on how the CSS float and clear properties work',
		),
		array(
			'url' => 'https://css-tricks.com/all-about-floats/',
			'title' => 'All About Floats',
		),
		array(
			'url' => 'http://www.hongkiat.com/blog/css-floats/',
			'title' => 'CSS Floats Explained in 5 Questions',
		),
		array(
			'url' => 'https://www.smashingmagazine.com/2007/05/css-float-theory-things-you-should-know/',
			'title' => 'CSS Float Theory: Things You Should Know',
		),
		array(
			'url' => 'http://css.maxdesign.com.au/floatutorial/',
			'title' => 'Floatutorial: simple tutorials on CSS floats',
		),
		array(
			'url' => 'http://learn.shayhowe.com/html-css/positioning-content/#floats',
			'title' => 'Positioning with Floats',
		),
	)
);

$propertyOptions['position']['clear'] = array(
	'short_label' => esc_html__('Clear', 'microthemer'),
	'label' => esc_attr__('Clear', 'microthemer'),
	'field-class' => 'icon-size-2',
	'last_in_sub' => 1,
	'input-class' => 'size-0',
	'type' => 'combobox',
	'select_options' => array(
		'',
		'left',
		'right',
		'both',
		'none'
	),
	'icon' => '19, 14',
	// ref
	'ref_desc' => "<p>The clear property specifies which sides of an element where other floating elements are not allowed.</p>",
	'ref_values' => array(
		"left" => "No floating elements allowed on the left side",
		"right" => "No floating elements allowed on the right side",
		"both" => "No floating elements allowed on the left or the right side",
		"none" => "Default. Allows floating elements on both sides"
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#search=CSS%202.1%20properties',
		'css_tricks' => 'https://css-tricks.com/almanac/properties/c/clear/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/clear',
		'quackit' => 'http://www.quackit.com/css/properties/css_clear.cfm',
		'w3s' => 'http://www.w3schools.com/cssref/pr_class_clear.asp',
	),
	'tutorials' => $propertyOptions['position']['float']['tutorials'],
	'related_tutorials' => esc_html__('Float', 'microthemer')
);

// gradient
// ------------------------------------------------------------

$propertyOptions['gradient']['gradient_angle'] = array(
	'sh' => array('gradient', 0),
	'short_label' => esc_html__('Angle', 'microthemer'),
	'label' => esc_attr__('Gradient Angle', 'microthemer'),
	'pg_label' => esc_attr__('Gradient', 'microthemer'),
	'sub_label' => esc_html__('Gradient', 'microthemer'),
	'sub_slug' => 'gradient',
	'field-class' => 'icon-size-2 last',
	'input-class' => 'size-big',
	'type' => 'combobox',
	"select_options" => array(
		"top to bottom",
		"bottom to top",
		"left to right",
		"right to left",
		"top left to bottom right",
		"bottom right to top left",
		"top right to bottom left",
		"bottom left to top right"
	),
	'hide imp' => 1,
	'icon' => '28, 1',
	// ref
	'ref_desc' => "<p>The angle of the gradient. You have 8 options which cover all possible horizontal, vertical and perfectly diagonal variations. Note: old versions of Safari and Chrome (< Chrome 10 and < Safari 5.1) don't properly support diagonal gradients.<p>",
	'ref_values' => array(
		"top to bottom" => "Gradient A blending from top to bottom into Gradient B or C.",
		"bottom to top" => "Gradient A blending from bottom to top into Gradient B or C.",
		"left to right" => "Gradient A blending from left to right into Gradient B or C.",
		"right to left" => "Gradient A blending from right to left into Gradient B or C.",
		"top left to bottom right" => "Gradient A blending from top left to bottom right into Gradient B or C.",
		"bottom right to top left" => "Gradient A blending from bottom right to top left into Gradient B or C.",
		"top right to bottom left" => "Gradient A blending from top right to bottom left into Gradient B or C.",
		"bottom left to top right" => "Gradient A blending from bottom left to top right into Gradient B or C."
	),
	'ref_links' => array(
		'can_i_use' => 'http://caniuse.com/#feat=css-gradients',
		'css_tricks' => 'https://css-tricks.com/css3-gradients/',
		'mozilla' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/linear-gradient',
		'quackit' => 'http://www.quackit.com/css/css3/gradients/linear_gradients.cfm',
		'w3s' => 'http://www.w3schools.com/css/css3_gradients.asp',
	),
	'tutorials' => array(
		array(
			'url' => 'http://www.cssmatic.com/gradient-generator',
			'title' => 'CSSmatic Gradient Generator',
			'tool' => 1
		),
		array(
			'url' => 'http://www.colorzilla.com/gradient-editor/',
			'title' => 'Ultimate CSS Gradient Generator',
			'tool' => 1
		),
		array(
			'url' => 'http://xahlee.info/js/css_gradient.html',
			'title' => 'CSS Linear Gradient Tutorial',
		),
		array(
			'url' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Images/Using_CSS_gradients',
			'title' => 'Using CSS gradients',
		),
	),
	'group_tutorials' => 1
);

$propertyOptions['gradient']['gradient_a'] = array(
	'sh' => array('gradient', 1),
	'short_label' => 'A',
	'label' => esc_attr__('Gradient A', 'microthemer'),
	'field-class' => 'always-label is-picker',
	'input-class' => 'color',
	// note, may need to do some sug_values stuff here if just parsing 'background' isn't the best way to get gradient colors
	'hide imp' => 1,
	'icon' => '25',
	// ref
	'ref_desc' => "<p>One of the color stops in the linear gradient. The color you specify here will gradually blend into the color you specify for Gradient B if you specify one. If you don't specify a color for Gradient B, Gradient A will blend into Gradient C.</p>",
	'ref_values' => array(
		"(hex code or RGB/A)" => "Microthemer provides a color picker for specifying color without having to remember hex codes or RGB/A values. Just click your mouse in the 'Gradient A' text field to reveal the color picker."
	),
	'tutorials' => $propertyOptions['gradient']['gradient_angle']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['gradient']['gradient_b'] = array(
	'sh' => array('gradient', 2),
	'short_label' => 'B',
	'label' => esc_attr__('Gradient B', 'microthemer'),
	'field-class' => 'always-label is-picker',
	'input-class' => 'color',
	'hide imp' => 1,
	'icon' => '25',
	// ref
	'ref_desc' => "<p>One of the color stops in the linear gradient. The color you specify here will gradually blend into Gradient A and C. <b>Gradient B is optional</b>. If you just want to blend 2 colors, you only need to specify a value for Grandient A and C. If you do use it, there is an additional option for Gradient B: 'B Position (optional)'. Click the label for this option for details.</p>",
	'ref_values' => array(
		"(hex code or RGB/A)" => "Microthemer provides a color picker for specifying color without having to remember hex codes or RGB/A values. Just click your mouse in the 'Gradient B' text field to reveal the color picker."
	),
	'tutorials' => $propertyOptions['gradient']['gradient_angle']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['gradient']['gradient_b_pos'] = array(
	'sh' => array('gradient', 3),
	'short_label' => esc_html__('B Position', 'microthemer'),
	'label' => esc_attr__('Gradient B Position', 'microthemer'),
	'field-class' => 'icon-size-0b icon-size-2',
	'auto' => array(
		'%' => 'Pass, this one is tricky.'
	),
	'default_unit' => 1,
	'hide imp' => 1,
	'icon' => '40, 14',
	// ref
	'ref_desc' => "<p>The position of Gradient B in relation to Gradient A. Gradient B is the middle color of the gradient, but it doesn't have to appear exactly in between Gradient A and C. If you were to specify a 'B Position' of 10% (for instance) Gradient B would begin almost immediately after Gradient A. If you were to specify a 'B Position' of 90%, Gradient B wouldn't begin until just before Gradient C. If you leave this setting blank, or specify a value of 50% Gradient B, will be placed exactly between Gradient A and C.</p>",
	'ref_values' => array(
		"(numeric)" => "For consistency, the default unit is pixels. So if you enter 25 it will default to 25px. But it's more common to specify gradient positions in percentages. So you might put 15% (specifying the unit so it doesn't default to pixels)"
	),
	'tutorials' => $propertyOptions['gradient']['gradient_angle']['tutorials'],
	'group_tutorials' => 1
);

$propertyOptions['gradient']['gradient_c'] = array(
	'sh' => array('gradient', 4),
	'short_label' => 'C',
	'label' => esc_attr__('Gradient C', 'microthemer'),
	'field-class' => 'always-label is-picker',
	'input-class' => 'color',
	'icon' => '25',
	'last_in_sub' => 1,
	'important_carrier' => 1,
	// ref
	'ref_desc' => "<p>One of the color stops in the linear gradient. The color you specify here will gradually blend into the color you specify for Gradient B if you specify one. If you don't specify a color for Gradient B, Gradient C will blend into Gradient A.</p>",
	'ref_values' => array(
		"(hex code or RGB/A)" => "Microthemer provides a color picker for specifying color without having to remember hex codes or RGB/A values. Just click your mouse in the 'Gradient C' text field to reveal the color picker."
	),
	'tutorials' => $propertyOptions['gradient']['gradient_angle']['tutorials'],
	'group_tutorials' => 1
);

$extraOptionsReference['CSS3_PIE']['CSS3_PIE'] = array(
	'short_label' => 'CSS3 PIE',
	'label' => 'CSS3 PIE (Progressive Internet Explorer)',
	'field-class' => '',
	'input-class' => '',
	'icon' => '26, 5',
	// ref
	'ref_desc' => "<p>Microthemer comes pre-integrated with CSS3 PIE which can be enabled by on a global or per-selector basis. CSS3 PIE makes Internet Explorer 6-9 render CSS3 properties like gradients, border-radius and box-shadow correctly. We recommend that you visit
		the <a href='http://css3pie.com/' target='_blank'>CSS3 PIE site</a> to learn more about it.</p>
		<p>One of the main drawbacks with PIE is that it is very frequently necessary to give elements a \"position\" value of \"relative\" when also assigning CSS3 properties to them. To make this less tedious, Microthemer automatically applies \"position:relative\" when you set CSS3 properties (if you have enabled CSS3 PIE).</p>
		<p>You can still use PIE and turn off the automatic \"position:relative\" by explictly setting the \"position\" value to something else (e.g. \"static\", \"absolute\" or \"fixed\"). However, sometimes it's better to just not use CSS3 PIE and allow corners to be square or backgrounds to be solid colors in old Internet Explorer versions that don't support CSS3 properties.</p>
		<p><b>Some Known PIE Shortcomings</b></p>

		<ul>
			<li>PIE does not currently work when applied to the \"body\" Selector</li>
			<li>Element types that cannot accept children (e.g. \"input\" and \"img\") will fail or throw errors if you apply styles that use relative length units such as em or ex. Stick to using px units for these elements (Microthemer automatically applies \"px\" to numerical values if no unit is set - apart from line-height as it is a valid (and useful) not to include a unit).</li>
			<li>There is another work around that avoids the \"position:relative\" fix mentioned above. You can make the ancestor element \"position:relative\" and give it a z-index. An ancester element is an element that contains another element. With WordPress, the \"post\" element will be the \"ancester\" of any content inside the post such as text, meta information, and images.</li>
		</ul>
		<br />
		<p><b>Donate to PIE:</b> PIE is Free for everyone. Please consider <a href='http://css3pie.com/' target='_blank'>donating to the PIE project</a> if it has helped you.</p>",
	'ref_values' => '',
);


// log moved groups/properties
// ------------------------------------------------------------

$legacy_groups['font'] = array(
	'forecolor' => array(
		'color' => 1 // 1 means same as key
	),
	'text' => array(
		'line_height' => 1,
		'text_decoration' => 1
	)
);

$legacy_groups['list'] = array(
	'text' => array(
		'list_style' => 'list_style_type' // define string when different
	)
);

$legacy_groups['shadow'] = array(
	'text' => array(
		'text_shadow_color' => 1,
		'text_shadow_x' => 1,
		'text_shadow_y' => 1,
		'text_shadow_blur' => 1
	),
	'CSS3' => array(
		'box_shadow_color' => 1,
		'box_shadow_x' => 1,
		'box_shadow_y' => 1,
		'box_shadow_blur' => 1
	)
);

/* // to be reliable, this needs to merge the value into one
$legacy_groups['background'] = array(
	'background' => array(
		'background_position_x' => 1,
		'background_position_y' => 1
	)
);
*/

$legacy_groups['padding_margin'] = array(
	'padding' =>array(
		'padding_top' => 1,
		'padding_right' => 1,
		'padding_bottom' => 1,
		'padding_left' => 1
	),
	'margin' => array(
		'margin_top' => 1,
		'margin_right' => 1,
		'margin_bottom' => 1,
		'margin_left' => 1
	)
);

$legacy_groups['border'] = array(
	'border' => array(
		'border_style' => array( // the only array - when the legacy value maps onto multiple props
			'border_top_style',
			'border_right_style',
			'border_bottom_style',
			'border_left_style'
		)
	),
	'CSS3' => array(
		'radius_top_left' => 'border_top_left_radius',
		'radius_top_right' => 'border_top_right_radius',
		'radius_bottom_right' => 'border_bottom_right_radius',
		'radius_bottom_left' => 'border_bottom_left_radius'
	)
	/* was only moved temp - version not released
	'border' => array(
		'radius_top_left',
		'radius_top_right',
		'radius_bottom_right',
		'radius_bottom_left'
	)*/
);

$legacy_groups['position'] = array(
	'behaviour' => array(
		'float' => 1,
		'clear' => 1
	)
);

$legacy_groups['gradient'] = array(
	'CSS3' => array(
		'gradient_a' => 1,
		'gradient_b' => 1,
		'gradient_b_pos' => 1,
		'gradient_c' => 1,
		'gradient_angle' => 1
	)
);
