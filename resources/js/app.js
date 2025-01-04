import './bootstrap';

import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

Echo.private(`App.Models.User.${userId}`)
    .notification((notification) => {
        // Tambahkan fungsi untuk menampilkan notifikasi baru di sini
        console.log(notification);
    });
