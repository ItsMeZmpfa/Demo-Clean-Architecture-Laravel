<?php

    namespace Tests;

    use App\Domain\Interfaces\User\UserEntity;
    use App\Models\EmailValueObject;
    use App\Models\PasswordValueObject;


    trait ProvidesUsers
    {
        public static function userDataProvider(): array
        {
            return [
                'Test User' => [
                    'data' => [
                        'name' => "Test User",
                        'email' => "test.user@example.com",
                        'password' => "Test12341234",
                    ],
                ],
            ];
        }

        public static function userSearchDataProvider(): array
        {
            return [
                'Test User' => [
                    'data' => [
                        'user1' => [
                            'name' => "Test User1",
                            'email' => "test.user1@example.com",
                            'password' => "Test12341234",
                        ],
                        'user2' => [
                            'name' => "Test User2",
                            'email' => "test.user2@example.com",
                            'password' => "Test12341234",
                        ],
                        'user3' => [
                            'name' => "Test User3",
                            'email' => "test.user3@example.com",
                            'password' => "Test12341234",
                        ],
                    ],
                ],
            ];
        }

        public function assertUserMatches(array $data, UserEntity $user)
        {
            $this->assertEquals($data['name'], $user->getUserName());
            $this->assertTrue($user->getUserEmail()->isEqualTo(new EmailValueObject($data['email'])));
            $this->assertTrue($user->getUserPassword()->check(new PasswordValueObject($data['password'])));
        }
    }
