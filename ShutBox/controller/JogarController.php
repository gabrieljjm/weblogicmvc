<?php

class JogarController
{

    public function gerarNumeros()
    {
        $q = 2;
        for ($i = 1; $i <= $q; $i++) {
            echo rand(1, 9) . " ";
        }
    }


}

if (isset($_POST['lancar'])) {
    echo "OK";
    $this->gerarNumeros();
}
?>