$(document).ready(function(){
    $('.js-user-autocomplete').autocomplete({hint:false} , [
        {
            source: function(query , cb){
                cb([
                    {value: 'manouba'},
                    {value: 'tunis'}
                ])
            }
        }
    ]);
});