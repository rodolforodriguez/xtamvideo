<template>
    <!-- Notifications Menu -->
          <li class="dropdown notifications-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">{{notifications.length}}</span>
            </a>
            <ul class="dropdown-menu" id="asdf">
              <li class="header">Tiene {{notifications.length}} notificationes de placas</li>
              <li v-for="notification in notifications" :key="notification.description">
                <!-- Inner Menu: contains the notifications -->
                <ul class="menu">
                  <li><!-- start notification -->
                    
                    <a target="_blank" rel="noopener noreferrer" :href="notification.url">
                      <i class="fa fa-users text-aqua"></i> {{ notification.description}}
                      <br>
                      <small> {{ notification.problema }} </small>
                      <br>
                      <small>{{ notification.centroComercial }} </small>
                      <br>
                      <small> {{ notification.descCentroComercial }} </small>
                      <br>
                      <small><i class="fa fa-clock-o"></i> {{ notification.time }} mins</small>                      
                    </a>
                  </li>
                  <!-- end notification -->
                </ul>
              </li>
              <!--
              <li class="footer"><a href="#">View all</a></li>
              -->
            </ul>
          </li>          
</template>

<script>
    import { moment } from 'moment'
    export default {
        props:[],
        data()
        {
            return{
                notifications:[]
            }

        },
        mounted() {
             Echo.channel('channelDemoEvent')
                .listen('eventTrigger',(e)=>{        
                    //console.log(e)
                    this.notifications.unshift({
                            description: 'Placa: ' + e.notificationLpr.licensePlateText + ' Reportada',
                            problema: e.notificationLpr.Description,
                            url:'/notificationlpr/'+ e.notificationLpr.slug + '/edit',
                            time: new Date() ,
                            centroComercial: e.notificationLpr.centrocomercial,
                            descCentroComercial: e.notificationLpr.descamara                           
                        }
                    )  
                });
        },
        methods:{
            since: function(d){
                return moment(d).fromNow();
            },
        }
    }
</script>
