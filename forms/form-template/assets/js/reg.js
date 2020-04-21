const host =  window.location.origin;
const imgPath = host+'/forms/assets/img/';
// URLs images
var female_img = imgPath+'women.gif';
var male_img = imgPath+'Life%20Cycle-595b40b75ba036ed117d9ef0.svg';

// On page loaded
$( document ).ready(function() {    
    // Set the "who" message
    set_who_message1();
    set_who_message2();

    // On change fist name input
    $("#first_name1").keyup(function() {
        // Set the "who" message
        set_who_message1();
        
        if(validation_name($("#first_name1").val()).code == 0) {
            $("#first_name1").attr("class", "form-control is-invalid");
            $("#first_name_feedback1").html(validation_name($("#first_name1").val()).message);
        } else {
            $("#first_name1").attr("class", "form-control");
        }
    });

        // On change fist name input
    $("#first_name2").keyup(function() {
        // Set the "who" message
        set_who_message2();
        
        if(validation_name($("#first_name2").val()).code == 0) {
            $("#first_name2").attr("class", "form-control is-invalid");
            $("#first_name_feedback2").html(validation_name($("#first_name2").val()).message);
        } else {
            $("#first_name2").attr("class", "form-control");
        }
    });

    // On change last name input
    $("#last_name1").keyup(function() {
        // Set the "who" message
        set_who_message1();
        
        if(validation_name($("#last_name1").val()).code == 0) {
            $("#last_name1").attr("class", "form-control is-invalid");
            $("#last_name_feedback1").html(validation_name($("#last_name1").val()).message);
        } else {
            $("#last_name1").attr("class", "form-control");
        }
    });

    // On change last name input
    $("#last_name2").keyup(function() {
        // Set the "who" message
        set_who_message2();
        
        if(validation_name($("#last_name2").val()).code == 0) {
            $("#last_name2").attr("class", "form-control is-invalid");
            $("#last_name_feedback2").html(validation_name($("#last_name2").val()).message);
        } else {
            $("#last_name2").attr("class", "form-control");
        }
    });
});



/**
*   Set "who" message
*/
function set_who_message1() {
    var sex = $("#input_sex1").val();
    var first_name = $("#first_name1").val();
    var last_name = $("#last_name1").val();
    
    if (validation_name(first_name).code == 0 || 
        validation_name(last_name).code == 0) {
        // Informations not completed
        $("#who_message1").html("Team Member 1");
    } else {
        // Informations completed
        $("#who_message1").html(sex+" "+first_name+" "+last_name);
    }
}

function set_who_message2() {
    var sex = $("#input_sex2").val();
    var first_name = $("#first_name2").val();
    var last_name = $("#last_name2").val();
    
    if (validation_name(first_name).code == 0 || 
        validation_name(last_name).code == 0) {
        // Informations not completed
        $("#who_message2").html("Team Member 2 (Optional)");
    } else {
        // Informations completed
        $("#who_message2").html(sex+" "+first_name+" "+last_name);
    }
}

/**
*   Validation function for last name and first name
*/
function validation_name (val) {
    if (val.length < 2) {
        // is not valid : name length
        return {"code":0, "message":"The name is too short."};
    }
    if (!val.match("^[a-zA-Z\- ]+$")) {
        // is not valid : bad character
        return {"code":0, "message":"The name use non-alphabetics chars."};
    }
    
    // is valid
    return {"code": 1};
}

