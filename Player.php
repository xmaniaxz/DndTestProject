<?php
$stats = array(
        'Strength' => -1,
        'Constitution' => -1,
        'Dexterity' => -1,
        'Intelligence' => -1,
        'Wisdom' => -1,
        'Charisma' => -1,
        'ProficiencyBonus' => -1,
);

$skills = array(
    'athletics' => false,
    'acrobatics' => false,
    'sleight of hand' => false,
    'stealth' => false,
    'arcana' => false,
    'history' => false,
    'investigation' => false,
    'nature' => false,
    'religion' => false,
    'animal handling' => false,
    'insight' => false,
    'medicine'=> false,
    'perception'=> false,
    'survival'=> false,
    'deception'=> false,
    'intimidation'=> false,
    'performance'=> false,
    'persuasion'=> false,
);

$proficientskills = array();

$playerdetails = array(
        'CharacterName' => '',
        'PlayerName' => '',
        'Level' => '',
        'Race' => '',
        'Class' => '',
        'SubClass' => '',
        'Background' => '',
        'Alignment' => '',
        'Exp' => '',
);

$player = array(
    'ID' => -1,
    'stats' => $stats,
    'proficientskills' => $skills,
    'playerdetails' => $playerdetails,
);

?>
