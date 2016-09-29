<?php

use App\User;
use Illuminate\Database\Seeder;

class AddAdminSeeder extends Seeder
{
    /**
     * @var string
     */
    protected $email = 'admin@ad3media.com';

    /**
     * @var string
     */
    protected $password = 'admin...';

    /**
     * Run the database seeds.
     */
    public function run()
    {
        if (!$this->exists($this->email)) {
            User::create([
                'email' => $this->email,
                'password' => $this->password,
                'verified_email' => true,
                'verified_phone' => true,
            ]);
        }
    }

    protected function exists($email)
    {
        return User::whereEmail($this->email)->first();
    }
}
