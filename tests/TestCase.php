<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function createAdmin(): User
    {
        return User::create([
            'PERD_EMER'     => 'Test',
            'PERD_MBIEMER'  => 'Admin',
            'PERD_EMAIL'    => 'testadmin@uni.edu.al',
            'PERD_FJKALIM'  => bcrypt('password123'),
            'PERD_TIPI'     => 'admin',
            'PERD_AKTIV'    => true,
        ]);
    }

    protected function createPedagog(): User
    {
        return User::create([
            'PERD_EMER'     => 'Test',
            'PERD_MBIEMER'  => 'Pedagog',
            'PERD_EMAIL'    => 'testpedagog@uni.edu.al',
            'PERD_FJKALIM'  => bcrypt('password123'),
            'PERD_TIPI'     => 'pedagog',
            'PERD_AKTIV'    => true,
        ]);
    }

    protected function createStudent(): User
    {
        return User::create([
            'PERD_EMER'     => 'Test',
            'PERD_MBIEMER'  => 'Student',
            'PERD_EMAIL'    => 'teststudent@uni.edu.al',
            'PERD_FJKALIM'  => bcrypt('password123'),
            'PERD_TIPI'     => 'student',
            'PERD_AKTIV'    => true,
        ]);
    }

    protected function adminToken(): string
    {
        $admin = $this->createAdmin();
        return $admin->createToken('test')->plainTextToken;
    }

    protected function pedagogToken(): string
    {
        $pedagog = $this->createPedagog();
        return $pedagog->createToken('test')->plainTextToken;
    }

    protected function studentToken(): string
    {
        $student = $this->createStudent();
        return $student->createToken('test')->plainTextToken;
    }
}
