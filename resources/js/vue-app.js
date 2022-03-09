import {createApp, ref, computed} from 'vue'
import Editor from './components/Editor.vue'

const app = createApp({
    components: {
        Editor
    }
});
app.mount("#vapp");
