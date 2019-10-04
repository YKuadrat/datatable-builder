<?php

return [
	'elOptions' => [
		'class' => "table table-striped table-bordered"
	],
	'pluginOptions' => [
		"pagingType" => "numbers",
		"ajax" => [
			"type" => "POST"
		]
	],
	'buttonTemplates' => [
		'edit' => '<a href="<<url>>" class="btn btn-primary" title="Edit details"> Edit </a>',
		'delete' => '<a href="<<url>>" class="btn btn-danger" title="Delete"> Delete </a>',
		'view' => '<a href="<<url>>" class="btn btn-success" title="View"> View </a>'
	]
];