function checkRequired(inputArray){
    let error = 0;
    for(input of inputArray) {
        if(input.val() === null || input.val().trim() === ''){
            showError(input, `${getFieldName(input)} is required`);
            error++;
        }else{
            hideError(input);
        }
    };
    if(error > 0){
        return false;
    }
    return true;
}

function checkIfOnlyLetters(field){
    if(/^[a-zA-Z]+$/.test(field.val())){
        hideError(field);
        return true;
    }else{
        showError(field, `${getFieldName(field)} doit contenir que des lettres`);
        return false;
    }
}

function validateResponse(field){
    if(field.value.trim() === ''){
        field.classList.add('is-invalid');
        field.parentElement.querySelector('small').innerText = 'Response is required';
        return false;
    }
    field.classList.remove('is-invalid');
    field.parentElement.querySelector('small').innerText = '';
    return true;
}

function checkLength(field, min, max) {//Tester la longueur de la valeur  d'un field
    if(field.val().length < min){
        showError(field, `${getFieldName(field)} must be at least ${min} characters!`)
        return false;
    }else if(field.val().length > max){
        showError(field, `${getFieldName(field)} must be less than ${max} characters !`);
        return false;
    }else{
        hideError(field);
        return true;
    }
}

function validatePassword(field){
    // 1 - a
    if(!containsCharacters(field, 1)) return;
    // 2 - a 1
    if(!containsCharacters(field, 2)) return;
    // 3 - A a 1
    if(!containsCharacters(field, 3)) return;
    // 4 - A a 1 @
    if(!containsCharacters(field, 4)) return;

    return true;
}

function containsCharacters(field, code){
    let regEx;
    switch(code){
        case 1 :
            // letter
            regEx = /(?=.*[a-zA-Z])/;
            return matchWithRegEx(field, regEx, 'Doit contenir au moins une lettre');
        case 2 :
            // letter & number
            regEx = /(?=.*\d)(?=.*[a-zA-Z])/;
            return matchWithRegEx(field, regEx, 'Doit contenir au moins une lettre et un nombre');
        case 3 :
            // lowercase, uppercase & number
            regEx = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/;
            return matchWithRegEx(field, regEx, 'Doit contenir au moins une lettre majuscule, une lettre minuscule et un nombre');
        case 4 :
            // lowercase, uppercase, number & special char
            regEx = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W)/;
            return matchWithRegEx(field, regEx, 'Doit contenir au moins une lettre majuscule, une lettre minuscule, un nombre et un caratère special');
        default :
            return false;
    }
}

function matchWithRegEx(field, regEx, message){
    if(field.val().match(regEx)){
        hideError(field);
        return true;
    }else{
        showError(field, message);
        return false;
    }
}

function validateConfirmPassword(password, confirm){
    if(password.val() !== confirm.val()){
        showError(confirm, "Les mots de passe ne sont pas identiques");
        return false;
    }
    hideError(confirm);
    return true;
}

function validateAvatar(field){
    if(field.value.trim() === ''){
        field.parentElement.nextElementSibling.innerHTML =  "Veuillez choisir une image";
        return false;
    }else{
        const fileSize = field.files[0].size;
        const fileName = field.files[0].name;
        
        const extensions = ["jpg", "jpeg", "png"];

        const fileExt = fileName.split(".");
        fileActExt = fileExt[fileExt.length-1].toLowerCase();

        if(!extensions.includes(fileActExt)){
            field.parentElement.nextElementSibling.innerHTML = "Veuillez choisir un format jpg ou png";
            return false;
        }else if(fileSize > 500000){
            field.parentElement.nextElementSibling.innerHTML = "Fichier trop volumineux";
            return false;
        }
    }
    field.parentElement.nextElementSibling.innerHTML = '';
    return true;
}

function getFieldName(input) {
    //Retour le nom de chaque input en se basant sur son id
    return input.attr('id').charAt(0).toUpperCase() + input.attr('id').slice(1);
}

function showError(field, message){
    field.addClass('is-invalid');
    field.parent().children('small').html(message);
}

function hideError(field){
    field.removeClass('is-invalid');
    field.parent().children('small').html('');
}