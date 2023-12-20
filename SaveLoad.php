<?php
//Include Data
include "Player.php";


//Wait for Post to be recieved.
if(isset($_POST['jsondata']))
{
    $jsondata = $_POST['jsondata'];
    $data = json_decode($jsondata,true);

    //When post has been received. Go through data
    loopthroughdata($data,$player);
//    print_r($player['stats']);
//    print_r($data).'<br>';
}


function loopthroughdata($data,$playerdata){
    //Set ID
    $playerdata['ID'] = $data['ID'];

    //Grab the data key and the player key and if they match replace player value with data value
    foreach($data as $key=>$value)
    {
        foreach ($playerdata['stats'] as $key2=>$value2)
        {
            if(checkifmatch($key,$key2))
            {
                $playerdata['stats'][$key2] = $value;

            }
        }
        //Grab the data key and the player key and if they match replace player value with data value
        foreach($playerdata['playerdetails'] as $key2=>$value2)
        {
            if(checkifmatch($key,$key2))
            {
                $playerdata['playerdetails'][$key2] = $value;

            }
        }
    }
    //Data is now ready
    //Put data into the database
    InsertToDataBase($playerdata);
}

function InsertToDataBase($data)
{
    //Set server details
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'dndcharacterssheet';
    //-------------------------------//
            //Predefine variables
    $details = $data['playerdetails'];
    $stats = $data['stats'];
    $skills = SQLConvertToBoolean($data['proficientskills']) ;

    //-------------------------------//

    try {
        //Create connection and remove errors
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //Check if player exists and if not make a new entry;
        if(!CheckIfIDExists($conn,$data['ID']));
        {
            $sql = "INSERT INTO `characters`(`ID`, `Charactername`, `Playername`, `CharacterLevel`, `Race`, `Class`, `SubClass`, `Background`, `Alignment`, `Exp`)
            VALUES ('{$data['ID']}','{$details['CharacterName']}','{$details['PlayerName']}','{$details['Level']}','{$details['Race']}','{$details['Class']}','{$details['SubClass']}','{$details['Background']}','{$details['Alignment']}','{$details['Exp']}')";
            $conn->exec($sql);

            $sql = "INSERT INTO `characterstats`(`ID`, `Strength`, `Constitution`, `Dexterity`, `Intelligence`, `Wisdom`, `Charisma`, `Proficiency`)
            VALUES ({$data['ID']},{$stats['Strength']},{$stats['Constitution']},{$stats['Dexterity']},{$stats['Intelligence']},{$stats['Wisdom']},{$stats['Charisma']},{$stats['ProficiencyBonus']})";
            $conn->exec($sql);

            $sql = "INSERT INTO `skills`(`ID`, `athletics`, `acrobatics`, `sleight of hand`, `stealth`, `arcana`, `history`, `investigation`, `nature`, `religion`, `animal handling`, `insight`, `medicine`, `perception`, `survival`, `deception`, `intimidation`, `performance`, `persuasion`) 
            VALUES ({$data['ID']},{$skills['athletics']},{$skills['acrobatics']},{$skills['sleight of hand']},{$skills['stealth']},{$skills['arcana']},{$skills['history']},{$skills['investigation']},{$skills['nature']},{$skills['religion']},{$skills['animal handling']},{$skills['insight']},{$skills['medicine']},{$skills['perception']},{$skills['survival']},{$skills['deception']},{$skills['intimidation']},{$skills['performance']},{$skills['persuasion']})";

            $conn->exec($sql);
            echo "Adding new entry into database";
        }

    }
    catch (PDOException $e)
    {
        $e->getMessage();
    }
    $conn = null;

}


//SQL doesnt like booleans so we convert them to integers.
function SQLConvertToBoolean($input)
{
    if(!is_array($input)) {
        if ($input)
            $output = 1;
        else
            $output = 0;
        return $output;
    }
    else {
        $output = array();
        foreach ($input as $key=>$value) {
            if($value)
                $output[$key] = 1;
            else
                $ouput[$key] = 0;
        }
        print_r($ouput);
        return $ouput;

    }
}

//Match ID with database
function CheckIfIDExists($connection,$ID){
    if($ID != -1);
    {
        $query = "select * from characters where ID = $ID";
        $result = $connection->query($query);
        $row = $result->fetch();
        if (!$row) {
            echo 'ID: ' . $ID . ' does not exist';
            return false;
        } else {
            return true;
        }
    }
}


// Match value with key
function checkifmatch($arg1,$arg2){
    if(strtolower($arg1) == strtolower($arg2)) {
        return true;
    }
    else{
        return false;
    }
}

?>



