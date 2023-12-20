var BaseStats = document.getElementsByClassName("StatsInput");

function SaveFile() {

    if(localStorage.myData)
        if(window.confirm('Do you want to override savedata?'))
        {
            var SaveFile = {
                Strength: BaseStats[0].value,
                Constitution:BaseStats[1].value,
                Dexterity:BaseStats[2].value,
                Intelligence:BaseStats[3].value,
                Wisdom:BaseStats[4].value,
                Charisma:BaseStats[5].value,
                ProficiencyBonus:GetElement('ProficiencyBonus').value,
                Charactername:GetElement('Charactername').value,
                Race: GetElement('Race').value,
                Class: GetElement('Class').value,
                Background:GetElement('Background').value,
                Playername:GetElement('Playername').value,
                Alignment:GetElement('Alignment').value,
                Exp:GetElement('EXP').value,
                Level:GetElement('playerLevel').value,
                MaxHP:GetElement('MaxHealthPoints').value,
                CurrentHP:GetElement('HealthPoints').value,
            };
            localStorage.myData = JSON.stringify(SaveFile);
        }
}

function SendToServer(){

    BaseStats = document.getElementsByClassName("StatsInput");

    var SaveFile = {
        ID: 32,
        Strength: BaseStats[0].value,
        Constitution:BaseStats[1].value,
        Dexterity:BaseStats[2].value,
        Intelligence:BaseStats[3].value,
        Wisdom:BaseStats[4].value,
        Charisma:BaseStats[5].value,
        ProficiencyBonus:GetElement('ProficiencyBonus').value,
        Charactername:GetElement('Charactername').value,
        Race: GetElement('Race').value,
        Class: GetElement('Class').value,
        Background:GetElement('Background').value,
        Playername:GetElement('Playername').value,
        Alignment:GetElement('Alignment').value,
        Exp:GetElement('EXP').value,
        Level:GetElement('playerLevel').value,
        MaxHP:GetElement('MaxHealthPoints').value,
        CurrentHP:GetElement('HealthPoints').value,
    };

    var JsonSaveFile = JSON.stringify(SaveFile);

    $.ajax({
        type: 'POST',
        data: {jsondata : JsonSaveFile},
        url: 'SaveLoad.php',
        success: function(msg){
            console.log(msg);
        }
});

}

function LoadFile(){

    if(!localStorage.myData)
    return;
    var SaveFile = JSON.parse(localStorage.myData);

    BaseStats[0].value = SaveFile.Strength;
    BaseStats[1].value = SaveFile.Constitution;
    BaseStats[2].value = SaveFile.Dexterity;
    BaseStats[3].value = SaveFile.Intelligence;
    BaseStats[4].value = SaveFile.Wisdom;
    BaseStats[5].value = SaveFile.Charisma;
    GetElement('ProficiencyBonus').value = SaveFile.ProficiencyBonus;
    GetElement('Charactername').value = SaveFile.Charactername;
    GetElement('Race').value = SaveFile.Race;
    GetElement('Class').value = SaveFile.Class;
    GetElement('Background').value = SaveFile.Background;
    GetElement('Playername').value = SaveFile.Playername;
    GetElement('Alignment').value = SaveFile.Alignment;
    GetElement('EXP').value = SaveFile.Exp;
    GetElement('playerLevel').value = SaveFile.Level;
    GetElement('MaxHealthPoints').value = SaveFile.MaxHP;
    GetElement('HealthPoints').value = SaveFile.CurrentHP;



}

function GetElement(arg) {
    return document.getElementById(arg);
}
