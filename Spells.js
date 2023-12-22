function ShowSpells()
{
    let spellcontainer = document.getElementById('spellContainer');
    if(spellcontainer.childElementCount === 0) {
        GetSpells();
        return;
    }
    if(spellcontainer.style.display === 'block')
    {
        spellcontainer.style.display = 'none';
    }
    else if(spellcontainer.style.display === 'none')
    {
        spellcontainer.style.display = 'block';
    }
}

function CreateSpellDiv(spellName,parent)
{
    var Spell = document.createElement('div');
    Spell.setAttribute('class','Spell');
    Spell.innerHTML = spellName;
    document.getElementById(parent).appendChild(Spell);
}

async function GetSpells()
{
    var lib = await GetLib();

    var keyName = Object.keys(lib);
    //Set parent per level
    for (let x = 0;x<keyName.length;x++)
    {
        // console.log(lib[keyName[x]])
        let elemDiv = document.createElement('div');
        elemDiv.setAttribute('class','SpellLevel');
        elemDiv.setAttribute('id','SpellLevel-'+keyName[x]);
        document.getElementById('spellContainer').appendChild(elemDiv);
        for (let y =0;y<lib[keyName[x]].length;y++)
        {
            CreateSpellDiv(lib[keyName[x]][y].spellName,'SpellLevel-'+keyName[x]);
        }
    }
}

async function GetLib(){
    var lib = await GetJson();
    lib = JSON.stringify(lib);
    lib = JSON.parse(lib);
    return lib;
}
async function GetJson(){
    const res = await fetch('./Spells/api.json',{method:'GET',credentials:'same-origin'});
    return await res.json();
}

