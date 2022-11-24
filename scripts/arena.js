
// Variables ====================================================================
let textArena = document.querySelectorAll("p")
let fighterA = document.querySelectorAll(".fA")
let fighterB = document.querySelectorAll(".fB")
let results = document.querySelectorAll(".result")
// VARIABLES =============================================================
let fightSounds = [
    "../assets/sounds/grunt.wav",
    "../assets/sounds/moan.wav",
    "../assets/sounds/punch.wav",
    "../assets/sounds/punch2.wav",
    "../assets/sounds/punch3.wav"
]


//FUNCTIONS ==================================================================
function rand(max) {
    return Math.floor(Math.random() * max);
  }
function playFightSound(){
    let punch = new Audio(fightSounds[rand(fightSounds.length)])
    punch.play()
    console.log("punch delivered")
}

function playVictory(){
    let victory = new Audio("../assets/sounds/ff7victory.mp3")
    victory.play()
}
function playResultSound(){
    let victory = new Audio("../assets/sounds/pop.wav")
    victory.play()
}


// Main animation.

let timelineFight = gsap.timeline()

for(let i = 0; i < textArena.length; i++){

    if(textArena[i].classList.contains("fA")){
        timelineFight.from(textArena[i], {duration:1.2,delay:1.2, opacity: 0, x:600, onComplete:playFightSound})
    }
    if(textArena[i].classList.contains("fB")){
        timelineFight.from(textArena[i], {duration:1.2,delay:1.2, opacity: 0, x:-600, onComplete:playFightSound})
    }
    if(textArena[i].classList.contains("result")){
        timelineFight.from(textArena[i], {duration:2, delay:1, opacity: 0, y:200, onComplete:playResultSound})
    }
    if(textArena[i].classList.contains("final")){
        timelineFight.from(textArena[i], {duration:4, opacity: 0, y:200, onComplete:playVictory})
    }


}
