<?php 
include("cabecera.php");
include("db.php"); //conexion base de datos

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtIndustria=(isset($_POST['txtIndustria']))?$_POST['txtIndustria']:"";
$txtPrecio=(isset($_POST['txtPrecio']))?$_POST['txtPrecio']:"";
$txtCaducidad=(isset($_POST['txtCaducidad']))?$_POST['txtCaducidad']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

    switch($accion){
        case "Agregar":
            //query se carga la consulta
            $query = $conexion->prepare("INSERT INTO productos (id, nombre, industria, precio, caducidad) VALUES (NULL, :nombre, :industria, :precio, :caducidad);");
            //nombre del parametro y su valor
            $query->bindParam(':nombre',$txtNombre);
            $query->bindParam(':industria',$txtIndustria);
            $query->bindParam(':precio',$txtPrecio);
            $query->bindParam(':caducidad',$txtCaducidad);
            // ejecutar la consulta
            $query->execute();
            break;
        
        case "Modificar":
            $query = $conexion->prepare("UPDATE productos SET nombre=:nombre, industria=:industria, precio=:precio, caducidad=:caducidad WHERE id=:id");
            $query->bindParam(":nombre",$txtNombre);
            $query->bindParam(":industria",$txtIndustria);
            $query->bindParam(":precio",$txtPrecio);
            $query->bindParam(":caducidad",$txtCaducidad);
            $query->bindParam(":id",$txtID);
            $query->execute();
            break;
        
         case "Cancelar":
            echo "SE PRESIONO CANCELAR";
            break;
        
        case "Seleccionar":
            
            $query = $conexion->prepare("SELECT * FROM productos WHERE id=:id");
            $query->bindParam(":id", $txtID);
            $query->execute();
            $producto=$query->fetch(PDO::FETCH_ASSOC);
            
            $txtNombre = $producto['nombre'];
            $txtIndustria = $producto['industria'];
            $txtPrecio = $producto['precio'];
            $txtCaducidad = $producto['caducidad'];
            break;

        case "Borrar":
            $query = $conexion->prepare("DELETE FROM productos WHERE id=:id");
            $query->bindParam(":id",$txtID);
            $query->execute();
            break;
    }

    $query = $conexion->prepare("SELECT * FROM productos");
    $query -> execute();
    $listaProductos=$query->fetchAll(PDO::FETCH_ASSOC); //recupera todos los registros   
?>


<div class="col-md-6">

    <div class="card">
        <div class="card-header">
            Datos del Producto
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class = "form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" class="form-control" value="<?php echo $txtID;?>" name="txtID" id="txtID" placeholder="ID">
                </div>
    
                <div class="form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" class="form-control" value="<?php echo $txtNombre;?>" name="txtNombre" id="txtNombre" placeholder="Nombre del Producto">
                </div>
    
                <div class="form-group">
                    <label for="txtEditorial">Industria</label>
                    <input type="text" class="form-control" value="<?php echo $txtIndustria;?>" name="txtIndustria" id="txtIndustria" placeholder="Nombre de la Industria">
                </div>

                <div class="form-group">
                    <label for="txtEditorial">Precio</label>
                    <input type="float" class="form-control" value="<?php echo $txtPrecio;?>" name="txtPrecio" id="txtPrecio" placeholder="Precio del Producto">
                </div>
                
                <div class="form-group">
                    <label for="txtEditorial">Caducidad</label>
                    <input type="text" class="form-control" value="<?php echo $txtCaducidad;?>" name="txtCaducidad" id="txtCaducidad" placeholder="Ingrese la fecha de Caducidad">
                </div>


                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" value="Modificar"class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" value="Cancelar"class="btn btn-info">Cancelar</button>
                </div>
            </form>
        </div>
    </div> 
</div>

<div class="col-md-12">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Industria</th>
                <th>Precio</th>
                <th>Caducidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($listaProductos as $producto){
                ?>
            <tr>
                <td><?php echo $producto['id']; ?></td>
                <td><?php echo $producto['nombre']; ?></td>
                <td><?php echo $producto['industria']; ?></td>
                <td><?php echo $producto['precio']; ?></td>
                <td><?php echo $producto['caducidad']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="txtID" value="<?php echo $producto['id']; ?>"> 
                        <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                        <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
include("pie.php");
?>
