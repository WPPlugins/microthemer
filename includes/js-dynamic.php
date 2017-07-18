<?php
/* This PHP file will be enqueued (indirectly) as if it were a regular javascript file.
It contains JS arrays/objects that change as the user updates their settings in Microthemer.
These include: media queries, default CSS units, suggested values, design packs...
*/

$data = '';

// Only run performance functions if dev_mode is enabled
$dev_mode = TVR_DEV_MODE ? 'true' : 'false';
$data.= 'TVR_DEV_MODE = ' . $dev_mode . ';' . "\n\n";

// add the design pack directories to the TvrMT.data.prog.combo object already defined in the static version JS file
$directories = array();
foreach ($this->file_structure as $dir => $array) {
	if (!empty($dir)) {
		$directories[] = $this->readable_name($dir);
	}
}
$data.= 'TvrMT.data.prog.combo.directories = ' . json_encode($directories) . ';' . "\n\n";

// the last 20 custom site preview URLs the user enters are saved in DB
$data.= 'TvrMT.data.prog.combo.custom_paths = ' . json_encode($this->preferences['custom_paths']) . ';' . "\n\n";

// ready combo for MQ and CSS unit sets (dynamic so they can be translated)
foreach ($this->mq_sets as $set => $junk){
	$mq_sets[] = $set;
}
$data.= 'TvrMT.data.prog.combo.mq_sets = ' . json_encode($mq_sets) . ';' . "\n\n";

// import css files for quick navigation
$data.= 'TvrMT.data.prog.combo.viewed_import_stylesheets = ' . json_encode($this->preferences['viewed_import_stylesheets']) . ';' . "\n\n";

// user's current media queries (combined with All Devices)
$data.= 'var TvrMQsCombined = ' . json_encode($this->combined_devices()) . ';' . "\n\n";

// full preferences (can replace the above)
$data.= 'TvrMT.data.dyn.pref = ' . json_encode($this->preferences) . ';' . "\n\n";

// just sels (going for the full ui)
//$data.= 'window.TvrMT.sels = ' . json_encode($this->sel_lookup) . ';' . "\n\n";

// the full ui options in JS form. Later, this will be used for speed optimisations
$data.= 'TvrMT.data.dyn.ui = ' . json_encode($this->options) . ';' . "\n\n";

// output JS
echo $data;
