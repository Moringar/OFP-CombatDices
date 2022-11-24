console.log("hello bitches")


const avatars = document.querySelectorAll("#avatar-selection")

console.log(avatars)


function shutThemDown(){
    for(i=0; i<avatars.length; i++ ){
        let imageLabel = avatars[i].children[1]
        imageLabel.style.filter = "brightness(1)";
    }
}


for(i=0; i<avatars.length; i++ ){

    let imageLabel = avatars[i].children[1]
   imageLabel.addEventListener("click", ()=>{
        shutThemDown();
        imageLabel.setAttribute("state", "selected")
        imageLabel.style.filter = "brightness(2)";


   })



}
