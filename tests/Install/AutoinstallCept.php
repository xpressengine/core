<?php
use \Codeception\Configuration;

$I = new InstallTester($scenario);

$config = (!$this->env) ? Configuration::suiteSettings('Install', Configuration::config()) : Configuration::suiteEnvironments('Install')[$this->env];

$db_config = $config['modules']['config']['Db'];

$dsn = $db_config['dsn'];
$dsn = preg_split('/[;:]/', $dsn);
$db_type = array_shift($dsn);

if($db_type === 'mysql' || $db_type === 'mysql_innodb')
{
	if(!function_exists('mysql_connect') && function_exists('mysqli_connect'))
	{
		$db_type = ($db_type === 'mysql') ? 'mysqli' : 'mysql_innodb';
	}
}

$dbinfo = [
    'type' => $db_type,
    'user' => $db_config['user'],
    'password' => $db_config['password'],
    'port' => ((isset($db_config['port']) && $db_config['port'])?: 3306),
];
foreach($dsn as $piece) {
    list($key, $val) = explode('=', $piece);
    $dbinfo[$key] = $val;
}

$install_config = array(
    'db_type' => $dbinfo['type'],
    'db_port' => $dbinfo['port'],
    'db_hostname' => $dbinfo['host'],
    'db_userid' => $dbinfo['user'],
    'db_password' => $dbinfo['password'],
    'db_database' => $dbinfo['dbname'],
    'db_table_prefix' =>'xe',
    'use_rewrite' =>'N',
    'time_zone' =>'0900',
    'email_address' =>'admin@admin.net',
    'password' =>'admin1@3',
    'password2' =>'admin1@3',
    'nick_name' =>'admin',
    'user_id' =>'admin',
    'lang_type' => 'ko',
);

$install_config = '<' . '?php $install_config = ' . var_export($install_config, true) . ';';

$I->wantTo('Auto install');
$I->writeToFile(_XE_PATH_ . 'config/install.config.php', $install_config);
$I->amOnPage('/');

$I->dontSeeElement('//div[@id="progress"]/ul/li');
$I->amOnPage('/index.php?act=dispMemberLoginForm');

$I->fillField('user_id', 'admin@admin.net');
$I->submitForm('.login-body form', [
    'act' => 'procMemberLogin',
    'user_id' => 'admin@admin.net',
    'password' => 'admin1@3',
    'success_return_url' => '/index.php?module=admin'
]);

$I->seeInCurrentUrl('module=admin');
$I->seeElement('#gnbNav');
$I->seeElement('#content .x_page-header');
$I->see('설치 환경 수집 동의', 'h2');

