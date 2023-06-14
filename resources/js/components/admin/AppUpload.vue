
<template>
    <div>
            <div class="form-group">
                <div class="form-control-sm">
                    <label class="round" >Добавить изображение !!!
                    <input  type="file" name="image" id="file" ref="file" multiple="" @change="fileInputChange()"></input>
                    </label>
                </div>

                <br>
                <img v-bind:src="imagePreview" v-show="showPreview"/>
            </div>
    </div>
</template>
<script>

    import { post } from '../../helpers/api';
    export default {
        name:'AppUpload',

        data(){
            return {
                files: [],
                imagePreview: '',
                showPreview: false,
            }
        },
        methods: {


            fileInputChange(e){
                this.files=this.$refs.file.files[0];
                this.encodeImage(this.files);
                if(this.files && this.files.length>0){

                }

                this.showPreview= true;
                this.$emit('input',this.files);

            },

            encodeImage (input) {
                if (input) {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                       this.imagePreview  = e.target.result;
                    };
                    reader.readAsDataURL(input);

                }
            },

        },


    }
</script>
<style>
    input[type="file"]{
        position: absolute;
        top: -500px;
    }
    div.file-listing{
        width: 200px;
    }
    span.remove-file{
        color: red;
        cursor: pointer;
        float: right;
    }
    img {
        width:200px; height: auto;
    }

    .round {
        background-color: #e4b9b9;font-size:115%; width:240px; height: 48px;
        padding: 10px 0 0 25px;
        -moz-border-radius: 10px; /* закругление для старых Mozilla Firefox */
        -webkit-border-radius: 10px; /* закругление для старых Chrome и Safari */
        -khtml-border-radius:10px; /* закругл. для браузера Konquerer системы Linux */
        border-radius: 10px; /* закругление углов для всех, кто понимает */
    }
</style>
