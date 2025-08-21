<?php


namespace P2718293\SoloWebDev2025\DTOs;

/**
 * UserDTO
 *
 * Contains standard user data such as user ID etc
 */

 class UserDTO {
    private ?int $id;
    private string $name;
    private string $email;
    private string $passwordHash;

    private function __construct(int $id, string $name, string $email, string $passwordHash) {
        $this->id=$id;
        $this->name=$name;
        $this->email=$email;
        $this->passwordHash=$passwordHash;
    }
    /**
     * Factory method to create a new UserDTO
     * Sourced from https://medium.com/@sjoerd_bol/how-to-use-data-transfer-objects-dtos-for-clean-php-code-3bbd47a2b3ab
     * @param int $id
     * @param string $name
     * @param string $email
     * @param string $passwordHash
     * @return UserDTO
     */

    public static function create($id, string $name, string $email, string $passwordHash): UserDTO {
        return new self($id, $name, $email, $passwordHash);
    }

    public function id():int{return$this->id;}
    public function name():string{return$this->name;}
    public function email():string{return$this->email;}
    public function passwordHash(): string {
        return $this->passwordHash;
    }
 }
