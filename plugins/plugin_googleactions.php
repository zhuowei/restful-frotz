<?php
require("actionlib.php");
function handler_input(array &$params) {
	if (getIntent() === "assistant.intent.action.TEXT") {
		$command = getRawInput();
	} else {
		$command = "";
	}
	$params["command"] = $command;
	$params["session_id"] = sha1(getUser()["user_id"]);
	$params["data_id"] = "zork1";
}
function handler_output(array $data) : array {
	$output = $data["error"]? $data["error"]: $data["title"] . "\n" . $data["message"];
	ask(buildInputPrompt(false, $output, ["Say a command such as \"look\""]),"42");
	return ["ok" => true];
}
function handler_error(string $error) {
	error_log("restful-frotz [googlehome] error: ".$error);
	ask(buildInputPrompt(false, $error, ["Say a command such as \"look\""]), "42");
}
