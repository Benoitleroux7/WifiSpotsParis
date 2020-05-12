var slideIndex = 0;
var index = 0;

showDivs(slideIndex);



function plusDivs(n) {
    showDivs(slideIndex += n);
}

function showDivs(n) {
    if (n > slides.length) {slideIndex = 0}
    if (n < 0) {slideIndex = slides.length} ;
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex].style.display = "block";
}

function finalise() {
    plusDivs(1);
    document.getElementById("final-resume").innerHTML = "";
    var res = document.getElementsByClassName("removeInline");
    var ul = document.getElementById("final-resume");
    for (var elt of res) {
        var divNew = document.createElement("div");
        divNew.appendChild(document.createTextNode(elt.innerText));
        ul.appendChild(divNew);
    }
}

function confirm() {
    if (!mainNom.value || !mainPrenom.value || !mainEmail.value || !mainDistrict.value || !mdp.value || !mdp2.value) {
        //Erreur champs non renseigné
        slides[0].getElementsByClassName('error')[0].innerText = "Veuillez remplir tous les champs";
        slideIndex = 0;
        showDivs(0);
    }
    else if (mdp.value != mdp2.value) {
        //Mots de passe différents
        slides[0].getElementsByClassName('error')[0].innerText = "Confirmez le mot de passe";
        slideIndex = 0;
        showDivs(0);
    }
    // else if () {
    //     //Pas mail
    //     slides[0].getElementsByClassName('error')[0].innerText = "Renseignez une adresse email valide";
    //     slideIndex = 0;
    //     showDivs(0);
    // }



    var all = {"mainUser" : [mainNom.value, mainPrenom.value, mainEmail.value, mainDistrcit.value, mdp.value, mdp2.value],

    $.ajax({
        url:"index.php?action=addTotal",
        method:"POST",
        data:{infos:all},
        dataType:"text",
        success:callbackSuccess
    });
}

callbackSuccess = function(data)
{
}
