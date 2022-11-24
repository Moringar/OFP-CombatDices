console.log("Hello fighters")

const combatStatus = document.querySelectorAll("p")
console.log (combatStatus)

for(let i = 0; i < combatStatus.length; i++){

    combatStatus[i].style.animationDelay = i*0.2+"s";
    
}