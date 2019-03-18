<template>
<alert v-model="showAlert" placement="top-right" duration="20000" type="success" width="400px" dismissable>
  <span class="icon-ok-circled alert-icon-float-left"></span>
  <strong>Alarma reportada! {{ licensePlateText }} </strong>
  <p> {{ description }}.</p>
  <p> {{ centroComercial }}.</p>
  <p> {{ descCentroComercial }}.</p>
</alert>


</template>

<script>
    import { alert } from 'vue-strap'


    export default {
        components:{
            alert
        },

        props:[],        
        data(){
            return{
                showAlert: false,
                licensePlateText:'',
                description:'',
                NotificationID:'',
                centroComercial:'',
                descCentroComercial:''
            }
        },

        mounted() {
            Echo.channel('channelDemoEvent')
                .listen('eventTrigger',(e)=>{     
                    console.log(e)   
                    this.showAlert = true   
                    this.licensePlateText = e.barrio + '-' + e.municipio
                    this.description = e.descripcion_caso
                    this.NotificationID = e
                    this.centroComercial =e.direccion
                    this.descCentroComercial =e.fecha
                });
        }
    }
</script>
