<?php

/*
Plugin Name: WpCrud Test
Plugin URI: http://github.com/limikael/wpcrud
GitHub Plugin URI: http://github.com/limikael/wpcrud
Description: Test for WpCrud. This is a library not a plugin! It exploses itself as a plugin for testing purposes only!
Version: 0.0.1
*/

require_once __DIR__."/WpCrud.php";

class WpCrudTest extends WpCrud {

	function init() {
		$this->addField("text")
			->description("this is a field");

		$this->addField("stamp")
			->type("timestamp")
			->description("this is a timestamp");

		$this->addField("sel")
			->type("select")
			->options(array(
				"a"=>"First Letter",
				"b"=>"Second Letter"
			));
	}

	function getItem($id) {
		global $wpdb;

		$row=$wpdb->get_row($wpdb->prepare(
			"SELECT * FROM {$wpdb->prefix}crudtest ".
			"WHERE  id=%s",
			$id
		));

		if ($wpdb->last_error)
			throw new Exception($wpdb->last_error);

		return $row;
	}

	function saveItem($item) {
		global $wpdb;

		if ($item->id) {
			$wpdb->query($wpdb->prepare(
				"UPDATE {$wpdb->prefix}crudtest ".
				"SET    text=%s, ".
				"       stamp=%s, ".
				"       sel=%s ".
				"WHERE  id=%s",
				$item->text,
				$item->stamp,
				$item->sel,
				$item->id
			));
		}

		else {
			$wpdb->query($wpdb->prepare(
				"INSERT INTO {$wpdb->prefix}crudtest ".
				"SET         text=%s, ".
				"            stamp=%s, ".
				"            sel=%s ",
				$item->text,
				$item->stamp,
				$item->sel
			));
		}

		if ($wpdb->last_error)
			throw new Exception($wpdb->last_error);
	}

	function deleteItem($item) {
		global $wpdb;

		$wpdb->query($wpdb->prepare(
			"DELETE FROM {$wpdb->prefix}crudtest ".
			"WHERE  id=%s",
			$item->id
		));

		if ($wpdb->last_error)
			throw new Exception($wpdb->last_error);
	}

	function getAllItems() {
		global $wpdb;

		$results=$wpdb->get_results($wpdb->prepare(
			"SELECT * FROM {$wpdb->prefix}crudtest ",
			NULL
		));

		if ($wpdb->last_error)
			throw new Exception($wpdb->last_error);

		return $results;
	}
}

function wpcrudtest_activate() {
	global $wpdb;

	$wpdb->query($wpdb->prepare(
		"CREATE TABLE IF NOT EXISTS {$wpdb->prefix}crudtest ( ".
		"    id INTEGER NOT NULL auto_increment, ".
		"    text VARCHAR(255) NOT NULL, ".
		"    stamp INTEGER NOT NULL, ".
		"    sel VARCHAR(255) NOT NULL, ".
		"    PRIMARY KEY (id) ".
		")",
		NULL
	));

	if ($wpdb->last_error)
		throw new Exception($wpdb->last_error);
}

function wpcrudtest_deactivate() {
	global $wpdb;

	$wpdb->query($wpdb->prepare(
		"DROP TABLE IF EXISTS {$wpdb->prefix}crudtest",
		NULL
	));

	if ($wpdb->last_error)
		throw new Exception($wpdb->last_error);
}

register_activation_hook(__FILE__, "wpcrudtest_activate");
register_deactivation_hook(__FILE__, "wpcrudtest_deactivate");

WpCrudTest::setup();
