<?php
// Stop direct call
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
	die('Please do not call this page directly.');
}

// save prop data in smaller var
$prop_data = $this->propertyoptions[$property_group_name][$property];

// is it a custom editor
$is_editor = false;
if (!empty($prop_data['type']) and $prop_data['type'] == 'editor'){
	$is_editor = true;
}

// add media query stem for form fields if necessary
$sel_imp_array = array();
$styles = array();
if ($con == 'mq') {
	if (!empty($this->options['non_section']['m_query'][$key][$section_name][$css_selector]['styles'])){
		$styles = $this->options['non_section']['m_query'][$key][$section_name][$css_selector]['styles'];
	}
	$mq_stem = '[non_section][m_query]['.$key.']';
	$imp_key = '[m_query]['.$key.']';
	$mq_extr_class = '-'.$key;
	// get the important val
	if (!empty($this->options['non_section']['important']['m_query'][$key][$section_name][$css_selector][$property_group_name][$property])) {
		$important_val = $this->options['non_section']['important']['m_query'][$key][$section_name][$css_selector][$property_group_name][$property];
	} else {
		$important_val = '';
	}
	// save the general selector important array for querying if legacy values are discovered
	if (!empty($this->options['non_section']['important']['m_query'][$key][$section_name][$css_selector])){
		$sel_imp_array = $this->options['non_section']['important']['m_query'][$key][$section_name][$css_selector];
	}

} else {
	if (!empty($this->options[$section_name][$css_selector]['styles'])){
		$styles = $this->options[$section_name][$css_selector]['styles'];
	}
	$mq_stem = '';
	$imp_key = '';
	$mq_extr_class = '-all-devices';
	// get the important val
	if ( !empty($this->options['non_section']['important'][$section_name][$css_selector][$property_group_name][$property])) {
		$important_val = $this->options['non_section']['important'][$section_name][$css_selector][$property_group_name][$property];
	} else {
		$important_val = '';
	}
	// save the general selector important array for querying if legacy values are discovered
	if (!empty($this->options['non_section']['important'][$section_name][$css_selector])){
		$sel_imp_array = $this->options['non_section']['important'][$section_name][$css_selector];
	}

}


// check if legacy value for prop exists
$legacy_adjusted = $this->populate_from_legacy_if_exists($styles, $sel_imp_array, $property);
if ($legacy_adjusted['value']){
	$value = $legacy_adjusted['value'];
	$important_val = $legacy_adjusted['imp'];
}

// account for old PHP versions with magic quotes
$value = $this->stripslashes($value);

/***
 * get variables from the config file
 */

// field class
$field_class = '';
if (!empty($prop_data['field-class']) ) {
	$field_class = $prop_data['field-class'];
}

// if combobox - replaces all select menus, for better styling and user flexibility
$combo_class = 'combobox'; // all should be comboboxes as some have suggested values
$combo_arrow = '';
if (
	!empty($prop_data['type']) and
	$prop_data['type'] == 'combobox') {
	$combo_class = 'combobox has-arrows';
	$combo_arrow = '<span class="combo-arrow"></span>';
}

// determine if the user has applied a value for this field, adjust comp class accordingly
$comp_class = 'comp-style cprop-' . str_replace('_', '-', $property);
if (!empty($value) or $value === 0 or $value === '0') {
	$man_class = ' manual-val';
	$comp_class.= ' hidden';
} else {
	$man_class = '';
}

// check if input is eligable for autofill
if (!empty($prop_data['rel'])) {
	$autofill_class = 'autofillable ';
	$autofill_rel = $prop_data['rel'];
}
else {
	$autofill_class = '';
	$autofill_rel = '';
}

// input class
$input_class = '';
if (!empty($prop_data['input-class']) ) {
	$input_class = $prop_data['input-class'];
}


// input icon or just text
$text_label = '<span class="text-label css-info">'
	. $prop_data['short_label']
	. '</span>';
/*if (!empty($prop_data['icon'])){
	$option_icon = '<span class="o-icon-wrap"><span class="tvr-icon option-icon option-icon-'.$property.'"></span></span>';
} else {
	$option_icon = '';
}*/

$option_icon = '<span class="o-icon-wrap"><span class="tvr-icon option-icon option-icon-'.$property.'"></span></span>';

