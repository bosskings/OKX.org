function addTraders() {
    
    
    var form = document.getElementById('createTraderForm');
    
    var formData = new FormData(form);
    
    console.log(formData);
    
    // jQuery AJAX request
    $.ajax({
        url: "/createTraders",
        type: "POST",
        data: formData,
        processData: false,                     // Tell jQuery not to process the data
        contentType: false,                     // Tell jQuery not to set contentType
       
        success: function(data) {
       
            var resultCell = $('#resultStock');
            if(data.success) {
                resultCell.html('<span class="text-success">Trader created!</span>');
                // Optionally reset the form
                form.reset();
            } else {
                resultCell.html('<span class="text-danger">Error: ' + (data.message || 'Failed') + '</span>');
            }
        },
        error: function(xhr) {
            var msg = 'Server error.';
            if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                msg += ' ' + xhr.responseJSON.message;
            }
            $('#resultStock').html('<span class="text-danger">' + msg + '</span>');
        }
    });
}


function approve_investment(id, amount) {

    $.ajax({
        url: "/approveInvestment", // Route to search
        type: "POST",
        data: { 
            user_id: id
        },

        success: function(data) {

            console.log(data);
            
            
            if(data.success) {
                $('#statusArea').html('<span class="text-success">User investment approved!</span>').css('display', 'block');
                setTimeout(function() {
                    $('#statusArea').css('display', 'none');
                }, 1000);
                $('#statusArea').css('display', 'none')   
            }
        }, 
        error: function() {
            // Handle any errors in the AJAX request
            $('.statusArea').append('<span>Error occurred while searching</span>');
        }
    });
    
}


function approve_withdraw(id, status, amount) {

    $.ajax({
        url: "/withdraw_request", // Route to search
        type: "GET",
        data: { 
            status: status, 
            amount:amount,
            transaction_id: id
        },

        success: function(data) {

            console.log(data);
            
            
            if(data.success) {
                $('#requestArea').css('display', 'none')   
            }else{
                $('#requestArea').append(`<span style='color:red'> ${data.message}</span>`)   
            }
            // location.reload();
        }, 
        error: function() {
            // Handle any errors in the AJAX request
            $('.requestArea').append('<span>Error occurred while searching</span>');
        }
    });
    
}


// function to change balance
function changeBalance(id){
    // Find the corresponding button and disable it
    var btn = $('.input-group-text');
    btn.css('display', 'none');

    $.ajax({
        url: "/change_balance", // Route to search 
        type: "GET",
        data: { 
            amount: $('#balance'+id).val(),
            user_id: id
        },

        success: function(data) {

            if(data.success) {
                $('#resultBalance'+id).append('<span style="color:green">success</span>');
            }
            // Enable the button again after success
            btn.css('display', 'inline');
        }, 
        error: function(e) {
            // Handle any errors in the AJAX request
            $('#resultBalance'+id).append('<span style="color:red">Error occurred while searching</span>');

            // Enable the button again on error
            btn.css('display', 'inline');
        }
    }); 
}



// function to suspend user
function suspend_user(id){

    $.ajax({
        url: "/suspend_user", // Route to search 
        type: "GET",
        data: { 
            data: $('#suspend'+id).val(),
            user_id: id
        },

        success: function(data) {
            
            if(data.success) {
                $('#resultSuspend'+id).append('<span style="color:green">success</span>')   
            }
        }, 
        error: function(e) {
            // console.error(e && e.responseJSON && e.responseJSON.message ? e.responseJSON.message : e);
            
            // Handle any errors in the AJAX request
            $('#resultSuspend'+id).append('<span style="color:red">Error occurred while searching</span>');
        }
    });

    // Disable all buttons with class "input-group-text"
    $('.input-group-text').prop('disabled', true);
}



// function to reset password
function reset_password(user_id) {
    
    $.ajax({
        url: '/admin_reset',
        type: 'GET',
        data: {
            user_id: user_id,
        },
        success: function(response) {
            if (response.success) {
                alert('Password reset successfully to 00000000.');
            } else {
                alert(response.message || 'Unable to reset password.');
            }
        },
        error: function(xhr) {
            let resp = xhr.responseJSON;
            alert((resp && resp.message) ? resp.message : 'Error resetting password.');
        }
    });
}