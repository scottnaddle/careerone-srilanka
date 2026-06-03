document.addEventListener('DOMContentLoaded', function() {
    if (window.Laravel.user) {
        const userId = window.Laravel.user.nic;
        var channel = Pusher.subscribe('NotificationEvent');
        channel.bind(`send-message-${userId}`, function (data) {
            var newNotificationHtml = `
                <a href="${data.href || '#'}" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 notification-item bg-gray-300 dark:bg-gray-900" data-id="${data.id}">
                    ${data.icon}
                    <div class="w-full ps-3 text-start">
                        <div class="text-gray-900 text-sm dark:text-white">${data.message}</div>
                        <div class="text-xs text-blue-600 dark:text-blue-500">a few moments ago</div>
                    </div>
                </a>
            `;

            document.querySelector('.show-notification').insertAdjacentHTML('afterbegin', newNotificationHtml);
        });
        document.querySelector('.show-notification').addEventListener('click', function (e) {
            if (e.target.closest('a.notification-item')) {
                e.preventDefault();
                var notificationElement = e.target.closest('a.notification-item');
                var notificationId = notificationElement.getAttribute('data-id');

                markAsRead(notificationElement, notificationId);

                if (notificationElement.getAttribute('href') !== '#') {
                    window.location.href = notificationElement.getAttribute('href');
                }
            }
        });

    }

});
