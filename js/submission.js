$(window).load(function(){
  $( '#form' ).submit( function( event )  {
    event.preventDefault();
    $( '#message-success' ).fadeOut();
    $( '#message-danger' ).fadeOut();
    var FormData = $( this ).serialize();

    $.ajax({
      type     : 'POST',
      url      : '/_app/digest.php',
      data     : FormData,
      dataType : 'json',
      encode   : true
    }).done(function( contact ) {

      if( contact.successMsg ) {

        $( '#message-success' ).html( contact.successMsg );
        $( '#message-success' ).fadeIn();
        document.getElementById("#form").reset();

      } else if( contact.errorMsg ) {

       $( '#message-danger' ).html( contact.errorMsg );
       $( '#message-danger' ).fadeIn();
     }

   }).fail(function() {
    $( '#message-danger' ).html( 'Please check your Internet connection or try again later' );
    $( '#message-danger' ).fadeIn();
  });
 });

});

