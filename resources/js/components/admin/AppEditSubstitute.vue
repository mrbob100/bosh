<template>
    <div>


        <div class="form-group inside" >
                    <!--div class="climb">{{ selected }}</div-->
            <label for="parent">{{soname.name}}</label>   <!--вывод power Idle steel  -->

                        {{gear}}

            <select   class="form-control part" id="parent" v-model="selected"   @change="optCategory(soname.name, $event.target.value)">

                <option v-for="(category, index) in cartworries"
                        :value="category.name"
                        :key="index"
                        :index="category.id"

                >
                    <!--Здесь выводится не выбран -->
                    {{ category.name }}


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


    export default {
        name: "AppEditSubstitute",
        props: {
            cartworries: '',
            soname: '',



        },
        data() {
            return {
                parentTitle: '',
                outParameter: '',
                selected: 'не выбран'

            }
        },



        computed: {
            ...mapGetters('optCategories', {
                optCategories: 'optCategories'
            }),

            gear(){


                if(this.optCategories) {

                    let  das=this.soname.name;

                    for(let i=0; i<this.optCategories.length; i++){
                        let sas=this.optCategories[i];
                        let aa=this.index;
                        if(sas.parentTitle.trim()===das.trim()) {

                            //this.selected=sas.value;
                            //   seg=true;
                            this.selected= sas.value.trim() ;

                            break;
                        }

                    }
                    //   if(!seg) this.selected='не выбран';
                    //  return JSON.stringify(this.selected);
                }


            },


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
            },
            capitalize(str) {
                return str.charAt(0).toUpperCase() + str.slice(1);
            }

        },



    }
</script>

<style scoped>
    .part, .inside{
        font-size: 87%;
    }
    .climb{
        font-size: 87%;
        color: red;

    }
</style>

