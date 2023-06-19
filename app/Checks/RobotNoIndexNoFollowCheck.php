<?php

namespace app\Checks;

use BeyondCode\SelfDiagnosis\Checks\Check;
use Illuminate\Support\Facades\File;

class RobotNoIndexNoFollowCheck implements Check
{
public const REGEX_META = '/<meta(.*)[\r\n]*(.*)[\r\n]*(.*)(noindex|nofollow)(.*)[\r\n]*(.*)>/m';
public const REGEX_HTACCESS = '/(.*)X-Robots-Tag(.*)(noindex|nofollow)(.*)/m';
public const LOCATION_RESOURCES_VIEWS = 'resources/views';
public const LOCATION_HTACCESS = 'public/.htaccess';

private const ERROR_CODE_VIEWS = 1;
private const ERROR_CODE_HTACCESS = 2;


private $errorCodes = [];

public function name(array $config): string
{
return 'Meta robot - Noindex Nofollow check';
}

public function check(array $config): bool
{
$this->checkViews();
$this->checkHtaccess();
return empty($this->errorCodes);
}

public function message(array $config): string
{
return implode(
PHP_EOL,
array_filter(
array_map(function ($errorCode) {
switch ($errorCode) {
case self::ERROR_CODE_VIEWS:
return "Please remove '<meta name=\"robots\" content=\"noindex, nofollow\">'" .
' in your layout.';
case self::ERROR_CODE_HTACCESS:
return "Please remove 'Header set X-Robots-Tag' in .htaccess file";
default:
return null;
}
}, $this->errorCodes)
)
);
}

protected function checkViews(): void
{
$dir = new \RecursiveIteratorIterator(
new \RecursiveDirectoryIterator(self::LOCATION_RESOURCES_VIEWS)
);
foreach ($dir as $file) {
if ($file->isDir()) {
continue;
}

$content = file_get_contents($file->getPathname());
if (preg_match(self::REGEX_META, $content)) {
$this->errorCodes[] = self::ERROR_CODE_VIEWS;
return; 
}
}
}

protected function checkHtaccess(): void
{
if (File::exists(self::LOCATION_HTACCESS)) {
$content = file_get_contents(self::LOCATION_HTACCESS);
if (preg_match(self::REGEX_HTACCESS, $content)) {
$this->errorCodes[] = self::ERROR_CODE_HTACCESS;
}
}
}
}
