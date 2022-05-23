// Homepage
$(document).ready(function () {
    $('#cart-modal').click(function () {
        $('.cart-modal').toggle(1000);
    })
    $('#cart-modal-primary').click(function () {
        $('.cart-modal').toggle(1000);
    })
    $('#modalClose').click(function () {
        $('.cart-modal').hide('slow');
    })
})

// menu toggler
$(document).ready(function () {
    $('#menu-toggler').click(function () {
        $('.left-menu').toggle(1000)
    })
    $('#menuClose').click(function () {
        $('.left-menu').hide(1000)
    })
})
// Checkout Page

$(document).ready(function () {
    $('#cashOnDelevery').change(function () {
        $('#orderNow').show();
        $('#payNow').hide();
    })
    $('#onlinePayment').change(function () {
        $('#payNow').show();
        $('#orderNow').hide();
    })
})

// login register page
$(document).ready(function () {
    $('#createAccount').click(function () {
        $('#register').show();
        $('#login').hide();
    })
    $('#backLogin').click(function () {
        $('#login').show();
        $('#register').hide();
    })
})

// user profile
$(document).ready(function () {
    $('#profile-nav').click(function () {
        $('#profile-card').show();
        $('#order-history-card').hide();
        $('#change-password-card').hide();
        $('#title').text('My Profile')
    })
    $('#password-nav').click(function () {
        $('#change-password-card').show();
        $('#profile-card').hide();
        $('#order-history-card').hide();
        $('#title').text('Change Password')
    })
    $('#order-history-nav').click(function () {
        $('#order-history-card').show();
        $('#profile-card').hide();
        $('#change-password-card').hide();
        $('#title').text('Order History')
    })
})
