<template>
    <div class="form-group ">
        <label >{{ name }}</label>
        <span class="fa" :class="validClass" v-if="activated">
        </span>
        <input type="text"
               class="form-control form-control-sm"
               :value="value"
               @input="onInput"
        >
    </div>
</template>

<script>
    export default {
        props: ['name', 'value', 'pattern'],
        data(){
            return {
                activated: this.value != ''
            }
        },
        mounted(){
            this.$emit('changeStatus', this.isValid);
        },
        computed: {
            isValid(){
                return this.pattern.test(this.value);
            },
            validClass(){
                return this.isValid ?
                    'fa-check-circle text-success' :
                    'fa-exclamation-circle text-danger';
            }
        },
        methods: {
            onInput(e){
                this.activated = true;
                this.$emit('update:value', e.target.value);
            }
        },
        watch: {
            isValid(){
                this.$emit('changeStatus', this.isValid);
            }
        }
    }
</script>
