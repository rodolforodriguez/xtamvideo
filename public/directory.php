<?php
$listar = null;
$directorio = opendir("//De-0303j8/g/videos");
while($elemento = readdir($directorio))
{
    if($elemento != '.' && $elemento != '..')
    {
    if (is_dir("\\De-0303j8\g\videos".$elemento))
    {   
        $listar .= "<li><a href='//De-0303j8/g/videos/$elemento' target='_blank'>$elemento/</a></li>";
    }
    else
    { 
        

        $listar .= "<li><a href='//De-0303j8/g/videos/$elemento' target='_blank'>$elemento</a></li>";
    }
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
</head>
<body>
<h1>Listar archivos y carpetas de un directorio</h1>
<h3>Listado de archivos y carpetas del directorio "//De-0303j8/g/videos"</h3>
<ul>
    <?php echo $listar ?>
</ul>
</body>
</html>