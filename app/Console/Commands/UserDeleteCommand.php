<?php

namespace app\Console\Commands;

use Exception;
use Illuminate\Database\Eloquent\Model;

class UserDeleteCommand extends UserCommand
{





protected $signature = 'wq:user:delete';






protected $description = 'Delete a user';







public function handle(): void
{
$email = $this->askUserEmail(false);

if (null === ($user = $this->getUser($email))) {
$this->error('User not found!');
} elseif ($this->askConfirmation($user)) {
$user->delete();
$this->info(sprintf('User #%d <%s> deleted!', $user->id, $user->email));
}
}

protected function askConfirmation(?Model $user): bool
{
return $this->confirm(
sprintf('Are you sure you want to delete user <%s>', $user->email)
);
}
}
