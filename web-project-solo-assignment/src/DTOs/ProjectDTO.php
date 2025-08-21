<?php


namespace P2718293\SoloWebDev2025\DTOs;

use P2718293\SoloWebDev2025\DTOs\StaffDTO;

/**
 * ModuleDTO
 * Data Transfer Object representing modules
 * used to structure data being passed in the program
 */

 class ModuleDTO {
    
    private ?int $id;
    private string $title;
    private int $year;
    private int $programmeId;
    private bool $shared;
    /**
     * @var StaffDTO[]
     */
    private array $staff;



    private function __construct(int $id, string $title, int $year, int $programmeId, bool $shared) {
       $this-> id = $id;
       $this-> title = $title;
       $this-> year = $year;
       $this-> programmeId = $programmeId;
       $this-> shared = $shared;
       $this-> staff = [];
    }

     /**
     * Factory method to create a new ModuleDTO
     * Logic sourced from https://medium.com/@sjoerd_bol/how-to-use-data-transfer-objects-dtos-for-clean-php-code-3bbd47a2b3ab
     *
     * @param int $id
     * @param string $title
     * @param int $year
     * @param int $programmeId
     * @param bool $shared
     *
     * @return ModuleDTO
     */

    public static function create(int $id, string $title, int $year, int $programmeId, bool $shared): ModuleDTO {
        return new self($id, $title, $year, $programmeId, $shared);
    }

    public function title(): string {
        return $this->title;
    }
    public function year(): int {
        return $this->year;
    }
    public function programmeId():int {
        return $this->programmeId;
    }
    public function shared():bool {
        return $this->shared;
    }
    public function staff(): array {
        return $this->staff;
    }
    /**
     * @param StaffDTO[] $staff
     */
    public function setStaff(array $staff): void {
        $this->staff = $staff;
    }

    public function addStaff(StaffDTO $staff): void {
        $this->staff[] = $staff;
    }
    public function id(): ?int {
        return $this->id;
    }


 }
