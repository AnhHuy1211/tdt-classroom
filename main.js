$(document).ready(function(){
    $('.nav-user').popover();

    $('textarea').each(function () {
        this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
    }).on('input', function () {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    //select all checkboxes
    $("#select_all").change(function(){  //"select all" change
        $(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
    });

//".checkbox" change
    $('.checkbox').change(function(){
        //uncheck "select all", if one of the listed checkbox item is unchecked
        if(false === $(this).prop("checked")){ //if this item is unchecked
            $("#select_all").prop('checked', false); //change "select all" checked status to false
        }
        //check "select all" if all checkbox items are checked
        if ($('.checkbox:checked').length === $('.checkbox').length ){
            $("#select_all").prop('checked', true);
        }
    });


    //email invitation
    setTimeout(function() {
        $('.box-up').hide(400, function (){
            window.history.back();
        });
    }, 2000);

    $('.search-input').on('keyup', function () {
        let inputSearch = $(this).val();
        let resultList = $(this).siblings('.search-result-list');
        $.get("class-search.php", {term: inputSearch}).done(function(data){
            // Display the returned data in browser
            console.log(data);
            resultList.html(data);
        });
    });
    
    $('#share-content').focus(function () {
        $('.share-section-buttons').css({
            'height' : '38px',
            'transition': 'height 0.2s linear'
        });
        $('.post-btn').show();
        $('.cancel-btn').show();
    })
});
function openNav() {
    $(".sidebar").css("width", "19rem");
    enableSearchBox(2);
}

function closeNav() {
    $('.sidebar').css("width", "0");
    $('[data-toggle="popover"]').popover("hide");
    this.$('#collapseSection').collapse("hide");
}

function hideShareButton() {
    $('.share-section-buttons').css({
        'height' : '0',
        'transition': 'height 0.2s linear'
    });
    $('.post-btn').hide();
    $('.cancel-btn').hide();
}

/////////////////////////// CREATE & JOIN CLASS FORM HANDLER //////////////////////////////

function enableModalButton() {
    let button = $('.add-class-btn');
    let className = $('#class-name').val();
    let classCode = $('#class-code').val();

    if(className === undefined) {className = 0;}

    if(classCode === undefined) {classCode = 0;}
    else {classCode = classCode.length;}

    button.attr('disabled', true);

    if(className || classCode >= 7) {
        button.attr('disabled', false);
    }

}

function enableInviteButton() {
    let button = $('.invite-btn');
    let studentInvite = $('#invite-student').val();
    let teacherInvite = $('#invite-teacher').val();

    button.attr('disabled', true);
    if(validateEmail(studentInvite) || validateEmail(teacherInvite)) {
        button.attr('disabled', false);
    }
}

/////////////////////////// REGISTER FORM HANDLER //////////////////////////////////////

function errorColorChange(element, active) { //change color of input form
    let submitButton = $('sign-up-btn');
    element.css({
        'border': '2px solid #f0f0f0',
        'outline-color': '#0275d8',
    });

    if(active) {
        element.css({
            'border': '2px solid #d9534f',
            'outline-color': '#d9534f',
        });

        submitButton.attr('disabled', true);
    }
}
function checkEmptyName() {
    let firstname = $('#firstname');
    let lastname = $('#lastname');
    let errorMessage = $('.name-error');
    let submitButton = $('#sign-up-btn');
    let letters = /^[A-Za-z]+$/;
    errorMessage.hide();
    errorMessage.empty();
    errorColorChange(firstname, false);
    errorColorChange(lastname, false);

    if(firstname.val().length < 1 && lastname.val().length > 0) {
        errorColorChange(firstname, true)
        errorMessage.html('First name is required');
        errorMessage.show(400);
        submitButton.attr("disabled", true);
        enableSubmitButton();
        return false;
    } else if(lastname.val().length < 1 && firstname.val().length > 0) {
        errorColorChange(lastname, true);
        errorMessage.html('Last name is required');
        errorMessage.show(400);
        submitButton.attr("disabled", true);
        enableSubmitButton();
        return false;
    }

    enableSubmitButton();
    return true;
}

function validateEmail(email) { //kiem tra dinh dang email
    let emailFormat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    return emailFormat.test(email);
}

function validateUsername(username) { //kiem tra dinh dang username
    let usernameFormat = /^(?=[a-zA-Z0-9._]{3,16}$)(?!.*[_.]{2})[^_.].*[^_.]$/;
    return usernameFormat.test(username);
}


function checkEmailExistence(active) { //kiem tra email ton tai chua
    let email = $('#email');
    let emailVal = email.val();
    let errorMessage = $('.email-error');
    errorMessage.hide();
    errorMessage.empty();
    errorColorChange(email, false);
    enableSubmitButton();
    if(active) { //neu active la 0 ham se khong chay
        if (emailVal.length) {
            $.get("./email-validate.php", {term: emailVal}).done(function (data) {
                if (!validateEmail(emailVal)) {
                    errorColorChange(email, true);
                    errorMessage.html('Invalid email address');
                    errorMessage.show(400);
                    enableSubmitButton();
                } else if (data) {
                    errorColorChange(email, true);
                    errorMessage.html('This email address is already taken');
                    errorMessage.show(400);
                    enableSubmitButton();
                } else {
                    errorMessage.hide();
                    errorMessage.empty();
                    enableSubmitButton();
                }
            });
        }
    }
}

function checkUserExistence(active) { //kiem tra email ton tai chua
    let user = $('#username');
    let userVal = user.val();
    let errorMessage = $('.username-error');
    errorMessage.hide();
    errorMessage.empty();
    errorColorChange(user, false);
    enableSubmitButton();
    if(active){ //neu active la 0 ham se khong chay
        if(userVal.length){
            $.get("./username-validate.php", {term: userVal}).done(function (data) {
                if(!validateUsername(userVal)) {
                    errorColorChange(user, true);
                    errorMessage.html('Invalid username');
                    errorMessage.show(400);
                    enableSubmitButton();
                } else if(data){
                    errorColorChange(user, true);
                    errorMessage.html('Username is already taken');
                    errorMessage.show(400);
                    enableSubmitButton();
                } else {
                    errorMessage.hide();
                    errorMessage.empty();
                    enableSubmitButton();
                }
            });
        }
    }

}

function checkPasswordValidate() {
    let password = $('#password');
    let errorMessage = $('.password-error');
    enableSubmitButton();
    if(password.val().length === 0) {
        errorColorChange(password, true);
        errorMessage.html('Password is required');
        errorMessage.show(400);
    }
    else if(password.val().length > 0 && password.val().length < 8) {
        errorMessage.hide();
        errorMessage.empty();
        errorColorChange(password, true);
    } else {
        errorMessage.hide();
        errorMessage.empty();
        errorColorChange(password, false);
    }
    checkPasswordConfirm();
}

function checkPasswordConfirm() {
    let password = $('#password');
    let passwordConfirm = $('#confirm');
    let errorMessage = $('.confirm-error');

    errorColorChange(passwordConfirm, false);

    if(password.val() !== passwordConfirm.val() && passwordConfirm.val().length !== 0) {
        errorColorChange(passwordConfirm, true);
        errorMessage.html("Passwords did not match");
        errorMessage.show(400);
        enableSubmitButton();
    } else {
        errorMessage.empty();
        errorMessage.hide();
        enableSubmitButton();
    }
    console.log(0);
}

function enableSubmitButton() {
    let submitButton = $('#sign-up-btn');
    let firstname = $('#firstname');
    let lastname = $('#lastname');
    let email = $('#email');
    let username = $('#username');
    let password = $('#password');
    let confirmPassword = $('#confirm');
    let errorMessage = $('.error');
    let enable = true;

    if (firstname.val().length < 1)
        enable = false;

    else if (lastname.val().length < 1)
        enable = false;

    else if (username.val().length < 3)
        enable = false;

    else if (email.val().length < 1)
        enable = false;

    else if (password.val().length < 8)
        enable = false;

    else if(confirmPassword.val() < 8 || confirmPassword.val() !== password.val())
        enable = false;

    else if (errorMessage.text())
        enable = false;

    if(enable) {
        submitButton.attr('disabled', false);
    }
    else{
        submitButton.attr('disabled', true);
    }
}

/////////////////////////// CLASS NAME EDIT //////////////////////////////////////
function saveClassname() {
    let xr = new XMLHttpRequest();
    let url = "./classname-edit.php";
    let val = $('.classname-header').text().trim();
    let content = "content=" + val;
    xr.open("POST", url, true);
    xr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xr.send(content);
    $(".save-edit").hide();
    $(".edit-description").show();
}

function editFieldFocus() {
    $('.classname-header').focus();
}

function enableEditButton() {
    $(".save-edit").show();
    $(".edit-description").hide();
}

//////////////////////////////  ENABLE SEARCH BOX ///////////////////////////////////////////////
function enableSearchBox(position) {
    if (position === 1) { // Navigation Bar
        let searchField = $('.search-input');
        let resultList = $('.search-result-list');
        searchField.css({
            'padding': '0 10px',
            'width': '250px',
            'caret-color': '#292b2c',
            'transition': 'width 0.4s linear',
            'border-bottom': '2px solid #292b2c'
        });
        searchField.focus();
        resultList.show(400);
    } else if(position === 2) { // Side Bar
        let searchField = $('.sidebar-searchbox');
        let resultList = $('.sidebar-result-list');
        searchField.css({
            'padding': '0 10px',
            'width': '250px',
            'caret-color': '#292b2c',
            'transition': 'width 0.4s linear',
            'border-bottom': '2px solid #292b2c'
        });
        resultList.show(400);
    }
}
function disableSearchBox(position) {
    if(position === 1) {
        let searchField = $('.search-input');
        let resultList = $('.search-result-list');
        resultList.hide();
        resultList.empty();
        searchField.css({
            'border': '0',
            'outline': '0',
            'background': 'none',
            'width': '0',
            'caret-color':'transparent',
            'line-height': '40px',
            'transition': 'width 0.4s linear'
        });
    } else if(position === 2) {
        let searchField = $('.sidebar-input');
        let resultList = $('.search-result-list');
        resultList.hide();
        resultList.empty();
        searchField.css({
            'border': '0',
            'outline': '0',
            'background': 'none',
            'width': '0',
            'caret-color':'transparent',
            'line-height': '40px',
            'transition': 'width 0.4s linear'
        });
    }

}

