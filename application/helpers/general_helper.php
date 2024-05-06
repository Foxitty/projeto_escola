<?php

require_once ("./application/enum/Enum.php");

function getGenderDescription($gender)
{
    $gender_map = [
        Gender::Male => 'Masculino',
        Gender::Female => 'Feminino'
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
        Periods::Morning => 'Manhã',
        Periods::Afternoon => 'Tarde',
    ];
    return $period_map[$period];
}