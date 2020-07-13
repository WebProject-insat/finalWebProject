let advFeatures = document.getElementById("advanced") ;
let aFeatures = document.getElementById("aForFeatures") ;
let slider=document.getElementById("theBudget") ;
let budget = document.getElementById("budget") ;
budget.innerHTML=slider.value + " DT" ;
slider.oninput=function(){
    budget.innerHTML=slider.value + " DT" ;
}
function displayAdvancedFeatures(){
    if(advFeatures.style.visibility==="hidden"){
        advFeatures.style.visibility="visible" ;
        aFeatures.innerHTML="Advanced features &#8593";
        advFeatures.style.height="auto";
    }
    else{
        advFeatures.style.visibility="hidden";
        aFeatures.innerHTML="Advanced features &#8595" ;
        advFeatures.style.height="10px";
    }
}