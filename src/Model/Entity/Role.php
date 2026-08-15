
<?php

class Role
{
    private ?int $id;
    private string $nom;

    public function __construct(string $nom,?int $id){
        $this ->id = $id;
        $this ->nom = $nom;

    }
}
