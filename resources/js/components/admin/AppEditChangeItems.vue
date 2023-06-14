<template>
    <div>


        {{gear}}
        <div class=" charactersList ">

            <div v-for="(item,ind) in optionMain"
                 :key="ind"
                 class="listInside"
                 :ingage="ind"
            >

                        <!--  ind- {{ind}} soname- {{soname}} -->
                <div class="form-group inside" >
                    <label for="parent">{{soname[ind].name}}</label>   <!--вывод power Idle steel  -->



                    <select   class="form-control part" id="parent" v-model="selected[ind]" data-title="soname.name"  @change="optCategory(item.name, $event.target.value)">

                        <option v-for="(category, index) in item"
                                :value="category.name"
                                :key="index"
                                :index="category.id"

                        >
                            <!--Здесь выводится не выбран -->
                            {{category.name}}

                        </option>
                    </select>

                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    export default {
        name: "AppEditChangeItems",

        props: {

            soname: '',
            optionMain: '',
            massive:[]

        },
        data() {
            return {
                selected: [],
                parentTitle: '',
                outParameter: '',
                priznak: true,
                ingage: ''
            }
        },

        computed: {
            ...mapGetters('optCategories', {
                optCategories: 'optCategories'
            }),
            gear() {
                let sas='';
                for (let i = 0; i < this.optionMain.length; i++) {
                    let sas = this.optionMain[i];
                    for(let j=0; j<sas.length; j++){
                        let a1=sas[j];
                        for(let k=0; k<a1.length; k++){
                            sas=a1.nick;
                        }
                    }
                }
                   /* let a2 = this.optCategories.find((c) => c.parentTitle === sas).value;
                    if (!a2) {
                        this.selected[i] = "не выбран";
                    } else {
                        this.selected[i] = a2;
                    } */


            }




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

</style>
