<?php

namespace app\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

abstract class UserCommand extends Command
{
protected function askUserEmail(bool $checkUnique = true): string
{
$email = $this->ask('Enter the user email');

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
if (!$checkUnique) {
return $email;
}
if (null === ($user = $this->getUser($email))) {
return $email;
} else {
$this->error(
sprintf(
'This email address already exists in table `%s`.',
$user->getTable()
)
);
}
} else {
$this->error('Invalid email address.');
}

return $this->askUserEmail();
}

protected function getUser(string $email): ?Model
{
$className = $this->getUserModelClassName();

if (
method_exists($className, 'isHashable') &&
(new $className())->isHashable('email')
) {
return $className::whereEncrypted('email', $email)->first();
}

return $className::where('email', $email)->first();
}

protected function getUserModelClassName(): string
{
return config('auth.providers.users.model');
}
}
