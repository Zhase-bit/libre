<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar libros
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar libros</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarlibro">
          
          Agregar libro

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablalibros" width="100%">
         
        <thead>
         
         <tr>
           
          <th style="width:10px">#</th>
           <th>Imagen</th>
           <th>Libro
           <th>Código</th>
           <th>Autor</th>
           <th>Descripción</th>
           <th>Categoría</th>
           <th>Idioma</th>
           <th>Fecha</th>
           <th>Stock</th>
           <th>Precio de compra</th>
           <th>Precio de venta</th>
           <th>Acciones</th>
           
         </tr> 

        </thead>

       

       </table>

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR libro
======================================-->

<div id="modalAgregarlibro" class="modal fade formulario" role="dialog">
  
  <div class="modal-dialog">
    <div class="cargando row formulario" >       
              <div class="d-flex justify-content-center">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Cargando...</span>
                </div>
              </div>
    </div>
    <div class="modal-content">
      

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar libro</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">


            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->
            <div class="form-group">
              
              <div class="input-group" id="ncodigo">
              
                <span class="input-group-addon"><i class="fa fa-code"></i></span> 

                <input type="text" class="form-control input-lg" id="nuevoCodigo" name="nuevoCodigo" placeholder="Ingresar código" onblur="buscar_datos();" required>
                <input type="text" name="accion" id="accion" value="crear">

              </div>

            </div>
            <div class="form-group">
              
              <div class="input-group" id="nnombre">
              
                <span class="input-group-addon"><i class="fa fa-book"></i></span> 

                <input type="text" class="form-control input-lg" id="nuevoNombre" name="nuevoNombre" placeholder="Ingresar Nombre del libro"  required>

              </div>

            </div>

            <div class="form-group">
              
              <div class="input-group" id="ncategoria">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg" id="nuevaCategoria" name="nuevaCategoria" required>
                  
                  <option value="">Selecionar categoría</option>

                  <?php

                  $item = null;
                  $valor = null;

                  $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

                  foreach ($categorias as $key => $value) {
                    
                    echo '<option value="'.$value["id"].'">'.$value["categoria"].'</option>';
                  }

                  ?>
  
                </select>

              </div>

            </div>

            <!-- ENTRADA PARA EL CÓDIGO -->
            
            <div class="form-group">
              
              <div class="input-group" id="nautor">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <select class="form-control input-lg" id="nuevoAutor" name="nuevoAutor" required>
                  
                  <option value="">Selecionar Autor</option>

                  <?php

                  $item = null;
                  $valor = null;

                  $autor = ControladorAutors::ctrMostrarAutors($item, $valor);

                  foreach ($autor as $key => $value) {
                    
                    echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';
                  }

                  ?>
  
                </select>



              </div>

            </div>

            <!-- ENTRADA PARA LA DESCRIPCIÓN -->

             <div class="form-group">
              
              <div class="input-group" id="ndescripcion">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <textarea class="form-control input-lg" style="height:200px" name="nuevaDescripcion" placeholder="Ingresar descripción"  id="nuevaDescripcion" required> </textarea>

              </div>

            </div>



            <div class="form-group">
              
              <div class="input-group" id="nfecha">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 
                <input placeholder="Ingresar la fecha de publicacion"class="form-control input-lg" type="text" onfocus="(this.type='date')"  id="nuevaFecha"  name="nuevaFecha" required>

              </div>

            </div>

            <div class="form-group">
              
              <div class="input-group" id="nidioma">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <input type="text" class="form-control input-lg" id="nuevoIdioma" placeholder="Ingresar el idioma del libro"  name="nuevoIdioma" required>

              </div>

            </div>

             <!-- ENTRADA PARA STOCK -->
             <div class="form-group" hidden id="vaca"> 


              <div class="input-group" id="nstock" >
              
                <span class="input-group-addon"><i class="fa fa-check"></i></span> 

                <input type="number" class="form-control input-lg" name="shastock" min="0" placeholder="Stock" id="shastock" >

              </div>


            </div>


            <div class="form-group" hidden id="ala">


              <div class="input-group" id="nstock">
              
                <span class="input-group-addon"><i class="fa fa-check"></i></span> 

                <input type="number" class="form-control input-lg" name="nostock" min="0" placeholder="nueva cantidad Stock" id="nostock" >

              </div>


            </div>


             <div class="form-group">


              <div class="input-group" id="nstock">
              
                <span class="input-group-addon"><i class="fa fa-check"></i></span> 

                <input type="number" class="form-control input-lg" name="nuevoStock" min="0" placeholder="Stock Total" id="nuevoStock"  required>

              </div>


            </div>

             <!-- ENTRADA PARA PRECIO COMPRA -->

             <div class="form-group row" id ="nprecio">

                <div class="col-xs-12 col-sm-6">
                
                  <div class="input-group">
                  
                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 

                    <input type="number" class="form-control input-lg" id="nuevoPrecioCompra" name="nuevoPrecioCompra" step="any" min="0" placeholder="Precio de compra" required>

                  </div>

                </div>

                <!-- ENTRADA PARA PRECIO VENTA -->

                <div class="col-xs-12 col-sm-6">
                
                  <div class="input-group">
                  
                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 

                    <input type="number" class="form-control input-lg" id="nuevoPrecioVenta" name="nuevoPrecioVenta" step="any" min="0" placeholder="Precio de venta" required>

                  </div>
                
                  <br>

                  <!-- CHECKBOX PARA PORCENTAJE -->

                  <div class="col-xs-6">
                    
                    <div class="form-group">
                      
                      <label>
                        
                        <input type="checkbox" class="minimal porcentaje" checked>
                        Utilizar procentaje
                      </label>

                    </div>

                  </div>

                  <!-- ENTRADA PARA PORCENTAJE -->

                  <div class="col-xs-6" style="padding:0">
                    
                    <div class="input-group">
                      
                      <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>

                      <span class="input-group-addon"><i class="fa fa-percent"></i></span>

                    </div>

                  </div>

                </div>

            </div>

            <!-- ENTRADA PARA SUBIR FOTO -->

            <div class="form-group" id="nimagen">
              
              <div class="panel">SUBIR IMAGEN</div>

              <input type="file" class="nuevaImagen" name="nuevaImagen" id="nuevaImagen">

              <p class="help-block">Peso máximo de la imagen 2MB</p>

              <img src="vistas/img/libros/default/anonymous.png" class="img-thumbnail previsualizar" id="imagen" width="100px">
              <input type="text" name="imagenActual" id="imagenActual">

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="limpiar();">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar libro</button>

        </div>

      </form>

      <?php
      if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        if ($accion == 'crear') {
          $crearlibro = new Controladorlibros();
          $crearlibro -> ctrCrearlibro();
        } else if ($accion == 'editar') {
          $editarlibros = new Controladorlibros();
          $editarlibros ->  ctrCrearlibros();
        }
      }
      ?>


    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR libro
