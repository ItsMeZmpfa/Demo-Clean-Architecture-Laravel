<?php

namespace App\Domain\UseCases\UserSearch;

use App\Domain\Interfaces\User\UserEntity;
use App\Domain\Interfaces\User\UserFactory;
use App\Domain\Interfaces\User\UserRepository;
use App\Domain\Interfaces\ViewModel;
use App\Models\PasswordValueObject;
use App\Domain\UseCases\UserSearch\UserSearchInputPort;

class UserSearchInteractor implements UserSearchInputPort
{
    public function __construct(
        private UserSearchOutputPort $output,
        private UserRepository $repository,
        private UserFactory $factory,
    ) {
    }

    public function searchUser(UserSearchRequestModel $request): ViewModel
    {
       
        
        $searchCredential = $this->factory->searchCredentialUser([
            'userId' => $request->getUserID(),
            'email' => $request->getEmail(),
            'name' => $request->getName(),
        ]);

        try {


            $userCollection = $this->repository->findUserbySearchCredential($searchCredential);
        } catch (\Exception $e) {
            return $this->output->unableToUserSearch(new UserSearchResponseModel($searchCredential), $e);
        }

        return $this->output->userSearch(
            new UserSearchResponseModel($userCollection)
        );
    }
}
