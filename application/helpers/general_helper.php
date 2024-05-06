<?php
function getGenderDescription($gender)
{
    $gender_map = [
        1 => 'Masculino',
        2 => 'Feminino'
    ];
    return $gender_map[$gender];
}

function getClassYearDescription($classYear)
{
    $class_year_map = [
        1 => '1º Ano',
        2 => '2º Ano',
        3 => '3º Ano',
        4 => '4º Ano',
        5 => '5º Ano',
        6 => '6º Ano',
        7 => '7º Ano',
        8 => '8º Ano',
        9 => '9º Ano'


    ];
    return $class_year_map[$classYear];
}

function getPeriodDescription($period)
{
    $period_map = [
        1 => 'Manhã',
        2 => 'Tarde',
    ];
    return $period_map[$period];
}