======================================-->

<div id="modalEditarlibro" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar libro</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg"  name="editarCategoria" readonly required>
                  
                  <option id="editarCategoria"></option>

                </select>

              </div>

            </div>

            <!-- ENTRADA PARA EL CÓDIGO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-code"></i></span> 

                <input type="text" class="form-control input-lg" id="editarCodigo" name="editarCodigo" readonly required>

              </div>

            </div>

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-book"></i></span> 

                <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre"  required>

              </div>

            </div>

            <!-- ENTRADA PARA LA DESCRIPCIÓN -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <input type="text" class="form-control input-lg" id="editarDescripcion" name="editarDescripcion" required>

              </div>

            </div>

             <!-- ENTRADA PARA STOCK -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-check"></i></span> 

                <input type="number" class="form-control input-lg" id="editarStock" name="editarStock" min="0" required>

              </div>

            </div>

             <!-- ENTRADA PARA PRECIO COMPRA -->

             <div class="form-group row">

                <div class="col-xs-12 col-sm-6">
                
                  <div class="input-group">
                  
                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 

                    <input type="number" class="form-control input-lg" id="editarPrecioCompra" name="editarPrecioCompra" step="any" min="0" required>

                  </div>

                </div>

                <!-- ENTRADA PARA PRECIO VENTA -->

                <div class="col-xs-12 col-sm-6">
                
                  <div class="input-group">
                  
                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 

                    <input type="number" class="form-control input-lg" id="editarPrecioVenta" name="editarPrecioVenta" step="any" min="0" readonly required>

                  </div>
                
                  <br>

                  <!-- CHECKBOX PARA PORCENTAJE -->

                  <div class="col-xs-6">
                    
                    <div class="form-group">
                      
                      <label>
                        
                        <input type="checkbox" class="minimal porcentaje" checked>
                        Utilizar procentaje
                      </label>

                    </div>

                  </div>

                  <!-- ENTRADA PARA PORCENTAJE -->

                  <div class="col-xs-6" style="padding:0">
                    
                    <div class="input-group">
                      
                      <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>

                      <span class="input-group-addon"><i class="fa fa-percent"></i></span>

                    </div>

                  </div>

                </div>

            </div>

            <!-- ENTRADA PARA SUBIR FOTO -->

             <div class="form-group">
              
              <div class="panel">SUBIR IMAGEN</div>

              <input type="file" class="nuevaImagen" name="editarImagen">

              <p class="help-block">Peso máximo de la imagen 2MB</p>

              <img src="vistas/img/libros/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

              <input type="hidden" name="imagenActual" id="imagenActual">

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>

      </form>

        <?php

          $editarlibro = new Controladorlibros();
          $editarlibro -> ctrEditarlibro();

        ?>      

    </div>

  </div>

