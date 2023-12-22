<html style="font-size: large;font-family: Arial;"></html><?php
//Get data from text or site.
 $html = GetFileData();

 //Split file up in different lines
 $splithtml = explode("\n",$html);
 $splithtml = CleanStrings($splithtml);

$sortedArray = PutIntoLevelArray($splithtml);

CreateJSONFiles($sortedArray);

function CreateJSONFiles($sArray)
{
    $folder = getcwd().'/Spells';
    $arrayKey = array_keys($sArray);
    $count = 0;

    $filepath = $folder.'/'.'api.json';
    if(!file_exists($filepath))
    {
        $data = json_encode($sArray,JSON_PRETTY_PRINT);
        if(!file_exists($filepath))
        {
            $fp = fopen($filepath,'w');
            fwrite($fp,$data);
            fclose($fp);
        }

    }
    //Loop trough sorted array
    foreach ($sArray as $level)
    {



        $currentDir = $folder . '/' . $arrayKey[$count];
        #region folder creation
        if(!is_dir($currentDir)) {
            echo 'trying to make directory in' .$currentDir. '<br>';
            mkdir($currentDir);
        }
        #endregion
        foreach ($level as $spell)
        {
            $filepath = $currentDir.'/'.CleanString('/','',$spell->spellName).'.json';
            $data = json_encode(get_object_vars($spell),JSON_PRETTY_PRINT);
            if(!file_exists($filepath))
            {
                $fp = fopen($filepath,'w');
                fwrite($fp,$data);
                fclose($fp);
            }
        }
        //This count goes up to switch to next folder
        $count++;
    }
}

function CleanString($target,$replacement,$input)
{
    return str_replace($target,$replacement,$input);
}

function PutIntoLevelArray($array){
    $spellTiers = array(
        'cantrips' => array(),
        '1' => array(),
        '2' => array(),
        '3' => array(),
        '4' => array(),
        '5' => array(),
        '6' => array(),
        '7' => array(),
        '8' => array(),
        '9' => array(),
    );
    $spellTiers['cantrips'] = GrabSpellsFromLevel(425,824,$spellTiers['cantrips'],$array);
    $spellTiers['1'] = GrabSpellsFromLevel(842,1569,$spellTiers['1'],$array);
    $spellTiers['2'] = GrabSpellsFromLevel(1587,2362,$spellTiers['2'],$array);
    $spellTiers['3'] = GrabSpellsFromLevel(2380,3051,$spellTiers['3'],$array);
    $spellTiers['4'] = GrabSpellsFromLevel(3069,3572,$spellTiers['4'],$array);
    $spellTiers['5'] = GrabSpellsFromLevel(3590,4125,$spellTiers['5'],$array);
    $spellTiers['6'] = GrabSpellsFromLevel(4143,4558,$spellTiers['6'],$array);
    $spellTiers['7'] = GrabSpellsFromLevel(4576,4815,$spellTiers['7'],$array);
    $spellTiers['8'] = GrabSpellsFromLevel(4833,5024,$spellTiers['8'],$array);
    $spellTiers['9'] = GrabSpellsFromLevel(5042,5217,$spellTiers['9'],$array);

    return $spellTiers;
#region debug
//   print_r($spellTiers);
/*
      foreach ($spellTiers['1'] as $key)
      {
          echo $key->spellName.'<br>';
      }*/

    /*$totalcount = 0;
    foreach ($spellTiers as $key){
        $totalcount += count($key);
    }
    echo $totalcount;*/

#endregion debug

}
function GrabSpellsFromLevel(int $start,int $end,$spelltier,$array){
    for ($i = $start-1; $i < $end;$i+=8){
        $spelltier[] = new Spell($array[$i+1],$array[$i+2],$array[$i+3],$array[$i+4],$array[$i+5],$array[$i+6]);
    }
    return $spelltier;
}

 function CleanStrings($List){
     for ($i = 0; $i < count($List);$i++)
     {
         $List[$i] = preg_replace('/<[^>]*>/', '', $List[$i]);
     }
//     $List = array_slice($List,416);
     return $List;
 }
function GetFileData()
{
    if(file_exists('Page.txt')) {

        $Page = fopen('Page.txt','r+');

        //fwrite($Page,file_get_contents('http://dnd5e.wikidot.com/spells'));
        return fread($Page,filesize("Page.txt"));
    }
    else return 'No Info';
}

class Spell{
    public $spellName;
    public $school;
    public $castingTime;
    public $range;
    public $duration;
    public $components;

    public $description;
    public $higherLevel;
    public $spelllists = array();

    public function __construct($spellname,$school,$castingTime,$range,$duration,$components)
    {
        $this->spellName = $spellname;
        $this->school = $school;
        $this->castingTime = $castingTime;
        $this->range = $range;
        $this->components = $components;
        $this->duration = $duration;
    }

    public function SetAdditionalData($description,$higherLevel,$spellLists)
    {
        $this->description = $description;
        $this->higherLevel = $higherLevel;
        $this->spelllists = $spellLists;
    }

}

?>