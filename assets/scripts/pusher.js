import Pusher from 'pusher-js';

const pusher = new Pusher('ae911b6f5186ce8dcf0c', {
    cluster: 'eu',
    encrypted: true
});

export default pusher;
