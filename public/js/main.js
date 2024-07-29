function infoMessage(message, type){
    console.log('triggered');
    string = '';
    var n = Date.now();
    icon = '';
    if (type == 'success'){
        title = 'Uspešno!';
        icon='<i class="fas fa-check-circle"></i>';
    } else if (type == 'info'){
        title = 'Info!';
        icon='<i class="fas fa-info-circle"></i>';
    } else if (type == 'danger'){
        title = 'Upozorenje!';
        icon='<i class="fas fa-exclamation-triangle"></i>';
    } else {
        icon='<i class="fas fa-question-circle"></i>';
    }
    string += '<div class="wh-notif-holder global-notif-'+n+'">'+
        '<div class="wh-notif-item '+type+'">'+
            '<div class="notif-item-icon">'+icon+'</div>'+
            '<div class="notif-item-content">'+
                '<h4>'+title+'</h4>'+
                '<p>'+message+'</p>'+
            '</div>'+
            '<span class="notif-item-close"><i class="fas fa-times"></i></span>'+
        '</div>'+
        '<div class="wh-notif-progress"></div>'+
    '</div>';
    $('.toast-holder').append(string);
    setTimeout(function(){ $('.global-notif-'+n+'').addClass('show'); }, 100);
    setTimeout(function(){ $('.global-notif-'+n+'').removeClass('show'); }, 5000);
    setTimeout(function(){ $('.global-notif-'+n+'').addClass('shrink'); }, 6000);
}

$(document).on('click', '.notif-item-close', function(){

  $(this).closest('.wh-notif-holder').removeClass('show');
  setTimeout(function(){ $(this).closest('.wh-notif-holder').addClass('shrink'); }, 1000);
  setTimeout(function(){ $(this).closest('.wh-notif-holder').remove(); }, 2000);

}); 