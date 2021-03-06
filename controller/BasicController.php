<?php

require_once 'model/Manager.php';
require_once 'model/UserManager.php';
require_once 'model/EventManager.php';

function index() {
	if (Manager::checkUserLoggedIn($_SESSION)) {
		$manager = new EventManager();
		$dataEvents = $manager->getEvents($_SESSION['id']);
		require_once 'view/eventsView.php';
	} else {
		require_once 'view/indexView.php';
	}
}

function register() {
	if (Mangager::checkUserLoggedIn($_SESSION)) {
		require_once 'view/indexView.php';
	} else {
		require_once 'view/registerView.php';
	}
}

function auth($data) {
	if (empty($data['login']) || empty($data['pwd'])) {
		header('Location: index.php');
	} else {
		$manager = new UserManager();
		$manager->connectUser($data['login'], $data['pwd']);
		header('Location: index.php');
	}
}

function setEvent($data) {
	if (empty($data['titre']) || empty($data['date']) || empty($data['lieu'])) {
		header('Location: index.php');
	} else {
		$manager = new EventManager();
		$manager->setEvent($data);
	}
}

function invit() {
	require_once 'view/invitationView.php';
}

function addUser($data) {
	if (empty($data['login']) || empty($data['pwd']) || empty($data['nom'])) {
		require_once 'view/indexView.php';
	} else {
		$manager = new UserManager();
		$manager->setUser($data);
	}
}

function event($data, $link) {
	$manager = new EventManager();
	if (empty($link['link'])) {
		header('Location: index.php');
	}
	$dataEvent = $manager->getEvent($link['link']);
	$dataInfo = $manager->getEvent($link['link']);
	require_once 'view/eventView.php';
}

function logout() {
	session_destroy();
	header("location: index.php");
	exit(); 
}

function joinEvent($data) {
	$manager = new EventManager();
	$manager->joinEvent($data);
	header('Location: index.php');
}

function create() {
	if (!Manager::checkUserLoggedIn($_SESSION)) {
		header('Location: index.php');
	}
	require_once 'view/editEventView.php';
}