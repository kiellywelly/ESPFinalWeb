$(document).ready(function() {
    $( '.dropdown' ).hover(
        function(){
            $(this).children('.sub-menu').slideDown(200);
        },
        function(){
            $(this).children('.sub-menu').slideUp(200);
        }
    );
}); // end ready

$('input[type="submit"]').mousedown(function(){
  $(this).css('background', '#2ecc71');
});
$('input[type="submit"]').mouseup(function(){
  $(this).css('background', '#1abc9c');
});

$('#loginform').click(function(){
  $('.login').fadeToggle('slow');
  $(this).toggleClass('green');
});


//.limit400 h1 { font-size:10px; }
//.limit1200 h1 { font-size:50px; }
//JS
window.onresize = function() {
    alert(hi);
};
$(window).on('resize', function() {
    if($(window).width() > 500) {
        $('#formholder').addClass('formholderbig');
        $('#formholder').removeClass('formholdersmall');
    }else{
        $('#formholder').addClass('formholdersmall');
        $('#formholder').removeClass('formholderbig');
    }
});
$(document).mouseup(function (e)
{
    var container = $(".login");

    if (!container.is(e.target) && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.hide();
        $('#loginform').removeClass('green');
    }
});


$("#login").click(function(){
    var email = "dwarren0@unc.edu";
    var password = "N1QsCK7TKB7G";
    // Checking for blank fields.
    if( email =='' || password ==''){
        $('input[type="text"],input[type="password"]').css("border","2px solid red");
        $('input[type="text"],input[type="password"]').css("box-shadow","0 0 3px red");
        alert("Please fill all fields...!!!!!!");
    }else {
        $.ajax({
            url: 'http://localhost:9999/login',
            type: "POST",
            contentType: 'application/json',
            data: JSON.stringify({ "username_or_email" : email, "password" : password, "Type" : "SaaSGrid"}),
            success: function(data)
            {
                 authToken = data.Token;
                 console(authToken);
            } 
         });

    }
});
