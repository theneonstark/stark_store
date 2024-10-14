function fetchNotification() {
    $.ajax({
      url: 'notify-badge-config.php',
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        if (response.data >= "1") {
          if (!$('.notification-btn').find('span').length) {
            $('.notification-btn').append(`
              <span aria-hidden="true" 
                    class="absolute top-0 right-0 inline-block w-3 h-3 transform translate-x-1 -translate-y-1 bg-red-600 border-2 border-white rounded-full dark:border-gray-800"></span>
            `);
          }
          $('.notification-count').html(response.data);
        } else {
          $('.notification-btn').find('span').remove();
        }
      },
      error: function(xhr, status, error) {
        console.log("Error: " + error);
      }
    });
  }
  
  
  function fetchCount() {
    $.ajax({
      url: 'notify-count-config.php',
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        if (response.data >= "1") {
          $('.notification-count').html(response.data);
        } else {
          $('.notification-count').html(0);
        }
      },
      error: function(xhr, status, error) {
        console.log("Error: " + error);
      }
    });
  }
  
  $('.notification-btn').on('click', function() {
    $.ajax({
      url: 'notify-badge-clear.php',
      type: 'POST',
      success: function(response) {
        $('.notification-btn').find('span').remove();
      },
      error: function(xhr, status, error) {
        console.log("Error: " + error);
      }
    });
  });
  
  
  $(document).ready(function() {
    fetchNotification();
    fetchCount();
    setInterval(fetchNotification, 1000);
    setInterval(fetchCount, 1000);
  });