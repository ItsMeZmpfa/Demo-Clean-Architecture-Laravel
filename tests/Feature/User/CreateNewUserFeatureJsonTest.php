<?php

    namespace Tests\Feature\User;

    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Arr;
    use Tests\ManipulatesConfig;
    use Tests\ProvidesUsers;
    use Tests\TestCase;

    class CreateNewUserFeatureJsonTest extends TestCase
    {
        use RefreshDatabase;
        use ProvidesUsers;
        use ManipulatesConfig;

        /**
         * @test
         * @dataProvider userDataProvider
         */
        public function createUser(array $data)
        {

            // Create Api Call
            $response = $this->postJson(route('send.registerNew', $data))->assertOk();
            //excepted Json Response
            $response->assertJsonFragment([
                'message' => "Register succusfully.",
            ]);

            // expect the user to be created in database
            $this->assertDatabaseHas('users', Arr::except($data, 'password'));

        }

        /**
         * @test
         * @dataProvider userDataProvider
         */
        public function wrongEmailFormat(array $data)
        {
            //Change the Email Format to an invalid
            $data['email'] = "test.sdfs.de";
            // Create Api Call
            $response = $this->postJson(route('send.registerNew', $data))->assertStatus(400);
            //excepted Json Response
            $response->assertJsonFragment([
                'error' => "Something went wrong with Input Your provide",
                "help" => "Check if the given input is valid",
            ]);

        }

        /**
         * @test
         * @dataProvider userDataProvider
         */
        public function emptyEmail(array $data)
        {
            //Change the Email Format to wrong one
            $data['email'] = "";
            // Create Api Call
            $response = $this->postJson(route('send.registerNew', $data))->assertStatus(400);
            //excepted Json Response
            $response->assertJsonFragment([
                'error' => "Something went wrong with Input Your provide",
                "help" => "Check if the given input is valid",
            ]);

        }
    }
