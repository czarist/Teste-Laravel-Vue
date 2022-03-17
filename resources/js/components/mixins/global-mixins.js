import moment from 'moment'
export default {
    data(){
        return{
            loading: false,
            baseURL:process.env.MIX_BASE_URL,
            data_init: {
                branding: false,
                height: 500,
                mode: 'textareas',
                plugins: 'print preview fullpage autosave save fullscreen image link media codesample table  hr pagebreak  insertdatetime advlist lists textpattern code paste',
                autosave_prefix: "tinymce-autosave-{path}{query}-{id}-",
                paste_data_images: false, 
                menubar: 'table tc',
                toolbar: 'fontselect fontsizeselect formatselect | undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor  permanentpen formatpainter | fullscreen preview | image | code',
                document_base_url: this.baseURL
            }
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
