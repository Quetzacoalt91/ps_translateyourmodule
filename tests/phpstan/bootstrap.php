<?php
/**
 * 2007-2020 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */
$rootDir = getenv('_PS_ROOT_DIR_');
if (!$rootDir) {
    echo '[ERROR] Define _PS_ROOT_DIR_ with the path to PrestaShop folder' . PHP_EOL;
    exit(1);
}
$pathToModuleRoot = __DIR__ . '/../../';
// Add module composer autoloader
require_once $pathToModuleRoot . 'vendor/autoload.php';
// Add PrestaShop composer autoload
define('_PS_ADMIN_DIR_', $rootDir . '/admin-dev/');
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_);
require_once $rootDir . '/config/defines.inc.php';
require_once $rootDir . '/config/autoload.php';
require_once $rootDir . '/config/bootstrap.php';
// Make sure loader php-parser is coming from php stan composer
// 1- Use with Docker container
$loader = new \Composer\Autoload\ClassLoader();
$loader->setPsr4('PhpParser\\', ['/composer/vendor/nikic/php-parser/lib/PhpParser']);
$loader->register(true);
// 2- Use with PHPStan phar
$loader = new \Composer\Autoload\ClassLoader();
// Contains the vendor in phar, like "phar://phpstan.phar/vendor"
$loader->setPsr4('PhpParser\\', ['phar://' . dirname($_SERVER['PATH_TRANSLATED']) . '/../phpstan/phpstan-shim/phpstan.phar/vendor/nikic/php-parser/lib/PhpParser/']);
$loader->register(true);
// We must declare these constant in this boostrap script.
// Ignoring the error partern with this value will throw another error if not found
// during the checks.
$constantsToDefine = [
  '_DB_SERVER_',
  '_DB_NAME_',
  '_DB_USER_',
  '_DB_PASSWD_',
  '_MYSQL_ENGINE_',
  '_COOKIE_KEY_',
  '_COOKIE_IV_',
  '_PS_VERSION_',
  '_DB_PREFIX_',
  '_PS_SSL_PORT_',
  '_THEME_NAME_',
  '_THEME_COL_DIR_',
  '_PS_MODULE_DIR_',
  '_PS_THEME_DIR_',
  '_PARENT_THEME_NAME_',
  '__PS_BASE_URI__',
  '_MODULE_DIR_',
];
foreach ($constantsToDefine as $constant) {
    if (!defined($constant)) {
        define($constant, 'DUMMY_VALUE');
    }
}
