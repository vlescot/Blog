<?php
if (isset($_GET["v"])) {
	if ($_GET["v"] === "posts") {
		require "posts.php";
	}
	elseif ($_GET["v"] === "comments") {
		require "comments.php";
	}
	elseif ($_GET["v"] === "tags") {
		require "tags.php";
	}
	elseif ($_GET["v"] === "addPost") {
		require 'add_post.php';
	}
}
else {
	require "dashbord.php";
}