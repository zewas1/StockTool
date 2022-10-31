<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Repositories\UserRepository;
use Illuminate\Console\Command;

class AddBalance extends Command
{
    /**
     * @var string
     */
    protected $signature = 'add:balance';

    /**
     * @var string
     */
    protected $description = 'Add balance to all users every week.';

    private const BALANCE_INCREASE_AMOUNT = 10000;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $users = $this->userRepository->all();

        foreach ($users as $user) {
            $user->balance += self::BALANCE_INCREASE_AMOUNT;
            $user->save();
        }
    }
}
