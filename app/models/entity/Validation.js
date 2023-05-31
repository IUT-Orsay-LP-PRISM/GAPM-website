// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// Déclaration des variables

const errorMessagesArray = [
    "Format du prénom incorrect", // 0
    "Format du nom incorrect", // 1
    "Format du mail incorrect", // 2
    "Date de naissance incorrecte", // 3
    "Format de l'adresse incorrecte", // 4
    "Ville renseignée non valable", // 5
    "Sexe renseigné non valable", // 6
    "Format du mot de passe incorrect", // 7
    "Format du téléphone incorrect", // 8
    "Format des spécialités incorrect", // 9
    "Format du login incorrect", // 10
    "Date du rendez-vous incorrecte" // 11
];



// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// Accès aux nodes HTLM
let inputPrenom = document.getElementById('XXXXXXXXXXXXX');
let inputNom = document.getElementById('XXXXXXXXXXXXX');
let inputEmail = document.getElementById('XXXXXXXXXXXXX');
let inputDateNaissance = document.getElementById('XXXXXXXXXXXXX');
let inputAdresse = document.getElementById('XXXXXXXXXXXXX');
let inputVille = document.getElementById('XXXXXXXXXXXXX');
let inputSexe = document.getElementById('XXXXXXXXXXXXX');
let inputNumeroTelephone = document.getElementById('XXXXXXXXXXXXX');
let inputMdp = document.getElementById('XXXXXXXXXXXXX');
let inputSpecialites = document.getElementById('XXXXXXXXXXXXX');
let inputVillePro = document.getElementById('XXXXXXXXXXXXX');
let inputAdressePro = document.getElementById('XXXXXXXXXXXXX');
let inputLogin = document.getElementById('XXXXXXXXXXXXX');
let inputDateRendezVous = document.getElementById('XXXXXXXXXXXXX');

let inputPrenomPElement = document.getElementById('XXXXXXXXXXXXX');
let inputNomPElement = document.getElementById('XXXXXXXXXXXXX');
let inputEmailPElement = document.getElementById('XXXXXXXXXXXXX');
let inputDateNaissancePElement = document.getElementById('XXXXXXXXXXXXX');
let inputAdressePElement = document.getElementById('XXXXXXXXXXXXX');
let inputVillePElement = document.getElementById('XXXXXXXXXXXXX');
let inputSexePElement = document.getElementById('XXXXXXXXXXXXX');
let inputNumeroTelephonePElement = document.getElementById('XXXXXXXXXXXXX');
let inputMdpPElement = document.getElementById('XXXXXXXXXXXXX');
let inputSpecialitesPElement = document.getElementById('XXXXXXXXXXXXX');
let inputVilleProPElement = document.getElementById('XXXXXXXXXXXXX');
let inputAdresseProPElement = document.getElementById('XXXXXXXXXXXXX');
let inputLoginPElement = document.getElementById('XXXXXXXXXXXXX');
let inputDateRendezVousPElement = document.getElementById('XXXXXXXXXXXXX');



 // --------------------------------------------------------------------------------------------------------
 // --------------------------------------------------------------------------------------------------------
 // --------------------------------------------------------------------------------------------------------
 // --------------------------------------------------------------------------------------------------------
 // --------------------------------------------------------------------------------------------------------
 // Méthodes
  
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// Fonction verifierPrenomNom : 
function verifierPrenomNom(evt){
    return evt.currentTarget.value.match('/^[A-Za-z][A-Za-z ]{0,49}$/');
}


    
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// Fonction verifierEmail : 
function verifierEmail(evt){
    // Caractères autorisés : lettres, numèros, [.-_] et 1 seul @
    // Pas de début ou fin avec [.-_] 
    // ET pas de [.-_] consécutifs
    // Taille maximale 50 caractères
    return evt.currentTarget.value.match('/^(?![\.\-\_])(?!.*\.\.)(?!.*\-\-)(?!.*\_\_)[A-Za-z0-9\.\-\_]*[A-Za-z0-9]+@[A-Za-z0-9][A-Za-z0-9\-\_]*[A-Za-z0-9]\.[A-Za-z]{2,}$/');        
}



// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// Fonction verifierDateNaissance : 
function verifierDateNaissance(evt){
    let inputDate = new Date(evt.currentTarget.value);

    if(inputDate != null){
        return (new Date().getFullYear - inputDate.getFullYear()) >= 18;
    }

    return false;
}


    
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// Fonction verifierAdresse : 
function verifierAdresse(evt){
    return evt.currentTarget.value.match('/^[A-Za-z0-9,\-\/\' ]{0,49}$/');
}


    
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// Fonction verifierVille : 
function verifierVille(evt){
    return !isNaN(evt.currentTarget.value) && evt.currentTarget.value >= 1 && evt.currentTarget.value <= 36208 ? true : false;
}


    
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// Fonction verifierSexe : 
function verifierSexe(evt){
        return evt.currentTarget.value.match('/^[HFA]{1}$/');
}


    
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// Fonction verifierNumeroTelephone : 
function verifierNumeroTelephone(evt){
    return evt.currentTarget.value.match('/(0|\+33|0033)[1-9][0-9]{8}/');
}


    
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// Fonction verifierMdp : 
function verifierMdp(evt){
    // >= 1 Majuscule + >= 1 minuscule + >= 1 chiffre + >= 1 caractère @$!%*?&
    return evt.currentTarget.value.match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,50}$/');
}


    
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// Fonction verifierSpecialites : 
function verifierSpecialites(evt){
    return evt.currentTarget.value.match('/^[0-9]+(-[0-9]+)*$/');
}


    
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// Fonction verifierLogin : 
function verifierLogin(evt){
    return evt.currentTarget.value.match('/^[A-Za-z0-9\._]{4,50}$/');
}


    
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// Fonction verifierDateRendezVous : 
function verifierDateRendezVous(evt){
    let inputDate = new Date(evt.currentTarget.value);

    if(inputDate != null){
        return (new Date().getDay() - inputDate.getDay()) > 0;
    }

    return false;
}



// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// Fonction verifierCodePostal : 
function verifierCodePostal(evt){
    return evt.currentTarget.value.match('/^(0[1-9]|[1-8]\d|9[0-8])([0-9]{3})$/');
}



// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// Fonction verifierRegEx : 
function verifierRegEx(evt){
    let result = false;
    switch (evt.currentTarget.id){
        case 'prenom' :
            result = verifierPrenomNom(evt);
            inputPrenomPElement.innerHTML = result ? "" : errorMessagesArray[0]; 
        return result;
        case 'nom' :
            result = verifierPrenomNom(evt);
            inputNomPElement.innerHTML = result ? "" : errorMessagesArray[1]; 
        return result;
        case 'email' :
            result = verifierEmail(evt);
            inputEmailPElement.innerHTML = result ? "" : errorMessagesArray[2]; 
        return result;
        case 'dateNaissance' :
            result = verifierDateNaissance(evt);
            inputDateNaissancePElement.innerHTML = result ? "" : errorMessagesArray[3]; 
        return result;
        case 'adresse' :
            result = verifierAdresse(evt);
            inputAdressePElement.innerHTML = result ? "" : errorMessagesArray[4]; 
        return result;
        case 'ville' :
            result = verifierVille(evt);
            inputVillePElement.innerHTML = result ? "" : errorMessagesArray[5]; 
        return result;
        case 'sexe' :
            result = verifierSexe(evt);
            inputSexePElement.innerHTML = result ? "" : errorMessagesArray[6]; 
        return result;
        case 'numeroTelephone' :
            result = verifierNumeroTelephone(evt);
            inputNumeroTelephonePElement.innerHTML = result ? "" : errorMessagesArray[8]; 
        return result;
        case 'mdp' :
            result = verifierMdp(evt);
            inputMdpPElement.innerHTML = result ? "" : errorMessagesArray[7]; 
        return result;
        case 'specialites' :
            result = verifierSpecialites(evt);
            inputSpecialitesPElement.innerHTML = result ? "" : errorMessagesArray[9]; 
        return result;
        case 'villePro' :
            result = verifierVille(evt);
            inputVilleProPElement.innerHTML = result ? "" : errorMessagesArray[5]; 
        return result;
        case 'adressePro' :
            result = verifierAdresse(evt);
            inputAdresseProPElement.innerHTML = result ? "" : errorMessagesArray[4]; 
        return result;
        case 'login' :
            result = verifierLogin(evt);
            inputLoginPElement.innerHTML = result ? "" : errorMessagesArray[10]; 
        return result;
        case 'dateRendezVous' :
            result = verifierDateRendezVous(evt);
            inputdateRendezVousPElement.innerHTML = result ? "" : errorMessagesArray[11]; 
        return result;
        default :
        return false;
    }
}



// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// Ajout des écouteurs d'événements

inputPrenom.addEventListener('focusout', verifierRegEx);
inputNom.addEventListener('focusout', verifierRegEx);
inputEmail.addEventListener('focusout', verifierRegEx);
inputDateNaissance.addEventListener('focusout', verifierRegEx);
inputAdresse.addEventListener('focusout', verifierRegEx);
inputVille.addEventListener('focusout', verifierRegEx);
inputSexe.addEventListener('focusout', verifierRegEx);
inputNumeroTelephone.addEventListener('focusout', verifierRegEx);
inputMdp.addEventListener('focusout', verifierRegEx);
inputSpecialites.addEventListener('focusout', verifierRegEx);
inputVillePro.addEventListener('focusout', verifierRegEx);
inputAdressePro.addEventListener('focusout', verifierRegEx);
inputLogin.addEventListener('focusout', verifierRegEx);
inputDateRendezVous.addEventListener('focusout', verifierRegEx);