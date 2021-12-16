<?php

defined('CORE') or (header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden") and die('403.14 - Access denied.'));

/**
 * A core object that provides access to libraries of the framework.
 * A core is a singleton object that should be accessed from its
 * static instance method.
 */

class Core {

  private static $instance;

  private $autoloader;
  private $config;
  private $uri;
  private $language;

  const AUTOLOADER = "autoloader";
  const CONFIG     = "config";
  const URI        = "uri";
  const LANGUAGE   = "language";

  public static function instance($coreConfig = null) {
    if (!Core::$instance) Core::$instance = new Core($coreConfig);
    else return Core::$instance;
  }

  private function __construct($coreConfig = null) {

    // load the autoloader...
    require_once CORE_LIB_PATH . 'CoreAutoloader.php';

    // instantiate core-class libraries
    $this->autoloader = CoreAutoloader::instance();
    $this->config     = CoreConfig::instance($coreConfig);
    $this->uri        = CoreUri::instance($coreConfig);

    // set default timezone
    date_default_timezone_set($coreConfig['runtime']['default_timezone']);

    // set error reporting mode according to environment setting
    error_reporting($coreConfig['runtime']['environment'] == 'DEV' ? E_ALL : 0);
  }

  public static function lib($lib) {
    return (Core::instance())->getLib($lib);
  }

  private function getLib($lib) {
    switch ($lib) {
      case Core::AUTOLOADER:
        return $this->autoloader;
      case Core::CONFIG:
        return $this->config;
      case Core::URI:
        return $this->uri;
      case Core::LANGUAGE:
        // this library is not mandatory, so instantiate here, only when necessary.
        return $this->language ? $this->language : CoreLanguage::instance();
    }
  }
}