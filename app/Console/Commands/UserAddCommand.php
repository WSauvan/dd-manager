<?php

namespace app\Console\Commands;

use app\Console\Commands\Base\UserCommand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class UserAddCommand extends UserCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wq:user:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $name = $this->askUserName();
        $email = $this->askUserEmail();
        $password = $this->askUserPassword();
        $roles = $this->canBindRoles() ? $this->askUserRoles() : null;

        $user = $this->insertUser($name, $email, $password);

        if (null !== $roles) {
            $user->assignRole($roles);
        }

        // add your admin account creation logic here!

        $this->info(sprintf('User #%d <%s> created!', $user->id, $user->email));
    }

    protected function askUserName(): string
    {
        return $this->ask('Enter the user name');
    }

    protected function askUserPassword(): string
    {
        $password = $this->secret(
            'Enter the password (leave blank to generate it)'
        );

        if (empty($password)) {
            $password = Str::random();

            $this->info(sprintf('Generated password: %s ', $password));

            return $password;
        }

        $confirmation = $this->secret('Confirm the password');

        if ($password === $confirmation) {
            return $password;
        }

        $this->error("Passwords don't match!");

        return $this->askUserPassword();
    }

    protected function canBindRoles(): bool
    {
        $traitName = 'Spatie\Permission\Traits\HasRoles';

        return trait_exists($traitName) &&
          in_array($traitName, class_uses($this->getUserModelClassName()));
    }

    protected function askUserRoles(): ?array
    {
        $className = config('permission.models.role');
        /** @var Model $className */
        $collection = $className::all();

        if ($collection->isEmpty()) {
            return null;
        }

        $noneValue = '<none>';
        try {
            /** @var array|string[] $roles */
            $roles = $this->choice(
                'Choose user roles (comma separated list)',
                $collection
                    ->pluck('name')
                    ->prepend($noneValue)
                    ->toArray(),
                null,
                3,
                true
            );
        } catch (InvalidArgumentException $e) {
            return null;
        }

        return 1 === count($roles) && in_array($noneValue, $roles)
          ? null
          : array_filter($roles, function (string $value) use ($noneValue): bool {
              return $value !== $noneValue;
          });
    }

    protected function insertUser(
        string $name,
        string $email,
        string $password
    ): Model {
        $className = $this->getUserModelClassName();

        /** @var Model $user */
        $user = new $className([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        $user->save();

        return $user;
    }
}