</div>

<?php

  $eliminarlibro = new Controladorlibros();
  $eliminarlibro -> ctrEliminarlibro();

?>      




<script type="text/javascript">
  $(document).ready(function(){
        $('.cargando').hide();
      }); 
  function buscar_datos()
  {
    doc = $("#nuevoCodigo").val();

    
    var parametros = 
    {
      "buscar": "1",
      "doc" : doc

    };
    $.ajax(
    {
      data:  parametros,
      dataType: 'json',
      url:   'ajax/libros.ajax.php',
      type:  'post',
      beforeSend: function() 
      {
        $('.formulario').hide();
        $('.cargando').show();
        
      }, 
      error: function()
      {alert("Error");},
      complete: function() 
      {
        $('.formulario').show();
        $('.cargando').hide();
       
      },
      success:  function (valores) 
      {
        if(valores.existe=="1") 
        {
          swal({
            title: "Codigo Libro",
            text: "El libro ya esta registrado",
            type: "success",
            confirmButtonText: "¡Cerrar!"
		      });
          $("#nuevaDescripcion").val(valores.nuevaDescripcion);
          $("#accion").val("editar");
          $("#ndescripcion").hide();
          $("#nuevoNombre").val(valores.nuevoNombre);
          $("#nuevaCategoria").val(valores.nuevaCategoria);
          $("#ncategoria").hide();
          $("#nuevoIdioma").val(valores.nuevoIdioma);
          $("#nidioma").hide();
          $("#nuevaFecha").val(valores.nuevaFecha);
          $("#nfecha").hide();
          $("#nuevoAutor").val(valores.nuevoAutor);
          $("#nautor").hide();
          $("#shastock").val(valores.nuevoStock);
          $("#vaca").show();
          $("#ala").show();
          $("#nuevoPrecioCompra").val(valores.nuevoPrecioCompra);
          $("#nuevoPrecioVenta").val(valores.nuevoPrecioVenta);
          $("#nprecio"). hide();
          $("#imagenActual").val(valores.nuevaImagen);

          $(".previsualizar").attr("src",  valores.nuevaImagen);
        } else
        { 
          
          
          $("#nuevaDescripcion").val("");
          $("#ndescripcion").show();
          $("#nuevoNombre").val("");
          $("#ncategoria").show();
          $("#nidioma").show();
          $("#nfecha").show();
          $("#nautor").show();
          $("#nprecio").show();
          $("#nuevaCategoria").val("");
          $("#nuevoIdioma").val("");
          $("#nuevaFecha").val("");
          $("#nuevoAutor").val("");
          $("#nuevoStock").val("");
          $("#vaca").hide();
          $("#ala").hide();
          $("#nuevoPrecioCompra").val("");
          $("#nuevoPrecioVenta").val("");
          $("#imagenActual").val("");
          $(".previsualizar").attr("src", "");
          swal({
            title: "Codigo Libro",
            text: "El libro es nuevo, ingrese sus datos",
            type: "error",
            confirmButtonText: "¡Cerrar!"
		      });

        }
        

      }
    })
    

  }

  function limpiar()
    { 
      $("#nuevoCodigo").val("");
      $("#nuevaDescripcion").val("");
      $("#nuevoNombre").val("");
      $("#nuevaCategoria").val("");
      $("#nuevoIdioma").val("");
      $("#nuevaFecha").val("");
      $("#nuevoAutor").val("");
      $("#nuevoStock").val("");
      $("#nuevoPrecioCompra").val("");
      $("#nuevoPrecioVenta").val("");
      $("#imagenActual").val("");
      $(".previsualizar").attr("src", "");
    }
  limpiar(); 
  



</script>