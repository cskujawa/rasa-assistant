<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Chat">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-lg sm:rounded-lg">
                    <vue-advanced-chat
                        height="calc(100vh - 200px)"
                        :current-user-id="currentUserId"
                        :rooms="JSON.stringify(rooms)"
                        :rooms-loaded="true"
                        :messages="JSON.stringify(messages)"
                        :messages-loaded="messagesLoaded"
                        @send-message="sendMessage($event.detail[0])"
                        :show-search="false"
                        :show-add-room="false"
                        :show-files="false"
                        :show-audio="false"
                        :show-emojis="false"
                        :show-reaction-emojis="false"
                        :single-room="true"
                        :theme="dark"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
  
<script>
    import { register } from 'vue-advanced-chat'

    register()
    
    export default {
        data() {
            return {
                currentUserId: '1234',
                rooms: [
                    {
                        roomId: '1',
                        roomName: 'J.A.R.V.I.S.',
                        avatar: 'https://w7.pngwing.com/pngs/571/686/png-transparent-jarvis-logo-edwin-jarvis-iron-man-youtube-marvel-cinematic-universe-male-jarvis-ui-comics-superhero-computer-thumbnail.png',
                        users: [
                            { _id: '1234', username: 'John Doe' },
                            { _id: '4321', username: 'John Snow' }
                        ]
                    }
                ],
                messages: [],
                messagesLoaded: true
            }
        },

        //Function to greet visitors upon entry
        mounted() {
            this.jarvisSays("Hello...");
        },

        methods: {
            sendMessage(message) {
                this.messages = [
                    ...this.messages,
                    {
                        _id: this.messages.length,
                        content: message.content,
                        senderId: this.currentUserId,
                        timestamp: new Date().toString().substring(16, 21),
                        date: new Date().toDateString()
                    }
                ]
                this.request(message.content);
            },

            jarvisSays($message) {
                this.messages = [
                    ...this.messages,
                    {
                        _id: this.messages.length,
                        content: $message,
                        senderId: '4321',
                        timestamp: new Date().toString().substring(16, 21),
                        date: new Date().toDateString()
                    }
                ]
            },

            request($message){
                axios.post("/api/rasa", {'message' : $message})
                    .then((response) => {
                        console.log("Request Handler", response.data );
                        for (var key in response.data['response']) {
                            console.log("Key is:")
                            console.log(key);
                            if ('text' in response.data['response'][key]) {
                                this.jarvisSays(response.data['response'][key]['text']);
                            }
                            else if ('image' in response.data['response'][key]){
                                this.jarvisSays(response.data['response'][key]['image']);
                            }
                        }
                        
                    })
                    .catch( error => {
                        console.log('Internal API Error:');
                        console.log(error);
                    });
            }
        }
    }
</script>