function addTraders() {
    
    
    var form = document.getElementById('createTraderForm');
    
    var formData = new FormData(form);
    
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
                location.reload();
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


function approve_investment(id, amount, transaction_id) {

    $.ajax({
        url: "/approveInvestment", // Route to search
        type: "POST",
        data: { 
            user_id: id,
            amount:amount,
            transaction_id:transaction_id
        },

        success: function(data) {

            console.log(data);
            
            
            if(data.success) {
                $('#statusArea').html('<span class="text-success">User investment approved!</span>').css('display', 'block');
                setTimeout(function() {
                    location.reload();
                }, 2000);
            }
        }, 
        error: function() {
            // Handle any errors in the AJAX request
            $('.statusArea').append('<span>Error occurred while searching</span>');
        }
    });
    
}


function approveWithdrawal(status, id, amount, withdraw_id) {

    $.ajax({
        url: "/approveWithdrawal", // Route to search
        type: "POST",
        data: { 
            user_id:id,
            status: status, 
            amount:amount,
            withdraw_id: withdraw_id
        },

        success: function(data) {

            console.log(data.message);
            
            if (data.success) {
                $('#requestArea').html('<span style="color:green">Withdrawal processed successfully!</span>');
                setTimeout(function() {
                    location.reload();
                }, 2000);
            } else {
                $('#requestArea').append(`<span style='color:red'> ${data.message}</span>`);
            }
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
        url: "/changeBalance", // Route to search 
        type: "POST",
        data: { 
            amount: $('#balance_'+id).val(),
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



// function to change PNL
function todaysPnl(id){
    // Find the corresponding button and disable it
    var btn = $('.input-group-text');
    btn.css('display', 'none');

    $.ajax({
        url: "/changePnl", // Route to search 
        type: "POST",
        data: { 
            amount: $('#todaysPnl_'+id).val(),
            user_id: id
        },

        success: function(data) {

            if(data.success) {
                $('#resultPnl'+id).append('<span style="color:green">success</span>');
            }
            // Enable the button again after success
            btn.css('display', 'inline');
        }, 
        error: function(e) {
            let errMsg = 'Error occurred while searching';
            if (e && e.responseJSON && e.responseJSON.message) {
                errMsg = e.responseJSON.message;
            }
            console.error(errMsg);
            $('#resultPnl'+id).append('<span style="color:red">Error occurred while searching</span>');

            // Enable the button again on error
            btn.css('display', 'inline');
        }
    }); 
}

// function to change total assets
function totalAssets(id){
    // Find the corresponding button and disable it
    var btn = $('.input-group-text');
    btn.css('display', 'none');

    $.ajax({
        url: "/changeTotalAssets", // Route to search 
        type: "POST",
        data: { 
            amount: $('#assets'+id).val(),
            user_id: id
        },

        success: function(data) {

            if(data.success) {
                $('#resultAssets'+id).append('<span style="color:green">success</span>');
            }
            // Enable the button again after success
            btn.css('display', 'inline');
        }, 
        error: function(e) {
            let errMsg = 'Error occurred while searching';
            if (e && e.responseJSON && e.responseJSON.message) {
                errMsg = e.responseJSON.message;
            }
            console.error(errMsg);

            // Handle any errors in the AJAX request
            $('#resultAssets'+id).append('<span style="color:red">Error occurred while searching</span>');

            // Enable the button again on error
            btn.css('display', 'inline');
        }
    }); 
}




// function to suspend user
function suspend_user(id){

    $.ajax({
        url: "/suspendUser", // Route to search 
        type: "POST",
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



// function to verify user
function verifyUser(id){

    $.ajax({
        url: "/verifyUser", // Route to search 
        type: "POST",
        data: { 
            data: $('#verify'+id).val(),
            user_id: id
        },

        success: function(data) {
            
            if(data.success) {
                $('#resultVerify'+id).append('<span style="color:green">success</span>')   
            }
        }, 
        error: function(e) {
            // console.error(e && e.responseJSON && e.responseJSON.message ? e.responseJSON.message : e);
            
            // Handle any errors in the AJAX request
            $('#resultVerify'+id).append('<span style="color:red">Error occurred </span>');
        }
    });

    // Disable all buttons with class "input-group-text"
    $('.input-group-text').prop('disabled', true);
}



// function to reset password
function reset_password(user_id) {
    
    $.ajax({
        url: '/changePassword',
        type: 'POST',
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