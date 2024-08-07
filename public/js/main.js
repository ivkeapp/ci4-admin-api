var displayedNotificationIds = [];
let isInitialLoad = true;

$(document).ready(function() {
    checkForNewNotifications();

    // Poll every 30 seconds (30000 ms)
    setInterval(checkForNewNotifications, 10000);
});

function infoMessage(message = '', type, title = '', link = ''){
    string = '';
    var n = Date.now();
    icon = '';
    if (type == 'success'){
        title = title ? title : 'Uspešno!';
        icon='<i class="fas fa-check-circle"></i>';
    } else if (type == 'info'){
        title = title ? title : 'Info!';
        icon='<i class="fas fa-info-circle"></i>';
    } else if (type == 'danger'){
        title = title ? title : 'Upozorenje!';
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
                (link ? '<a href="'+link+'">View more</a>' : '')+
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

function checkForNewNotifications() {
    $.ajax({
        url: '/notifications/check-new',
        type: 'GET',
        contentType: 'application/json',
        success: function(response) {
            console.log(response, 'response');
            const newNotifications = response.filter(notification => !displayedNotificationIds.includes(notification.id));
            if (!isInitialLoad && newNotifications.length > 0) {
                newNotifications.forEach(notification => {
                    infoMessage(notification.message, 'info');
                    displayedNotificationIds.push(notification.id);
                });
            } else {
                // On initial load, just store the IDs without displaying
                newNotifications.forEach(notification => {
                    displayedNotificationIds.push(notification.id);
                });
                isInitialLoad = false; // Set the flag to false after initial load
            }
        },
        error: function(xhr, status, error) {
            // console.log(error, 'error');
            // console.log(status, 'status');
        }
    });
}