<?php
if (isset($_GET["view"])) {
	if ($_GET["view"] === "posts") {
		require "posts.php";
	}
	elseif ($_GET["view"] === "comments") {
		require "comments.php";
	}
	elseif ($_GET["view"] === "tags") {
		require "tags.php";
	}
	elseif ($_GET["view"] === "addPost") {
		require 'add_post.php';
	}
}
else {
	require "dashbord.php";
}