<?php
namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ClientSearchDTO
{
    /**
     * @Assert\Length(min=10, max=10)
     * @Assert\Regex(pattern="/^[0-9]*$/", message="Veuillez entrer un numéro de téléphone valide.")
     */
    public ?string $telephone = null;

    /**
     * @Assert\Length(min=2, max=255)
     */
    public ?string $surname = null;

    /**
     * Enum pour vérifier si le client a un compte (true/false)
     */
    public ?bool $hasAccount = null;

    public function __construct(string $telephone = null, string $surname = null, bool $hasAccount = null)
    {
        $this->telephone = $telephone;
        $this->surname = $surname;
        $this->hasAccount = $hasAccount;
    }
}
