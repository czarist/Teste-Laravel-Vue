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
                title: '<span style="font-size:27px;">'+title+'</span>',
                text: '<span style="font-size:20px;">'+message+'</span>',
                type: type,
                duration: duration ? duration : 6000
            });
        },
    }
}
