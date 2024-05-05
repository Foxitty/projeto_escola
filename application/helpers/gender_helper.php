<?php
function getGenderDescription($gender)
{
    $gender_map = [
        1 => 'Masculino',
        2 => 'Feminino'
    ];
    return $gender_map[$gender];
}