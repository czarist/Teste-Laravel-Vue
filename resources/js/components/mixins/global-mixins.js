import moment from 'moment'
export default {
    data(){
        return{
            loading: false,
        }
    },

    methods:{
        message(title, message, type, duration = null){
            this.$notify({
                group: 'submit',
                clean: true
            })
            this.$notify({
                group: 'submit',
                title: title,
                text: message,
                type: type,
                duration: duration ? duration : 3000
            });
        },
    }
}
