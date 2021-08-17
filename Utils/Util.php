<?php

class Util {

    static public function formatCPF($cpf) {
        $ArrCpf = str_split($cpf, 3);
        $cpf = $ArrCpf[0] . '.' . $ArrCpf[1] . '.' . $ArrCpf[2] . '-' . $ArrCpf[3];
        return $cpf;
    }

}

?>
