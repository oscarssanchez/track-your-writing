jQuery( document ).ready( function($) {
   $( '#select_user_profile' ).change( function(){
       var user_id = $(this).children(":selected").attr("value");
       jQuery.ajax({
           url : ajaxurl,
           type: 'post',
           data : {
               action : 'tyw_user_profile',
               user_id : user_id
           },
           sucess : function ( response ) {
               alert(response);
               console.log( 'Success retrieving id: ' + id );
           }
       });
   });
});

