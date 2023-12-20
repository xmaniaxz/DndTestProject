var input = document.getElementsByClassName("StatsInput");
var output = document.getElementsByClassName("StatsOutput");
var ProficiencyBonus;

function ConvertNumber(identifier, e) {
    //Start at lowest which is a -5
    var modifier = -5;

    //Increment by 2 and add 1 to modifier
    for (var i = 0; i < input[identifier].value; i++) {
        i++;
        modifier++;
    }
    if (input[identifier].value == 0)
        modifier = 0;

    else {
        //Set output
        output[identifier].value = modifier;
        GetSkillID(identifier);
    }
}

function ConvertNumber() {
    for (var x = 0; x < input.length; x++) {
        //Start at lowest which is a -5
        var modifier = -5;

        //Increment by 2 and add 1 to modifier
        for (var i = 0; i < input[x].value; i++) {
            i++;
            modifier++;
        }
        if (input[x].value == 0)
            modifier = 0;

        else {
            //Set output
            output[x].value = modifier;
            GetSkillID(x);
        }
    }
}


//Called when page is loaded. 
function onPageLoad() {
    ProficiencyBonus = document.getElementById("ProficiencyBonus");
    //Loop through all inputs
    for (var i = 0; i < input.length; i++) {
        //Create a function that carries the index. Then give index to Convertnumber
        (function (index) {
            //mimic input to sent to <input>
            input[index].addEventListener('input', function (e) {
                ConvertNumber(index, e);
            });
            //When value on Input get changed. Update number
            input[index].addEventListener('propertychange', function (e) {
                ConvertNumber(index, e);
            });
            //Give it to log
            console.log(`Added Listening event on object ${document.getElementById("statsContainer").children[index].children[2].innerHTML}`);
        })(i);
    }
    ProficiencyBonus.addEventListener('propertychange', function (e) {
        for (var i = 0; i < input.length; i++) {
            ConvertNumber(i, e);
        }

    });
    ProficiencyBonus.addEventListener('input', function (e) {
        for (var i = 0; i < input.length; i++) {
            ConvertNumber(i, e);
        }
    });

}

function GetSkillID(identifier) {
    var SkillContainer = input[identifier].parentElement;

    var SkillCalcInputs = SkillContainer.querySelectorAll('.SkillCalc');
    var ProficiencyCheck = SkillContainer.querySelectorAll('#Proficiency')
    for (var i = 0; i < SkillCalcInputs.length; i++) {
        if (ProficiencyCheck[i].checked && ProficiencyBonus.value != "") {
            SkillCalcInputs[i].value = parseInt(output[identifier].value) + parseInt(ProficiencyBonus.value);
        }
        else {
            SkillCalcInputs[i].value = output[identifier].value;
        }
    }


}

// This is where we will be setting up the skills
function ShowSkills(arg, arg2) {
    var tab = document.getElementById(arg);
    var btn = document.getElementById(arg2);
    if (tab.style.display === 'none') {
        tab.style.display = 'block';
        btn.innerHTML = 'Hide skills'
    }
    else {
        tab.style.display = 'none';
        btn.innerHTML = 'Show skills'
    }
}



// Call onPageLoad when the page is loaded
document.addEventListener('DOMContentLoaded', onPageLoad);







