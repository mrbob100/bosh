<template>
    <div>


        <div class="form-group inside" >
            <label for="parent">{{soname.name}}</label>

            <select   class="form-control part" id="parent" v-model="selected" data-title="soname.name"  @change="optCategory(soname.name, $event.target.value)">

                <option v-for="(category, index) in cartworries"
                        :value="category.name"
                        :key="index"
                        :index="category.id"
                        :selected="category.id==1 ? selected : ''"
                >
                    {{category.name}}


                </option>
            </select>
        </div>

        <!--div class="form-group" v-for="(guest, index) in outParameter">
        <label @dblclick="deleteGuest(index)">
            {{guest.parentTitle}} - {{guest.value}} (-)
        </label>

        </div-->


    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import {indexOf} from "lodash";


    export default {
        name: "AppSelectionCategories",
        props: {
            cartworries: '',
            soname: '',

        },
        data() {
            return {
                selected: 'не выбран',
                parentTitle: '',
                outParameter: ''
            }
        },

        computed: {
            ...mapGetters('optCategories', {
                optCategories: 'optCategories'
            }),
        },

        methods: {
            optCategory(name,value) {
                let sas=value, sas1=name, isis='', isis1='';

                this.outParameter={'parentTitle': name, 'value':value};
                sas1={name, value};
                isis=Object.values(sas1);
                   isis1= JSON.stringify(isis);
                this.$store.dispatch('optCategories/loadItems',  // загрузка справочников под категорию option
                    this.outParameter
                );
            }
        },


    }
</script>

<style scoped>
.part, .inside{
    font-size: 87%;
}
</style>
