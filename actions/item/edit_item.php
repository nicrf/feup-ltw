<?php
require_once(dirname(__FILE__) . "/../../includes/common/only_allow_login.php");
verifyCSRF();

require_once(dirname(__FILE__) . "/../../includes/common/check_request.php");
verifyAttributes($_POST, ["itemId", "action"]);

require_once(dirname(__FILE__) . "/../../classes/Item.php");
require_once(dirname(__FILE__) . "/../../classes/TodoList.php");

$result = array("success" => false);

$item = new Item();

if (!in_array($_POST["action"], ["completed", "content"])) {
	$result["errors"] = array("Invalid action supplied");
} else {
	if ($item->load($_POST["itemId"])) {
		$item->todoListId;
		if ($item->verifyOwnership($_SESSION["userId"])) {
			//validate the answer
			if ($_POST["action"] == "completed") {
				verifyAttributes($_POST, ["completed"]);
				$item->completed = $_POST["completed"] == "false" ? 0 : 1;
			} else if ($_POST["action"] == "content") {
				verifyAttributes($_POST, ["content"]);
				$item->content = $_POST["content"];
			}
			//update the correct parameter
			if ($item->update() !== false) {
				$result["success"] = true;
			} else {
				$result["errors"] = array("Could not update item");
			}
		} else {
			$result["errors"] = array("User has no permission to access Todo List");
		}
	} else {
		$result["errors"] = array("Could not load Item");
	}
}
echo json_encode($result);