/** Deal with property exceptions */
$extra_icon = '';
$input_name_adj = '';
$image_field = false;
// add image insert button for bg image
if ($property == 'background_image' or $property == 'list_style_image') {
	$extra_icon = ' <span class="tvr-icon tvr-image-upload"></span>';
	$input_name_adj = 'img_display';
	$image_field = true;
}
// strip font-family custom quotes for legacy reasons
if ($property == 'font_family') {
	$value = str_replace('cus-#039;', '&quot;', $value);
}
// allow user to edit their google fonts with a link
if ($property == 'google_font') {
	$extra_icon = '<span class="g-font tvr-icon" title="Edit Google Font"></span>';
	// hide if background positon isn't set to custom
	if ($property_group_array['font_family'] != 'Google Font...') {
		$field_class.= ' hidden';
	}
}

// get the property label
$prop_label = $prop_data['label'];

// adjust for lang
if ($this->preferences['tooltip_en_prop']){
	$valid_syntax = str_replace('_', '-', $property);
	// for english, the valid syntax is so similar to the capitalised label that we should just show the valid syntax
	// showing the valid syntax is now the default preference
	if ($this->is_en()){
		$prop_label = $valid_syntax;
	} else {
		$prop_label.= ' / '.$valid_syntax;
	}
}

// exception for google-font
$prop_label = ($prop_label == 'google-font') ? 'font-family': $prop_label;


/***
 * output the form fields
 */

// check if it's a new sub group
$sub_label_html = '';
if (!empty($prop_data['sub_label'])){
	$subgroup_label = $prop_data['sub_label'];

	// save subgroup in global var for following iterations
	$this->subgroup = $prop_data['sub_slug'];
	$disabled = false;
	$dis_class = '';
	if (!empty($array['pg_disabled'][$this->subgroup])) {
		$disabled = true;
		$dis_class.= ' item-disabled';
	}
	// disable icon
	$sub_dis_icon = $this->icon_control(
		'disabled',
		$disabled,
		'subgroup',
		$section_name,
		$css_selector,
		$key,
		$property_group_name,
		$this->subgroup
	);

	// clear icon
	$sub_clear_icon = $this->clear_icon('subgroup');

	// chain icon
	$chained = false;
	if (!empty($array['pg_chained'][$this->subgroup])) {
		$chained = true;
	}

	$sub_chain_icon = $this->icon_control(
		'chained',
		$chained,
		'subgroup',
		$section_name,
		$css_selector,
		$key,
		$property_group_name,
		$this->subgroup);

	// info icon - just for editor
	// if editor, just show icon
	$info_icon = '';
	$colon = ':';
	if ($is_editor){
		$mode_icon = $this->preferences['allow_scss'] ? 'scss' : 'css';
		$subgroup_label = '<span class="'.$mode_icon.'-icon tvr-icon">'.$prop_data['sub_label'].'</span>';
		$info_icon = '<span class="tvr-icon info-icon css-info" rel="program-docs"
		title="'.esc_attr__('Click for info', 'microthemer').'"
				data-prop-group="'.$property_group_name.'" data-prop="'.$property.'"></span>';
		$colon = '';
	}

	// manual resize icon
	$manual_resize_icon = $this->manual_resize_icon('inline-editor');

	$opening_sub_label = '<div id="opts-'.$section_name.'-'.$css_selector.'-'.$property_group_name.'-'.$this->subgroup.'-subgroup'.$mq_extr_class.'"
	class="field-wrap sub-label sub-label-'.$property.' subgroup-tag">';

	// sub label html
	$sub_label_html = $opening_sub_label;

		$sub_label_html.= '
		<span class="quick-opts-wrap tvr-fade-in'.$dis_class.'">
			<span class="subgroup-label">'. $subgroup_label . '</span>'.$colon.'
			<span class="quick-opts">
				<div class="quick-opts-inner">'
				. ($is_editor ? $this->save_icon() : '')
				. $sub_dis_icon
				. $sub_clear_icon
				. ($is_editor ? $this->manual_resize_icon('inline-code') : '')
				. $info_icon
				. '
				</div>
			</span>
		</span>';

		// do we need a chain icon?
		if (!empty($prop_data['rel'])){
			//$rel = $prop_data['rel'];
			$sub_label_html.= $sub_chain_icon;
		}
		$sub_label_html.= '
	</div>';
}

