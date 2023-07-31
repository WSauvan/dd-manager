<?php

namespace app\Console\Commands;

use app\Console\Commands\Base\UserCommand;
use Exception;
use Illuminate\Database\Eloquent\Model;

class UserDeleteCommand extends UserCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wq:user:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a user';

    /**
     * Execute the console command.
     *
     * @return mixed
     *
     * @throws Exception
     */
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
