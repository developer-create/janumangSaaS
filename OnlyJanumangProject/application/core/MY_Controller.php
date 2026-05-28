<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    // Common properties that older CI code often attaches dynamically
    public $benchmark;
    public $hooks;
    public $config;
    public $log;
    public $utf8;
    public $uri;
    public $exceptions;
    public $router;
    public $output;
    public $security;
    public $input;
    public $lang;
    public $db;
    public $session;
    public $form_validation;
    public $agent;
    // Add any models you load as properties here to avoid dynamic creation notices
    public $login_model;
    public $Log_model;

    public function __construct()
    {
        parent::__construct();
        // nothing else required — this simply gives the properties a declared slot
    }
}
