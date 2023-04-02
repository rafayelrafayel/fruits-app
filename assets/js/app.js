import { createApp } from 'vue';
import App from './components/App.vue';
import router from './router';
// any CSS you import will output into a single css file (app.css in this case)
import '../styles/app.css';

const app = createApp(App);

app.use(router);

app.mount('#app');