// add to $field_class manually as class crops up in unwanted places if set via property-optioins.inc.php
if ($is_editor){
	$field_class.= ' tvr-editor-area';
}

// opening field wrap html
$field_wrap_html = '<div id="opts-'.$section_name.'-'.$css_selector.'-'.$property_group_name.'-'.$this->subgroup.'-'.$property. $mq_extr_class. '"
 class="property-tag field-wrap tvr-clearfix subgroup-'.$this->subgroup.' '.$man_class . ' '.$field_class
	. ' field-'.$property_group_name.'-'.$property.'">';


	// render custom code editor
	if ($is_editor){

		// jquery $.ajax returns data that is already escaped, so set double encoding to false
		$css_code = htmlentities($value, ENT_QUOTES, 'UTF-8', false);

		$html.= $field_wrap_html . $option_icon  . '<span class="option-label css-info link" rel="program-docs"
				data-prop-group="'.$property_group_name.'" data-prop="'.$property.'">'.$prop_data['label'].'</span>' ;

		// set editor
		$ed_id = 'ed-opts-'. $section_name.'-'.$css_selector.'-'.$property_group_name.'-'.$this->subgroup.'-'.$property. $mq_extr_class;
		$html.= '
		<div class="css-code-wrap">
			<textarea autocomplete="off" rel="'.$property.'" class="property-input '.$input_class . '" name="tvr_mcth'.$mq_stem.'['.$section_name.']['.$css_selector.'][styles]['.$property_group_name.']['. $property.$input_name_adj.']">'.$css_code.'</textarea>

			<pre id="'.$ed_id.'" class="custom-css-pre pg-css-styles"></pre>

		</div>';

		$html.= '</div><!-- end field-wrap -->'
		. $sub_label_html ;

	}

	// render normal property input
	else {

		// output any subgroup label
		$html.= $sub_label_html;

		// start the field div
		$html.= $field_wrap_html;

		// show the property icon, with quick options
		$html.= '
		<label class="quick-opts-wrap tvr-fade-in">';

		$html.= $option_icon . $text_label;

		$html.= '
		<span class="quick-opts">
			<div class="quick-opts-inner">
				<span class="option-label css-info link" rel="program-docs"
				data-prop-group="'.$property_group_name.'" data-prop="'.$property.'">'.$prop_label.'</span>
				<span class="option-value"></span>
				<div class="comp-mixed-wrap">
					<table class="comp-mixed-table">
						<tbody></tbody>
					</table>
				</div>
			</div>
		</span>';

		$html.= '
		</label>'

		. '<span class="tvr-input-wrap">';


		if ($image_field){
			$html.= '
				<span class="tvr-icon clear-bg-image delete-icon"></span>
				<input type="hidden"
				class="property-input image-url-store '.$input_class . '"
				name="tvr_mcth'.$mq_stem.'['.$section_name.']['.$css_selector.'][styles]['.$property_group_name.']['. $property.']" value="'.$value.'" />';
			// now only show filename
			$value = basename($value);
		}

		// render combobox
		$html.= '
	<input type="text" autocomplete="off" rel="'.$property.'" data-autofill="'.$autofill_rel.'"
	class="property-input '.$combo_class.' '.$input_class . ' ' . $autofill_class . ' ' . $input_name_adj .'"
	name="tvr_mcth'.$mq_stem.'['.$section_name.']['.$css_selector.'][styles]['.$property_group_name.']['. $property.$input_name_adj.']" value="'.$value.'" />'.$combo_arrow;

		$html.= $extra_icon;

		$html.= '<span class="'.$comp_class.'"></span>

	</span>'; // end input wrap

		$html.= $this->icon_control('important', $important_val, 'property', $section_name,
			$css_selector, $key, $property_group_name, $this->subgroup, $property);

		$html.= '</div><!-- end field-wrap -->';
	}



if (
!empty($prop_data['linebreak']) and
$prop_data['linebreak'] == '1' ) {
	$html.= '<div class="clear"></div>';
}