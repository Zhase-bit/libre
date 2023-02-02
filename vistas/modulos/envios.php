<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar envios
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar envios</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <a href="crear-envio">

          <button class="btn btn-primary">
            
            Agregar envio

          </button>

        </a>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Código </th>
           <th>Cliente</th>
           <th>Vendedor</th>
           <th>Fecha de Envio</th>
           <th>Fecha de Entrega</th>
           <th>Estado/th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;

          $respuesta = Controladorenvios::ctrMostrarenvios($item, $valor);

          foreach ($respuesta as $key => $value) {
           

           echo '<tr>

                  <td>'.($key+1).'</td>

                  <td>'.$value["codigo"].'</td>';

                  $itemCliente = "id";
                  $valorCliente = $value["id_cliente"];

                  $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                  echo '<td>'.$respuestaCliente["nombre"].'</td>';

                  $itemUsuario = "id";
                  $valorUsuario = $value["id_vendedor"];

                  $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                  echo '<td>'.$respuestaUsuario["nombre"].'</td>


                  <td>'.$value["fecha"].'</td>
                  <td>'.$value["fecha_entrega"].'</td>
                  <td>'.$value["estado"].'</td>
                  <td>

                    <div class="btn-group">
                        
                     

                      <button class="btn btn-warning btnEditarenvio" idenvio="'.$value["id"].'"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger btnEliminarenvio" idenvio="'.$value["id"].'"><i class="fa fa-times"></i></button>

                    </div>  

                  </td>

                </tr>';
            }

        ?>
               
        </tbody>

       </table>

       <?php

      $eliminarenvio = new Controladorenvios();
      $eliminarenvio -> ctrEliminarenvio();

      ?>
       

      </div>

    </div>

  </section>

</div>




