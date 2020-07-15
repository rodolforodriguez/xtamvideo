@extends('crudbooster::admin_template')

<?php
//Dashboard por perfil de instancia 
$dash=db::table('xtam_profile_inst')
->select('idProfile_inst')
->where('Profile_StatusChek','=','1')
->get();
$ProfileDashboard = substr($dash,19,-2);
//end Dashboard
?>
<script>
    var home = <?php echo $ProfileDashboard ?>;
        switch(home)
            {
                case 1:
                window.location.href = "./admin/dashboard";
                //window.location.href = "./admin/statistic_builder/show/xtam-video";
                break;

                case 2:
                window.location.href = "./admin/statistic_builder/show/xtam-alarmas";
                break;

                case 3:
                window.location.href = "./admin/statistic_builder/show/xtam-video-alarmas";
                break;

                default:
                window.location.href = "./admin/Perfil_de_instancia";
                
            };
</script>

@section('content')

@endsection